<?php 
namespace PT2\Model;

use Think\Model;
use Think\Exception;
use \PT2\Model\LoginModel;

class WasteBookModel extends CommonModel
{
	public function __construct()
	{
		parent::__construct();
	}

	public function ajaxControl($flag)
	{
		return $this->$flag();
	}

	// 充值卡充值
	public function verification_card()
	{
		$where = [
					'serial_number' => (int)I('get.serial_number'),
					'relevance_id'	=> $this->pInfo['id'],
					'status'		=> 1
				];
		$card_info = M('RechargeCard')->field('money, presenter_money, start_time, end_time, used_visitor_id')
				    ->where($where)->find();
		$this->startTrans();
		try {
			if (!$card_info) throw new Exception("序列号无效");

			if ((int)$card_info['start_time'] > time()) throw new Exception("序列号无效2");

			if ($card_info['used_visitor_id']) throw new Exception("序列号已使用");

			if ((int)$card_info['end_time'] < time()) throw new Exception("该序列号已过期");

			$res = $this->write_waste_book($card_info, 2);

			if(!$res) throw new Exception("充值失败1");

			$data = [
				'used_time' => time(),
				'used_visitor_id' => $this->userInfo['id']
			];
			$res = M('RechargeCard')->where($where)->save($data);

			if(!$res) throw new Exception("充值失败2");

			$res = M('VisitorInfo')->where(['visitor_id' => $this->userInfo['id']])->save(['wallet' => (int)$this->userInfo['wallet']+(int)$card_info['money']+(int)$card_info['presenter_money']]);

			if(!$res) throw new Exception("充值失败3");

			$_SESSION['visitorInfo'] = LoginModel::getUserInfo('', $this->userInfo['id']);

			$this->commit();
			return ['status' => 'true'];
		} catch (Exception $e) {
			$this->rollback();
			return ['status' => 'false', 'err_msg' => $e->getMessage()];
		}
	}

	// 写入钱包流水
	public function write_waste_book($card_info, $pay_type)
	{
		$data = [
			'relevance_id' 	=> $this->pInfo['id'],
			'visitor_id'	=> $this->userInfo['id'],
			'pay_type'		=> $pay_type,
			'balance'		=> $this->userInfo['wallet']+$card_info['money']+$card_info['presenter_money'],
			'pay_status'	=> 1,
			'recharge_total'=> $card_info['money']+$card_info['presenter_money'],
			'system_remark'	=> '充值卡充值,卡金额:'.$card_info['money'].'元,赠送金额:'.$card_info['presenter_money'].'元',
			'pay_time'		=> date('YmdHis',time()),
			'create_time'	=> time(),
			'referer'		=> $_SERVER['HTTP_REFERER'],
		];

		return $this->add($data);
	}

	public function myWasteBook()
	{
		$where = ['visitor_id' => $this->userInfo['id'],'pay_status' => 1];
		$count = $this->where($where)->count();

		$page  = new \Think\Page($count, 10); 

		$list = $this->field('recharge_total,recharge_or_buy, system_remark,pay_time')
					->where($where)
					->order('pay_time desc')
					->limit($page->firstRow.','.$page->listRows)
					->select();
		return $list;
	}

	public function createAdvance()
	{
		if (I('get.recharge_total') < 0.01) {
			return false;
		}

		$info = $this->wei_xin_order_insert();

		$config = [
		    'out_trade_no' 	=> $info['order_number'],
		    'body' 			=> $this->pInfo['market_name'].'-充值订单'.$info['order_number'],
		    'total_fee' 	=> $info['recharge_total'] * 100,
		    'notify_url' 	=> 'http://'.$_SERVER['HTTP_HOST'].U('WasteBook/returnWXPay').'?rd='.$this->pInfo['id'].'&vd='.$this->userInfo['id'].'&w='.$this->userInfo['wallet'],
		];
		$wxOrder = $this->wechat->wxPayUnifiedOrder($this->userInfo['open_id'], $config);
		// 判断预订单是否生成成功
		if ($wxOrder['return_code'] != 'SUCCESS') {
		    return '生成预订单失败1';
		}

		// 生成微信支付JSAPI参数
		if (! array_key_exists('prepay_id', $wxOrder)) {
		     return '生成预订单失败2';
		}
		return $jsApiParams = $this->wechat->getWxPayJsApiParameters($wxOrder['prepay_id']);
	}

	public function wei_xin_order_insert()
	{
		$where = [
			'recharge_total' 	=> I('get.recharge_total'),
			'visitor_id'	 	=> $this->userInfo['id'],
			'pay_status'	 	=> 0,
			'recharge_or_buy'	=> 1,
			'pay_type'		 	=> 1,
			'relevance_id'	 	=> $this->pInfo['id']
		];

		// 如同样价格,同样条件有未支付,返回此数据
		$info = $this->field('order_number, recharge_total')->where($where)->find();

		if ($info) return $info;

		$where['order_number'] 	= 'V'.$this->userInfo['id'].'RECHARGE'.time().mt_rand(10000,99999);
		$where['referer'] 		= $_SERVER['HTTP_REFERER'];
		$where['create_time'] 	= time();

		$res = $this->add($where);

		if ($res) {
			return $where;
		}
		return false;
	}

	// 微信支付回调修改订单状态
	public function changeOrder($data)
	{
		$save = [
			'wechat_order_number' 	=> $data['transaction_id'],
			'status'				=> 2,
			'pay_time'				=> $data['time_end'],
			'pay_status'			=> 1,
			'wechat_total'			=> $data['cash_fee']/100,
		];
		$s_info = $this->find_visitor_is_first_recharge($data);

		if ($s_info) {
			$save['system_remark'] = '微信充值,充值金额:'.($data['cash_fee']/100).'元.达到条件:充值'.$s_info['recharge_price'].'元,赠送'.$s_info['present_price'].'元';
			$save['balance'] = $data['w'] + ($data['cash_fee']/100) + $s_info['present_price'];
		}else{
			$save['system_remark'] = '微信充值,充值金额:'.($data['cash_fee']/100).'元';
			$save['balance'] = $data['w'] + ($data['cash_fee']/100);
		}

		$res = $this->where(['order_number' => $data['out_trade_no']])->save($save);
		if ($res) {
			return M('VisitorInfo')->where(['visitor_id' => $data['vd']])->save(['wallet' => $save['balance']]);
		}
	}

	// 判断是否首充
	public function find_visitor_is_first_recharge($data)
	{
		$where = [
			'visitor_id'	 	=> $data['vd'],
			'pay_status'	 	=> 1,
			'recharge_or_buy'	=> 1,
			'pay_type'		 	=> 1,
			'relevance_id'	 	=> $data['rd']
		];

		$info = $this->field('order_number, recharge_total')->where($where)->find();

		$r_where = [
			'relevance_id' 		=> $data['rd'], 
			'is_first_recharge' => '1',
			'start_time'		=> ['lt',time()],
			'end_time'			=> ['gt',time()],
			'status'			=> 0,
			'recharge_price'	=> [['gt', ($data['cash_fee']/100)-1 ],['lt', ($data['cash_fee']/100)+1]],
		];
		if ($info) {// 不是首充
			$r_where['is_first_recharge'] = 0;
		}

		return M('RechargeSetting')->field('present_price,recharge_price')->where($r_where)->find();
	}
}

 ?>