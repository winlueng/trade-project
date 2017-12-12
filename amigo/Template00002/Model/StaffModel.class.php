<?php 
namespace Template00002\Model;

use Think\Model;

class StaffModel extends CommonModel
{
	private $collectObj;
	public function __construct()
	{
		parent::__construct();
		$this->collectObj = M('VisitorCollect');
	}

	public function staffList($jobId = '')
	{
		if (I('get.job_id')) $jobId = I('get.job_id');

		$where = [
			'job_id' => $jobId,
			'company_id' => $this->companyInfo['id'], 
			'status' => ['not in', '-1,1']
		];

		$list = $this->where($where)->select();
		foreach($list as $v)
		{
			$v['service_total'] = M('SubscribeOrderForm')->where(['staff_id' => $v['id'], 'status' => ['in', '3,4']])->count();
			$result[] = $v;
		}
		return $result;
	}

	public function staffInfo()
	{
		$info = $this->where(['id' => I('get.id'), 'company_id' => $this->companyInfo['id']])->find();

		$info['introduce'] = htmlReturn($info['introduce']);

		$info['staff_image'] = json_decode($info['staff_image'], true);

		$info['style'] = explode(',',$info['style']);

		$collectList = $this->collectObj
					->where(['visitor_id' => $this->userInfo['id']])
					->getField('staff_collect');

		$collectList = json_decode($collectList, true);

		$info['is_collect'] = in_array((string)$info['id'], $collectList);// 判断是否收藏

		$info['thesame'] = $this->field('id, store_nickname, staff_logo, professional_title')
						->where(['job_id' => $info['job_id'], 'id' => ['neq', I('get.id')], 'status' => ['not in', '-1,1']])
						->order('create_time desc')
						->limit(4)
						->select();

		foreach ($info['thesame'] as $k => $v) {
			$info['thesame'][$k]['orderTotal'] = M('SubscribeOrderForm')->where(['staff_id' => $v['id'], 'status' =>['in', '3,4']])->count();
		}

		$this->staffTrack((int)$info['id']);// 记录足迹

		return $info;
	}

	public function ajaxControl($flag)
	{
		return $this->$flag();
	}

	// 记录用户足迹
	public function staffTrack($id)
	{
		$time = strtotime('Today');

		$info = M('VisitorTrack')->where(['visitor_id' => $this->userInfo['id'], 'visit_date' => $time])->getField('id_aggregate');

		if (!$info) {
			
			$data = [
				'visit_date' 	=> $time,
				'visitor_id' 	=> $this->userInfo['id'],
				'id_aggregate' 	=> json_encode([['id' => $id, 'type' => 2]])
			];

			M('VisitorTrack')->add($data);

			return true;
		}else{
			$info = json_decode($info, true);

			foreach ($info as $v) {
				if (($v['type'] == 2 && $v['id'] != $id) || $v['type'] == 1) {
					$arr[] = $v;
				}
			}

			if (!$arr) {
				$arr = [['id' => $id, 'type' => 2]];
			}else{
				array_unshift($arr, ['id' => $id, 'type' => 2]);
			}
			
			M('VisitorTrack')->where(['visitor_id' => $this->userInfo['id'], 'visit_date' => $time])->setField('id_aggregate', json_encode($arr));
		}
	}

	// 收藏商品
	public function collectStaff()
	{
		$staffID = I('get.staff_id');

		$status = I('get.status');

		$where = ['visitor_id' => $this->userInfo['id']];

		// 查询用户收藏商品数据
		$info = $this->collectObj->where($where)->find();
		// return $list;
		if (!$info && $status == '1') 
		{
			$result = $this->collectObj->add(['visitor_id' => $this->userInfo['id'], 'staff_collect' => json_encode([$staffID])]);
			return $result;
		}else if((!$info || !$info['staff_collect']) && $status == '2'){
			return '非法操作';
		}else if(!$info['staff_collect'] && $status == '1'){
			return $this->collectObj->where($where)->setField('staff_collect',json_encode([$staffID]));
		}

		$list = json_decode($info['staff_collect'],true);

		if (!in_array((string)$staffID, $list) && $status == '1') // 判断是否已经收藏过
		{
			array_push($list, $staffID);
		}

		if (in_array((string)$staffID, $list) && $status == '2') // 判断是否已经收藏过
		{
			$list = array_diff($list, [$staffID]);
		}

		$data = json_encode($list);
		return $this->collectObj->where($where)->setField('staff_collect',$data);
	}
}

?>