<?php
namespace PT2\Controller;

use Think\Controller;

class SystemNewsController extends CommonController
{
	private $newObj;

	public function __construct()
	{
		parent::__construct();
		$this->newsObj = new \PT2\Model\SystemNewsModel;
	}

	public function newsList()
	{
		$result = $this->newsObj->newsList();
		
		// dump($result);exit;
		$this->assign('list', $result);
		$this->display();
	}

	public function ajaxControl()
	{
		if (IS_AJAX) {
			$this->ajaxReturn($this->newsObj->ajaxControl(I('get.flag')));
		}
	}
}

?>