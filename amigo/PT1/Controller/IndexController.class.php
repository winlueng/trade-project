<?php 
namespace PT1\Controller;

use Think\Controller;

class IndexController extends CommonController
{
	public function index()
	{
		$index = new \PT1\Model\IndexModel('Poster');
		$posterList = $index->selIndexPoster(C('POSTER_CENTER'),C('POSTER_FOOT'));
		$topNewsList = $index->topNewsList();
		$classify = $index->showClassifyList();
		$goodsList = $index->showGoodsFromClassify($classify[0]['id']);
		$featureShop = $index->showFeatureShop('','',1);
		$activityList = $index->showActivityList();
		$newsList = $index->showNewsList();
		$this->assign('posterTop', $posterList['top']);
		$this->assign('posterHead', $topNewsList);
		// dump($topNewsList);exit;
		$this->assign('posterFoot', $posterList['foot']);
		$this->assign('classify', $classify);
		$this->assign('goodsList', $goodsList);
		$this->assign('featureShop', $featureShop);
		$this->assign('activityList', $activityList);
		$this->assign('newsList', $newsList);
		// dump($_SESSION);exit;
		$this->display();
	}

	public function ajaxControl()
	{
		$index = new \PT1\Model\IndexModel();
		$result = $index->ajaxControl();
		$this->ajaxReturn($result);
	}	

}

 ?>