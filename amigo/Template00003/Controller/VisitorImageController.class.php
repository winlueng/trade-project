<?php 
namespace Template00003\Controller;

use Think\Controller;

// 预约订单
class VisitorImageController extends CommonController
{
	private $obj;

	public function __construct()
	{
		parent::__construct();
		$this->obj = new \Template00002\Model\VisitorImageModel();
		
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