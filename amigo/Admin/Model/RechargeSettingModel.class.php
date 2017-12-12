<?php 
namespace Admin\Model;

use Think\Model;

/**
* 流水账类
*/
class RechargeSettingModel extends CommonModel
{
	protected $_validate = [
		['recharge_price', 'require', '请填写充值金额',1],
		// ['present_price', 'require', '达到条件赠送金额',1],
		['start_time', 'require', '请填写充值优惠开始时间',1],
		['end_time', 'require', '请填写充值优惠结束时间',1],
	];

	public function __construct()
	{
		parent::__construct();
		$this->_auto = [
			['relevance_id', $this->userInfo['relevance_id'], 3],
		];
	}

	public function rechargeSetting()
	{
		$where = [
			'status' => ['neq', '-1'],
			'relevance_id' => $this->userInfo['relevance_id'],
			'is_first_recharge' => 1,
		];

		$field = [
			'id',
			'recharge_price',
			'present_price',
			'start_time',
			'end_time',
		];
		$res['first_recharge'] = $this->field($field)->where($where)->select();
		$where['is_first_recharge'] = 0;
		$res['other_recharge'] = $this->field($field)->where($where)->select();
		return $res;
	}

	public function settingIns()
	{
		if ($data = $this->create()) {
			$data['start_time'] = $data['start_time']/1000;
			$data['end_time'] 	= $data['end_time']/1000;
			$res = $this->add($data);
			if (!$res) {
				return ['status' => 'false', 'err_msg' => '添加失败'];
			}
			return ['status' => 'true'];
		}
		return ['status' => 'false', 'err_msg' => $this->getError()];
	}

	public function settingUpdate()
	{
		if ($data = $this->create()) {
			$res = $this->where(['id' => I('get.id')])->save($data);
			if (!$res) {
				return ['status' => 'false', 'err_msg' => '修改失败'];
			}
			return ['status' => 'true'];
		}
		return ['status' => 'false', 'err_msg' => $this->getError()];
	}

	public function settingDel()
	{
		$res = $this->where(['id' => I('get.id')])->save(['status' => '-1']);
		if (!$res) {
			return ['status' => 'false', 'err_msg' => '删除失败'];
		}
		return ['status' => 'true'];
	}

	public function ajaxControl($flag)
	{
		return $this->$flag();
	}
}