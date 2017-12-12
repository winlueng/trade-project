<?php 
namespace PT2\Controller;

use Think\Controller;

class NewsController extends CommonController
{
	private $obj;
	public function __construct()
	{
		parent::__construct();
		$this->obj = new \PT2\Model\NewsModel;
	}

	public function newsList()
	{
		$where = [
			'company_id' => 0,
			'status'	 => ['not in', '-1,1'],
			'relevance_id' => $this->pInfo['id']
		];
		$classify = M('NewsClassify')->field('news_type_name,id')->where($where)->select();
		$id = I('get.news_classify_id')?I('get.news_classify_id'):$classify[0]['id'];
		$list = $this->obj->showNewsList($id);
		// dump($list);exit;
		$this->assign('classify', $classify);
		$this->assign('list', $list);
		$this->display();
	}

	public function newsDetail()
	{
		$newsInfo = $this->obj->selNewsInfo();
		// dump($newsInfo);exit;
		$this->assign('newsInfo', $newsInfo);
		$this->display();
	}
}