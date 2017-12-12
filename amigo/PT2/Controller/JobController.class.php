<?php 
namespace PT2\Controller;

use Think\Controller;

// 招聘类
class JobController extends CommonController
{
	private $obj;

	public function __construct()
	{
		parent::__construct();
		$this->obj = new \PT2\Model\JobModel;
	}

	public function jobList()
	{
		$list = $this->obj->job_list();
		$this->assign('list', $list);
		$this->display();
	}

	public function jobDetail()
	{
		$info = $this->obj->job_info();
		$this->assign('info', $info);
		$this->display();
	}

}