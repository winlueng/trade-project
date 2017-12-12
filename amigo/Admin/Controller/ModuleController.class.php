<?php 
namespace Admin\Controller;

use Think\Controller;

class ModuleController extends Controller
{
	private $moduleObj;

	public function __construct()
	{
		parent::__construct();
		$this->moduleObj = D('Module');
	}

	// 显示模块添加
	public function moduleAdd()
	{
		if (IS_POST) 
		{
			$res = $this->moduleObj->moduleAdd();
			if ($res) 
			{
				$this->success('添加成功');exit;
			}else{
				$this->error($this->moduleObj->getError());exit;
			}
		}else{
			$moduleList = $this->moduleObj->moduleList();

			$rulesList = D('AuthRule')->showRulesList();

			$this->assign('list', $moduleList);
			$this->assign('rules', $rulesList);
			$this->display();
		}
	}

	// 显示模块修改
	public function moduleUpdate()
	{
		if (IS_POST) 
		{
			$res = $this->moduleObj->moduleUpdate();
			if ($res) 
			{
				$this->success('添加成功');exit;
			}else{
				$this->error($this->moduleObj->getError());exit;
			}
		}
	}

	// ajax方法操作
	public function ajaxControl()
	{
		$res = $this->moduleObj->ajaxControl();
		$this->ajaxReturn($res);exit;
	}
}


?>