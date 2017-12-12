<?php
namespace Admin\Controller;

use Think\Controller;

class AuthRuleController extends CommonController
{
	private $authObj;

	public function __construct()
	{
		parent::__construct();
		$this->authObj = D('AuthRule');
	}

	public function authAdd()
	{
		if (IS_POST) 
		{
			$res = $this->authObj->authAdd();
			if ($res) 
			{
				$this->success('添加成功');exit;
			}else{
				$this->error($this->authObj->getError());exit;
			}			
		}else{
			$list = $this->authObj->showRulesList(1);
			$this->assign('list', $list);
			$this->display();exit;
		}
	}

	public function authUpdate()
	{
		$res = $this->authObj->authUpdate();
		if ($res) 
		{
			$this->success('修改成功');exit;
		}else{
			$this->error('修改失败');exit;
		}
	}

	public function ajaxControl()
	{
		if (IS_AJAX) {
			$this->ajaxReturn($this->authObj->ajaxControl(I('get.flag')));
		}
	}
}