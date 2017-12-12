<?php 
namespace PT2\Controller;

use Think\Controller;

class AllianceShopsController extends CommonController
{
	private $obj;
	public function __construct()
	{
		parent::__construct();
		$this->obj = new \PT2\Model\AllianceShopsModel();
	}
	public function companyList()
	{

		$business = $this->obj->businessList();
		$region = $this->obj->regionList();
		// dump($region);exit;
		$this->assign('business', $business);
		$this->assign('region', $region);
		$this->display();
	}

	public function ajaxControl()
	{
		if (IS_AJAX) {
			$this->ajaxReturn($this->obj->ajaxControl(I('get.flag')));
		}
	}
}