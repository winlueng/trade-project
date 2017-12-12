<?php
namespace Admin\Controller;

use Think\Controller;

class AuthGroupController extends CommonController
{
	private $obj;
	public function __construct()
	{
		parent::__construct();
		$this->obj = D('AuthGroup');
	}

	public function groupAdd()
	{
		if (IS_POST) 
		{
			$res = $this->obj->groupAdd();
			if ($res) 
			{
				$this->success('添加成功');exit;
			}else{
				$this->error($this->obj->getError());exit;
			}		
		}else{
			$groupList = $this->obj->showGroupList();
			$rulesList = D('AuthRule')->showRulesList();
			$this->assign('group', $groupList);
			$this->assign('rules', $rulesList);
			$this->display();exit;
		}
	}

	public function groupUpdate()
	{
		if (IS_POST) {
			// dump(I('post.'));exit;
			$res = $this->obj->groupUpdate();
			// dump($res);exit;
			if ($res) 
			{
				$this->success('修改成功');exit;
			}else{
				$this->error($this->obj->getError());exit;
			}
		}
	}

	public function ajaxControl()
	{
		if (IS_AJAX) {
			$this->ajaxReturn($this->obj->ajaxControl(I('get.flag')));
		}
	}
}