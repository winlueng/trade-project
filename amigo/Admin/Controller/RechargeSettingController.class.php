<?php 
namespace Admin\Controller;

use Think\Controller;

/**
* 流水账类
*/
class RechargeSettingController extends CommonController
{
	private $obj;
	public function __construct()
	{
		parent::__construct();
		$this->obj = D('RechargeSetting');
	}

	// 
	public function rechargeSetting()
	{
		$res = $this->obj->rechargeSetting();
		// dump($res);exit;
		$this->assign('first_recharge', $res['first_recharge']);
		$this->assign('other_recharge', $res['other_recharge']);
		$this->display();
	}

	public function ajaxControl()
	{
		if(!IS_AJAX) E('非法访问');
		else $this->ajaxReturn($this->obj->ajaxControl(I('get.flag')));
	}
}

 ?>