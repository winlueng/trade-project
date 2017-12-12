<?php 
namespace Template00003\Controller;

use Think\Controller;

class OrderFormController extends CommonController
{
	private $obj;
	public function __construct()
	{
		parent::__construct();
		$this->obj = new \Template00002\Model\OrderFormModel();
		// dump($this->userInfo);
	}

	public function orderList()
	{
		$list = $this->obj->orderList();
		// dump($list);exit;
		$this->assign('list',$list);
		$this->display();
	}

	public function addressList()
	{
		$list = D('VisitorAddress')->addrList();
		// dump($list);exit;
		$this->assign('list',$list);
		$this->display();
	}

	public function orderDetail()
	{
		$info = $this->obj->payBeforeGetOrderInfo();
		// dump($info);exit;
		
		// dump((1498022940 - time())/86400);exit;
		$address = json_decode($info['address_id'],true);
		// dump($address);exit;
		$this->assign('address', $address);
		$this->assign('info', $info);
		$this->display();
	}

	public function ajaxControl()
	{
		if (!IS_AJAX) E('非法访问');

		$result = $this->obj->ajaxControl(I('get.flag'));

		$this->ajaxReturn($result);
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