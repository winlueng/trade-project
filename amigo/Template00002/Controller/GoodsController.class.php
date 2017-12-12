<?php 
namespace Template00002\Controller;

use Think\Controller;

class GoodsController extends CommonController
{
	private $obj;
	public function __construct()
	{
		parent::__construct();
		$this->obj = new \Template00002\Model\GoodsModel();
	}
	public function goodsList()
	{
		$result = $this->obj->showGoodsList();
		// dump($result['list']);exit;
		$cartTotal = M('ShoppingCart')->where(['visitor_id' => $this->userInfo['id']])->count();
		$this->assign('cartTotal', $cartTotal);
		$this->assign('list', $result['list']);
		$this->assign('classifyList', $result['classifyList']);
		$this->display();
	}

	public function goodsDetail()
	{
		if (IS_GET) 
		{
			$goodsInfo = $this->obj->showGoodsDetail();
			// dump($goodsInfo);exit;
			if ($goodsInfo) 
			{
				$this->assign('goodsInfo', $goodsInfo['Info']);
				$this->assign('goodsLike', $goodsInfo['thesame']);
				$this->display();
			}else{
				$this->error('商品已下架或商户不存在此商品');
			}
		}
	}

	public function ajaxControl()
	{
		if (!IS_AJAX) E('非法访问');

		$result = $this->obj->ajaxControl(I('get.flag'));

		$this->ajaxReturn($result);
	}
}