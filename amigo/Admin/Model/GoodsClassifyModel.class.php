<?php 
namespace Admin\Model;

use Think\Model;
use Think\Exception;

class GoodsClassifyModel extends CommonModel
{
	protected $_validate = array(
		array('classify_name', 'require', '分类名不能为空！'),
		array('parent_id', 'integer', '非法数据输入!'),
		// array('title', 'require', '请填写分类描述!'),
	);

	public function __construct()
	{
		parent::__construct();
		$this->_auto = array(
			array('company_id', $this->userInfo['company_id']),
			array('relevance_id', $this->userInfo['relevance_id']),
			array('create_time', 'time', 3, 'function'),
			array('update_time', 'time', 3, 'function'),
		);
	}

	// 添加分类
	public function insert()
	{
		if ($data = $this->create()) 
		{
			if ($_FILES['classify_logo']['size'] != 0) 
			{
				$path = fileUpload('/Uploads/goodsClassify/', 'classify_logo');

				if (isset($path['error_msg'])) {
					$this->error = $path['error_msg'];return false;
				}
				// return $path;
				$data['classify_logo'] = thumbImage($path);

				$sort = $this->where(['relevance_id' => $this->userInfo['relevance_id'], 'status' => ['neq', '-1']])->max('control_time');

				if ($sort) {
					$data['control_time'] = (int)$sort + 1;	
				}else{
					$data['control_time'] = 1;
				}

				$result = $this->add($data);

				if (!$result) 
				{
					$this->error = '添加商品分类失败';return false;
				}
				return $result;
			}else{
				$this->error = '请上传分类logo';return false;
			}
		}else{
			return false;
		}
	}

	public function update()
	{
		if ($data = $this->create()) 
		{
			if ($_FILES['classify_logo']['size'] != 0) 
			{
				$path = fileUpload('/Uploads/goodsClassify/', 'classify_logo');

				if (isset($path['error_msg'])) {
					$this->error = $path['error_msg'];return false;
				}

				$data['classify_logo'] = thumbImage($path);

				$path = $this->where(['id'=>I('get.id')])->getField('classify_logo');
				
			}

			$result = $this->where(['id'=>I('get.id')])->save($data);

			if (!$result) {
				$this->error = '修改失败';return false;
			}

			unlink('./Public'.$path);// 删除缩略图
			unlink('./Public'.getArtwork($path));// 删除原图
			return $result;
		}
		return false;
	}

	// 商品分类列表
	public function goodsClassifyList($setWhere = [], $flag = 0)
	{
		$where = [
			'company_id' => $this->userInfo['company_id'],
			'status' => ['neq','-1'],
		];

		if ($setWhere) {
			$where = $setWhere;
		}

		$count = $this->where($where)->count();

		$page = new \Think\Page($count, 10);

		$field = 'id,classify_name,classify_logo,parent_id, status, create_time, update_time';

		$classifyList = $this->field($field)
						->where($where)
						->order('control_time')
						->limit($page->firstRow.','.$page->listRows)
						->select();

		foreach ($classifyList as $k => $v) {
			$idList = M('Goods')->where(['classify_id'=>$v['id'], 'status' => ['neq','-1']])->getField('id', true);
			if ($idList) {
				$v['visitorTotal'] = M('GoodsStatistics')->where(['relevance_id' => ['in', implode(',', $idList)]])->sum('visit_total');
			}
			$v['gnum'] = count($idList);
			$res['list'][] = $v;
		}
		$res['page'] = $page->show();
		return $res;
	}

	public function ajaxControl()
	{
		switch (I('get.flag')) {
			case 'goodsClassifyDel':
				$result = $this->goodsClassifyDel();//删除分类
				break;
			case 'selClassifyInfo':
				$result = $this->selClassifyInfo();//查询分类查询信息
				break;
			case 'changeGoodsClassifyStatus':// 修改商品分类状态
				$result = $this->changeGoodsClassifyStatus();
				break;
			case 'setControlTimeToTop':// 根据control_time字段排序
				$result = $this->setControlTimeToTop();
				break;
			case 'goodsClassifySort':
				$result = $this->goodsClassifySort();
				break;
		}
		return $result;
	}

	/**
	 * 删除分类
	 */
	protected function goodsClassifyDel()
	{
		$count = M('Goods')->where(['classify_id' => I('get.id'), 'status' => ['neq','-1']])->count();
		if ($count) {
			$res['status']  = false;
			$res['err_msg'] = '当前分类下存在存在商品,不能删除!';
			return $res;
		}

		$result = $this->where(['id' => I('get.id')])->setField(['status' => '-1']);
		if ($result) {
			return true;
		}
		$res['status']  = false;
		$res['err_msg'] = '删除失败';
		return $res;
	}

	/**
	 * 查询分类查询信息
	 */
	protected function selClassifyInfo()
	{
		$id = I('get.id');
		$result = $this->field('id, classify_name, classify_logo, title')
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

	/**
	 * 修改商品分类状态
	 */
	protected function changeGoodsClassifyStatus()
	{
		$where['id'] = I('get.id');

		$data['status'] = I('get.status');


		if (I('get.status') == '1') 
		{
			$count = M('Goods')->where(['classify_id' => I('get.id')])->count();
			if ($count) {
				$res['status']  = false;
				$res['err_msg'] = '当前分类下存在子类或存在商品不能被修改状态';
				return $res;
			}
		}

		if ($this->where($where)->setField($data)) 
		{
			$res['status'] = true;
			return $res;
		}
		$res['status']  = false;
		$res['err_msg'] = '操作失败';
		return $res;
	}

	public function goodsClassifySort()
	{
		if (!I('get.id') || !I('get.control')) {
			return ['status' => 'false', 'err_msg' => '缺少参数'];
		}

		$where = [
			'id' => I('get.id'),
			'relevance_id' => $this->userInfo['relevance_id'],
			'status' => ['neq', '-1'],
		];

		$sort = $this->where($where)->getField('control_time');
		unset($where['id']);

		switch (I('get.control')) {
			case 'up':
				$find_sort = $this->where([
								'relevance_id' 	=> $this->userInfo['relevance_id'], 
								'status' 		=> ['neq', '-1'], 
								'control_time'	=> ['lt',$sort]
							])->max('control_time');
				break;
			case 'down':
				$find_sort = $this->where([
								'relevance_id' 	=> $this->userInfo['relevance_id'], 
								'status' 		=> ['neq', '-1'], 
								'control_time'	=> ['gt',$sort]
							])->min('control_time');
				break;
		}
		$where['control_time'] = $find_sort;
		$save['control_time']  = $find_sort;
		$this->startTrans();
		try {
			$res = $this->where($where)->save(['control_time' => $sort]);
			if (!$res) throw new Exception('操作失败1');
				
			unset($where['control_time']);
			$where['id'] = I('get.id');
			$res = $this->where($where)->save($save);
			if (!$res) throw new Exception("操作失败2");

			$this->commit();
			return ['status' => 'true'];
		} catch (Exception $e) {
			$this->rollback();
			return ['status' => 'false', 'err_msg' => $e->getMessage()];
			
		}
	}
}


 ?>