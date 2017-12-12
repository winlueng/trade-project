<?php
namespace Template00003\Controller;

use Think\Controller;

class SystemNewsController extends CommonController
{
	private $newObj;

	public function __construct()
	{
		parent::__construct();
		$this->newsObj = new \Template00002\Model\SystemNewsModel;
	}

	public function newsList()
	{
		$result = $this->newsObj->newsList();
		
		// dump($result);exit;
		$this->assign('list', $result);
		$this->display();
	}

	// 商户系统消息列表
	/*public function showSystemNewsListByVisitor()
	{
		$result = $this->newsObj->showSystemNewsList('1,2');
		$this->assign('newsList', $result['list']);
		$this->assign('page', $result['page']);
		$this->display();
	}*/


	public function ajaxControl()
	{
		$result = $this->newsObj->ajaxControl(I('get.flag'));
		$this->ajaxReturn($result);
	}
}

?>