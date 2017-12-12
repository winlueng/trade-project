<?php 
namespace PT2\Controller;

use Think\Controller;

class VisitorTrackController extends CommonController
{
	private $obj;

	public function __construct()
	{
		parent::__construct();
		$this->obj = new \PT2\Model\VisitorTrackModel();
		
	}

	public function myTrack()
	{
		$list = $this->obj->myTrack();
		// dump($list[0]);exit;
		$this->assign('list', $list);
		$this->display();
	}

	public function ajaxControl()
	{
		if (IS_AJAX) {
			$this->ajaxReturn($this->obj->ajaxControl(I('get.flag')));
		}
	}
}

 ?>