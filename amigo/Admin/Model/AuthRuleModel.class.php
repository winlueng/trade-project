<?php
namespace Admin\Model;

use Think\Model;
use Think\Exception;

class AuthRuleModel extends CommonModel
{
	protected $_validate = array(     
			array('parent_id', 'require', '请选择所属父级权限',1),
			array('title', 'require', '请填写权限名称',1),
			array('name', 'require', '请填写规则',1),
			array('display', 'require', '请选择是否显示权限功能',1),
			
		);

	// 权限规则添加
	public function authAdd()
	{
		if ($data = $this->create()) 
		{
			$this->startTrans();
			try {
				$res = $this->add($data);
				if (!$res) throw new Exception("权限添加失败");
				
				$id = C('SUPER_USER_ID');
				$sql = <<<SQL
UPDATE `market_auth_group` SET rules=concat(rules,',$res') WHERE id=$id;
SQL;
				$result = M()->execute($sql);
				if (!$result) throw new Exception("追加超管权限失败");

				$this->commit();
				return true;
			} catch (Exception $e) {
				$this->rollback();
				$this->error = $e->getMessage();return false;
			}
		}
	}

	// 权限列表查询
	public function showRulesList($flag = 0)
	{
		$res = $this->where(['parent_id' => 0])->select();
	
		foreach($res as $k => $v)
		{
			$where = ['parent_id'=>$v['id']];
			if ($flag) {
				$where['status'] = 1;
			}
			$res[$k]['rule'] = $this->where(['parent_id'=>$v['id']])->select();
		}
		return $res;
	}

	// 修改权限状态
	protected function changeRuleStatus()
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

	// 修改权限信息
	public function authUpdate()
	{
		if ($data = $this->create()) 
		{
			$this->startTrans();
			try {
				$res = $this->where(['id' => I('get.id')])->save($data);
				if (!$res) throw new Exception("权限添加失败");
				
				$this->commit();
				return true;
			} catch (Exception $e) {
				$this->rollback();
				$this->error = $e->getMessage();return false;
			}
		}
		return false;
	}

	/**
	 * [ruleDel 权限删除,删除单个权限并把权限组下的也删除]
	 * @return [bool] 
	 */
	protected function ruleDel()
	{
		if($this->where(['parent_id' => I('get.id')])->find()) return '下面还有子权限,不能删';

		$this->startTrans();
		try {
			$result = $this->where(['id'=>I('get.id')])->delete();

			if (!$result) throw new Exception('删除失败');

			$groupList = M('AuthGroup')->field('id,rules')->select();

			// 修改组内的权限信息
			foreach ($groupList as $k => $v) 
			{
				$newRules = array_diff(explode(',', $v['rules']), [I('get.id')]);
				$res = M('AuthGroup')->where(['id'=>$v['id']])->save(['rules'=>implode(',', $newRules)]);
				/*if (!$res || $res) 
				{
					throw new Exception('在分组删除权限时失败');
				}*/
			}
			$this->commit();return true;
		} catch (Exception $e) {
			$this->rollback();
			// return  M('AuthGroup')->getLastSql();
			return $e->getMessage();
		}
	}

	protected function selRule()
	{
		return $this->where(['id'=>I('get.id')])->find();
	}

	public function priorityRule()
	{
		return $this->where(['id' => I('get.id')])->save(['control_time' => time()]);
	}

	public function ajaxControl($flag)
	{
		return $this->$flag();
	}
}