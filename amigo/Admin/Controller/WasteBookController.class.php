<?php 
namespace Admin\Controller;

use Think\Controller;

/**
* 流水账类
*/
class WasteBookController extends CommonController
{
	private $obj;
	public function __construct()
	{
		parent::__construct();
		$this->obj = D('WasteBook');
	}

	// 
	public function currentCount()
	{
		$res = $this->obj->currentCount();
		// dump($list);exit;
		$this->assign('list', $res['list']);
		$this->assign('recharge_total', $res['recharge_total']);
		$this->assign('card_recharge_total', $res['card_recharge_total']);
		$this->assign('page', $res['page']);
		$this->display();
	}

	public function ajaxControl()
	{
		if(!IS_AJAX) E('非法访问');

		$this->ajaxReturn($this->obj->ajaxControl(I('get.flag'))) ;
	}

}

 ?>