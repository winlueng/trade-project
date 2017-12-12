<?php 
namespace Template00002\Controller;

use Think\Controller;

class NewsController extends CommonController
{
	private $newsObj;
	public function __construct()
	{
		parent::__construct();
		$this->newsObj = D('News');
	}
	public function newsList()
	{
		$newsList = $this->newsObj->showNewsList();
		$this->assign('newsList', $newsList['newsList']);
		$this->assign('classifyList', $newsList['classifyList']);
		$this->display();
	}

	public function newsDetail()
	{
		$newsInfo = $this->newsObj->selNewsInfo();
		// dump($newsInfo);exit;
		$this->assign('newsInfo', $newsInfo);
		$this->display();
	}

	public function ajaxControl()
	{
		if (IS_AJAX) 
		{
			$result = $this->newsObj->ajaxControl();
			$this->ajaxReturn($result);
		}
	}
}