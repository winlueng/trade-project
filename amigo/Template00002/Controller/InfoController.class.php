<?php 
namespace Template00002\Controller;

use Think\Controller;

class InfoController extends CommonController
{
	public function companyDetail()
	{
		$jobList = D('job')->showJobList();
		$infoObj = new \Template00002\Model\InfoModel();
		$companyDetail = $infoObj->getCompanyInfo();
		$this->assign('companyNews', $companyDetail);
		$this->assign('jobList', $jobList);
		$this->display();
	}
}