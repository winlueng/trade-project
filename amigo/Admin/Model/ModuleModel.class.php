<?php
namespace Admin\Model;
use Think\Model;

class ModuleModel extends Model
{
	// 登录时表单验证的规则 
	protected $_validate = array(
		array('module_name', 'require', '模块名不能为空！', 1),
	);

	// 模块列表
	public function moduleList()
	{
		$list = $this->select();
		foreach ($list as $k => $v) 
		{
			$ruleList = array();
			$ruleList = M('AuthRule')->where(['id' => ['in',explode(',', $v['parent_rules'])]])->getField('title', true);
			$list[$k]['ruleName'] = implode(',', $ruleList);
		}
		return $list;
	}

	// 添加模块功能
	public function moduleAdd()
	{
		if ($data = $this->create()) {
			if ($data['parent_rules'] == '') {
				$this->error = '请选择显示功能';return false;
			}
			$data['parent_rules'] = implode(',', $data['parent_rules']);
			$result = $this->add($data);
			if ($result) return $result;

			$this->error = '添加失败';return false;
		}
		return false;
	}

	protected function selModuleInfo()
	{
		$result = $this->where(['id' => I('get.id')])->find();
		$result['parent_rules'] = explode(',', $result['parent_rules']);
		return $result;
	}

	public function moduleUpdate()
	{
		if ($data = $this->create()) {
			if ($data['parent_rules'] == '') {
				$this->error = '请选择显示功能';return false;
			}
			$data['parent_rules'] = implode(',', $data['parent_rules']);
			$result = $this->where(['id'=>I('get.id')])->save($data);
			if ($result) return $result;

			$this->error = '添加失败';return false;
		}
		return false;
	}

	public function ajaxControl()
	{
		switch (I('get.flag')) 
		{
			case 'del':
				$res = M('Module')->where(['id' => I('get.id')])->delete();
				break;
			case 'selModuleInfo':
				$res = $this->selModuleInfo();
				break;
		}
		return $res;
	}
}