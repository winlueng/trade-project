<?php 
namespace Template00003\Controller;

use Think\Controller;

class SubscribeOrderFormController extends CommonController
{
	public function __construct()
	{
		parent::__construct();
		// dump($this->userInfo);exit;
		$this->obj = new \Template00002\Model\SubscribeOrderFormModel();
	}

	/**
	 * 预约订单生成页面
	 */
	public function orderInsert()
	{
		$staffInfo = M('Staff')->field('staff_logo,store_nickname,professional_title,speciality')
					->where(['id' => I('get.staffID'), 'company_id' => $this->companyInfo['id']])->find();
		$this->assign('staffInfo', $staffInfo);
		$this->assign('userInfo', $this->userInfo);
		$this->display();
	}

	/**
	 * 生成预约订单
	 */
	public function insert()
	{
		// dump(I('post.'));exit;
		if (IS_POST) {
			$res = $this->obj->insert();
			// dump($res);exit;
			if ($res) {
				$this->success('订单生成成功', U('SubscribeOrderInfo', ['companyName' => I('get.companyName'), 'id' => $res]));exit;
			}
			$this->error($this->obj->getError());exit;
		}
	}

	/**
	 * 预约订单列表
	 */
	public function orderList()
	{
		$list = $this->obj->orderList();
		// dump($list);exit;
		$this->assign('empty', '<br><br><center>没有你想要的哦</center>');
		$this->assign('list', $list);
		$this->display();
	}

	/**
	 * 预约订单详情
	 */
	public function SubscribeOrderInfo()
	{
		$info = $this->obj->orderInfo();
		$this->assign('info', $info);
		$this->display();
	}

	/**
	 * 填写预约人信息页面
	 */
	public function information()
	{
		$this->display();
	}

	/**
	 * 取消预约提交并发送微信通知
	 */
	public function orderCancel()
	{
		$where = ['id' => I('get.id'), 'visitor_id' => $this->userInfo['id']];

		$save = [
			'status' => 5,
			'remark' => I('post.drawback_remark'),
			'update_time' => time(),
		];

		$result = $this->obj->where($where)->save($save);

		if ($result) {

			$info = $this->obj->field('staff_id,subscribe_number,come_time')->where($where)->find();

			$id = M('Staff')->where(['id' =>$info['staff_id']])->getField('visitor_id');

			$openID = M('WechatVisitor')->where(['id' => $id])->getField('open_id');

			$templateID = $this->wechatTemplateReturn('OPENTM401761240');
			
			$news =  [
					'first' 	=> ['value' => '你好,你的预约订单号:'.$info['subscribe_number'].'.取消了!'],
					'keyword1' 	=> ['value' => '预约美容'],
					'keyword2' 	=> ['value' => date('Y-m-d H:i', $info['come_time'])],
					'keyword3' 	=> ['value' => I('post.drawback_remark')],
					'remark' 	=> ['value' => '点黎睇睇咩回事']
				];

			// $url = 'http://'.$_SERVER['HTTP_HOST'].U('SubscribeOrderForm')
			$res = $this->wechat->send_template_news($openID, $templateID, $news);// 发送取消预约通知模版
			if ($res) {
				$this->success('取消成功!');exit;
			}
		}else{
			$this->error('取消失败!');exit;
		}
	}

	public function returnWXPay()
	{
		list($res, $notifyData, $replyData) = $this->wechat->progressWxPayNotify();
		if ($res) {
			$this->obj->changeOrder($notifyData);
		}
		$this->wechat->replyWxPayNotify($replyData);
		exit();
	}

	public function ajaxControl()
	{
		if (!IS_AJAX) E('非法访问');

		$result = $this->obj->ajaxControl(I('get.flag'));

		$this->ajaxReturn($result);
	}

}


 ?>