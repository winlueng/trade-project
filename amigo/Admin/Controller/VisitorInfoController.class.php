<?php 
namespace Admin\Controller;

use Think\Controller;

/**
* 前台用户类
*/
class VisitorInfoController extends CommonController
{
	private $obj;
	public function __construct()
	{
		parent::__construct();
		$this->obj = D('VisitorInfo');

	}

	public function visitorList()
	{
		$list = $this->obj->getVisitorList();
		// dump($list);exit;
		$this->assign('list', $list['list']);
		$this->assign('page', $list['page']);
		$this->display();
	}

	public function ajaxControl()
	{
		if(!IS_AJAX) E('非法访问');

		$this->ajaxReturn($this->obj->ajaxControl(I('get.flag')));
	}

	public function visitorListByProject()
	{
		$where = [
			'relevance_id' => $this->userInfo['relevance_id'],
		];
		$list = $this->obj->getVisitorList($where);
		// dump($list);exit;
		$this->assign('list', $list['list']);
		$this->assign('page', $list['page']);
		$this->display();
	}
}

 ?>