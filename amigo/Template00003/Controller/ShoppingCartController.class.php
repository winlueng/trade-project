<?php 
namespace Template00003\Controller;

use Think\Controller;

class ShoppingCartController extends CommonController
{
	private $obj;
	public function __construct()
	{
		parent::__construct();
		$this->obj = new \Template00002\Model\ShoppingCartModel();
	}

	public function myCart()
	{
		$res = $this->obj->cartInfo();
		// dump($res);exit;
		$this->assign('info', $res);
		$this->display();
	}

	/**
	 * 加入购物车
	 */
	public function insertCart()
	{
		if (IS_AJAX) {
			$res = $this->obj->insert();
			$this->ajaxReturn($res);
		}
	}

	public function ajaxControl()
	{
		if (IS_AJAX) $this->ajaxReturn($this->obj->ajaxControl(I('get.flag')));
	}
}
?>