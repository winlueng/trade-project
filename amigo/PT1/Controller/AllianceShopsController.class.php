<?php 
namespace PT1\Controller;

use Think\Controller;

class AllianceShopsController extends CommonController
{

	public function companyList()
	{
		$obj = new \PT1\Model\AllianceShopsModel();
		$index = new \PT1\Model\IndexModel();
		$business = $obj->businessList();
		$region = $obj->regionList();
		$companyList = $index->showFeatureShop();
		// dump($companyList);exit;
		$this->assign('business', $business);
		$this->assign('region', $region);
		$this->assign('companyList', $companyList);
		$this->display();
	}

	public function ajaxControl()
	{
		$obj = new \PT1\Model\AllianceShopsModel();
		$result = $obj->ajaxControl();
		$this->ajaxReturn($result);
	}
}