<?php 
namespace Admin\Model;

use Think\Model;

/**
* 流水账类
*/
class WasteBookModel extends CommonModel
{
	public function __construct()
	{
		parent::__construct();
	}

	// 
	public function currentCount()
	{
		$where = [
				'relevance_id' 		=> $this->userInfo['relevance_id'],
				'status' 			=> ['neq','-1'],
				'pay_status' 		=> 1,
				'recharge_or_buy' 	=> 1,
				'pay_type'			=> ['not in','3,4']
			];
		$count = $this->where($where)->count();
		$page = new \Think\Page($count, 10);
		$list = $this->field('id, visitor_id, pay_time, wechat_total, system_remark, recharge_total')
				->where($where)
				->order('pay_time desc')
				->limit($page->firstRow.','.$page->listRows)
				->select();

		foreach ($list as $v) {
			$v['nick_name'] = M('VisitorInfo')->where(['visitor_id' => $v['visitor_id']])->getField('nick_name');
			$v['pay_time']	= wechatPayTime($v['pay_time']);
			$res['list'][]  = $v;
		}
		$res['recharge_total'] = $this->where($where)->sum('wechat_total');
		$where['pay_type'] = 2;
		$res['card_recharge_total'] = $this->where($where)->sum('recharge_total');
		$res['page'] = $page->show();
		return $res;
	}

	public function ajaxControl($flag)
	{
		return $this->$flag();
	}

	public function statisticsTable()
	{
		$start = I('get.start')/1000;
		$end = I('get.end')/1000;

		$where = [
			'relevance_id' 		=> $this->userInfo['relevance_id'],
			'pay_status'		=> 1,
			'recharge_or_buy'	=> 1
		];

		for ($i=$start; $i < ($end + 1);) { 
			$where['pay_time'] = [['gt', date('YmdHis',$i-1)], ['lt', date('YmdHis',$i + 86399)]];
			$data = $this->where($where)->sum('wechat_total');
			$result['recharge_total'][] = $data?$data:0;
			$result['date'][]  = $i;
			$i += 86400;
		}

		return ['status' => true, 'data' => $result];
	}

	public function refund_to_visitor($info, $refund_price)
	{
		$wallet	= M('WasteBook')
				->where(['visitor_id' => $info['visitor_id'], 'relevance_id' => $this->userInfo['relevance_id']])
				->order('id desc')
				->getField('balance');

		$data = [
			'relevance_id' 	=> $this->userInfo['relevance_id'],
			'visitor_id'	=> $info['visitor_id'],
			'pay_type'		=> 4,
			'balance'		=> $refund_price + $wallet,
			'pay_status'	=> 1,
			'recharge_total'=> $refund_price,
			'system_remark'	=> '退款回滚,退款金额:'.$refund_price.'元',
			'pay_time'		=> date('YmdHis',time()),
			'create_time'	=> time(),
			'referer'		=> $_SERVER['HTTP_REFERER'],
		];

		return $this->add($data);
	}
}