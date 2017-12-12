<?php 
namespace Admin\Model;

use Think\Model;
use Think\Exception;
/**
* 流水账类
*/
class RechargeCardModel extends CommonModel
{
	protected $_validate = [
		['money', 'require', '请输入充值卡金额'],
		// ['presenter_money', 'require', '请输入充值卡金额'],
		['start_time', 'require', '请输入充值卡使用开始时间戳'],
		['end_time', 'require', '请输入充值卡使用结束时间戳'],
		['card_count', 'require', '请输入生成充值卡数量'],
	];

	public function __construct()
	{
		parent::__construct();
		$this->_auto = [
			['create_time', 'time', 1, 'function'],
			['relevance_id', $this->userInfo['relevance_id']],
		];
	}

	// 
	public function cardList()
	{
		$field  = [
			'count(card_number)' => 'card_total',
			'start_time',
			'end_time',
			'create_time',
			'money',
			'card_id',
			'presenter_money'
		];

		$count = $this->field('money')->where(['relevance_id' => $this->userInfo['relevance_id']])->group('card_id')->select();
		$count = count($count);
		$page = new \Think\Page($count, 20);

		$list = $this->field($field)
			->where(['relevance_id' => $this->userInfo['relevance_id']])
			->group('card_id')
			->order('create_time desc')
			->limit($page->firstRow.','.$page->listRows)
			->select();
		foreach ($list as $v) {
			$v['use_sum'] = $this->where(['card_id' => $v['card_id'], 'visitor_id' => ['neq',''], 'used_time' => ['neq','0']])->count();
			$result[] = $v;
		}
		$res['list'] = $result;
		$res['page'] = $page->show();
		return $res;
	}

	// 实用情况
	public function card_info($flag)
	{
		$where = [
			'card_id' => I('get.card_id'), 
			'relevance_id' => $this->userInfo['relevance_id']
		];

		if (I('get.card_number')) {
			$where['card_number'] = I('get.card_number');
		}

		switch ($flag) {
			case '1':// 未使用
				$where['used_visitor_id'] = '0';
				break;
			case '2':// 已实用
				$where['used_visitor_id'] = ['neq','0'];
				break;
		}

		$count = $this->where($where)->count();

		$page = new \Think\Page($count, 25);

		$field = 'serial_number, card_number, money, presenter_money, status, start_time, end_time, used_visitor_id, used_time';

		$list = $this->field($field)
				->where($where)
				->limit($page->firstRow.','.$page->listRows)
				->order('used_time desc')
				->select();
		if ($flag == '2') {
			foreach ($list as $v) {
				$v['nick_name'] = M('VisitorInfo')->where(['visitor_id' => $v['used_visitor_id']])->getField('nick_name');
				$v['phone'] 	= M('WechatVisitor')->where(['id' => $v['used_visitor_id']])->getField('phone');
				$res['list'][]  = $v;
			}
		}else{
			$res['list'] = $list;
		}

		$res['page'] = $page->show();
		return $res;
	}

	public function downloadExcelBefore($flag)
	{
		$where = [
			'card_id' => I('get.card_id'), 
			'relevance_id' => $this->userInfo['relevance_id']
		];

		if (I('get.card_number')) {
			$where['card_number'] = I('get.card_number');
		}

		if (I('get.used')) {
			$flag = I('get.used');
		}

		switch ($flag) {
			case '1':// 未使用
				$where['used_visitor_id'] = '0';
				break;
			case '2':// 已实用
				$where['used_visitor_id'] = ['neq','0'];
				break;
		}

		$field = 'serial_number, card_number, money, presenter_money, status, start_time, end_time, used_visitor_id, used_time';

		$list = $this->field($field)
				->where($where)
				->select();

		if ($flag == '2') {
			foreach ($list as $v) {
				$v['nick_name'] = M('VisitorInfo')->where(['visitor_id' => $v['used_visitor_id']])->getField('nick_name');
				$v['phone'] 	= M('WechatVisitor')->where(['id' => $v['used_visitor_id']])->getField('phone');
				$res[]  		= $v;
			}
		}else{
			$res = $list;
		}
		return $res;
	}

	public function cardAdd()
	{
		try {
			$data = $this->create();

			if (!$data) throw new Exception($this->getError());
			
			$num = I('post.card_count');

			$data['card_id'] = $this
							->where(['relevance_id' => $this->userInfo['relevance_id']])
							->max('card_id');

			$data['card_id'] += 1;
			$this->startTrans();

			if ((int)$data['money'] < 100000 && (int)$data['money'] >= 10000) {
				$card_num = '000'.(string)ceil((int)$data['money']/100);
			}elseif((int)$data['money'] < 10000 && (int)$data['money'] >= 1000){
				$card_num = '000'.(string)ceil((int)$data['money']/100).'9';
			}elseif((int)$data['money'] < 1000 && (int)$data['money'] >= 100){
				$card_num = '0'.(string)ceil((int)$data['money']/100).'99';
			}
			$data['money'] = ceil((int)$data['money']/100)*100;

			$c_mun = $this->where(['money' => $data['money']])->min('card_number');

			if (!$c_mun) {
				$start = 888888;
			}else{
				$start = (int)substr($c_mun,-6) - 1;
			}

			for ($i=0, $j=(int)$start; $i < (int)$num; $i++, $j--) { 
				$data['serial_number'] = (string)time().(string)mt_rand(10000,99999);
				$data['card_number'] = $card_num.(string)$j;
				$res = $this->add($data);
				if(!$res) throw new Exception("生成失败,生成第".($i+1).'张卡片出现异常');
			}

			$this->commit();
			return $data['card_id'];
		} catch (Exception $e) {
			$this->rollback();
			return $e->getMessage();
		}
	}

	public function changeCardStatus()
	{
		return $this->where(['card_number' => I('get.card_number')])->save(['status' => I('get.status')]);
	}

	public function ajaxControl($flag)
	{
		return $this->$flag();
	}

}

 ?>