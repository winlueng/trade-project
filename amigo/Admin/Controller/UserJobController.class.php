<?php
namespace Admin\Controller;

use Think\Controller;

class UserJobController extends CommonController
{
	private $jobObj;

	public function __construct()
	{
		parent::__construct();
		$this->jobObj = D('Job');
	}

	public function jobAdd()
	{
		if (IS_POST) 
		{
			$result = $this->jobObj->jobAdd();
			if ($result) 
			{
				$this->success('添加成功');exit;
			}else{
				$this->error($this->jobObj->getError());exit;
			}
		}else{
			$jobInfo = $this->jobObj->selJobList();
			$this->assign('list', $jobInfo['list']);
			$this->assign('page', $jobInfo['page']);
			$this->display();
		}
	}

	public function ajaxControl()
	{
		$result = $this->jobObj->ajaxControl();
		$this->ajaxReturn($result);
	}
}