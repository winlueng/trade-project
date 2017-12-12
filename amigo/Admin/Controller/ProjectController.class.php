<?php
namespace Admin\Controller;

use Think\Controller;

class ProjectController extends CommonController
{
	private $projectObj;

	public function __construct()
	{
		parent::__construct();
		$this->projectObj = D('Project');
	}

	// 商场资料完善
	public function marketInfo()
	{
		if (IS_POST) 
		{
			$result = D('WriteInfo')->infoUpdate();
			if ($result) 
			{
				$this->success('保存成功');exit;
			}else{
				$this->error(D('WriteInfo')->getError());exit;
			}
		}else{
			$info = D('WriteInfo')->selMarketInfo();
			$this->assign('info', $info);
			$this->display();
		}
	}

	// 项目添加
	public function projectInfoAdd()
	{
		if (IS_POST) 
		{
			$result = $this->projectObj->projectInfoAdd();
			if ($result) 
			{
				$this->success('保存成功');exit;
			}else{
				$this->error($this->projectObj->getError());exit;
			}
		}else{
			$address = D('Card')->getAddress();
			$result = $this->projectObj->selProjectList();
			$templateList = M('Template_change')->field('template_logo,id,template_name')->where(['template_type'=>1, 'status' => 0])->select();
			$category = M('category')->select();
			$this->assign('category', $category);
			$this->assign('address', $address);
			$this->assign('templateList', $templateList);
			$this->assign('list', $result['list']);
			$this->assign('page', $result['page']);
			$this->display();
		}
	}

	// ajax操作
	public function ajaxControl()
	{
		$result = $this->projectObj->ajaxControl();
		$this->ajaxReturn($result);
	}

	// 项目分类列表
	public function categoryList()
	{
		if (IS_POST) 
		{
			$result = D('category')->categoryAdd();
			if ($result) 
			{
				$this->success('添加成功');exit;
			}else{
				$this->error(D('category')->getError());exit;
			}
		}else{
			$result = D('category')->showCategoryList();
			$this->assign('list', $result);
			$this->display();
		}
	}

	public function categoryUpdate()
	{
		$result = D('category')->categoryUpdate();
		if ($result) 
		{
			$this->success('修改成功');exit;
		}else{
			$this->error(D('category')->getError());exit;
		}
	}

	// 超管审核列表
	public function projectCheckOut()
	{
		$result = $this->projectObj->selProjectList(1);
		$this->assign('address', $address);
		$this->assign('list', $result['list']);
		$this->assign('page', $result['page']);
		$this->display();
	}

	public function projectCheckHistory()
	{
		$result = $this->projectObj->selProjectList(['in', '0,1,2']);
		$this->assign('address', $address);
		$this->assign('list', $result['list']);
		$this->assign('page', $result['page']);
		$this->display();
	}
	
	public function projectTemplateChange()
	{
		if (IS_POST) 
		{
			$where['id'] = I('get.id');
			$result = $this->projectObj->where($where)->save(['template_id'=>I('post.template_id')]);
			if ($result) 
			{
				$this->success('切换模版成功,模版将在一小时后生效');exit;
			}else{
				$this->error('修改出错');exit;
			}
		}
	}

	// 开通商户限额修改
	public function createCompanyQuota()
	{
		if (IS_POST) {
			$where['id'] = I('get.id');
			$result = $this->projectObj->where($where)->save(['company_quota'=>I('post.company_quota')]);
			if ($result) 
			{
				$this->success('设置成功');exit;
			}else{
				$this->error('设置失败');exit;
			}
		}
	}
}