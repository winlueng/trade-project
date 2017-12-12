<?php
namespace Admin\Controller;

use Think\Controller;

class UserController extends CommonController
{
	private $userObj;
	private $cardObj;
	private $templateObj;

	public function __construct()
	{
		parent::__construct();
		$this->userObj = D('User');
		$this->cardObj = D('Card');
		$this->templateObj = new \Admin\Model\TemplateModel('template_change');
	}

	// 添加用户
	public function userAdd()
	{
		if (IS_POST) 
		{
			$res = $this->userObj->userAddByAdmin();
			$res?$this->success('添加用户成功'):$this->error($this->userObj->getError());
		}else{
			$adminList = $this->userObj->groupList(1);
			$projectAdmin = $this->userObj->groupList(3);
			$address = $this->cardObj->getAddress();
			$category = M('Category')->select();
			$this->assign('address',$address);
			$this->assign('category',$category);
			$this->assign('adminList', $adminList);
			$this->assign('projectAdmin', $projectAdmin);
			$this->display();
		}
	}

	public function adminList()
	{
		$groupList = M('auth_group')->select();
		$userList = $this->userObj->showAdminList();
		$this->assign('userList', $userList);
		$this->assign('groupList', $groupList);
		$this->display();
	}

	public function marketCompanyList()
	{
		$list = $this->userObj->companyList('11,12');
		$address = $this->cardObj->getAddress();
		$this->assign('address',$address);
		$this->assign('list',$list['company']);
		$this->assign('page',$list['page']);
		$this->display();
	}

	// 项目管理员观看商户管理员列表
	public function userListByProject()
	{
		$list = $this->userObj->userListByProject();
		// dump($list);exit;
		$this->assign('userList', $list['list']);
		$this->assign('page', $list['page']);
		$this->assign('noList', $list['noList']);
		$this->display();
	}

	public function adminUpdate()
	{
		if (IS_POST) 
		{
			$res = $this->userObj->adminUpdate();
			$res?$this->success('修改用户成功'):$this->error($this->userObj->getError());exit;
		}
	}

	public function ajaxControl()
	{
		$res = $this->userObj->ajaxControl();
		$this->ajaxReturn($res);exit;
	}

	public function websiteCompanyList()
	{

		$list = $this->userObj->companyList('10,12');
		$address = $this->cardObj->getAddress();
		$templateList = $this->templateObj->showTemplateList();
		$this->assign('template',$templateList);
		$this->assign('address',$address);
		$this->assign('list',$list['company']);
		$this->assign('page',$list['page']);
		$this->display();
	}

	public function allCompanyList()
	{
		$list = $this->userObj->companyList('10,11,12');
		$address = $this->cardObj->getAddress();
		$templateList = $this->templateObj->showTemplateList();
		$this->assign('template',$templateList);
		$this->assign('address',$address);
		$this->assign('list',$list['company']);
		$this->assign('page',$list['page']);
		$this->display();
	}

	public function companyAddCheck()
	{
		$list = $this->userObj->companyAddAfterCheckList('10,11,12');
		$address = $this->cardObj->getAddress();
		$templateList = $this->templateObj->showTemplateList();
		$this->assign('template',$templateList);
		$this->assign('address',$address);
		$this->assign('list',$list['company']);
		$this->assign('page',$list['page']);
		$this->display();
	}

	// 项目商户添加
	public function companyAdminAdd()
	{
		if (IS_POST) 
		{
			$res = $this->userObj->userAddByProjectAdmin();

			if ($res) 
			{
				$this->success('添加用户成功');exit;
			}else{
				$this->error($this->userObj->getError());exit;
			}
		}else{
			$regionList = D('Region')->getRegionList();
			$projectAdmin = $this->userObj->groupList(2);
			$this->assign('projectCompany', $projectAdmin);
			$this->assign('region',$regionList);
			$this->display();
		}
		
	}
}