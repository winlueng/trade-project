<?php 
namespace Template00002\Controller;

use Think\Controller;

class CompanyController extends CommonController
{
	public function companyDetail()
	{
		$companyDetail = D('Company')->getCompanyInfo();
		$this->assign('companyNews', $companyDetail);
		$this->display();
	}
}