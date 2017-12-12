<?php
namespace Admin\Model;

use Think\Model;

class CategoryModel extends Model
{
	// 自动验证
	protected $_validate = array( 
		array('category_name', 'require', '请填写类别名称'),
		array('title', 'require', '请类别填写描述'),
	);

	protected $_auto = array (          
		/*array('status','1'),  // 新增的时候把status字段设置为1         
		array('password','md5',3,'function') , // 对password字段在新增和编辑的时候使md5函数处理         
		array('name','getName',3,'callback'), // 对name字段在新增和编辑的时候回调getName方法     */    
		array('addtime','time',1,'function'), // 对addtime字段在更新的时候写入当前时间戳     
	);

	// 类别列表
	public function showCategoryList()
	{
		if (I('get.selname')) 
		{
			$where['category_name'] = ['like', '%'.I('get.selname').'%'];
		}
		$list = $this->where($where)->select();
		return $list;
	}

	// 添加类别
	public function categoryAdd()
	{
		if ($this->create()) 
		{
			$res = $this->add();

			if ($res) return $res;

			$this->error = '添加失败';

			return false;exit;
		}else{
			return false;exit;
		}
	}

	// ajax操作方法
	public function ajaxControl()
	{
		if (IS_AJAX) 
		{
			$flag = I('get.flag');
			switch ($flag) 
			{
				case 'selThisCategory':// 搜索所属次类别的项目列表
					$result = $this->selThisCategory();
					break;
				case 'selCategoryInfo'://查询类别详细信息
					$result = $this->selCategoryInfo();
					break;
			}
			return $result;
		}

	}

	// 类别更新
	public function categoryUpdate()
	{
		if ($data = $this->create()) 
		{
			$count = $this->where(['category_id' => I('get.id')])->count();
			if ($count) {
				$this->error = '因有项目属于次类别下,为避免项目用户误解,信息不能修改.';
			}
			$result = $this->where(['id' => I('get.id')])->save($data);
			if ($result) return $result;
			
			$this->error = '修改分类失败';return false;
		}else{
			return false;exit;
		}
	}

	// 编辑时查询类别详细信息
	public function selCategoryInfo()
	{
		$id = I('get.id');
		$result = $this->where(['id' => $id])->getField('id,category_name,title');
		return $result;
	}

}