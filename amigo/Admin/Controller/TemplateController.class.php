<?php
namespace Admin\Controller;

use Think\Controller;

class TemplateController extends CommonController
{
	private $templateObj;

	public function __construct()
	{
		parent::__construct();
		$this->templateObj = new \Admin\Model\TemplateModel('template_change');
	}

	public function templateAdd()
	{
		if (IS_POST) 
		{
			$result = $this->templateObj->templateAdd();
			if ($result) 
			{
				$this->success('添加成功');exit;
			}else{
				$this->error($this->templateObj->getError());exit;
			}
		}else{
			$templateList = $this->templateObj->showTemplateList();
			$this->assign('templateList', $templateList);
			$this->display();
		}
	}

	public function ajaxControl()
	{

		$result = $this->templateObj->ajaxControl();
		$this->ajaxReturn($result);
	}

	public function templateUpdate()
	{
		if (IS_POST) 
		{
			$result = $this->templateObj->templateUpdate();
			if ($result) 
			{
				$this->success('更新成功');exit;
			}else{
				$this->error($this->templateObj->getError());exit;
			}
		}
	}

	public function templateChange()
	{
		if (IS_POST) 
		{
			$result = $this->templateObj->templateChange();
			if ($result) 
			{
				$this->success('修改成功');exit;
			}else{
				$this->error('修改失败');exit;
			}
		}else{
			$list       = $this->templateObj->showTemplateList();
			$templateId = $this->templateObj->getCompanyTemplate();
			$this->assign('templateId', $templateId);
			$this->assign('list', $list);
			$this->display();
		}
	}	
}