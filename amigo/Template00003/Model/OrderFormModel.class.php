<?php 
namespace Template00002\Model;

use Think\Model;

class OrderFormModel extends CommonModel
{
	// protected $insertFields = ['company_id','visitor_id','order_number','total','goods_data','remark','address_id','create_time'];

	protected $updateFields = ['status', 'update_time'];

	public function __construct()
	{
		parent::__construct();
		$this->_auto = [
			['update_time','time',3, 'function'],
		];
	}

	public function insert()
	{
		$data = I('post.');
		$this->startTrans();
		foreach ($data['cart_id'] as $v) {
			$where = ['id' => $v, 'visitor_id' => $this->userInfo['id']];
			$info = M('ShoppingCart')->where($where)->find(); // 
			if(!$info) return false; 
			$arr[$info['company_id']]['total'][] = (int)($info['total'] * $data['price'][$v]);
			$arr[$info['company_id']]['goods_data'][] = [
				'goods_id' => $info['goods_id'],
				'attribute_id' => $info['attribute_id'],
				'total' => $info['total'],
				'price' => $data['price'][$v]
			];
			 M('ShoppingCart')->where($where)->delete();
		}

		$insData = [
			'visitor_id' => $this->userInfo['id'],
			'create_time' => time(),
		];

		foreach ($arr as $k => $v) {
			$insData['company_id'] = $k;
			foreach ($v['goods_data'] as $vo) {
				$idList[] = $vo['goods_id'];
			} 
			$insData['express_price'] = M('Goods')->where(['id' => ['in', implode(',', $idList)]])->order('express_price desc')->getField('express_price');
			$insData['goods_data'] = json_encode($v['goods_data']);
			$insData['order_number'] = 'V'.$this->userInfo['id'].'C'.$k.'D'.date('YmdHis',time()).mt_rand(111111,999999);
			$addrID = M('VisitorAddress')->field('consignee,phone,address_str')->where(['visitor_id' => $this->userInfo['id'], 'status' => 1])->find();
			$insData['address_id'] = json_encode($addrID);
			$insData['total'] = array_sum($v['total']);
			$insData['referer'] = $_SERVER['HTTP_REFERER'];
			$result[] = $res = $this->add($insData);
			if(!$res){
				$this->rollback();
				return false;
			}
		}

		$this->commit();
		if (IS_AJAX) {
		    return U('OrderForm/orderDetail', ['companyName' => $_GET['companyName'], 'id' => $res]);
		}
		return $result;
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
				$where['status'] = 5;
				break;
			case '6':// 已处理退款
				$where['status'] = ['in', '6,7'];
				break;
		}

		$count = $this->where($where)->count();
		if (!in_array((string)$show, ['0','1','2','3','4','5','6'])) {
			if ($flag == 6) {
				$list = json_decode($this->redis->get('B_orderLook_'.$this->userinfo['id']), true);
				$idList = $this->where($where)->getField('id',true);
				$count = count(array_diff($idList, $list));
			}
			return (int)$count;
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
			$arr = [];
			$result[] = $v;
		}
		return $result;
	}

	// 调起微信支付前
	public function payBeforeGetOrderInfo()
	{
		$where = [
			'id' => I('get.id'),
			'status' => ['neq','-1'],
			'visitor_id' => $this->userInfo['id']
		];

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
			$list = json_decode($this->redis->get('B_orderLook_'.$this->userinfo['id']), true);
			if (!$list) {
				$list = [I('get.id')];
			}else{
				$list = array_merge($list, [I('get.id')]);
			}
			$this->redis->set('B_orderLook_'.$this->userinfo['id'], json_encode($list));
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
			$where = [
				'goods_id' 		=> $v['goods_id'],
				'attribute_id' 	=> $v['attribute_id'],
				'date'			=> strtotime('Today'),
			];
			$find = M('GoodsSalesVolume')->where($where)->find();
			if ($find) {
				M('GoodsSalesVolume')->where($where)->setInc('sales_total',(int)$v['total']);
			}else{
				$where['sales_total'] = $v['total'];
				M('GoodsSalesVolume')->add($where);
			}

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
	 * 生成预订单
	 */
	public function createAdvance()
	{
		if(!IS_AJAX) E('非法访问');

		$info = $this->payBeforeGetOrderInfo();
		if(!$info) {

			$data = [
				'admin_remark' 	=> '订单不存在!',
			];

			$this->where(['id' => I('get.id')])->save($data);
			return $info;
		}elseif(!$info['address_id'] || $info['address_id'] == 'null'){
			return 2;
		}

		$minus = $this->minusInventory($info['goods_data']);
		if(!$minus) {
			$data = [
				'admin_remark' 	=> '订单关闭原因,库存不足',
				'status'		=> 3,
			];
			$this->where(['id' => I('get.id')])->save($data);
			return $minus;
		}

		$config = [
		    'out_trade_no' => $info['order_number'],
		    'body' => $this->companyInfo['company_name'].'-购物订单'.$info['order_number'],
		    'total_fee' => ((int)$info['total'] + (int)$info['express_price']) * 100,
		    //'time_expire' => date('YmdHis', (int)$order['created_at'] + (int)$order['timeout']),
		    'notify_url' => 'http://'.$_SERVER['HTTP_HOST'].U('OrderForm/returnWXPay', ['companyName' => I('get.companyName')]),
		];

		$wxOrder = $this->wechat->wxPayUnifiedOrder($this->userInfo['open_id'], $config);
		// 判断预订单是否生成成功
		if ($wxOrder['return_code'] != 'SUCCESS') {
		    return '生成预订单失败1';
		}

		// 生成微信支付JSAPI参数
		if (! array_key_exists('prepay_id', $wxOrder)) {
		     return '生成预订单失败2';
		}
		return $jsApiParams = $this->wechat->getWxPayJsApiParameters($wxOrder['prepay_id']);
	}

	/**
	 * 支付成功后改动订单状态
	 *	array(16) {
	 *	  ["appid"] => string(18) "wx3e8a17089c5d5a0a"
	 *	  ["bank_type"] => string(3) "CFT" // 零钱
	 *	  ["cash_fee"] => string(1) "1" // 1分钱
	 *	  ["fee_type"] => string(3) "CNY" // 人民币
	 *	  ["is_subscribe"] => string(1) "Y" // 已关注公众号
	 *	  ["mch_id"] => string(10) "1317829401"
	 *	  ["nonce_str"] => string(32) "4lUpOJgxloBtY3pwaO6kMW5dJ2LMxD0A"
	 *	  ["openid"] => string(28) "oxMJauJjEgKrczxvEfZVo6X_xWc8"
	 *	  ["out_trade_no"] => string(24) "215220170606220514485910" // 商户系统订单号
	 *	  ["result_code"] => string(7) "SUCCESS"
	 *	  ["return_code"] => string(7) "SUCCESS"
	 *	  ["sign"] => string(32) "D71623D9463E41ECA428D41A37AD22DA"
	 *	  ["time_end"] => string(14) "20170606220523"
	 *	  ["total_fee"] => string(1) "1"
	 *	  ["trade_type"] => string(5) "JSAPI"
	 *	  ["transaction_id"] => string(28) "4000002001201706064608516151" // 微信订单号
	 *	}
	*/
	public function changeOrder($data)
	{
		$save = [
			'wechat_order_number' 	=> $data['transaction_id'],
			'status'				=> 2,
			'pay_time'				=> $data['time_end'],
			'pay_status'			=> 1,
			'wechat_total'			=> $data['cash_fee']/100,
		];

		$this->where(['order_number' => $data['out_trade_no']])->save($save);
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
		$res = $this->where(['id' => I('get.id'), 'visitor_id' => $this->userInfo['id']])->getField('status');
		if ($res != 2) {
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
}
?>