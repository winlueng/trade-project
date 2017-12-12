<?php
namespace Admin\Model;

use Think\Model;
use Think\Exception;

class OrderFormModel extends CommonModel
{
	private $host;
	public function __construct()
	{
		parent::__construct();
		$this->host  = $this->getHostUrl();
	}

	public function orderList($setWhere = [])
	{
		$order = 'create_time desc';
		$where = [
			'relevance_id' => $this->userInfo['relevance_id'],
			'company_id' => $this->userInfo['company_id'],
		];
		// 订单状态查询
		switch (I('get.status')) {
			case '1':// 待付款
				$where = [
					'is_send_out' => 0,
					'status'	  => 0
				];
				break;
			case '2':// 待发货
				$where = [
					'is_send_out' => 0,
					'status'	  => 2
				];
				$order = 'pay_time';
				break;
			case '3':// 已发货
				$where = [
					'is_send_out' => 1,
					'status'	  => 2
				];
				$order = 'update_time desc';
				break;
			case '4':// 已完成(待评价)
				$where = [
					'is_send_out' => 2,
					'status'	  => ['in', '2,4']
				];
				break;
			case '5':// 已完成(待评价)
				$where = [
					'status'	  => 5
				];
				$order = 'update_time';
				break;
			case '6':// 已完成(待评价)
				$where = [
					'status'	  => ['in', '6,7']
				];
				$order = 'update_time desc';
				break;
		}

		if (I('get.visitor_id')) {
			$where['visitor_id'] = I('get.visitor_id');
		}

		if(!empty($setWhere)) $where = array_merge($where, $setWhere);

		if(I('get.start') && I('get.end')) $where['create_time'] = [['gt', I('get.start')/1000], ['lt', I('get.end')/1000]];

		if(I('get.order_number')) $where = ['order_number' => I('get.order_number')];

		$count = $this->where($where)->count();

		$page = new \Think\Page($count, 5);

		$list = $this->where($where)
		       ->order($order)
		       ->limit($page->firstRow.','.$page->listRows)
		       ->select();
		foreach ($list as $v) {
			$v['goods_data'] = json_decode($v['goods_data'], true);
			$v['piece'] = 0;
			if ($v['company_id'] != 0) {
				$v['company_name'] = M('Company')->where(['id' => $v['company_id']])->getField('company_name');
			}
			foreach ($v['goods_data'] as $vo) {
				$vo['goodsInfo'] = M('Goods')->where(['id' => $vo['goods_id']])->getField('goods_name');
				$vo['goodsAttr'] = M('GoodsAttribute')->where(['id' => $vo['attribute_id']])->find();
				$vo['goodsTotal'] = (int)$vo['total'] * (int)$vo['price'];
				$arr[] = $vo;
			}
			$v['address_id'] = json_decode($v['address_id'], true);
			$v['goods_data'] = $arr;
			$arr = [];
			$v['piece'] += (int)$vo['total'];
			$result['list'][] = $v;
		}
		$result['page'] = $page->show();
		return $result;
	}

	// 导出excel前查询数据
	public function excelBefore($setWhere = [])
	{
		// 订单状态查询
		switch (I('get.status')) {
			case '1':// 待付款
				$name = '待付款';
				$where = [
					'is_send_out' => 0,
					'status'	  => 0
				];
				break;
			case '2':// 待发货
				$name = '待发货';
				$where = [
					'is_send_out' => 0,
					'status'	  => 2
				];
				break;
			case '3':// 已发货
				$name = '已发货';
				$where = [
					'is_send_out' => 1,
					'status'	  => 2
				];
				break;
			case '4':// 已完成(待评价)
				$name = '已完成';
				$where = [
					'is_send_out' => 2,
					'status'	  => ['in', '2,4']
				];
				break;
			case '5':// 已完成(待评价)
				$name = '申请售后';
				$where = [
					'status'	  => 5
				];
				break;
			case '6':// 已完成(待评价)
				$name = '已处理售后';
				$where = [
					'status'	  => ['in', '6,7']
				];
				break;
		}
		if(!empty($setWhere)) $where = array_merge($where, $setWhere);
		if(!$where) $where = $setWhere;
		if(I('get.start') && I('get.end')) {
			$where['create_time'] = [['gt', I('get.start')/1000], ['lt', I('get.end')/1000]];
			$result['name'] = date('Y-m-d', I('get.start')/1000).'至'.date('Y-m-d', I('get.end')/1000).$name.'订单表';
		}else{
			$result['name'] = '总订单表';
		}

		if (I('get.visitor_id')) $where['visitor_id'] = I('get.visitor_id');

		$field = 'order_number, wechat_order_number, status, goods_data, express_price, wechat_total, address_id, admin_remark, create_time, pay_time, is_send_out, pay_type, company_id';

		$list = $this->field($field)
				->where($where)
		       	->order('create_time desc')
		       	->select();
		foreach ($list as $v) {
			$v['goods_data'] = json_decode($v['goods_data'], true);
			$v['piece'] = 0;
			switch (I('get.status')) {
				case '0':
					switch ($v['status']) {
						case '0':// 待付款
							$v['status'] =  '代付款';
							break;
						case '1':// 待付款
							$v['status'] =  '取消订单';
							break;
						case '2':// 待发货
							switch ($v['is_send_out']) {
								case '0':
									$v['status'] =  '待发货';
									break;
								case '1':
									$v['status'] =  '待收货';
									break;
								case '2':
									$v['status'] =  '已收货';
									break;
							}
							break;
						case '3':// 已发货
							$v['status'] = '关闭交易';
							break;
						case '4':// 已完成(待评价)
							$v['status'] =  '已完成';
							break;
						case '5':// 已完成(待评价)
							$v['status'] =  '申请售后';
							break;
						case '6':
							$v['status'] =  '同意退款';
							break;
						case '7':
							$v['status'] =  '拒绝退款';
							break;
					}
					break;
				case '1':// 待付款
					$v['status'] =  '待付款';
					break;
				case '2':// 待发货
					$v['status'] =  '待发货';
					break;
				case '3':// 已发货
					$v['status'] = '已发货';
					break;
				case '4':// 已完成(待评价)
					$v['status'] =  '已完成';
					break;
				case '5':// 已完成(待评价)
					$v['status'] =  '申请售后';
					break;
				case '6':// 已完成(待评价)
					switch ($v['status']) {
						case '6':
							$v['status'] =  '同意退款';
							break;
						case '7':
							$v['status'] =  '拒绝退款';
							break;
					}
					break;
			}
			foreach ($v['goods_data'] as $vo) {
				$vo['goodsInfo'] = M('Goods')->where(['id' => $vo['goods_id']])->getField('goods_name');
				$vo['goodsAttr'] = M('GoodsAttribute')->where(['id' => $vo['attribute_id']])->find();
				$vo['goodsTotal'] = (int)$vo['total'] * (int)$vo['price'];
				$arr[] = $vo;
			}
			if ($v['company_id'] != 0) {
				$v['company_name'] = M('Company')->where(['id' => $v['company_id']])->getField('company_name');
			}
			$v['address_id'] = json_decode($v['address_id'], true);
			$v['goods_data'] = $arr;
			$arr = [];
			$v['piece'] += (int)$vo['total'];
			$v['pay_time'] = $v['pay_time']?wechatPayTime($v['pay_time']):'未支付';
			$v['create_time'] = date('Y年m月d日 H:i:s',$v['create_time']);
			$result['list'][] = $v;
		}
		return $result;
	}

	/**
	 * 订单详情
	 */
	public function orderInfo($setWhere = '', $bool=false)
	{
		$where = [
				'id' 			=> I('get.id'), 
				'company_id' 	=> $this->userInfo['company_id'],
				'relevance_id' 	=> $this->userInfo['relevance_id'],
				'status'		=>  ['neq', '-1'],
			];

		if($setWhere) {
			$where = array_merge($where, $setWhere);
		}

		if ($bool) {
			$where = $setWhere;
		}

		$result = $this->where($where)->find();

		if (in_array((string)$result['status'], ['5', '6', '7'])) {
			$result['refundInfo'] = M('WechatRefund')->field('out_refund_no, refund_remark, admin_remark')->where(['out_trade_no' => $result['order_number'], 'company_id' => $this->userInfo['company_id']])->find();
		}

		$result['goods_data'] = json_decode($result['goods_data'], true);

		foreach ($result['goods_data'] as $vo) {

			$vo['goodsInfo'] = M('Goods')->where(['id' => $vo['goods_id']])->getField('goods_name');

			$vo['goodsAttr'] = M('GoodsAttribute')->where(['id' => $vo['attribute_id']])->find();

			if ($result['status'] == 4) {// 如果已经完成,查询评论
				$vo['comment'] = M('GoodsComment')
						->where(['order_id' => $result['id'], 'goods_id' => $vo['goods_id'], 'visitor_id' => $result['visitor_id']])
						->find();
				$vo['comment']['image'] = $vo['comment']['image']?json_decode($vo['comment']['image'], true):'';
			}

			$arr[] = $vo;
		}

		$result['address_id'] = json_decode($result['address_id'], true);

		$result['goods_data'] = $arr;

		$result['head_portrait'] = M('VisitorInfo')->where(['visitor_id' => $result['visitor_id']])->getField('head_portrait');

		return $result;
	}

	public function selExpress()
	{
		$info = $this->field('address_id,order_number')->where(['id' => I('get.id')])->find();
		$info['address_id'] = json_decode($info['address_id'], true);
		$express = M('ExpressTrace')->field('trace,express_coding,express_number')->where(['order_number' => $info['order_number']])->find();
		$info['express']['Traces'] = json_decode($express['trace'], true);
		$info['express']['express_number'] = $express['express_number'];
		$info['express']['name'] = M('Express')->where(['coding' => $express['express_coding']])->getField('name');
		return ['status' => 'true','info' => $info];
	}

	/**
	 * 商品发货
	 */
	public function sendExpress()
	{
		$where = [
				'id' => I('get.id'), 
				'company_id' => $this->userInfo['company_id'], 
				'relevance_id' => $this->userInfo['relevance_id']
			];

		$data['is_send_out'] 	= 1;
		$data['update_time'] 	= time();
		$data['is_control']  	= 1;
		$data['express_way']  	= I('post.express_way');
		$this->startTrans();

		try {
			if (I('post.express_way') == '1') {
				$sel = $this->field('visitor_id, order_number')->where($where)->find();
				$express_info = [
					'order_number'   => $sel['order_number'],
					'visitor_id' 	 => $sel['visitor_id'],
					'express_coding' => I('post.express_name'),
					'express_number' => I('post.express_number'),
					'relevance_id' 	 => $this->userInfo['relevance_id'],
					'company_id' 	 => $this->userInfo['company_id'],
				];
				// return $express_info;
				$res = D('ExpressTrace')->expressSend($express_info);
				if ($res['status'] == 'false') throw new Exception($res['err_msg']);
			}else{
				$data['is_send_out'] 	= 2;
				$data['express_way']  	= 2;
			}
			

			$res = $this->where($where)->save($data);

			if (!$res) throw new Exception("更新订单发货状态失败");
			
			$info = $this->field('id, address_id, order_number, visitor_id')->where($where)->find();

			$info['address_id'] = json_decode($info['address_id'], true);

			$openID 	= M('WechatVisitor')->where(['id' => $info['visitor_id']])->getField('open_id');

			$nickName 	= M('VisitorInfo')->where(['visitor_id' => $info['visitor_id']])->getField('nick_name');
			if (I('post.express_way') == 1) {

				$expressName = M('Express')->where(['coding' => I('post.express_name')])->getField('name');
			}
			$templateID = $this->wechatTemplateReturn('OPENTM410578602');
			
			$news =  [
					'first' 	=> ['value' => '您好,'.$nickName. ',您的宝贝已发货!'],
					'keyword1' 	=> ['value' => $info['address_id']['consignee']],
					'keyword2' 	=> ['value' => $info['address_id']['phone']],
					'keyword3' 	=> ['value' => I('post.express_way')==1?$expressName:'自提'],
					'keyword4' 	=> ['value' => I('post.express_way')==1?I('post.express_number'):'自提'],
					'keyword5' 	=> ['value' => $info['order_number']],
					'remark' 	=> ['value' => '谢谢您的支持,亲.']
				];
				
			$url = $this->host[0].U($this->host['tem'].'/Express/showExpressInfo', ['companyName' => $this->host[1] ,'id' => $info['id']]);

			$newsData = [
				'obj_id'  		=> $info['visitor_id'],
				'title' 		=> '您好,'.$nickName. ',您的宝贝已发货!',
				'create_time' 	=> time(),
				'url'			=> $url,
				'content'		=> '您好,您的订单号:'.$info['order_number'].'已经发货了!',
			];

			$res = M('SystemNews')->add($newsData);

			if(!$res) throw new Exception("发送系统消息失败");
			
			$this->wechat->send_template_news($openID, $templateID, $news, '');// 发送消息给用户
			$this->commit();
			return ['status' => true];
		} catch (Exception $e) {
			$this->rollback();
			$this->error = $e->getMessage();return false;
			// return ['status' => false, 'err_msg' => $e->getMessage()];
		}
		
	}

	public function recontent()
	{
		$templateID = $this->wechatTemplateReturn('OPENTM409367327');

		$info = M('GoodsComment')->field('visitor_id, content, order_id')->where(['id' => I('get.id')])->find();

		$nickName = M('VisitorInfo')->where(['visitor_id' => $info['visitor_id']])->getField('nick_name');

		$news =  [
					'first' 	=> ['value' => '您好,'. $nickName .',谢谢您的评价.'],
					'keyword1' 	=> ['value' => $info['content']],
					'keyword2' 	=> ['value' => date('Y年m月d日 H:i', time())],
					'keyword3' 	=> ['value' => I('post.recontent')],
					'remark' 	=> ['value' => '感谢您的支持哦!']
				];

		$res = M('GoodsComment')->where(['id' => I('get.id')])->setField('recontent',I('post.recontent'));

		if ($res) {
			$url = $this->host[0].U($this->host['tem'].'/OrderForm/orderDetail', ['companyName' => $this->host[1] ,'id' => $info['order_id'],'back' => 1]);

			$openID = M('WechatVisitor')->where(['id' => $info['visitor_id']])->getField('open_id');

			$result = $this->wechat->send_template_news($openID, $templateID, $news,$url);// 发送消息给用户

			$newsData = [
				'obj_id'  		=> $info['visitor_id'],
				'title' 		=> '您好,您的订单号:'.$info['order_number'].',有回复消息!',
				'create_time' 	=> time(),
				'url'			=> $url,
				'content'		=> I('post.recontent'),
			];
			
			M('SystemNews')->add($newsData);
			return $res;
		}
		$this->error = '评论失败';return false;
	}

	public function ajaxControl($flag)
	{
		return $this->$flag();
	}
}
?>