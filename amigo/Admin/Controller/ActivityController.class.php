<?php 
namespace Admin\Controller;

use Think\Controller;

class ActivityController extends CommonController
{
	private $activityObj;

	public function __construct()
	{
		parent::__construct();
		$this->activityObj = D('Activity');
	}

	public function activityList()
	{
		if (IS_POST) 
		{
			$result = $this->activityObj->activityAdd();
			if ($result) 
			{
				$this->success('添加成功');exit;
			}else{
				$this->error($this->activityObj->getError());exit;
			}
		}else{
			$activityList = $this->activityObj->activityList();
			$this->assign('list', $activityList['list']);
			$this->assign('page', $activityList['page']);
			$this->display();
		}
	}

	public function ajaxControl()
	{
		$result = $this->activityObj->ajaxControl();
		$this->ajaxReturn($result);
	}
	
	public function activityUpdate()
	{
		$result = $this->activityObj->activityUpdate();
		if ($result) 
		{
			$this->success('修改成功');exit;
		}else{
			$this->error($this->activityObj->getError());exit;
		}
	}
}