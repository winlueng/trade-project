<?php 
namespace Template00002\Controller;

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
		if (IS_POST) {
			// dump(I('post.'));exit;
			$res = $this->obj->insert();
			
			if ($res) {
				$this->redirect($_SERVER['HTTP_REFERER'],array('companyName' => I('get.companyName')));exit;
			}
			$this->error($this->obj->getError());exit;
		}
		E('非法访问');
	}

	public function ajaxControl()
	{
		if (!IS_AJAX) E('非法访问');

		$result = $this->obj->ajaxControl(I('get.flag'));

		$this->ajaxReturn($result);
	}
}
?>