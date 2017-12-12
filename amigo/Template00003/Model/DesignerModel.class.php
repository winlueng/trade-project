<?php 
namespace Template00002\Model;

use Think\Model;

class DesignerModel extends CommonModel
{
	protected $autoCheckFields = false;

	private $staffID;

	public function __construct()
	{
		parent::__construct();
		$this->staffID = M('Staff')->where(['visitor_id' => $this->userInfo['id'], 'status' => 0])->getField('id');
	}

	public function orderList()
	{
		$where = [
			'staff_id' => $this->staffID,
			'status'   => 1,
		];

		switch (I('get.show')) {
			case '1':
				$where['status'] = 1;
				break;
			case '2':
				$where['status'] = ['in', '2,3,4'];
				break;
		}

		$count = M('SubscribeOrderForm')->where($where)->count();

		$page = new \Think\Page($count, 6);

		$info = M('SubscribeOrderForm')->where($where)
				->order('create_time desc')
				->limit($page->firstRow.','.$page->listRows)
				->select();

		foreach ($info as $v) {
			$v['distance_time'] = turnDistanceTime($v['come_time']);
			$result[] = $v;
		}
		return $result;
	}

	public function orderInfo()
	{
		$info = M('SubscribeOrderForm')->where(['id' => I('get.id'), 'staff_id' => $this->staffID])->find();
		$info['visitorLogo'] = M('VisitorInfo')->where(['visitor_id' => $info['visitor_id']])->getField('head_portrait');
		$info['distance_time'] = turnDistanceTime($info['come_time']);

		if ($info['status'] == '4') {
			$info['comment'] = M('StaffComment')->where(['subscribe_id' => $info['id'], 'staff_id' => $this->staffID])->find();
		}
		return $info;
	}

	public function showVisitorImage()
	{
		$id = M('SubscribeOrderForm')->where(['id' => I('get.id'), 'staff_id' => $this->staffID])->getField('visitor_id');
		$info = M('VisitorImage')->where(['visitor_id' => $id])->order('create_time desc')->find();
		$info['information'] = json_decode($info['information'], true);
		$info['company_upload'] = json_decode($info['company_upload'], true);
		$info['visitor_upload'] = json_decode($info['visitor_upload'], true);
		return $info;
	}
	
	public function imageList()
	{
		$id = M('SubscribeOrderForm')->where(['id' => I('get.id'), 'staff_id' => $this->staffID])->getField('visitor_id');

		$count = M('VisitorImage')->where(['visitor_id' => $id])->count();

		$page = new \Think\Page($count, 10);

		$list = M('VisitorImage')->field('company_upload, visitor_upload, create_time')
				->where(['visitor_id' => $id])
				->order('create_time desc')
				->limit($page->firstRow.','.$page->listRows)
				->select();
		foreach ($list as $v) {
			$v['company_upload'] = json_decode($v['company_upload'], true);
			$v['visitor_upload'] = json_decode($v['visitor_upload'], true);
			$result[] = $v;
		}
		return $result;
	}
}

?>