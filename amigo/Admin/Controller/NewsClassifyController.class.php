<?php 
namespace Admin\Controller;

use Think\Controller;

class NewsClassifyController extends CommonController
{
	private $classifyObj;

	public function __construct()
	{
		parent::__construct();
		$this->classifyObj = D('NewsClassify');
	}

	// 动态分类列表
	public function newsClassifyList()
	{
		if (IS_POST) 
		{
			$result = $this->classifyObj->newsClassifyAdd();
			if ($result) 
			{
				$this->success('添加成功');exit;
			}else{
				$this->error($this->classifyObj->getError());exit;
			}
		}else{
			$result = $this->classifyObj->newsClassifyList();
			$this->assign('list', $result['list']);
			$this->assign('page', $result['page']);
			$this->display();
		}
	}

	// 动态分类修改
	public function newsClassifyUpdate()
	{
		if (IS_POST) 
		{
			$result = $this->classifyObj->newsClassifyUpdate();
			if ($result) 
			{
				$this->success('更新成功');exit;
			}else{
				$this->error($this->classifyObj->getError());exit;
			}
		}
	}

	// ajax操作
	public function ajaxControl()
	{
		$result = $this->classifyObj->ajaxControl();
		$this->ajaxReturn($result);
	}

	public function newsClassifyAddByProject()
	{
		if (IS_POST) 
		{
			$result = $this->classifyObj->newsClassifyAdd();
			if ($result) 
			{
				$this->success('添加成功');exit;
			}else{
				$this->error($this->classifyObj->getError());exit;
			}
		}else{
			$result = $this->classifyObj->newsClassifyList();
			$this->assign('list', $result['list']);
			$this->assign('page', $result['page']);
			$this->display();
		}
	}

	// 动态分类修改
	public function newsClassifyUpdateByProject()
	{
		if (IS_POST) 
		{
			$result = $this->classifyObj->newsClassifyUpdate();
			if ($result) 
			{
				$this->success('更新成功');exit;
			}else{
				$this->error($this->classifyObj->getError());exit;
			}
		}
	}
}

 ?>