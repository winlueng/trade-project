<?php
namespace Admin\Model;

use Think\Model;
use Think\Exception;

class WechatRefundModel extends CommonModel
{
	private $host;
	public function __construct()
	{
		parent::__construct();
		$this->host  = $this->getHostUrl();
	}

	public function orderList($set_where = [])
	{
		$where['company_id'] = $this->userInfo['company_id'];

		$where = array_merge($where, $set_where);

		// 订单状态查询
		switch (I('get.status')) {
			case '1':// 待付款
				$where = [
					'status'	  => 0
				];
				break;
			case '2':// 待发货
				$where = [
					'status'	  => 1
				];
				break;
			case '3':
				$where = [
					'status'	  => 2
				];
				break;
		}
		if(I('get.start') && I('get.end')) $where['create_time'] = [['gt', I('get.start')/1000], ['lt', I('get.end')/1000]];
		
		if(I('get.out_refund_no')) $where = ['out_refund_no' => I('get.out_refund_no')];

		$count = $this->where($where)->count();

		$page = new \Think\Page($count, 8);

		$list = $this->where($where)
		       ->order('create_time desc')
		       ->limit($page->firstRow.','.$page->listRows)
		       ->select();
		foreach ($list as $v) {
			$v['visitor_name'] = M('VisitorInfo')->where(['visitor_id' => $v['visitor_id']])->getField('nick_name');
			if ($v['company_id']) {
				$v['company_name'] = M('Company')->where(['id' => $v['company_id']])->getField('company_name');
			}
			$info = M('OrderForm')->field('goods_data, address_id')->where(['order_number' =>$v['out_trade_no']])->find();
			$v['address_id'] = json_decode($info['address_id'], true);
			$v['goods_data'] = json_decode($info['goods_data'], true);
			$arr = [];
			foreach ($v['goods_data'] as $vo) {
				$vo['goodsInfo'] = M('Goods')->where(['id' => $vo['goods_id']])->getField('goods_name');
				$vo['goodsAttr'] = M('GoodsAttribute')->where(['id' => $vo['attribute_id']])->find();
				$vo['goodsTotal'] = (int)$vo['total'] * (int)$vo['price'];
				$arr[] = $vo;
			}
			$v['goods_data'] = $arr;
			$result['list'][] = $v;
		}
		$result['page'] = $page->show();
		return $result;
	}

	public function excelBefore()
	{
		$where['company_id'] = $this->userInfo['company_id'];

		// 订单状态查询
		switch (I('get.status')) {
			case '1':// 待付款
				$where = [
					'status'	  => 0
				];
				$result['name'] = '申请退款';
				break;
			case '2':// 待发货
				$where = [
					'status'	  => 1
				];
				$result['name'] = '已退款';
				break;
			case '3':
				$where = [
					'status'	  => 2
				];
				$result['name'] = '拒绝退款';
				break;
		}
		if(I('get.start') && I('get.end')) {
			$where['create_time'] = [['gt', I('get.start')/1000], ['lt', I('get.end')/1000]];
			$result['name'] = date('Y-m-d', I('get.start')/1000).'至'.date('Y-m-d', I('get.end')/1000).$name.'退款订单表';
		}else{
			$result['name'] = '总退款订单表';
		}
		
		if(I('get.out_refund_no')) $where = ['out_refund_no' => I('get.out_refund_no')];

		$list = $this->where($where)
		       ->order('create_time desc')
		       ->select();
		foreach ($list as $v) {
			$info = M('OrderForm')->field('goods_data, address_id')->where(['order_number' =>$v['out_trade_no']])->find();
			$v['address_id'] = json_decode($info['address_id'], true);
			$v['goods_data'] = json_decode($info['goods_data'], true);

			$arr = [];
			foreach ($v['goods_data'] as $vo) {
				$vo['goodsInfo'] = M('Goods')->where(['id' => $vo['goods_id']])->getField('goods_name');
				$vo['goodsAttr'] = M('GoodsAttribute')->where(['id' => $vo['attribute_id']])->find();
				$vo['goodsTotal'] = (int)$vo['total'] * (int)$vo['price'];
				$arr[] = $vo;
			}
			$v['goods_data'] = $arr;
			switch ($v['status']) {
				case '0':// 待付款
					$v['status'] = '申请退款中';
					break;
				case '1':// 待发货
					$v['status'] = '已退款';
					break;
				case '2':
					$v['status'] = '拒绝退款';
					break;
			}
			$v['visitor_name'] = M('VisitorInfo')->where(['visitor_id' => $v['visitor_id']])->getField('nick_name');
			$result['list'][] = $v;
		}
		return $result;
	}

	/**
	 * 订单详情
	 */
	public function orderInfo($where = '')
	{
		if (I('get.id')) {
			$where = ['id' => I('get.id')];
		}
		$info = $this->where($where)->find();
		// dump($info);exit;
		$where = [
			'order_number' 	=> ['eq', $info['out_trade_no']],
			'project_order'	=> ['eq', $info['out_trade_no']],
			'_logic'		=> 'or'
		];
		$info['orderInfo'] = D('OrderForm')->orderInfo($where, true);
		$info['visitor_name'] = M('VisitorInfo')->where(['visitor_id' => $info['visitor_id']])->getField('nick_name');
		return $info;
	}

	/**
	 * 微信退款申请
	 * @return [type] [description]
	 */
	public function wxToRefund($info)
	{
		
		$info['refund_fee'] 	= I('post.refund_fee') * 100;
		$info['total_fee'] 		= $info['total_fee'] * 100;
		$out_trade_no 			= $info['out_trade_no'];
		$project_order 	= M('OrderForm')->where(['order_number' => $info['out_trade_no']])->getField('project_order');
		$count = M('OrderForm')->where(['project_order' => $project_order])->count();
		if ($count > 1) {
			$info['out_trade_no'] = $project_order;
		}
		$xml = $this->wechat->wxRefund($info);
		$url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
		$data = curl_post_ssl($url,$xml,$this->userInfo['pem_addr']);
		libxml_disable_entity_loader(true);
        $res = json_decode(json_encode(simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        if ($res['result_code'] === 'SUCCESS') {
        	$save = [
        		'status' 		=> 1,
        		'admin_id' 		=> $this->userInfo['id'],
        		'admin_remark' 	=> I('post.admin_remark'),
        		'refund_fee'   	=> I('post.refund_fee'),
        		'refund_id'		=> $res['refund_id'],
        		'update_time'	=> time(),
        		'is_control'	=> 1
        	];
        	$where = [
        		'out_refund_no' 	=> $res['out_refund_no'],
        		'out_trade_no'		=> $out_trade_no,
        		'transaction_id'	=> $res['transaction_id'],
        		'relevance_id'		=> $this->userInfo['relevance_id'],
        	];
        	// dump($where);exit;
        	$this->startTrans();
        	try {
	        	$result = $this->where($where)->save($save);
	        	if(!$result) throw new Exception("更新数据失败,请重新确认退款申请1", 1);

	        	$result = M('OrderForm')->where(['order_number' => $out_trade_no, 'relevance_id' => $this->userInfo['relevance_id']])->setField('status', 6);

        		if(!$result) throw new Exception("更新数据失败,请重新确认退款申请2", 1);

				$orderInfo = M('OrderForm')->field('id,visitor_id')->where(['order_number' => $res['out_trade_no'], 'relevance_id' => $this->userInfo['relevance_id']])->find();

        		$openID = M('WechatVisitor')->where(['id' => $orderInfo['visitor_id']])->getField('open_id');

        		$nickName = M('VisitorInfo')->where(['visitor_id' => $orderInfo['visitor_id']])->getField('nick_name');

				$templateID = $this->wechatTemplateReturn('OPENTM408918579');

				$news =  [
						'first' 	=> ['value' => '您好,'. $nickName .',您的订单已退款'],
						'keyword1' 	=> ['value' => $res['out_trade_no']],
						'keyword2' 	=> ['value' => date('Y年m月d日 H:i:s', time())],
						'keyword3' 	=> ['value' => '退款成功'],
						'remark' 	=> ['value' => '请及时登录网站查看退款详情']
					];

				$url = $this->host[0].U($this->host['tem'].'/OrderForm/orderDetail', ['companyName' => $this->host[1] ,'id' => $orderInfo['id']]);// 用户的订单地址
				$this->wechat->send_template_news($openID, $templateID, $news, $url);// 发送消息给用户

        		$this->commit();
        		return ['status' => 'true'];
        	} catch (Exception $e) {
        		$this->rollback();
        		return ['status' => 'false', 'err_msg' => $e->getMessage()];
        	}
        }else{
        	return ['status' => 'false', 'err_msg' => $res['err_code_des']];
        }
	}

	/**
	 * 退款返回到钱包
	 */
	public function walletRefund($info)
	{
    	$save = [
    		'status' 		=> 1,
    		'admin_id' 		=> $this->userInfo['id'],
    		'admin_remark' 	=> I('post.admin_remark'),
    		'refund_fee'   	=> I('post.refund_fee'),
    		'update_time'	=> time(),
    		'is_control'	=> 1
    	];
    	$where = [
    		'out_trade_no'		=> $info['out_trade_no'],
    		'transaction_id'	=> 0,
    		'relevance_id'		=> $this->userInfo['relevance_id'],
    	];
    	// dump($where);exit;
    	$this->startTrans();
    	try {
    		if (I('post.refund_fee') > $info['total_fee']) throw new Exception("超出订单金额");

        	$result = $this->where($where)->save($save);
        	if(!$result) throw new Exception("更新数据失败,请重新确认退款申请1");

        	$result = M('OrderForm')->where(['order_number' => $info['out_trade_no'], 'relevance_id' => $this->userInfo['relevance_id']])->setField('status', 6);

    		if(!$result) throw new Exception("更新数据失败,请重新确认退款申请2");

			$orderInfo 	= M('OrderForm')->field('id,visitor_id')
			            ->where([
			            	'order_number' => $info['out_trade_no'], 
			            	'relevance_id' => $this->userInfo['relevance_id']
			            ])->find();

			$res = D('WasteBook')->refund_to_visitor($orderInfo,I('post.refund_fee'));

			if(!$res) throw new Exception("写入流水失败");

    		$openID 	= M('WechatVisitor')->where(['id' => $orderInfo['visitor_id']])->getField('open_id');

    		$nickName 	= M('VisitorInfo')->where(['visitor_id' => $orderInfo['visitor_id']])->getField('nick_name');

			$templateID = $this->wechatTemplateReturn('OPENTM408918579');

			$news =  [
					'first' 	=> ['value' => '您好,'. $nickName .',您的订单已退款'],
					'keyword1' 	=> ['value' => $res['out_trade_no']],
					'keyword2' 	=> ['value' => date('Y年m月d日 H:i:s', time())],
					'keyword3' 	=> ['value' => '退款成功'],
					'remark' 	=> ['value' => '请及时登录网站查看退款详情']
				];

			$url = $this->host[0].U($this->host['tem'].'/OrderForm/orderDetail', ['companyName' => $this->host[1] ,'id' => $orderInfo['id']]);// 用户的订单地址
			$this->wechat->send_template_news($openID, $templateID, $news, $url);// 发送消息给用户

    		$this->commit();
    		return ['status' => 'true'];
    	} catch (Exception $e) {
    		$this->rollback();
    		return ['status' => 'false', 'err_msg' => $e->getMessage()];
    	}
       
	}

	// 拒绝退款
	public function refuse_refund()
	{
		$where = ['id' => I('get.id'), 'relevance_id' => $this->userInfo['relevance_id']];
				
		$orderInfo = $this->field('out_trade_no, visitor_id, referer_status')->where($where)->find();

		try {
			$this->startTrans();

			$res = M('OrderForm')->where([
					'order_number' 	=> $orderInfo['out_trade_no'], 
					'relevance_id' 	=> $this->userInfo['relevance_id'],
					'visitor_id' 	=> $orderInfo['visitor_id'],
				])->save(['status'=> $orderInfo['referer_status'], 'refuse_remark' => I('post.admin_remark'), 'update_time' => time()]);

			if(!$res) throw new Exception("更新数据失败,请重新确认退款申请", 1);

			$data = [
				'admin_remark' 	=> I('post.admin_remark'),
				'status' 	   	=> 2,
				'is_control'	=> 1
			];

			$res = $this->where($where)->save($data);

			if(!$res) throw new Exception("更新数据失败,请重新确认退款申请", 1);

			$newsData = [
				'obj_id'  		=> $orderInfo['visitor_id'],
				'obj_type'		=> 3,
				'title' 		=> '您好,您的退款订单被拒绝',
				'create_time' 	=> time(),
				'url'			=> 'javasprict:;',
				'content'		=> '拒绝原因'.I('post.admin_remark'),
				'relevance_id'	=> $this->userInfo['relevance_id']
			];

			$res = M('SystemNews')->add($newsData);

			if(!$res) throw new Exception("操作失败,发送消息给用户失败", 1);

			$templateID = $this->wechatTemplateReturn('OPENTM408918579');

			$news =  [
					'first' 	=> ['value' => '您好,'. $nickName .',您的退款订单被拒绝'],
					'keyword1' 	=> ['value' => $orderInfo['out_trade_no']],
					'keyword2' 	=> ['value' => date('Y年m月d日 H:i:s', time())],
					'keyword3' 	=> ['value' => '拒绝退款'],
					'remark' 	=> ['value' => '拒绝原因:'.I('post.admin_remark')]
				];

			$url = $this->host[0].U($this->host['tem'].'/OrderForm/orderDetail', ['companyName' => $this->host[1] ,'id' => $orderInfo['id']]);// 用户的订单地址
			$this->wechat->send_template_news($openID, $templateID, $news, $url);

			$this->commit();
			return ['status' => 'true'];
		} catch (Exception $e) {
			$this->rollback();
			return ['status' => 'false', 'err_msg' => $e->getMessage()];
		}
	}

	public function wxRefund()
	{
		if (I('post.refund_fee')) {// 传入退款金额,同意退款
		// dump(I('post.'));exit;
			$info = M('WechatRefund')->field('out_trade_no,out_refund_no,transaction_id,total_fee')
					->where(['id' => I('get.id'), 'relevance_id' => $this->userInfo['relevance_id']])
					->find();
			// $this->ajaxReturn($info);
			if($info['transaction_id']){
				$res = $this->wxToRefund($info);
			}else{
				$res = $this->walletRefund($info);
			}
			return $res;
		}else{
			return $this->refuse_refund();
		}
	}

	public function ajaxControl($flag)
	{
		return $this->$flag();
	}
}
?>