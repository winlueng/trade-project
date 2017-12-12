<?php 
namespace PT2\Controller;

use Think\Controller;

class OrderFormController extends CommonController
{
	private $obj;
	private $visitorInfoObj;
	public function __construct()
	{
		parent::__construct();
		$this->obj = new \PT2\Model\OrderFormModel();
		// dump($this->userInfo);exit;
		$this->visitorInfoObj = new \PT2\Model\VisitorInfoModel;
	}

	public function orderList()
	{
		$list = $this->obj->orderList();
		// dump($list);exit;
		// dump(implode(',',array_keys($list[0]['goods_data'])));exit;
		$this->assign('list',$list);
		$this->display();
	}

	// 待提交订单页面
	public function unpaid()
	{
		/*echo '<pre>';
		dump(I('post.'));exit;*/

		$list = $this->obj->insertBefore(I('get.way'));
		$data = $list['project_order']?$this->redis->get($list['project_order']):$this->redis->get(session('order_no_'. $this->userInfo['id']));
		// dump($this->redis->get(session('order_no')));exit;
		$data = json_decode($data, true);
		$this->assign('addr_id', $data['address_id']);
		$this->assign('list',$list);
		$this->display();
	}

	// 支付成功页
	public function payed()
	{
		if (I('get.project_order')) {
			$where = ['project_order' => I('get.project_order')];
		}elseif(I('get.order_id')){
			$where = ['id' => I('get.order_id')];

		}
		$total 		= $this->obj->where($where)->getField('wechat_total');
		$selYouLike	= $this->visitorInfoObj->selYouLike();
		// dump($selYouLike);exit;
		$this->assign('sel_you_like', $selYouLike);
		$this->assign('total', $total);
		$this->display();
	}

	public function orderDetail()
	{
		$info = $this->obj->payBeforeGetOrderInfo();
		$address = json_decode($info['address_id'],true);
		// dump($info);exit;
		$this->assign('address', $address);
		$this->assign('info', $info);
		$this->display();
	}

	public function ajaxControl()
	{
		if (!IS_AJAX) E('非法访问');

		$this->ajaxReturn($this->obj->ajaxControl(I('get.flag')));
	}

	public function returnWXPay()
	{
		/*dump(S('qwe'));
		dump(S('GET'));
		exit;*/
		list($res, $notifyData, $replyData) = $this->wechat->progressWxPayNotify();
		if ($res) {
			S('qwe',$notifyData);
			S('GET',I('get.'));
			$result = $this->obj->changeOrder($notifyData);
			if ($result) {
				$this->wechat->replyWxPayNotify($replyData);
			}
		}
		exit();
	}

	public function orderApplicationForDrawback()
	{
		if (IS_POST) {
			// dump(I('post.'));exit;
			$res = $this->obj->orderApplicationForDrawback();
			if ($res) {
				$this->success('提交成功');exit;
			}
			$this->error('提交异常');exit;
		}
	}

	public function refundList()
	{
		$list = $this->obj->orderList();
		$this->assign('list',$list);
		$this->display();
	}
}

?>