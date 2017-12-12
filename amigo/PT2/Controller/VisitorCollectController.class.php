<?php 
namespace PT2\Controller;

use Think\Controller;

// 用户收藏类
class VisitorCollectController extends CommonController
{
	private $obj;

	public function __construct()
	{
		parent::__construct();
		$this->obj = new \PT2\Model\VisitorCollectModel();
	}

	// 商品收藏
	public function goodsCollect()
	{
		$list = $this->obj->goodsCollect();
		// dump($list);exit;
		$this->assign('list', $list);
		$this->display();
	}

	// 店铺关注
	public function companyCollect()
	{
		$list = $this->obj->companyCollect();
		// dump($list);exit;
		$this->assign('list', $list);
		$this->display();
	}

	public function ajaxControl()
	{
		if (IS_AJAX) {
			$this->ajaxReturn($this->obj->ajaxControl(I('get.flag')));
		}
	}
}