<?php
namespace Admin\Model;

use Think\Model;

class AuthGroupModel extends CommonModel
{
	protected $_validate = array(     
			array('title', 'require', '分组名称',3),
			// array('rules', 'require', '请选择权限'),
			array('group_type', 'require', '请选择权限分类'),
		);

	// 查询所有权限组信息
	public function showGroupList()
	{
		$rules = M('AuthRule');
		if ($this->userInfo['id'] == C('SUPER_USER_ID')) 
		{
			$num = 0;
		}else{
			$num = 1;
		}
		$list = $this->field('id, title, status, rules')->where(['id' => ['gt',$num]])->select();
		$status = array(0=>'禁用', 1=>'启用');
		foreach ($list as $k => $v) 
		{
			$arr = array();
			$rulesArr = explode(',', $v['rules']);
			$list[$k]['statusName'] = $status[$v['status']];
			foreach ($rulesArr as $vo) 
			{
				$arr[] = $rules->where(['id' => $vo])->getField('title');
			}
			$list[$k]['rulesName'] = implode('&nbsp;&nbsp;&nbsp;', $arr);
		}
		return $list;
	}

	// 添加权限组
	public function groupAdd()
	{
		if ($data = $this->create()) {
			if ($data['rules'] == '') {
				$this->error = '请选择权限';return false;
			}
			$data['rules'] = implode(',', $data['rules']);

			$res = $this->add($data);

			if ($res) return $res;
			
			$this->error = '添加失败';return false;
		}
		return false;
	}

	// 编辑权限组前获取当前id的权限数据
	protected function selGroup()
	{
		$rules = $this->where(['id'=>I('get.id')])->find();
		$rules['rules'] = explode(',', $rules['rules']);
		return $rules;
	}

	// 改变权限组状态
	protected function changeGroupStatus()
	{
		if (I('get.status') == 1) 
		{
			$status = 0;
			$str = '禁用';
		}else{
			$status = 1;
			$str = '启用';
		}

		$res = $this->where(['id' => I('get.id')])->save(['status' => $status]);

		if ($res) 
		{
			return $str;
		}else{
			return false;
		}
	}

	public function groupUpdate()
	{
		if ($data = $this->create()) {
			if ($data['rules'] == '') {
				$this->error = '请选择权限';return false;
			}
			$data['rules'] = implode(',', $data['rules']);

			$res = $this->where(['id' => I('get.id')])->save($data);

			if ($res) return $res;
			
			$this->error = '修改失败';return false;
		}
		return false;
	}

	protected function groupDel()
	{
		if (M('AuthGroupAccess')->where(['group_id' => I('get.id')])->count()) {
			return false;
		}

		$result = $this->where(['id'=>I('get.id')])->delete();

		if ($result) return $result;
		
		return false;
	}

	public function ajaxControl($flag)
	{
		return $this->$flag();
	}
}