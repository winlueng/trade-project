<?php 
namespace Template00002\Controller;

use Think\Controller;

class GoodsController extends CommonController
{
	public function goodsList()
	{
		$goods = D('Goods');
		$goodsList = $goods->showGoodsList();
		$this->assign('list', $goodsList);
		$this->display();
	}

	public function goodsDetail()
	{
		if (IS_GET) 
		{
			$goods = D('Goods');
			$goodsInfo = $goods->showGoodsDetail();
			if ($goodsInfo) 
			{
				// dump($goodsInfo);exit;
				$this->assign('goodsInfo', $goodsInfo);
				$this->display();
			}else{
				$this->error('商品已下架或商户不存在此商品');
			}
		}
	}
}