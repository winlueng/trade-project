<?php 
namespace PT1\Controller;

use Think\Controller;

class NewsController extends CommonController
{
	
	public function newsDetail()
	{
		$news = D('News');
		$newsInfo = $news->selNewsInfo();
		// dump($newsInfo);exit;
		$newslist = $news->selPrevAndNextNews();
		$this->assign('newsprev', $newslist['prev']);
		$this->assign('newsnext', $newslist['next']);
		$this->assign('newsInfo', $newsInfo);
		$this->display();
	}
}