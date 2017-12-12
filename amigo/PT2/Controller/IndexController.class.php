<?php 
namespace PT2\Controller;

use Think\Controller;

class IndexController extends CommonController
{
	private $obj;
	private $visitorInfoObj;

	public function __construct()
	{
		parent::__construct();
		$this->obj = new \PT2\Model\IndexModel();
		$this->visitorInfoObj = new \PT2\Model\VisitorInfoModel();
	}

	public function index()
	{
		$topNewsList 	= $this->obj->topNewsList();
		$banner 		= $this->obj->bannerList();
		$stickGoods		= $this->obj->showStickGoods();
		$selYouLike		= $this->visitorInfoObj->selYouLike();
		// dump($stickGoods[3]);exit;
		$cartTotal = M('ShoppingCart')->where(['visitor_id' => $this->userInfo['id']])->count();
		$this->assign('cartTotal', $cartTotal);
		$this->assign('newsList', $topNewsList);
		$this->assign('discount_goods', $stickGoods[1]);
		$this->assign('hot_goods', $stickGoods[2]);
		$this->assign('new_goods', $stickGoods[3]);
		$this->assign('selYouLike', $selYouLike);
		$this->assign('topBanner', $banner[1]);
		$this->assign('footBanner', $banner[2]);
		$this->display();
	}

	public function ajaxControl()
	{
		if (IS_AJAX) {
			return $this->ajaxReturn($this->obj->ajaxControl(I('get.flag')));
		}
	}

}

 ?>