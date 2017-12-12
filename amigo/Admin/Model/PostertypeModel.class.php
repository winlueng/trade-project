<?php 
namespace Admin\Model;

use Think\Model;

class PostertypeModel extends Model
{
	protected $_validate = array( 
			array('type_name', 'require', '广告分类名不能空',1),
			array('type_desc', 'require', '分类描述不能空',1),
			array('template_id', 'require', '请选择所属模版',1),
		);

	/**
	 * 添加广告分类
	 */
	public function typeAdd()
	{
		if ($this->create()) 
		{
			$data = I('post.');
			$data['addtime'] = time();
			$res = M('Postertype')->add($data);
			return $res;
		}else{
			return false;
		}
	}

	/**
	 * 查询广告分类表
	 */
	public function typeList()
	{
		$posterType = M('Postertype');

		$res['templateList'] = M('Template_change')->field('id, template_name')->select();

		if (I('get.template_id')) 
		{
			$where['template_id'] = I('get.template_id');
		}

		$count = $posterType->where($where)->count();

		$page = new \Think\Page($count,10);

		$typeList = $posterType->field('type_name,id,type_desc,addtime')->where($where)->limit($page->firstRow.','.$page->listRows)->select();

		$res['list'] = $typeList;

		$res['page'] = $page->show();

		return $res;
	}

	public function posterTypeUpdate()
	{
		if ($this->create()) 
		{
			$data = I('post.');
			$res = M('Postertype')->where(['id' => I('get.id')])->save($data);
			if (!$res) 
			{
				$this->error = '无任何信息修改';return false;
			}
			return $res;
		}else{
			return false;
		}
	}
}



 ?>