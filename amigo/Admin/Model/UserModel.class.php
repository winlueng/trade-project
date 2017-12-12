<?php
namespace Admin\Model;

use Think\Model;

class UserModel extends CommonModel
{
	protected $_validate = array( 
			array('user_name', 'require', '用户名不能空'),
			array('phone', 'require', '号码不能空'),
			array('email', 'require', '邮箱不能空'),
			array('group_id', 'require', '请选择管理员角色'),
			array('password', 'require', '请填写密码!'),
			array('repass', 'require', '请填写重复密码!'),
			array('password', 'repass', '两次密码输入不一致！', 0, 'confirm'),
			array('user_name', '', '用户名已存在', 1, 'unique'),
			array('phone', '', '手机号已存在', 1, 'unique'),
			array('email', '', '邮箱已存在', 1, 'unique'),
		);

	protected $_auto = array(
			array('start_time', 'strtotime', 3, 'function'),
			array('end_time', 'strtotime', 3, 'function'),
			array('addtime', 'strtotime', 3, 'function'),
		);

	// 显示用户列表
	public function showAdminList()
	{
		$where['group_type'] = 1;

		if ($this->userInfo['id'] == 1) 
		{
			$where['group_type'] = ['in','0,1'];
		}

		// 搜索管理员信息
		if (I('get.group_id')) 
		{
			$where['group_type'] = I('get.group_id');
		}

		$adminGroupId = M('AuthGroup')->field('id,title')->where($where)->select();

		$authGroup = M('AuthGroupAccess');

		foreach ($adminGroupId as $k => $v) 
		{
			$id = $authGroup->where(['group_id' => $v['id']])->getField('uid',true);
			foreach ($id as $vo) 
			{
				$info = $this->field('id,user_name,phone,email,status,relevance_id')->where(['id'=>$vo])->select()[0];

				if ($where['group_type'] == 2 || $where['group_type'] == 3)  
				{
					$info['project_name'] = M('Project')->where(['id' => $info['relevance_id']])->getField('project_name');
				}

				$info['group_name'] = $v['title'];
				$userList[] = $info;
			}
		}
		return $userList;
	}

	// 管理员用户添加
	// group_type(1=>管理员,2=>商户)
	public function userAddByAdmin()
	{
		$group_type = I('post.group_type');
		if ($data = $this->create()) {

			if ($group_type == 3 && I('post.relevance_id')<1) 
			{
				$this->error = '请选择所属项目';return false;
			}

			$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
			
			$res = $this->add($data);

			if ($res) 
			{
				$userData['group_id'] = I('post.group_id');

				$userData['uid'] = $res;

				$res = M('AuthGroupAccess')->add($userData);

				if ($res)return $res;

				$this->error = '添加权限列表时出现异常';

				return false; 
			}else{
				$this->error = '添加用户失败';
				return false;
			}
		}else{
			return false;
		}
	}

	// 项目管理员添加商户管理员
	public function userAddByProjectAdmin()
	{
		$rule = array(
				array('user_name', 'require', '用户名不能空'),
				array('phone', 'require', '号码不能空'),
				array('email', 'require', '邮箱不能空'),
				array('password', 'require', '请填写密码!'),
				array('repass', 'require', '请填写重复密码!'),
				array('password', 'repass', '两次密码输入不一致！', 0, 'confirm'),
				array('user_name', '', '用户名已存在', 1, 'unique'),
				array('phone', '', '手机号已存在', 1, 'unique'),
				array('email', '', '邮箱已存在', 1, 'unique'),
				array('group_id', 'require', '请选择管理员类型'),
				array('company_id', 'require', '请选择所属商户'),
				array('company_id', '-1', '请选择所属商户', 0, 'notequal'),
			);

		if ($data = $this->validate($rule)->create()) {

			$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

			$data['relevance_id'] = $this->userInfo['relevance_id'];

			$data['category_id'] = $this->userInfo['category_id'];

			$res = $this->add($data);

			if ($res) 
			{
				$userData['group_id'] = I('post.group_id');

				$userData['uid'] = $res;

				$res = M('Auth_group_access')->add($userData);

				if ($res)return $res;

				$this->error = '添加权限列表时出现异常';

				return false; 
			}else{
				$this->error = '添加管理员失败';
				return false;
			}
		}else{
			return false;
		}
	}

	/**
	 * [selAdminUserInfo 获取用户详细信息]
	 * @return [array] [返回所属用户组,]
	 */
	protected function selAdminUserInfo()
	{
		$id = I('get.id');
		$res['group'] = M('auth_group')->field('id, title')/*->where(['status'=>1,'group_type' =>1])*/->select();
		$res['userGroup'] = M('auth_group_access')->field('group_id')->where(['uid'=>$id])->select()[0];
		$res['user'] = $this->field('id,user_name,phone,email')->where(['id' => $id])->select();
		return $res;
	}

	// 查询管理员&商户组列表
	public function groupList($type)
	{
		$group = M('auth_group');
		$list = $group->field('id, title')->where(['status' => 1,'group_type'=>$type])->select();
		return $list;
	}

	// ajax操作方法
	public function ajaxControl()
	{
		$flag = I('get.flag');
		switch ($flag) 
		{
			case 'changeAdminUserStatus':
				$result = $this->changeAdminUserStatus();
				break;
			case 'selAdminUserInfo':
				$result = $this->selAdminUserInfo();
				break;
			case 'selCompanyInfo'://修改商户资料前查询商户详细信息
				$result = $this->selCompanyInfo();
				break;
			case 'selUserAddBefore'://添加用户前查询是否有存在同样的信息
				$result = $this->selUserAddBefore();
				break;
		}
		return $result;
	}

	// 查询商户详细信息
	protected function selCompanyInfo()
	{
		$id = I('get.id');
		$company = D('Company');
		$result = $company->field('id,company_ip,company_name,principal,company_pic,logo_path,business_id,email,region_id,web_postfix,template_id,company_type,phone,start_time,end_time,address_info')->where(['id'=>$id])->select()[0];
		$result['region'] = findRegionInfo($result['region_id'], 'Region', 'region_name');
		$result['group_id'] = M('auth_group_access')->where(['id' => $id])->getField('group_id');
		return $result;
	}

	// 修改管理员信息
	public function adminUpdate()
	{
		$id = I('get.id');
		$data['user_name'] = I('post.user_name');
		$data['phone'] = I('post.phone');
		$data['email'] = I('post.email');
		$pass = I('post.password');
		$repass = I('post.repass');
		$oldpass = I('post.oldpass');
		$this->startTrans();
		if ($oldpass && ($pass == $repass) && $pass && $repass) 
		{
			$userPassWord = $this->where(['id' => $id])->getField('password');
			if (pwd_hash($oldpass,$userPassWord)) 
			{
				$data['password'] = password_hash($pass, PASSWORD_DEFAULT);
			}else{
				$this->error = '原始密码有误';
				return false;
			}
		}elseif ($pass && $repass && $pass != $repass) {
			$this->error = '新密码与重复密码不匹配';
			return false;
		}

		$result = $this->where(['id' => $id])->save($data);
		if ($result || I('post.group_id')) 
		{
			if (I('post.group_id')) {
				$res = M('auth_group_access')->where(['uid' => $id])->save(['group_id' => I('post.group_id')]);
				if ($res) {
					$this->commit();
					return $res;
				}
			}
			$this->rollback();
			$this->error = '修改失败';
			return false;
		}else{
			$this->rollback();
			$this->error = '修改失败';
			return false;
		}
	}

	// 添加用户前验证
	protected function selUserAddBefore()
	{
		$value = I('get.data');
		$key = I('get.key');

		$result = $this->where([$key => $value])->getField('id');

		if ($result) 
		{
			return false;
		}else{
			return true;
		}
	}

	public function userListByProject()
	{
		$where = array(
				'relevance_id' => $this->userInfo['relevance_id'],
				'category_id'  => $this->userInfo['category_id'],
				'company_id'   => ['neq', '0'],
			);

		$result['noList'] = '111';

		if (I('get.selCompanyName')) {
			$companyIdList = M('Company')->where(['company_name' => ['like', '%'. I('get.selCompanyName') .'%'], 'relevance_id' => $this->userInfo['relevance_id'], 'category_id' => $this->userInfo['category_id']])->getField('id',true);
			if ($companyIdList) {
				$where['company_id'] = ['in', (string)implode(',', $companyIdList)];
			}else{
				$result['noList'] = '';
			}
		}

		$count = $this->where($where)->count();

		$page = new \Think\Page($count, 10);

		$userList = $this->field('id,user_name,phone,email,status,company_id')
					->where($where)
					->limit($page->firstRow.','.$page->listRows)
					->select();

		foreach ($userList as $k => $v) {
			$userList[$k]['company_name'] = M('Company')->where(['id' => $v['company_id']])->getField('company_name');
		}

		$result['page'] = $page->show();

		$result['list'] = $userList;

		return $result;
	}

	private function changeAdminUserStatus()
	{
		$where['id'] = I('get.id');
		$save['status'] = I('get.status');
		$result = $this->where($where)->save($save);
		if (!$result) {
			return false;
		}
		return $result;
	}

}