<?php 
namespace Template00002\Model;

use Think\Model;

class ShoppingCartModel extends CommonModel
{
	protected $insertFields = ['visitor_id','company_id','goods_id','attribute_id','total'];

	protected $updateFields = ['attribute_id','total'];

	protected $_validate = array(
		array('attribute_id','require','请选择属性'), 
	);

	public function __construct()
	{
		parent::__construct();
		$this->_auto = [
			['visitor_id',$this->userInfo['id'],1],
			['company_id',$this->companyInfo['id'],1],
			['create_time','time',1,'function'],
		];
	}

	public function cartInfo()
	{
		$res = $this->where(['visitor_id' => $this->userInfo['id']])->order('create_time desc')->select();
		foreach ($res as $v) {
			$v['goodsInfo'] = M('Goods')->where(['id' => $v['id']])->find();
			$v['attr'] = M('GoodsAttribute')->where(['id' => $v['attribute_id']])->find();
			$v['true_price'] = $v['attr']['attr_price'] != '0.00'?$v['attr']['attr_price']:($v['goodsInfo']['is_promotion']?$v['Info']['is_promotion']:$v['goodsInfo']['price'] * $v['goodsInfo']['discount']);
			$v['link'] = $this->handleGoodsLink($v['goods_id']);
			$result[$v['company_id']][] = $v;
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
			$sel = $this->where($where)->find();

			if ($sel) {// 判断是否加入同一个属性商品
				return $this->where($where)->setInc('total');
			}

			$res=$this->add($data);

			if ($res) return $res;

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
		return $this->where(['id' => ['in',implode(',',I('get.id'))]])->delete();
	}

	public function ajaxControl($flag)
	{
		return $this->$flag();
	}
}
?>