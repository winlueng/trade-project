<?php 
namespace Template00002\Controller;

use Think\Controller;

class JobController extends CommonController
{
	public function jobList()
	{
		$jobList = D('job')->showJobList();
		$this->assign('jobList', $jobList);
		$this->display();
	}

	public function jobDetail()
	{
		$jobNews = D('Job')->selJobInfo();
		$this->assign('jobInfo',$jobNews);
		$this->display();
	}
}