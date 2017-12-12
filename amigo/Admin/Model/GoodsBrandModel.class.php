<?php 
namespace Admin\Model;

use Think\Model;
use Think\Exception;

class GoodsBrandModel extends CommonModel
{
	protected $_validate = array(
		array('brand_name', 'require', '品牌名不能为空！'),
		// array('brand_describe', 'require', '请选择商品分类'),
	);

	

	public function __construct()
	{
		parent::__construct();
		$this->_auto = [
			['create_time', 'time', self::MODEL_INSERT, 'function'],
			['update_time', 'time', self::MODEL_UPDATE, 'function'],
			['company_id', $this->userInfo['company_id'], self::MODEL_INSERT],
			['relevance_id', ($this->userInfo['company_id']?0:$this->userInfo['relevance_id']), self::MODEL_INSERT],
		];
	}

	public function insert()
	{
		if ($data = $this->create()) {
			if ($_FILES['brand_logo']['size'] != 0) {
				$path = fileUpload('/Uploads/GoodsBrand/', 'brand_logo');

				if (isset($path['error_msg'])) {
					$this->error = $path['error_msg'];return false;
				}

				$data['brand_logo'] = thumbImage($path);

				$result = $this->add($data);
				if (!$result) {
					$this->error = '添加失败';return false;
				}
				return $result;
			}
			$this->error = '请上传品牌LOGO!';return false;
		}
		return false;
	}

	public function update()
	{
		if ($data = $this->create()) {
			if ($_FILES['brand_logo']['size'] != 0) 
			{
				$path = fileUpload('/Uploads/GoodsBrand/', 'brand_logo');

				if (isset($path['error_msg'])) {
					$this->error = $path['error_msg'];return false;
				}
				$data['brand_logo'] = thumbImage($path);
			}

			$result = $this->where(['id' => I('get.id'), 'status' => ['neq','-1']])->save($data);

			if (!$result) {
				$this->error = '修改失败';return false;
			}
			return $result;
		}
		return false;
	}

	public function selBrandList($setWhere ='')
	{
		$where = [
			'status' => ['neq','-1'],
			'company_id' => $this->userInfo['company_id']
		];
		
		if ($setWhere) $where = $setWhere;
		$count = $this->where($where)->count();

		$page = new \Think\Page($count, 10);

		$list = $this->where($where)
					->order('create_time desc')
					->limit($page->firstRow.','.$page->listRows)
					->select();
		foreach ($list as $v) {
			$v['goodsCount'] = M('Goods')->where(['brand_id' => $v['id'], 'company_id' => $this->userInfo['company_id'], 'status' => ['neq','-1']])->count();
			$result['list'][] = $v;
		}
		$result['page'] = $page->show();
		return $result;
	}

	/**
	 * 删除和禁用/启用操作
	 * @return int 结果
	 */
	public function del()
	{
		$count = D('Goods')->where(['brand_id' => I('get.id'), 'status' => ['neq','-1']])->count();
		if($count) {
			$res['status'] = false;
			$res['err_msg'] = '此品牌下存在商品,搞不了!';
			return $res;
		}

		$result = $this->where(['id' => I('get.id')])->setField('status', I('get.status'));

		if ($result) return ['status' => true];

		$res['status'] = false;
		$res['err_msg'] = '删除失败';
		return $res;
	}

	public function selBrandInfo()
	{
		$result = $this->field('brand_name, brand_describe, brand_logo')
				->where(['id' => I('get.id')])
				->find();

		if ($result) 
		{
			$result['info'] = $result;
			$result['status'] = true;
			return $result;exit;
		}else{
			return ['status'=>false];exit;
		}
	}

	public function ajaxControl()
	{
		switch (I('get.flag')) {
			case 'del':
				$result = $this->del();
				break;
			case 'brandList':
				$result = $this->brandList();
				break;
			case 'selBrandInfo':
				$result = $this->selBrandInfo();
				break;
		}
		return $result;
	}

	public function brandList()
	{
		$where = [
			'relevance_id'  => ($this->userInfo['company_id']?0:$this->userInfo['relevance_id']),
			'company_id'	=> $this->userInfo['company_id'],
			'status' => ['neq','-1']
		];
		$result = $this->where($where)->select();
		if ($result) 
		{
			$result['info'] = $result;
			$result['status'] = true;
			return $result;exit;
		}else{
			return ['status'=>false];exit;
		}
	}
}

 ?>