<?php 
namespace PT2\Model;

use Think\Model;

class GoodsModel extends CommonModel
{
	private $collectObj;

	public function __construct()
	{
		parent::__construct();
		$this->collectObj = M('VisitorCollect');
		session('order_no', null);
	}

	public function showGoodsList()
	{
		$where = [
			'relevance_id' 	=> $this->pInfo['id'],
			'company_id'	=> 0,
			'status' 		=> ['not in','-1,1']
		];

		$result['classifyList'] = M('GoodsClassify')->field('id, classify_name')->where($where)->order('control_time')->select();

		$where = [
			'classify_id' => $result['classifyList'][0]['id'],
			'status'      => ['not in','-1,3']
		];

		if (I('get.classify_id')) $where['classify_id'] = I('get.classify_id');

		$field = [
			'id',
			'classify_id',
			'goods_name',
			'goods_title',
			'goods_logo',
			'promotion_price',
			'is_promotion',
			'price',
			'discount',
			'sales_start_time',
			'sales_end_time',
			'is_discount',
			'express_price',
		];

		$list = $this->field($field)->where($where)->select();

		foreach ($list as $v) {
			$v['salesTotal'] = M('GoodsSalesVolume')->where(['goods_id' => $v['id']])->sum('sales_total');
			$result['list'][] = $v;
		}
		return $result;
	}

	public function showGoodsDetail($id = '', $company_id=0)
	{
		$goodsId = I('get.id');

		if ($id) $goodsId=$id;

		$field = [
			'id',
			'classify_id',
			'goods_name',
			'goods_title',
			'goods_picture',
			'promotion_price',
			'is_promotion',
			'price',
			'discount',
			'sales_start_time',
			'sales_end_time',
			'is_discount',
			'company_id',
			'relevance_id',
			'express_price'
		];

		$goods['Info'] = $this->field($field)->where([
					'status'=>['not in','-1,3'], 
					'company_id' => $company_id,
					'relevance_id' => $this->pInfo['id'],
					'id' => $goodsId
				])->find();
		
		if ($id) return $goods['Info'];
		
		if ($goods['Info']) 
		{
			$collectList = $this->collectObj->where(['visitor_id' => $this->userInfo['id']])->getField('goods_collect');

			$collectList = json_decode($collectList, true);

			$goods['Info']['is_collect'] = in_array((string)I('get.id'), $collectList);

			$goods['thesame'] = $this->field('id, goods_name, goods_logo, price')
							->where(['classify_id' => $goods['Info']['classify_id'], 'id' => ['neq', $goodsId], 'status'=>['not in','-1,3']])
							->order('addtime desc')
							->limit(4)
							->select();
			$goods['Info']['sales_total'] = M('GoodsSalesVolume')->where(['goods_id' => $goods['Info']['id']/*, 'date' => ['gt', strtotime('-30 day')]*/])->sum('sales_total');

			foreach ($goods['thesame'] as $k => $v) {
				$sales = M('GoodsSalesVolume')->where(['goods_id' => $v['id']])->sum('sales_total');
				$goods['thesame'][$k]['salesTotal'] = $sales?$sales:0;
			}
			$goods['Info']['goods_title'] = htmlReturn($goods['Info']['goods_title']);
			$goods['Info']['goods_picture'] = json_decode($goods['Info']['goods_picture'], true);
			$this->saveStatis('GoodsStatistics', $goodsId);
			$this->goodsTrack((int)$goodsId);
			return $goods;
		}else{
			return false;
		}
	}

	// 记录用户足迹
	public function goodsTrack($id)
	{
		$time = strtotime('Today');

		$info = M('VisitorTrack')->where([
					'visitor_id' => $this->userInfo['id'], 
					'visit_date' => $time
				])->getField('id_aggregate');

		if (!$info) {
			
			$data = [
				'visit_date' 	=> $time,
				'visitor_id' 	=> $this->userInfo['id'],
				'id_aggregate' 	=> json_encode([['id' => $id, 'type' => 1]])
			];

			M('VisitorTrack')->add($data);

			return true;
		}else{
			$info = json_decode($info, true);

			foreach ($info as $v) {
				if (($v['type'] == 1 && $v['id'] != $id) || $v['type'] == 2) {
					$arr[] = $v;
				}
			}

			if (!$arr) {
				$arr = [['id' => $id, 'type' => 1]];
			}else{
				array_unshift($arr, ['id' => $id, 'type' => 1]);
			}

			M('VisitorTrack')->where(['visitor_id' => $this->userInfo['id'], 'visit_date' => $time])->setField('id_aggregate', json_encode($arr));
		}
	}

	/**
	 * 获取商品属性信息
	 */
	public function getAttr()
	{
		$field = [
			'id',
			'classify_id',
			'goods_name',
			'goods_logo',
			'price',
			'discount',
			'sales_start_time',
			'sales_end_time',
			'is_discount'
		];

		$goods['Info'] = $this->field($field)
						->where([
							'status'		=> ['not in','-1,3'], 
							'relevance_id' 	=> $this->pInfo['id'],
							'company_id' 	=> 0,
							'id' 			=> I('get.id')
						])->find();
						
		$goodsAttr = M('GoodsAttribute')->field('id,attr_name,attr_val,attr_pic,inventory_total,attr_price')
							->where(['goods_id' => I('get.id')])
							->select();
		if ($goods['Info']['is_discount'] && ((int)$goods['Info']['sales_start_time'] < time()) && ((int)$goods['Info']['sales_end_time'] > time())) {
			foreach ($goodsAttr as $v) {
				$v['price']		 = $v['attr_price'];
				$v['attr_price'] = $v['attr_price'] * ($goods['Info']['discount']/10);
				$goods['goodsAttr'][] = $v;
			}
		}else{
			foreach ($goodsAttr as $v) {
				$v['price']		 = $v['attr_price'];
				$goods['goodsAttr'][] = $v;
			}
		}

		$goods['Info']['inventory_total'] = M('GoodsAttribute')->where(['goods_id' => I('get.id')])->sum('inventory_total');

		return ['status' => 'true', 'info' => $goods];
	}

	public function ajaxControl($flag)
	{
		return $this->$flag();
	}

	// 收藏商品
	public function collectGoods()
	{
		$goodsId = I('get.goods_id');

		$status = I('get.status');

		$where = ['visitor_id' => $this->userInfo['id']];

		// 查询用户收藏商品数据
		$info = $this->collectObj->where($where)->find();
		// return $list;
		if (!$info && $status == '1') 
		{
			return $this->collectObj->add(['visitor_id' => $this->userInfo['id'], 'goods_collect' => json_encode([$goodsId])]);
		}else if((!$info || !$info['goods_collect']) && $status == '2'){
			return '非法操作';
		}else if(!$info['goods_collect'] && $status == '1'){
			return $this->collectObj->where($where)->save(['goods_collect' => json_encode([$goodsId])]);
		}

		$list = json_decode($info['goods_collect'],true);
		if (!in_array((string)$goodsId, $list) && $status == '1') // 判断是否已经收藏过
		{
			array_push($list, $goodsId);
		}

		if (in_array((string)$goodsId, $list) && $status == '2') // 判断是否已经收藏过
		{
			$list = array_diff($list, [$goodsId]);
		}

		$data = json_encode(array_merge($list));
		return $this->collectObj->where($where)->save(['goods_collect' => $data]);
	}
}