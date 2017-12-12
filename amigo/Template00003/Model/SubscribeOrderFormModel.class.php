<?php 
namespace Template00002\Model;

use Think\Model;

class SubscribeOrderFormModel extends CommonModel
{
	protected $insertFields = ['come_time', 'remark', 'people', 'phone', 'sex'];

	protected $_validate = [
		['people','require','请填写预约人姓名',1],
		['phone','require','请填写预约人电话',1],
		['sex','require','请填写预约人性别',1],
		['come_time','require','请填写预约时间'],
	];

	public function __construct()
	{
		parent::__construct();
		$this->_auto = [
			['company_id', $this->companyInfo['id']],
			['visitor_id', $this->userInfo['id']],
			['staff_id', I('get.staffID')],
			['create_time', 'time', self::MODEL_INSERT, 'function'],
		];
	}

	public function insert()
	{
		if ($data = $this->create()) {

			$data['subscribe_number'] = 'YY_V'.$this->userInfo['id'].'C'.$this->companyInfo['id'].time();

			$res = $this->add($data);

			if($res) return $res;

			$this->error = '生成订单失败';return false;
		}
		return false;
	}

	public function orderList()
	{
		$where = [
			'status' => ['neq','-1'],
			'visitor_id' => $this->userInfo['id']
		];

		switch (I('get.show')) {
			case '1':// 待确认
				$where['status'] = 0;
				break;
			case '2':// 待服务
				$where['status'] = ['in', '1,2'];
				break;
			case '3':// 待评价
				$where['status'] = 3;
				break;
			case '4':// 已完成
				$where['status'] = 4;
				break;
		}

		$count = $this->where($where)->count();

		$page = new \Think\Page($count, 6);

		$info = $this->where($where)
				->order('create_time desc')
				->limit($page->firstRow.','.$page->listRows)
				->select();

		foreach ($info as $v) {
			$v['staffInfo'] = M('Staff')->where(['id' => $v['staff_id']])->find();
			$v['distance_time'] = turnDistanceTime($v['come_time']);
			$v['service_total'] = $this->where(['staff_id' => $v['staff_id'], 'status' => 4])->count();
			$result[] = $v;
		}
		return $result;
	}

	public function ajaxControl($flag)
	{
		return $this->$flag();
	}

	/**
	 * 订单详情
	 */
	public function orderInfo()
	{
		$info = $this->where(['id' => I('get.id'), 'visitor_id' => $this->userInfo['id']])->find();
		$info['staffInfo'] = M('Staff')->field('staff_logo,store_nickname,professional_title,speciality')
					       ->where(['id' => $info['staff_id']])->find();
		return $info;
	}

	/**
	 * 生成预订单
	 */
	public function createAdvance()
	{
		if(!IS_AJAX) E('非法访问');

		$info = $this->orderInfo();

		$config = [
		    'out_trade_no' => $info['subscribe_number'],
		    'body' => $this->companyInfo['company_name'].'-预约订单'.$info['subscribe_number'],
		    'total_fee' => (int)$info['total'] * 100,
		    //'time_expire' => date('YmdHis', (int)$order['created_at'] + (int)$order['timeout']),// 交易结束时间
		    'notify_url' => 'http://'.$_SERVER['HTTP_HOST'].U('SubscribeOrderForm/returnWXPay', ['companyName' => I('get.companyName')]),
		];

		$wxOrder = $this->wechat->wxPayUnifiedOrder($this->userInfo['open_id'], $config);
		// 判断预订单是否生成成功
		if ($wxOrder['return_code'] != 'SUCCESS') {
		    return 0;
		}

		// 生成微信支付JSAPI参数
		if (! array_key_exists('prepay_id', $wxOrder)) {
		     return 0;
		}
		return $jsApiParams = $this->wechat->getWxPayJsApiParameters($wxOrder['prepay_id']);
	}

	/**
	 * 支付成功修改订单状态
	 */
	public function changeOrder($data)
	{
		$save = [
			'wechat_order_number' 	=> $data['transaction_id'],
			'status'				=> 3,
			'pay_time'				=> $data['time_end'],
			'pay_status'			=> 1,
			'wechat_total'			=> $data['cash_fee']/100,
			'update_time'			=> time()
		];

		$this->where(['order_number' => $data['out_trade_no']])->save($save);
	}
}

?>