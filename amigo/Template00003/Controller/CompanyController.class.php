<?php 
namespace Template00003\Controller;

use Think\Controller;

class CompanyController extends CommonController
{
	private $companyObj;
	private $jobObj;

	public function __construct()
	{
		parent::__construct();
		$this->companyObj = new \Template00002\Model\CompanyModel();
		$this->jobObj 	= new \Template00002\Model\JobModel();
	}
	public function companyDetail()
	{

		$result = $this->companyObj->getCompanyInfo();
		// dump($result);exit;
		$this->assign('info', $result);
		$this->display();
	}
}
