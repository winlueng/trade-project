<?php 
namespace Template00003\Controller;

use Think\Controller;

class NewsController extends CommonController
{
	private $newsObj;
	public function __construct()
	{
		parent::__construct();
		$this->newsObj = new \Template00002\Model\NewsModel;
	}
	public function newsList()
	{
		$where = [
			'company_id' => $this->companyInfo['id'],
			'status'	 => ['not in', '-1,1'],
			// 'relevance_id' => $this->pInfo['id']
		];
		
		$classify = M('NewsClassify')->field('news_type_name,id')->where($where)->select();
		// dump($classify);exit;
		$id = I('get.news_classify_id')?I('get.news_classify_id'):$classify[0]['id'];
		$list = $this->newsObj->showNewsList($id);
		// dump($list);exit;
		$this->assign('classify', $classify);
		$this->assign('list', $list);
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