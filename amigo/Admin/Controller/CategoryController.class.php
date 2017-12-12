<?php
namespace Admin\Controller;

use Think\Controller;

/**
 * 项目分类
 */
class CategoryController extends CommonController
{
	private $cateObj

	public function __construct()
	{
		parent::__construct();
		$this->cateObj = D('Category');
	}

	public function categoryList()
	{
		if (IS_POST) 
		{
			$res = $this->cateObj->categoryAdd();
			if ($res) 
			{
				$this->success('添加成功');exit;
			}else{
				$this->error($this->cateObj->getError());exit;
			}
		}else{
			$list = $this->cateObj->showCategoryList();
			$this->assign('list', $list);
			$this->display();
		}
	}

	public function ajaxControl()
	{
		$result = $this->cateObj->ajaxControl();
		$this->ajaxReturn($result);
	}

	public function categoryUpdate()
	{
		if (IS_POST) 
		{
			$result = $this->cateObj->categoryUpdate();
			if ($result) 
			{
				$this->success('修改成功');exit;
			}else{
				$this->error($this->cateObj->getError());exit;
			}
		}
	}
}
?>