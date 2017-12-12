<?php 
namespace PT2\Model;

use Think\Model;

class ShoppingCartModel extends CommonModel
{
	protected $insertFields = ['visitor_id','company_id','goods_id','attribute_id','total'];

	protected $updateFields = ['attribute_id','total'];

	protected $_validate = array(
		array('attribute_id','require','请选择属性'), 
		array('goods_id','require','请提交商品id'), 
	);

	public function __construct()
	{
		parent::__construct();
		$this->_auto = [
			['visitor_id',$this->userInfo['id'],1],
			['relevance_id',$this->pInfo['id'],1],
			['company_id',($this->companyInfo['id']?$this->companyInfo['id']:0),1],
			['create_time','time',1,'function'],
		];
		session('order_no', null);
	}

	public function cartInfo()
	{
		$res = $this->where([
				'visitor_id' => $this->userInfo['id'],
				'relevance_id' => $this->pInfo['id']
			])->order('create_time desc')
		      ->select();
		foreach ($res as $v) {
			$v['goodsInfo'] = D('Goods')->showGoodsDetail($v['goods_id'], $v['company_id']);
			$v['attr'] = M('GoodsAttribute')->where(['id' => $v['attribute_id']])->find();

			if ($v['goodsInfo']['is_discount'] && ($v['goodsInfo']['sales_start_time'] < time()) && ($v['goodsInfo']['sales_end_time'] > time())) {
				$v['true_price'] = $v['attr']['attr_price'] * ($v['goodsInfo']['discount']/10);
			}else{
				$v['true_price'] = $v['attr']['attr_price'];
			}
			$v['link'] = $this->handleGoodsLink($v['goods_id']);
			if ($v['company_id'] == 0) {
				$result['project'][$v['relevance_id']][] = $v;
			}else{
				$result['company'][$v['company_id']][] = $v;
				if (!$result['company'][$v['company_id']]['link']) {
					$companyInfo = M('Company')->field('company_name, web_postfix')->where(['id' => $v['company_id']])->find();
					$result['company'][$v['company_id']]['link'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.$companyInfo['web_postfix'];
					$result['company'][$v['company_id']]['name'] = $companyInfo['company_name'];
				}
			}
		}
		return $result;
	}

	public function insert()
	{
		if ($data = $this->create()) {
			if (!$data['attribute_id']) {
				$this->error = '请选择商品属性';return false;
			}
			$where = [
				'attribute_id'  => $data['attribute_id'],
				'goods_id' 		=> $data['goods_id'],
				'visitor_id' 	=> $this->userInfo['id'],
			];
			$data['company_id'] = M('Goods')->where(['id' => $data['goods_id']])->getField('company_id');

			$sel = $this->where($where)->find();

			if ($sel) {// 判断是否加入同一个属性商品
				return $this->where($where)->setInc('total');
			}

			$res=$this->add($data);

			if ($res) return true;

			$this->error = '加入购物车失败';
			return false;
		}
		return false;
	}

	public function update()
	{
		if ($data = $this->create()) {

			$res = $this->where(['id' => I('get.id')])->save($data);

			if ($res) return $res;

			return false;
		}
	}

	// 修改购物车商品数量
	public function setTotal()
	{
		if (I('get.status') == 'plus') {
			$res = $this->where(['id' => I('get.id')])->setInc('total');
		}else{
			$res = $this->where(['id' => I('get.id')])->setDec('total');
		}
		return $res;
	}

	// 删除购物车其中一个数据
	public function del()
	{
		return $this->where(['id' => ['in',implode(',',I('get.id'))], 'visitor_id' => $this->userInfo['id']])->delete();
	}

	public function ajaxControl($flag)
	{
		return $this->$flag();
	}
}
?>