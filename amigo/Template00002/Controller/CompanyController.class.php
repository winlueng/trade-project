<?php 
namespace Template00002\Controller;

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
		$this->assign('info', $result);
		$this->display();
	}

	

}
