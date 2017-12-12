<?php 
namespace PT2\Controller;

use Think\Controller;

class GoodsController extends CommonController
{
	private $obj;
	public function __construct()
	{
		parent::__construct();
		$this->obj = new \PT2\Model\GoodsModel();
		$cartTotal = M('ShoppingCart')->where(['visitor_id' => $this->v_info['id']])->count();
		$this->assign('cartTotal',$cartTotal);
		/*if (!$this->userInfo || strlen($this->userInfo['phone']) < 11) {
			$this->redirect('/PT2/Login/visitorSignIn');
		}*/
	}

	public function goodsList()
	{
		$result = $this->obj->showGoodsList();
		// dump($this->obj);exit;
		$cartTotal = M('ShoppingCart')->where(['visitor_id' => $this->v_info['id']])->count();
		$this->assign('cartTotal', $cartTotal);
		$this->assign('list', $result['list']);
		$this->assign('classifyList', $result['classifyList']);
		$this->display();
	}

	public function goodsDetail()
	{
		if (!$this->v_info) {
			$this->redirect(MODULE_NAME.'/Login/defaultLogin');exit;
		}
		if (I('get.id')) 
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
		if (IS_AJAX){
			$this->ajaxReturn($this->obj->ajaxControl(I('get.flag')));
		}

	}
}