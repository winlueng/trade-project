<?php 
namespace Template00002\Controller;

use Think\Controller;

// 预约订单
class DesignerController extends CommonController
{
	private $obj;

	public function __construct()
	{
		parent::__construct();
		$this->obj = new \Template00002\Model\DesignerModel();
		$staff = M('Staff')->where(['visitor_id' => $this->userInfo['id'], 'status' => 0])->getField('id');
		// dump($staff);exit;
		if (!$staff) {
			$this->error('非法访问!');exit;
		}
	}

	public function orderList()
	{
		$list = $this->obj->orderList();
		// dump($list);exit;
		$this->assign('list', $list);
		$this->display();
	}

	public function orderInfo()
	{
		$info = $this->obj->orderInfo();
		// dump($info);exit;
		$this->assign('info', $info);
		$this->display();
	}

	public function showVisitorImage()
	{
		$info = $this->obj->showVisitorImage();
		if (!$info) {
			$this->error('他第一次来,还没做过服务呢.没他的形象资料');exit;
		}
		// dump($info);exit;
		$this->assign('info', $info);
		$this->display();
	}

	public function imageList()
	{
		$list = $this->obj->imageList();
		// dump($list);exit;
		$this->assign('list', $list);
		$this->display();
	}

	public function ajaxControl()
	{
		if(!IS_AJAX) E('非法访问');

		$this->ajaxReturn($this->obj->ajaxControl(I('get.flag')));
	}
}

?>