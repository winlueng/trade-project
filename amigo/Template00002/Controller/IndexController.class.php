<?php 
namespace Template00002\Controller;

use Think\Controller;

class IndexController extends CommonController
{
	private $indexObj;
	public function __construct()
	{
		parent::__construct();
		$this->indexObj = new \Template00002\Model\IndexModel();
	}
	public function index()
	{
		// dump($this->companyInfo);exit;
		$where = array(
				'company_id' => $this->companyInfo['id'],
				'status' => 0,
				'is_top' => 0,
			);
		$newsList = D('News')->newsList($where);
		// $posterList = $this->indexObj->selIndexPoster();
		$hotGoods = $this->indexObj->selHotGoods();
		$cartTotal = M('ShoppingCart')->where(['visitor_id' => $this->userInfo['id']])->count();
		$this->assign('cartTotal', $cartTotal);
		$this->assign('hotGoods1', $hotGoods[0]);
		$this->assign('hotGoods2', $hotGoods[1]);
		// $this->assign('posterTop', $posterList['top']);
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