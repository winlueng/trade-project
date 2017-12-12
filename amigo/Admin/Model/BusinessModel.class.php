<?php 
namespace Admin\Model;

use Think\Model;

class BusinessModel extends Model
{
	// 自动验证添加数据是否合法
	protected $_validate = array( 
			array('business_name', 'require', '行业名称不能空!'), 	//默认情况下用正则进行验证
			array('business_desc', 'require', '行业描述不能空!'),
			array('region_id', 'require', '请选择商圈!',0,'regex',1),
			// array('rname', '', '行业名已存在', 1, 'unique'),
		);

	protected $_auto = array( 
			array('addtime', 'time', 3,'function'), 	//默认情况下用正则进行验证
		);

	public function businessAdd()
	{
		if ($data = $this->create()) 
		{
			$data['category_id'] = $_SESSION['marketInfo']['category_id'];
			$data['relevance_id'] = $_SESSION['marketInfo']['relevance_id'];
			$result = $this->add($data);
			if (!$result) 
			{
				$this->error = '添加失败';return false;
			}
			return $result;
		}
			return false;
	}

	/**
	 * 查询行业数据信息
	 * @return $res array 返回商户行业查询数据
	 */
	public function businessSel()
	{
		$where['category_id'] = $_SESSION['marketInfo']['category_id'];

		$where['relevance_id'] = $_SESSION['marketInfo']['relevance_id'];

		$count = $this->where($where)->count();

		$page = new \Think\Page($count,15);


		$bus = $this->field('id,business_name,business_desc,addtime,status,region_id')->where($where)->order('addtime desc')->limit($page->firstRow.','.$page->listRows)->select();
		
		foreach ($bus as $v) 
		{
			$v['address'] = findRegionInfo($v['region_id'], 'Region', 'region_name');
			$businessList[] = $v;
		}

		$res['list'] = $businessList;

		$where['status'] = 0;

		$where['parent_id'] = 0;

		$res['region'] = D('Region')->field('id,region_name')->where($where)->select();
		$res['page'] = $page->show();

		return $res ;

	}

	// 删除行业
	protected function businessDel()
	{	
		$id = I('get.id');
		$where['business_id'] = $id;
		$res = checkChildInfo('Company',$where);
		if ($res) 
		{
			$delId = $this->where(['id'=>$id])->delete();
			return $delId?'删除成功':'删除失败';
		}else{
			return '当前行业还存在商户,不能删除';
		}
		
	}

	// 修改行业信息
	public function businessUpdate()
	{
		if ($data = $this->create()) 
		{
			if (!$data['region_id']) 
			{
				unset($data['region_id']);
			}

			$where['id'] = I('get.id');

			$res = $this->where($where)->save($data);
			if (!$res) 
			{
				$this->error = '修改失败';return false;
			}
			return $res;
		}
			return false;
	}

	// 查询行业详细信息
	protected function selBusinessInfo()
	{
		$id = I('get.id');

		$res = $this->field('id,business_name,region_id,business_desc')->where(['id'=>$id])->select()[0];

		$res['region_name'] = findRegionInfo($res['region_id'], 'Region', 'region_name');

		return $res;
	}

	// ajax操作
	public function ajaxControl()
	{
		$flag = I('get.flag');
		switch ($flag)
		{
			case 'changeBusinessStatus':
				$res = $this->changeBusinessStatus();
				break;
			case 'del':
				$res = $this->businessDel();
				break;
			case 'selBusinessInfo':
				$res = $this->selBusinessInfo();
				break;
		}
		return $res;
	}

	/**
	 * 更改行业状态
	 * @param bool $flag 0=>显示,1=>隐藏
	 * @return void $res
	 */
	public function changeBusinessStatus()
	{
		$where['business_id'] = I('get.id');
		$status['status'] = I('get.status');
		$check = checkChildInfo('Company',$where);
		if ($check) 
		{
			$res = $this->where(['id' => I('get.id')])->save($status);
			if ($res) 
			{
				return '更新成功';
			}else{
				return '已是当前状态';
			}
		}else{
			return '当前行业还存在商户,不能更改状态';
		}
	}
}