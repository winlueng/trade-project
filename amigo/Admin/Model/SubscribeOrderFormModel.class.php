<?php
namespace Admin\Model;

use Think\Model;

class SubscribeOrderFormModel extends CommonModel
{
	private $where;
	private $host;
	private $openID;
	private $staffOpenID;
	private $info;
	private $nickName;
	private $staffID;

	public function __construct()
	{
		parent::__construct();
		$this->where = ['id' => I('get.id'), 'company_id' => $this->userInfo['company_id']];
		$this->host  = $this->getHostUrl();
		$this->info = $this->field('visitor_id,staff_id,subscribe_number,people')->where($this->where)->find();
		$this->openID = M('WechatVisitor')->where(['id' => $this->info['visitor_id']])->getField('open_id');
		$this->nickName = M('VisitorInfo')->where(['visitor_id' => $this->info['visitor_id']])->getField('nick_name');
		$this->staffInfo = M('Staff')->field('store_nickname,visitor_id')->where(['id' => $this->info['staff_id']])->find();
		$this->staffOpenID = M('WechatVisitor')->where(['id' => $this->staffInfo['visitor_id']])->getField('open_id');
	}

	/**
	 * 预约概况
	 */
	public function orderData()
	{
		$yesterday = strtotime(date('Y-m-d',strtotime('yesterday')));

		$info['yesterdayData'] = [
				'orderCount' =>  $this->where(['complete_time' => [['gt', $yesterday], ['lt', $yesterday + 86400]], 'company_id' => $this->userInfo['company_id'], 'status' => ['in','3,4']])->count(),// 成交量
				'sql' => $this->getLastSql(),
				'orderTotal' =>  $this->where(['create_time' => [['gt', $yesterday], ['lt', $yesterday + 86400]], 'company_id' => $this->userInfo['company_id'],'status' => ['not in', '-1, 5']])->count(),// 订单数
				'priceTotal' =>  $this->where(['complete_time' => [['gt', $yesterday], ['lt', $yesterday + 86400]], 'company_id' => $this->userInfo['company_id'],'status' => ['in','3,4']])->sum('total'),// 成交额
				'cancelOrderCount'=>  $this->where(['update_time' => [['gt', $yesterday], ['lt', $yesterday + 86400]], 'company_id' => $this->userInfo['company_id'],'status' => 5])->count(),// 取消订单数
				// 'time'		 => $this->getLastSql(),
		];

		return $info;
	}

	public function firstOrderTable()
	{
		if (I('get.start') && I('get.end')) {
			$start = I('get.start')/1000;
			$end = I('get.end')/1000;
			$result['name'] = date('Y-m-d', I('get.start')/1000).'至'.date('Y-m-d', I('get.end')/1000).$name.'预约概况表';
		}else{
			$start = strtotime(date('Y-m-d',strtotime('-7 day')));
			$end = strtotime('Today');
			$result['name'] = '近7日预约概况表';
		}
		// return $day.'+'.$end;
		for ($i=$end; $i > $start-1;) { 
			// echo $i.'<br>';
			$info[] = [
				'time'		 	  => $i,
			];
			$i -= 86400;
		}

		$count = count($info);
		// 不够一页完整返回
		if ($count < 21 || I('get.getExcel')) 
		{
			$arr = $info;
		}else{
			$page = 0;

			if (I('get.p')) 
			{
				$page = (int)I('get.p') - 1;
			}

			$dataList = array_chunk($info, 20);
			$result['count'] = count($dataList);
			$arr = $dataList[$page]?$dataList[$page]:false;
		}

		if ($arr) {
			foreach ($arr as $v) {
				$result['list'][date('Y-m-d', $v['time'])] = [
					'orderCount' 	  =>  $this->where(['complete_time' => [['gt', $v['time'] - 1], ['lt', $v['time'] + 86399]], 'company_id' => $this->userInfo['company_id'], 'status' => ['in','3,4']])->count(),// 成交量
					'orderTotal' 	  =>  $this->where(['create_time' => [['gt', $v['time'] - 1], ['lt', $v['time'] + 86399]], 'company_id' => $this->userInfo['company_id'], 'status' => ['not in', '-1, 5']])->count(),// 订单数
					'priceTotal' 	  =>  $this->where(['complete_time' => [['gt', $v['time'] - 1], ['lt', $v['time'] + 86399]], 'company_id' => $this->userInfo['company_id'], 'status' => ['in','3,4']])->sum('total'),// 成交额
					// 'sql' => $this->getLastSql(),
					'cancelOrderCount'=>  $this->where(['update_time' => [['gt', $v['time'] - 1], ['lt', $v['time'] + 86399]], 'company_id' => $this->userInfo['company_id'], 'status' => 5])->count(),// 取消订单数
				];
			}
			return $result;
		}
	}

	public function secondOrderTable()
	{
		if (I('get.start') && I('get.end')) {
			$start = I('get.start')/1000;
			$end = I('get.end')/1000;
			$res['name'] = date('Y-m-d', I('get.start')/1000).'至'.date('Y-m-d', I('get.end')/1000).$name.'设计师预约概况表';
		}else{
			$start = strtotime(date('Y-m-d',strtotime('-7 day')));
			$end = strtotime('Today');
			$res['name'] = '近7日设计师预约概况表';
		}

		$where = [
			'company_id' => $this->userInfo['company_id'],
			'complete_time' => ['gt', $start],
			'status' => ['in','3,4']
		];

		if (I('get.getExcel')) {
			$list = $this->field('staff_id, service_content, total, is_offline_pay, complete_time')
					->where($where)
					->order('complete_time desc')
					->select();
			foreach ($list as $v) {
				$v['staff_name'] = M('Staff')->where(['id' => $v['staff_id']])->getField('store_nickname');
				$v['complete_time'] = date('Y-m-d', $v['complete_time']);
				$v['is_offline_pay'] = $v['is_offline_pay']?'线下支付':'线上支付';
				$res['list'][] = $v;
			}
			return $res;
		}

		$count = $this->where($where)->count();

		$page = new \Think\Page($count, 10);

		$list = $this->field('staff_id, service_content, total, is_offline_pay, complete_time')
				->where($where)
				->order('complete_time desc') 
				->limit($page->firstRow.','.$page->listRows)
				->select();

		foreach ($list as $v) {
			$v['staff_name'] = M('Staff')->where(['id' => $v['staff_id']])->getField('store_nickname');
			$v['complete_time'] = date('Y-m-d', $v['complete_time']);
			$v['is_offline_pay'] = $v['is_offline_pay']?'线下支付':'线上支付';
			$res['list'][] = $v;
		}
		$res['page'] = $page->show();
		return $res;
	}
	
	public function orderList()
	{
		$where = [
			'company_id' => $this->userInfo['company_id'],

		];

		switch (I('get.status')) {
			case '1':// 待确认
				$where['status'] = 0;
				break;
			case '2':// 待服务
				$where['status'] = ['in', '1,2'];
				break;
			case '3':// 待评价
				$where['status'] = 3;
				break;
			case '4':// 已完成
				$where['status'] = 4;
				break;
		}

		// if (I('get.visitor_id')) $where['status'] = I('get.visitor_id');

		if(I('get.start') && I('get.end')) $where['create_time'] = [['gt', I('get.start')/1000], ['lt', I('get.end')/1000]];

		if(I('get.order_number')) $where = ['order_number' => I('get.order_number')];

		if (I('get.visitor_id')) {
			$where['visitor_id'] = I('get.visitor_id');
		}

		$count = $this->where($where)->count();

		$page = new \Think\Page($count, 6);

		$info = $this->where($where)
				->order('create_time desc')
				->limit($page->firstRow.','.$page->listRows)
				->select();

		foreach ($info as $v) {
			$v['staffInfo'] = M('Staff')->where(['id' => $v['staff_id']])->find();
			$v['distance_time'] = turnDistanceTime($v['come_time']);
			$v['service_total'] = $this->where(['staff_id' => $v['staff_id'], 'status' => 4])->count();
			$result['list'][] = $v;
		}
		$result['page'] = $page->show();
		return $result;
	}

	public function excelBefore()
	{
		$where = [
			'company_id' => $this->userInfo['company_id']
		];

		switch (I('get.status')) {
			case '1':// 待确认
				$where['status'] = 0;
				$name = '待确认';
				break;
			case '2':// 待服务
				$where['status'] = ['in', '1,2'];
				$name = '待服务';
				break;
			case '3':// 待评价
				$where['status'] = 3;
				$name = '待评价';
				break;
			case '4':// 已完成
				$where['status'] = 4;
				$name = '已完成';
				break;
		}

		if(I('get.start') && I('get.end')) {
			$where['create_time'] = [['gt', I('get.start')/1000], ['lt', I('get.end')/1000]];
			$result['name'] = date('Y-m-d', I('get.start')/1000).'至'.date('Y-m-d', I('get.end')/1000).$name.'预约订单表';
		}else{
			$result['name'] = '总订单表';
		}

		if(I('get.order_number')) $where = ['order_number' => I('get.order_number')];

		if (I('get.visitor_id')) {
			$where['visitor_id'] = I('get.visitor_id');
		}

		$info = $this->where($where)
				->order('create_time desc')
				->select();

		foreach ($info as $v) {
			switch ($v['status']) {
				case '0':// 待确认
					$v['status'] = '待确认';
					break;
				case '1':// 待服务
					$v['status'] = '待服务';
					break;
				case '2':// 待评价
					$v['status'] = '待评价';
					break;
				case '3':// 已完成
					$v['status'] = '已付款';
					break;
				case '4':// 已完成
					$v['status'] = '已完成';
					break;
				case '5':// 已完成
					$v['status'] = '取消订单';
					break;
				case '6':// 已完成
					$v['status'] = '拒绝订单';
					break;
			}
			$v['is_offline_pay'] = $v['is_offline_pay']?'线下支付':'线上支付';
			$v['staffInfo'] = M('Staff')->where(['id' => $v['staff_id']])->find();
			$v['distance_time'] = turnDistanceTime($v['come_time']);
			$v['service_total'] = $this->where(['staff_id' => $v['staff_id'], 'status' => 4])->count();
			$v['buyer'] = '预约人:'.$v['people'].' ; 联系电话:'.$v['phone'].' ; 性别:'.($v['sex']==1?'男':'女');
			$result['list'][] = $v;
		}
		return $result;
	}

	/**
	 * 接受或拒绝订单
	 */
	public function concurnaysay()
	{
		switch (I('get.status')) {
			case '1':// 同意预约订单
				$data['status'] = I('get.status');

				$data['is_accepted'] 	= 1;

				$data['is_control']		= 1;

				$templateID = $this->wechatTemplateReturn('OPENTM207867403');
			
				$news =  [
						'first' 	=> ['value' => '恭喜,'. $this->nickName .',您的预约订单号:'.$this->info['subscribe_number'].'.受理啦!'],
						'keyword1' 	=> ['value' => '预约服务'],
						'keyword2' 	=> ['value' => '预约成功!'],
						'keyword3' 	=> ['value' => date('Y-m-d H:i', time())],
						'remark' 	=> ['value' => '您预约的门店正在为您准备中,请及时到店消费吧.']
					];

				// 发给设计师的
				$templateID2 = $this->wechatTemplateReturn('OPENTM207350009');

				$news2 =  [
						'first' 	=> ['value' => '您好, '.$this->staffInfo['store_nickname'].', 您有一个预约订单生成,订单号:'.$this->info['subscribe_number']],
						'keyword1' 	=> ['value' => $this->info['people'].'预约了你'],
						'keyword2' 	=> ['value' => date('Y-m-d H:i', time())],
						'remark' 	=> ['value' => '您有一个订单生成,请查看详情']
					];

				$newsData = [
					'obj_id'  		=> $this->info['visitor_id'],
					'title' 		=> '您好,'. $this->nickName .',您有一个订单生成.',
					'create_time' 	=> time(),
					'content'		=> '您有一个预约订单生成,订单号:'.$this->info['subscribe_number'].',请查看详情',
				];

				$url2 = $this->host[0].U($this->host[3].'/Designer/orderInfo', ['companyName' => $this->host[1] ,'id' => I('get.id'),'back' => 1]);// 用户的订单地址

				$this->wechat->send_template_news($this->staffOpenID, $templateID2, $news2, $url2);// 发送消息给设计师

				$newsData2 = [
					'obj_id'  		=> $this->staffInfo['visitor_id'],
					'obj_type'		=> 3,
					'title' 		=> '您好,'.$this->staffInfo['store_nickname'].'.'.$this->info['people'].'预约了你!',
					'create_time' 	=> time(),
					'url'			=> $url2,
					'content'		=> '您有一个预约订单生成,订单号:'.$this->info['subscribe_number'].',请查看详情',
				];

				M('SystemNews')->add($newsData2);
				break;
			case '6':
				$data = [
					'status' 		=> I('get.status'),
					'admin_remark' 	=> I('get.admin_remark'),
					'is_control'	=> 1
				];
				// return I('get.');
				$templateID = $this->wechatTemplateReturn('OPENTM407616608');
			
				$news =  [
						'first' 	=> ['value' => '您好,'. $this->nickName .',您有一条任务单被对方拒绝.'],
						'keyword1' 	=> ['value' => $this->info['subscribe_number']],
						'keyword2' 	=> ['value' => date('Y-m-d H:i', time())],
						'remark' 	=> ['value' => '拒绝原因:'.I('get.admin_remark')]
					];
				$newsData = [
					'obj_id'  		=> $this->info['visitor_id'],
					'title' 		=> '您好,'. $this->nickName .',您有一条任务单被对方拒绝.',
					'create_time' 	=> time(),
					'content'		=> '拒绝原因:'.I('get.admin_remark'),
				]; 
				break;
		}

		$res = $this->where($this->where)->save($data);

		if ($res) {
			$url = $this->host[0].U($this->host[3].'/SubscribeOrderForm/SubscribeOrderInfo', ['companyName' => $this->host[1] ,'id' => I('get.id'),'back' => 1]);// 用户的订单地址
			$this->wechat->send_template_news($this->openID, $templateID, $news, $url);// 发送消息给用户
			$newsData['url'] = $url;
			M('SystemNews')->add($newsData);
			return $res;
		}
		return 0;
	}

	/**
	 * 服务已完成
	 */
	public function confirmServe()
	{
		$data = [
			'total' 		=> I('get.total'),
			'status' 		=> 2,
			'service_content' 	=> I('get.service_content'),
			'complete_time' => time(),
		];

		if (I('get.is_offline_pay') == 1) {
			$data['status'] = 3;
			$data['is_offline_pay'] = I('get.is_offline_pay');

		}

		$templateID = $this->wechatTemplateReturn('OPENTM204821357');

		$news =  [
					'first' 	=> ['value' => '您好,'. $this->nickName .',您的服务单号:'.$this->info['subscribe_number'].'.已完成'],
					'keyword1' 	=> ['value' => I('get.service_content')],
					'keyword2' 	=> ['value' => date('Y年m月d日 H:i', time())],
					'remark' 	=> ['value' => '感谢您的支持哦!']
				];

		$res = $this->where($this->where)->save($data);

		if ($res) {
			$url = $this->host[0].U($this->host[3].'/SubscribeOrderForm/SubscribeOrderInfo', ['companyName' => $this->host[1] ,'id' => I('get.id'),'back' => 1]);// 用户的订单地址
			$this->wechat->send_template_news($this->openID, $templateID, $news, $url);// 发送消息给用户
			$newsData = [
				'obj_id'  		=> $this->info['visitor_id'],
				'title' 		=> '您好,'. $this->nickName .',您的服务已完成.',
				'create_time' 	=> time(),
				'url'			=> $url,
				'content'		=> '您好,您的服务单号:'.$this->info['subscribe_number'].',已经完成了.谢谢您的支持!',
			]; 
			M('SystemNews')->add($newsData);
			return $res;
		}
	}

	public function recontent()
	{
		$templateID = $this->wechatTemplateReturn('OPENTM409367327');

		$info = M('StaffComment')->field('visitor_id, content, subscribe_id')->where(['subscribe_id' => I('get.id')])->find();

		$news =  [
					'first' 	=> ['value' => '您好,'. $this->nickName .',谢谢您的评价.'],
					'keyword1' 	=> ['value' => $info['content']],
					'keyword2' 	=> ['value' => date('Y年m月d日 H:i', time())],
					'keyword3' 	=> ['value' => I('post.recontent')],
					'remark' 	=> ['value' => '感谢您的支持哦!']
				];

		$res = M('StaffComment')->where(['subscribe_id' => I('get.id')])->setField('recontent',I('post.recontent'));

		if ($res) {
			$openID = M('WechatVisitor')->where(['id' => $info['visitor_id']])->getField('open_id');

			$url = $this->host[0].U($this->host[3].'/SubscribeOrderForm/SubscribeOrderInfo', ['companyName' => $this->host[1] ,'id' => $info['subscribe_id'],'back' => 1]);

			$result = $this->wechat->send_template_news($openID, $templateID, $news, $url);// 发送消息给用户
			// 发送站内系统信息
			$newsData = [
				'obj_id'  		=> $info['visitor_id'],
				'title' 		=> '我们回复了您的评价',
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

	public function saveComeTime()
	{
		$res = $this->where($this->where)->setField('come_time',I('get.come_time'));
		if ($res) {
			$templateID = $this->wechatTemplateReturn('OPENTM202193611');

			$news =  [
					'first' 	=> ['value' => '您好,'. $this->nickName .',您的服务单号:'.$this->info['subscribe_number'].'.预约时间已重置'],
					'keyword1' 	=> ['value' => '服务预约预约时间更改'],
					'keyword2' 	=> ['value' => date('Y年m月d日 H:i', I('get.come_time'))],
					'remark' 	=> ['value' => '感谢您的支持哦!']
				];

			$url = $this->host[0].U($this->host[3].'/SubscribeOrderForm/SubscribeOrderInfo', ['companyName' => $this->host[1] ,'id' => I('get.id'),'back' => 1]);// 用户的订单地址

			$this->wechat->send_template_news($this->openID, $templateID, $news, $url);

			$url2 = $this->host[0].U($this->host[3].'/Designer/orderInfo', ['companyName' => $this->host[1] ,'id' => I('get.id'),'back' => 1]);// 用户的订单地址

			$news =  [
					'first' 	=> ['value' => '您好,'. $this->nickName .',您的服务单号:'.$this->info['subscribe_number'].'.预约时间已重置'],
					'keyword1' 	=> ['value' => '服务预约预约时间更改'],
					'keyword2' 	=> ['value' => date('Y年m月d日 H:i', I('get.come_time'))],
					'remark' 	=> ['value' => '感谢您的支持哦!']
				];

			$this->wechat->send_template_news($this->staffOpenID, $templateID, $news, $url2);

			$newsData = [
				'obj_id'  		=> $this->info['visitor_id'],
				'title' 		=> '您好,'. $this->nickName .',您的服务时间已重置',
				'create_time' 	=> time(),
				'url'			=> $url,
				'content'		=> '您好,'. $this->nickName .',您的服务单号:'.$this->info['subscribe_number'].'.预约时间已重置',
			];

			$newsData2 = [
				'obj_id'  		=> $this->staffInfo['visitor_id'],
				'obj_type'		=> 3,
				'title' 		=> '您好,'. $this->staffInfo['store_nickname'] .',预约订单的服务时间已重置',
				'create_time' 	=> time(),
				'url'			=> $url2,
				'content'		=> '您好,'. $this->staffInfo['store_nickname'] .',您的服务单号:'.$this->info['subscribe_number'].'.预约时间已重置',
			];

			M('SystemNews')->add($newsData);
			M('SystemNews')->add($newsData2);
		}
		return $res;
	}
}
?>