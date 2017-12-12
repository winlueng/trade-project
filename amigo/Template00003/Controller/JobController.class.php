<?php 
namespace Template00003\Controller;

use Think\Controller;

class JobController extends CommonController
{
	protected $obj;
	public function __construct()
	{
		parent::__construct();
		$this->obj = new \Template00002\Model\JobModel;
	}

	public function jobList()
	{
		$jobList = $this->obj->showJobList();
		$this->assign('jobList', $jobList);
		$this->display();
	}

	public function jobDetail()
	{
		$jobInfo = $this->obj->selJobInfo();
		// dump($jobInfo);exit;
		$this->assign('jobInfo',$jobInfo);
		$this->display();
	}
}