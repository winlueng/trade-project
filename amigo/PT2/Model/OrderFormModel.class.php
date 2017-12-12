<?php 
namespace PT2\Model;

use Think\Model;
use Think\Exception;
use \PT2\Model\LoginModel;

class OrderFormModel extends CommonModel
{
	protected $updateFields = ['status', 'update_time'];
	private   $waste_obj;
	public function __construct()
	{
		parent::__construct();
		$this->_auto = [
			['update_time','time',3, 'function'],
		];

		$this->waste_obj = new \PT2\Model\WasteBookModel;
	}

	// 订单列表
	public function orderList($flag = '')
	{
		$show = I('get.show');

		if (in_array((string)$show, ['0','1','2','3','4','5','6'])) {
			$flag = $show;
		}
		$where = [
			'status' => ['not in','-1,5,6,7'],
			'visitor_id' => $this->userInfo['id']
		];


		switch ($flag) {
			case '1':// 待付款
				$where['status'] = 0;
				$where['create_time'] = ['gt', time()-172800];
				$where['is_send_out'] = 0;
				break;
			case '2':// 待发货
				$where['status'] = 2;
				$where['is_send_out'] = 0;
				break;
			case '3': // 待收货
				$where['status'] = 2;
				$where['is_send_out'] = 1;
				break;
			case '4': // 待评价
				$where['status'] = 2;
				$where['is_send_out'] = 2;
				$where['score'] = 0;
				break;
			case '5':// 申请退款
				$where['status'] = ['in', '5,7'];
				break;
			case '6':// 已处理退款
				$where['status'] = ['in', '6,7'];
				break;
		}

		$count = $this->where($where)->count();
		if (!in_array((string)$show, [0,1,2,3,4,5,6])) {
			if ($flag == 6) {
				$list = json_decode($this->redis->get('B_orderLook_'.$this->userInfo['id']), true);
				$idList = $this->where($where)->getField('id',true);
				$count = count(array_diff($idList, $list));
			}
			return $count;
		}

		$page = new \Think\Page($count, 6);
		$info = $this->where($where)
				->order('create_time desc')
				->limit($page->firstRow.','.$page->listRows)
				->select();
		foreach ($info as $v) {
			$v['goods_data'] = json_decode($v['goods_data'], true);
			$v['piece'] = 0;
			foreach ($v['goods_data'] as $vo) {
				$where = ['goods_id' => $vo['goods_id'], 'attribute_id' => $vo['attribute_id']];
				$vo['sales'] = M('GoodsSalesVolume')->where($where)->sum('sales_total');// 销量
				$vo['attrInfo'] = M('GoodsAttribute')->field('attr_pic,inventory_total,attr_val')->where(['id' => $vo['attribute_id']])->find();// 库存
				$vo['goods_name'] = M('Goods')->where(['id' => $vo['goods_id']])->getField('goods_name');
				$vo['link'] = $this->handleGoodsLink($vo['goods_id']);
				$arr[] = $vo;
				$v['piece'] += (int)$vo['total'];
			}
			$v['goods_data'] = $arr;
			if ($v['company_id'] != 0) {
				$companyInfo = M('Company')->field('company_name, web_postfix')->where(['id' => $v['company_id']])->find();
				$v['company_link'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.$companyInfo['web_postfix'];
				$v['company_name'] = $companyInfo['company_name'];
			}
			$arr = [];
			$result[] = $v;
		} 
		return $result;
	}

	/**
	 * 预生成订单
	 * @param  string $way 	跳转标签(1是从商品到此,2是购物车到此)
	 * @return array  $result   返回与处理好的订单详情
	 */
	public function insertBefore($way = '')
	{
		// dump(session('order_no'));exit;
		if (session('order_no')) {// 编辑地址后返回平台订单号
			$data = $this->redis->get(session('order_no'));
			$data = json_decode($data, true);
			// dump($data);exit;
			$way  = $data['way'];
			$res['project_order'] = session('order_no');
		}else{
			$data = I('post.');
			$data['way'] = $way;
			$res['project_order'] = 'V'.$this->userInfo['id'].date('YmdHis',time()).mt_rand(111111,999999);
			session('order_no', $res['project_order']);
		}
		

		// dump($data);exit;
		switch ($way) {
			case '1':
				$relevance_id = M('Goods')->where([
						'id' 			=> $data['goods_id'],
						'relevance_id' 	=> $this->pInfo['id']
					])->getField('company_id');
				// $arr[$relevance_id]['total'][] = ($data['total'] * $data['price']);
				$arr[$relevance_id]['goods_data'][] = [
					'goods_id' 		=> $data['goods_id'],
					'attribute_id' 	=> $data['attribute_id'],
					'total' 		=> $data['total'],
					'price' 		=> $data['price']
				];
				break;
			case '2':
				foreach ($data['cart_id'] as $v) {
					$where = [
							'id' => $v, 
							'visitor_id' => $this->userInfo['id'],
							'relevance_id' => $this->pInfo['id']
						];
					$info = M('ShoppingCart')->where($where)->find();
					if(!$info) return false; 
					// $arr[$info['company_id']]['total'][] = ($info['total'] * $data['price'][$v]);
					$arr[$info['company_id']]['goods_data'][] = [
						'goods_id' => $info['goods_id'],
						'attribute_id' => $info['attribute_id'],
						'total' => $info['total'],
						'price' => $data['price'][$v]
					];
				}
			break;
		}
		foreach ($arr as $k => $v) {
			$idList = [];
			$goods_data = [];
			foreach ($v['goods_data'] as $vo) {
				$where = ['goods_id' => $vo['goods_id'], 'attribute_id' => $vo['attribute_id']];
				// $vo['sales'] = M('GoodsSalesVolume')->where($where)->sum('sales_total');// 销量
				$vo['attrInfo'] = M('GoodsAttribute')->field('attr_pic,attr_name,inventory_total,attr_val')->where(['id' => $vo['attribute_id']])->find();// 库存
				$vo['goods_name'] = M('Goods')->where(['id' => $vo['goods_id']])->getField('goods_name');
				$discount = M('Goods')->where([
						'id' 				=> $vo['goods_id'], 
						'sales_start_time' 	=> ['lt', time()],
						'sales_end_time'	=> ['gt', time()],
						'is_discount'		=> 1,
					])->getField('discount');
				if ($discount) {
					$vo['price'] = $vo['price'] * ($discount/10);
				}
				$v['total'][] = $vo['total'] * $vo['price'];
				$vo['link'] = $this->handleGoodsLink($vo['goods_id']);
				$v['piece'] += (int)$vo['total'];
				$idList[] = $vo['goods_id'];
				$goods_data[] = $vo;
			}
			$v['goods_data'] = $goods_data;
			$v['company_id'] = $k;
			$v['express_price'] = M('Goods')->where(['id' => ['in', implode(',', $idList)]])->max('express_price');
			$express_price += (int)$v['express_price'];
			$order_total += array_sum($v['total']);
			if ($k != 0) {
				$companyInfo = M('Company')->field('company_name, web_postfix')->where(['id' => $v['company_id']])->find();
				$v['company_link'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.$companyInfo['web_postfix'];
				$v['company_name'] = $companyInfo['company_name'];
			}
			$res['orderInfo'][] = $v;
		}
		$res['express_price'] = $express_price;
		$res['order_total'] = $order_total;
		$this->redis->setex(session('order_no'), 3600, json_encode($data));
		return $res;
	}

	public function insert($order)
	{
		$data = $this->redis->get($order);
		if (!$data) {
			return 9;
		}

		$data = json_decode($data, true);

		$addr_id = $this->redis->get('pay_address'. session('order_no'));

 		if ($addr_id) {// 编辑地址后返回addr_id
			$data['address_id'] = $addr_id;
		}else{
			$data['address_id'] = M('VisitorAddress')->where(['visitor_id' => $this->userInfo['id'], 'status' => 1])->getField('id');
		}

		$this->startTrans();
		switch ($data['way']) {
			case '1':
				$relevance_id = M('Goods')->where([
						'id' => $data['goods_id'],
						'relevance_id' => $this->pInfo['id']
					])->getField('company_id');
				// $arr[$relevance_id]['total'][] = ($data['total'] * $data['price']);
				$discount = M('Goods')->where([
						'id' 				=> $data['goods_id'], 
						'sales_start_time' 	=> ['lt', time()],
						'sales_end_time'	=> ['gt', time()],
						'is_discount'		=> 1,
					])->getField('discount');
				$arr[$relevance_id]['goods_data'][] = [
					'goods_id' => $data['goods_id'],
					'attribute_id' => $data['attribute_id'],
					'total' => $data['total'],
					'price' => $discount?$data['price']*($discount/10):$data['price'],
				];
				break;
			case '2':
				foreach ($data['cart_id'] as $v) {
					$where = ['id' => $v, 'visitor_id' => $this->userInfo['id']];
					$info = M('ShoppingCart')->where($where)->find(); // 
					if(!$info) return false; 
					// $arr[$info['company_id']]['total'][] = ($info['total'] * $data['price'][$v]);
					$discount = M('Goods')->where([
						'id' 				=> $info['goods_id'], 
						'sales_start_time' 	=> ['lt', time()],
						'sales_end_time'	=> ['gt', time()],
						'is_discount'		=> 1,
					])->getField('discount');
					$arr[$info['company_id']]['goods_data'][] = [
						'goods_id' => $info['goods_id'],
						'attribute_id' => $info['attribute_id'],
						'total' => $info['total'],
						'price' => $discount?$data['price'][$v]*($discount/10):$data['price'][$v],
					];
					M('ShoppingCart')->where($where)->delete();
				}
				break;
		}

		$insData = [
			'visitor_id' 	=> $this->userInfo['id'],
			'create_time' 	=> time(),
			'relevance_id' 	=> $this->pInfo['id'],
			'project_order' => $order
		];
		$remark = I('get.visitor_remark');
		foreach ($arr as $k => $v) {
			$insData['company_id'] = $k;
			foreach ($v['goods_data'] as $vo) {
				$v['total'][] = $vo['price'] * $vo['total'];
				$idList[] = $vo['goods_id'];
			} 
			$insData['express_price'] = M('Goods')->where(['id' => ['in', implode(',', $idList)]])->max('express_price');
			$insData['goods_data'] = json_encode($v['goods_data']);
			$insData['order_number'] = 'V'.$this->userInfo['id'].'C'.$k.'D'.date('YmdHis',time()).mt_rand(111111,999999);
			$address = M('VisitorAddress')->field('consignee,phone,address_str')
					->where(['visitor_id' => $this->userInfo['id'], 'id' => $data['address_id']])
					->find();
					
			$insData['address_id'] = json_encode($address);
			$insData['total'] = array_sum($v['total']);
			$insData['referer'] = $_SERVER['HTTP_REFERER'];

			if ($remark[$k]) {
				$insData['visitor_remark'] = $remark[$k];
			}
			$result[] = $res = $this->add($insData);
			if(!$res){
				$this->rollback();
				return false;
			}
		}

		$this->commit();
		return $result;
	}

	// 调起微信支付前
	public function payBeforeGetOrderInfo($id = '')
	{
		$where = [
			'id'	=> I('get.id'),
			'status' => ['neq','-1'],
			'visitor_id' => $this->userInfo['id']
		];

		if ($id) {
			$where['id'] = $id;
		}

		$info = $this->where($where)->find();

		if (!$info) return false;

		$info['goods_data'] = json_decode($info['goods_data'], true);

		$info['piece'] = 0;

		foreach ($info['goods_data'] as $vo) {
			$where = ['goods_id' => $vo['goods_id'], 'attribute_id' => $vo['attribute_id']];
			// $vo['sales'] = M('GoodsSalesVolume')->where($where)->sum('sales_total');// 销量
			$vo['attrInfo'] = M('GoodsAttribute')->field('attr_pic,attr_name,inventory_total,attr_val')->where(['id' => $vo['attribute_id']])->find();// 库存
			$vo['goods_name'] = M('Goods')->where(['id' => $vo['goods_id']])->getField('goods_name');
			$vo['link'] = $this->handleGoodsLink($vo['goods_id']);
			$arr[] = $vo;
			$info['piece'] += (int)$vo['total'];
		}
		if ($info['company_id'] != 0) {
			$companyInfo = M('Company')->field('company_name, web_postfix')->where(['id' => $info['company_id']])->find();
			$info['company_link'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.$companyInfo;
			$info['company_name'] = $companyInfo['company_name'];
		}
		$info['goods_data'] = $arr;
		// 查询物流信息
		if (in_array((string)$info['is_send_out'],['1','2']) && in_array((string)$info['status'],['2','4']) && $info['express_name'] && $info['express_number']) {
			$express = $this->redis->get('express_'.$info['express_name'].$info['express_number']);
			if (!$express) {
				$data = [
					'ShipperCode'  => $info['express_name'],
					'LogisticCode' => $info['express_number'],
				];
				$express = orderTracesSubByJson(json_encode($data));
				$this->redis->setex('express_'.$info['express_name'].$info['express_number'], 3600, $express);
			}
			$info['express'] = json_decode($express, true);
			$info['express']['expressLast'] = array_pop($info['express']['Traces']);
			$info['express']['name'] = M('Express')->where(['coding' => $info['express_name']])->getField('name');
		}

		if (in_array($info['status'],['6','7'])) {
			$list = json_decode($this->redis->get('B_orderLook_'.$this->userInfo['id']), true);
			if (!$list) {
				$list = [I('get.id')];
			}else{
				$list = array_merge($list, [I('get.id')]);
			}
			$this->redis->set('B_orderLook_'.$this->userInfo['id'], json_encode($list));
		}
		return $info;
	}

	// 减去库存并记录销量
	public function minusInventory($data)
	{
		$this->startTrans();

		foreach ($data as $v) {
			$inventory = M('GoodsAttribute')->where(['id' => $v['attribute_id']])->getField('inventory_total');
			// 记录销量

			$save = (int)$inventory - (int)$v['total'];
			if($save < 0) {
				$this->rollback();
				return false;
			}
			$res  = M('GoodsAttribute')->where(['id' => $v['attribute_id']])->setField('inventory_total',$save); 
		}
		$this->commit();
		return true;
	}

	/**
	 * 钱包支付
	 */
	public function balance_to_buy()
	{
		try {
			if(!IS_AJAX) throw new Exception("非法访问", 100);

			if (!$this->userInfo['pay_pass_word']) throw new Exception("请前往设置密码", 1);
			
			if (!I('get.pay_pass')) throw new Exception("请输入钱包密码", 2);

			if (!pwd_hash(I('get.pay_pass'),$this->userInfo['pay_pass_word'])) throw new Exception("钱包密码错误", 3);

			$this->startTrans();

			if (I('get.project_order')) {
				$res = $this->where(['project_order' => I('get.project_order')])->getField('id', true);
				if (!$res) {
					$res = $this->insert(I('get.project_order'));
					if ($res == 9) {
						throw new Exception("订单已失效!", 13);
					}
				}
			}elseif(I('get.id')){
				$res[] = I('get.id');
			}

			foreach($res as $v)
			{
				$info = $this->payBeforeGetOrderInfo($v);
				if(!$info) {

					$data = [
						'admin_remark' 	=> '订单不存在!',
					];

					$this->where(['id' => I('get.id')])->save($data);
					throw new Exception("订单不存在!", 4);
				}elseif(!$info['address_id'] || $info['address_id'] == 'null'){
					throw new Exception("请填写收货地址", 5);
				}

				$minus = $this->minusInventory($info['goods_data']);
				if(!$minus) {
					$data = [
						'admin_remark' 	=> '订单关闭原因,库存不足',
						'status'		=> 3,
					];
					$this->where(['id' => I('get.id')])->save($data);

					throw new Exception("订单关闭原因,库存不足", 6);
				}
				$order_number = $info['project_order'];

				$total_fee += ($info['total'] + $info['express_price']);
			}

			if (($this->userInfo['wallet'] - $total_fee) < 0) throw new Exception("余额不足", 9);

			$waste_data = [
			    'order_number' 		=> $order_number,
			    'system_remark' 	=> $this->pInfo['market_name'].'-购物订单,平台单号:'.$order_number,
			    'recharge_total'	=> $total_fee,
			    'balance'			=> $this->userInfo['wallet'] - $total_fee,
			    'visitor_id'		=> $this->userInfo['id'],
			    'pay_type'			=> 3,
			    'referer'			=> $_SERVER['HTTP_REFERER'],
			    'recharge_or_buy'	=> 2,
			    'relevance_id'		=> $this->pInfo['id'],
			    'pay_time'			=> date('YmdHis',time()),
			    'create_time'		=> time(),
			    'pay_status'		=> 1
			];
			$res = $this->waste_obj->add($waste_data);

			if(!$res) throw new Exception("支付异常", 7);
			
			$save = [
				'transaction_id' => '0',
				'cash_fee'		 => $waste_data['recharge_total'] * 100,
				'out_trade_no'	 => $waste_data['order_number'],
				'pay_time'		 => date('YmdHis',time()),
				'pay_type'		 => 2,	
			];
			if (I('get.id')) {
				$save['order_id'] = I('get.id');
			}

			$res = $this->changeOrder($save);

			if(!$res) throw new Exception("未支付成功", 8);

			$this->commit();
			$_SESSION['visitorInfo'] = LoginModel::getUserInfo('', $this->userInfo['id']);
			return ['status' => 'true', 'err_msg' => '', 'err_code' => '0'];
		} catch (Exception $e) {
			$this->rollback();
			return ['stauts' => 'false', 'err_msg' => $e->getMessage(), 'err_code' => $e->getCode()];
		}
		
	}

	/**
	 * 生成预订单
	 */
	public function createAdvance()
	{
		// return $this->wechat->jssdkConfig();
		if(!IS_AJAX) E('非法访问');
		if (I('get.project_order')) {

			$res = $this->where(['project_order' => I('get.project_order')])->getField('id', true);
			if (!$res) {
				$res = $this->insert(I('get.project_order'));
				if (!$res) {
					return '订单已失效';
				}
			}
		}elseif(I('get.id')){
			$res[] = I('get.id');
		}
		$this->startTrans();
		foreach($res as $v)
		{
			$info = $this->payBeforeGetOrderInfo($v);
			if(!$info) {

				$data = [
					'admin_remark' 	=> '订单不存在!',
				];

				$this->where(['id' => $v])->save($data);
				return $data;
			}elseif(!$info['address_id'] || $info['address_id'] == 'null'){
				return 2;
			}

			$minus = $this->minusInventory($info['goods_data']);
			if(!$minus) {
				$this->rollback();
				$data = [
					'admin_remark' 	=> '订单关闭原因,库存不足',
					'status'		=> 3,
				];
				$this->where(['id' => $v])->save($data);

				return $data;
			}
			$order_number = $info['project_order'];
			$total_fee += ($info['total'] + $info['express_price']);
		}
		$this->commit();
		if (count($res) > 1) {
			$config = [
			    'out_trade_no' 	=> $order_number,
			    'body' 			=> $this->pInfo['market_name'].'-购物订单'.$order_number,
			    'total_fee' 	=> $total_fee * 100,
			    'notify_url' 	=> 'http://'.$_SERVER['HTTP_HOST'].U('OrderForm/returnWXPay'),
			];
		}else{
			$config = [
			    'out_trade_no' 	=> $info['order_number'],
			    'body' 			=> $this->pInfo['market_name'].'-购物订单'.$info['order_number'],
			    'total_fee' 	=> $total_fee * 100,
			    'notify_url' 	=> 'http://'.$_SERVER['HTTP_HOST'].U('OrderForm/returnWXPay'),
			];
		}
		// return $config;
		$wxOrder = $this->wechat->wxPayUnifiedOrder($this->userInfo['open_id'], $config);
		// 判断预订单是否生成成功
		if ($wxOrder['return_code'] != 'SUCCESS') {
		    return '生成预订单失败1';
		}

		// 生成微信支付JSAPI参数
		if (! array_key_exists('prepay_id', $wxOrder)) {
		     return $wxOrder['err_code_des'];
		}
		return $jsApiParams = $this->wechat->getWxPayJsApiParameters($wxOrder['prepay_id']);
	}

	/**
	 * 微信支付回调信息
	 */
	public function changeOrder($data)
	{
		$save = [
			'wechat_order_number' 	=> $data['transaction_id'],
			'status'				=> 2,
			'pay_time'				=> date('YmdHis',time()),
			'pay_status'			=> 1,
			'wechat_total'			=> $data['cash_fee']/100,

		];
		if ($data['pay_type']) {
			$save['pay_type'] = $data['pay_type'];
		}

		$condition['project_order'] = $data['out_trade_no'];
		$condition['order_number'] 	= $data['out_trade_no'];
		$condition['_logic'] = 'OR';
		$this->quantity_ins($condition);
		return $this->where($condition)->save($save);
	}

	public function quantity_ins($condition)
	{
		$info = $this->field('goods_data, relevance_id, company_id')->where($condition)->find();
		$where = [
				'date'			=> strtotime('Today'),
				'relevance_id'	=> $info['relevance_id'],
				'company_id'	=> $info['company_id'],	
			];
		$goods_data = json_decode($info['goods_data'], true);
		foreach ($goods_data as $v) {
			$where['goods_id'] 		= $v['goods_id'];
			$where['attribute_id'] 	= $v['attribute_id'];
			$find = M('GoodsSalesVolume')->where($where)->find();
			if ($find) {
				M('GoodsSalesVolume')->where($where)->setInc('sales_total',(int)$v['total']);
			}else{
				$where['sales_total'] = $v['total'];
				M('GoodsSalesVolume')->add($where);
			}
		}
	}

	public function ajaxControl($flag)
	{
		return $this->$flag();
	}

	/**
	 * 订单详情修改地址信息
	 */
	public function changeAddr()
	{
		$adr = M('VisitorAddress')->field('consignee,phone,address_str')
				->where(['visitor_id' => $this->userInfo['id'], 'id' => I('get.id')])
				->find();
		$res = $this->where(['id' => I('get.orderID'), 'visitor_id' => $this->userInfo['id']])->setField('address_id', json_encode($adr));
		if ($res) {
			return $result = 'http://'.$_SERVER['HTTP_HOST'].U("orderDetail",['companyName' => I('get.companyName'), "id" => I('get.orderID')]);
		}
	}

	public function selOrderStatus()
	{
		$res = $this->where([
				'project_order' => I('get.project_order'), 
				'visitor_id' => $this->userInfo['id'],
				'status'	 => ['neq', '2']
			])->getField('id');
		if ($res) {
			return false;
		}else{
			return true;
		}
	}

	public function selOrderChange()
	{
		$res = $this->where([
				'id' => I('get.id'), 
				'visitor_id' => $this->userInfo['id'],
				'status'	 => ['neq', '2']
			])->getField('id');
		if ($res) {
			return false;
		}else{
			return true;
		}
	}

	/**
	 * 取消订单
	 */
	public function orderCancel()
	{
		$data = [
			'status' => 1,
			'refund_remark' => I('get.cancel_remark'),
		];

		$res = $this->where(['id' => I('get.id'), 'visitor_id' => $this->userInfo['id']])->save($data);
		return $res;
	}

	/**
	 * 延长收货
	 */
	public function prolong()
	{
		$data = [
			'is_prolong' => 1,
		];

		$res = $this->where(['id' => I('get.id'), 'visitor_id' => $this->userInfo['id']])->save($data);
		return $res;
	}

	/**
	 * 确认收货
	 */
	public function receiving()
	{
		$data = [
			'is_send_out' => 2,
		];

		$res = $this->where(['id' => I('get.id'), 'visitor_id' => $this->userInfo['id']])->save($data);
		return $res;
	}

	/**
	 * 申请退款
	 */
	public function orderApplicationForDrawback()
	{
		$where = ['id' => I('get.id'), 'visitor_id' => $this->userInfo['id']];
		$data = [
			'status' => 5,
			'refund_remark' => I('get.drawback_remark'),
			'update_time'	=> time()
		];
		$this->startTrans();
		$orderInfo = $this->field('wechat_order_number,order_number,total,company_id,status')->where($where)->find();
		$status = M('WechatRefund')->where([
					'transaction_id' => $orderInfo['wechat_order_number'], 
					'status' => ['eq','0'], 
					'refund_fee' => ['eq','0'], 
					'refund_id' => '',
				])->find();
		if ($status) {
			$this->rollback();
			return  false;
		}
		$refund = [
			'refund_remark'    	=> I('get.drawback_remark'),
			'out_refund_no'    	=> 'REFUND_V'.$this->userInfo['id'].'C'.$orderInfo['company_id'].time(),
			'total_fee'        	=> $orderInfo['total'],
			'company_id'       	=> $orderInfo['company_id'],
			'transaction_id'   	=> $orderInfo['wechat_order_number'],
			'visitor_id'	   	=> $this->userInfo['id'],
			'out_trade_no'	   	=> $orderInfo['order_number'],
			'create_time'		=> time(),
			'referer_status'	=> $orderInfo['status'],
			'relevance_id'		=> $this->pInfo['id'],
		];
		$res = M('WechatRefund')->add($refund);

		if(!$res) {
			$this->rollback();
			return false;
		}

		$res = $this->where($where)->save($data);
		if(!$res) {
			$this->rollback();
			return false;
		}
		$this->commit();
		return $res;
	}

	public function extend_the_receiving()
	{
		try {
			$this->startTrans();

			$order_number = $this->where(['id' => I('get.id'), 'relevance_id' => $this->pInfo['id']])->getField('order_number');

			$state = M('ExpressTrace')->where(['order_number' => $order_number])->getField('state');

			if ($state != 3) throw new Exception("物流未送达, 未能做延长收货操作", 2);
			
			/*$res = M('ExpressTrace')->where(['order_number' => $order_number,'state' => 3])->save(['update_time' => time()]);

			if (!$res) throw new Exception("操作失败", 3);*/
			
			$res = $this->where([
					'id' => I('get.id'), 
					'relevance_id' => $this->pInfo['id'], 
					'is_prolong' => ['neq','1']
				])->save(['is_prolong' => '1', 'update_time' => time()]);

			if (!$res) throw new Exception("延迟失败", 1);

			$this->commit();
			return ['status' => 'true', 'err_msg' => '', 'err_code' => '0'];
		} catch (Exception $e) {
			$this->rollback();
			return ['stauts' => 'false', 'err_msg' => $e->getMessage(), 'err_code' => $e->getCode()];
		}
	}
}
?>