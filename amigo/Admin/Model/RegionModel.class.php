<?php
namespace Admin\Model;

use Think\Model;

class RegionModel extends Model
{
	protected $_validate = array( 
			array('parent_id', 'require', '请选择区域所属父级位置'),
			array('region_name', 'require', '区域名称不能空'),
		);

	protected $_auto = array( 
			// array('relevance_id', '"'.$_SESSION['marketInfo']['relevance_id'].'"',1),
			// array('category_id', '"'.$_SESSION['marketInfo']['category_id'].'"',1),
			array('addtime', 'time', 1, 'function'),
		);


	public function regionAdd()
	{	
		if ($data = $this->create()) 
		{
			$data['relevance_id'] = $_SESSION['marketInfo']['relevance_id'];

			$data['category_id'] = $_SESSION['marketInfo']['category_id'];

			$res = $this->add($data);
			if (!$res) 
			{
				$this->error = '添加失败';return false;
			}
				return $res;
		}
		return false;
	}

	// 区域列表
	public function showList()
	{
		$where['relevance_id'] = $_SESSION['marketInfo']['relevance_id'];

		$where['category_id'] = $_SESSION['marketInfo']['category_id'];

		$regionList = $this->field('id,region_name,parent_id,addtime,status')->where($where)->select();
		// return $regionList;
		if ($regionList) 
		{
			$showcate = getCate($regionList);
			// 加入父分类名到showcate
			foreach ($showcate as $k => $v) 
			{
				$gnum = M('Company')->where(['region_id'=>$v['id']])->count('id');
				$showcate[$k]['cnum'] = empty($gnum)? '0' : $gnum;
			}
		    $list = findRegionInfo($showcate,'Region', 'region_name');
		}
		return $list;
	}

	public function ajaxControl()
	{
		$flag = I('get.flag');
		switch ($flag){
			case 'changeRegionStatus'://隐藏
				$res = $this->changeRegionStatus();
				break;
			case 'regionDel':// 区域删除
				$res = $this->regionDel();
				break;
			case 'selRegionInfo':
				$res = $this->selRegionInfo();
				break;
		}
		return $res;
	}

	// 区域删除
	public function regionDel()
	{
		$id = I('get.id');

		$where['region_id'] = $id;

		$res1 = checkChildInfo('Company',$where);

		$res2 = checkChildInfo('Business',$where);

		if ($res1 && $res2) 
		{
			$delId = M('Region')->where(['id'=>$id])->delete();

			if ($delId) 
			{
				return '删除成功';
			}
			return '删除失败';
		}else{
			return '当前区域存在商户或存在行业信息';
		}

	}

	// 区域信息更新
	public function regionUpdate()
	{
		if ($this->create()) 
		{
			$data = I('post.');
			$result = $this->where(['id' => I('get.id')])->save($data);
			return $result;
		}else{
			return false;
		}
	}

	// 修改区域信息
	public function changeRegionStatus()
	{
		$id = I('get.id');

		$where['region_id'] = $id;
		$res1 = checkChildInfo('Company',$where);
		$res2 = checkChildInfo('Business',$where);
		$res3 = checkChildInfo('Region',['parent_id' => $id]);
		if ($res1 && $res2 && $res3) 
		{
			$status['status'] = I('get.status');
			$result = M('Region')->where(['id'=>$id])->save($status);

			if ($result) 
			{
				return '状态更新成功!';
			}else{
				return '状态更新失败!';
			}
		}else{
			return '当前区域存在商户或存在行业信息,或存在子类区域,不能更改状态!';
		}
	}

	// 获取区域信息列表
	public function getRegionList()
	{
		$where['category_id'] = $_SESSION['marketInfo']['category_id'];
		$where['relevance_id'] = $_SESSION['marketInfo']['relevance_id'];
		$where['parent_id'] = 0;
		$regionList = M('Region')->field('id,region_name')->where($where)->select();
		return $regionList;
	}

	public function selRegionInfo()
	{
		$where['id'] = I('get.id');
		$result = $this->field('id, parent_id, region_name')->where($where)->select()[0];
		return $result;
	}

}
