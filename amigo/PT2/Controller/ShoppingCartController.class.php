<?php 
namespace PT2\Controller;

use Think\Controller;

class ShoppingCartController extends CommonController
{
	private $obj;
	public function __construct()
	{
		parent::__construct();
		$this->obj = new \PT2\Model\ShoppingCartModel();
	}

	public function myCart()
	{
		$res = $this->obj->cartInfo();
		// echo '<pre>';
		// var_dump($res['company']);exit;
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