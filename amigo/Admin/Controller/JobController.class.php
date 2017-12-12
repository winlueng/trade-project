<?php
namespace Admin\Controller;

use Think\Controller;

class JobController extends CommonController
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
			// dump($jobInfo);exit;
			$this->assign('list', $jobInfo['list']);
			$this->assign('page', $jobInfo['page']);
			$this->display();
		}
	}

	public function jobUpdate()
	{
		if (IS_POST) 
		{
			$result = $this->jobObj->saveJobInfo();
			if ($result) 
			{
				$this->success('修改成功');exit;
			}else{
				$this->error($this->jobObj->getError());exit;
			}
		}else{
			$this->error('非法访问');exit;
		}
	}

	public function ajaxControl()
	{
		$result = $this->jobObj->ajaxControl();
		$this->ajaxReturn($result);
	}

	public function jobAddByProject()
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
			// dump($jobInfo);exit;
			$this->assign('list', $jobInfo['list']);
			$this->assign('page', $jobInfo['page']);
			$this->display();
		}
	}

	public function jobUpdateByProject()
	{
		if (IS_POST) 
		{
			$result = $this->jobObj->saveJobInfo();
			if ($result) 
			{
				$this->success('修改成功');exit;
			}else{
				$this->error($this->jobObj->getError());exit;
			}
		}else{
			$this->error('非法访问');exit;
		}
	}
}