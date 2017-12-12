<?php 
namespace Template00003\Controller;

use Think\Controller;

class IndexController extends CommonController
{
	private $indexObj;
	private $visitorInfoObj;
	public function __construct()
	{
		parent::__construct();
		$this->indexObj 		= new \Template00002\Model\IndexModel();
		$this->visitorInfoObj 	= new \Template00002\Model\VisitorInfoModel();
	}
	public function index()
	{
		$where = array(
				'company_id' => $this->companyInfo['id'],
				'status' => 0,
				'is_top' => 0,
			);
		$newsList  		= $this->indexObj->topNewsList();
		$hotGoods 		= $this->indexObj->selHotGoods();
		$newGoods 		= $this->indexObj->selNewGoods();
		$selYouLike		= $this->visitorInfoObj->selYouLike();/*
		dump($hotGoods);
		dump($newGoods);exit;*/
		$collect_total  = M('Company')->where(['id' => $this->companyInfo['id']])->getField('collect_total');
		$cartTotal = M('ShoppingCart')->where(['visitor_id' => $this->userInfo['id']])->count();
		$this->assign('is_save', $this->selIsSave());
		$this->assign('collect_total', $collect_total);
		$this->assign('cartTotal', $cartTotal);
		$this->assign('hotGoods', $hotGoods);
		$this->assign('newGoods', $newGoods);
		$this->assign('selYouLike', $selYouLike);
		$this->assign('topNews', $newsList);
		$this->display();
	}

	public function ajaxControl()
	{
		$result = $this->indexObj->ajaxControl();
		$this->ajaxReturn($result);
	}	
}

 ?>