<?php 
namespace Admin\Model;

use Think\Model;

class IndexModel extends CommonModel
{

	protected $autoCheckFields = false;

	public function ajaxControl($flag)
	{
		return $this->$flag();
	}

	/**
	 * 商户统计开始
	 */
	public function getFirstTableData()
	{
		$start = I('get.start')/1000;
		$end = I('get.end')/1000;
		$where = [
			'relevance_id' => $this->userInfo['company_id'],
		];

		for ($i=$start; $i < ($end + 1);) { 
			$where['date'] = $i;
			$data = M('CompanyStatistics')->where($where)->getField('visit_total');
			$result['visit_total'][] = $data?$data:0;
			$result['date'][]  = $i;
			$i += 86400;
		}

		return $result;
	}

	public function getSecondTableData()
	{
		$start = I('get.start')/1000;
		$end = I('get.end')/1000;
		for ($i=$start; $i < ($end + 1);) 
		{ 
			$OrderForm[]= M('OrderForm')->where(['create_time' => [['gt', $i-1], ['lt', $i + 86399]], 'company_id' => $this->userInfo['company_id'], 'status' => ['in','2,4']])->count();
			$SubscribeOrderForm[] = M('SubscribeOrderForm')->where(['create_time' => [['gt', $i-1], ['lt', $i + 86399]], 'company_id' => $this->userInfo['company_id'],'status' => ['not in', '-1, 5']])->count();
			$date[] = $i;
			$i += 86400;
		}
		$result['OrderForm'] = $OrderForm;
		$result['SubscribeOrderForm'] = $SubscribeOrderForm;
		$result['date'] = $date;
		return $result;
	}

	public function getThirdTableData()
	{
		$start = I('get.start')/1000;
		$end = I('get.end')/1000;
		for ($i=$start; $i < ($end + 1);) 
		{ 
			$data[] = M('WechatVisitor')->where(['addtime' => [['gt', $i-1], ['lt', $i + 86399]], 'company_id' => $this->userInfo['company_id'],])->count();
			$date[] = $i;
			$i += 86400;
		}
		$result['data'] = $data;
		$result['date'] = $date;
		return $result;
	}

	public function getFortTableData()
	{
		$start = I('get.start')/1000;
		$end = I('get.end')/1000;
		$where = [
			'company_id' => $this->userInfo['company_id'],
		];
		for ($z=1; $z < 6; $z++) 
		{ 
			for ($i=$start,$j = 0; $i < ($end + 1); $j++) { 
				$where['date'] = $i;
				$where['button_type'] = $z;
				$data = M('ButtonClickStatistics')->where($where)->getField('click_total');
				$result['click_total'][$z][] = $data?$data:0;
				$result['date'][$j]  = $i;
				$i += 86400;
			}
		}
		return $result;
	}

	/**
	 * 商户统计结束
	 */
	
	/**
	 * 大平台统计开始
	 */
	// 订单统计
	public function get_project_first_table_data()
	{
		$start = I('get.start')/1000;
		$end = I('get.end')/1000;
		for ($i=$start; $i < ($end + 1);) 
		{ 
			$OrderForm[]= M('OrderForm')->where([
						'create_time' 	=> [['gt', $i-1], ['lt', $i + 86399]], 
						'company_id' 	=> 0, 
						'relevance_id' 	=> $this->userInfo['relevance_id'], 
						'status' 		=> ['in','2,4']
					])->count();
			// $SubscribeOrderForm[] = M('SubscribeOrderForm')->where(['create_time' => [['gt', $i-1], ['lt', $i + 86399]], 'company_id' => $this->userInfo['company_id'],'status' => ['not in', '-1, 5']])->count();
			$date[] = $i;
			$i += 86400;
		}
		$result['OrderForm'] = $OrderForm;
		// $result['SubscribeOrderForm'] = $SubscribeOrderForm;
		$result['date'] = $date;
		return $result;
	}
	
	// 用户统计
	public function get_project_second_table_data()
	{
		$start = I('get.start')/1000;
		$end = I('get.end')/1000;
		for ($i=$start; $i < ($end + 1);) 
		{ 
			$visitor[]= M('WechatVisitor')->where([
						'addtime' 	=> [['gt', $i-1], ['lt', $i + 86399]], 
						// 'company_id' 	=> 0, 
						'relevance_id' 	=> $this->userInfo['relevance_id'], 
					])->count();
			// $SubscribeOrderForm[] = M('SubscribeOrderForm')->where(['create_time' => [['gt', $i-1], ['lt', $i + 86399]], 'company_id' => $this->userInfo['company_id'],'status' => ['not in', '-1, 5']])->count();
			$date[] = $i;
			$i += 86400;
		}
		$result['visitor'] = $visitor;
		// $result['SubscribeOrderForm'] = $SubscribeOrderForm;
		$result['date'] = $date;
		return $result;
	}

	// 浏览量统计
	public function get_project_third_table_data()
	{
		$start = I('get.start')/1000;
		$end = I('get.end')/1000;
		$where = [
			'relevance_id' => $this->userInfo['relevance_id'],
		];

		for ($i=$start; $i < ($end + 1);) { 
			$where['date'] = $i;
			$data = M('Statistics')->where($where)->getField('visit_total');
			$result['visit_total'][] = $data?$data:0;
			$result['date'][]  = $i;
			$i += 86400;
		}

		return $result;
	}

	// 导航栏点击量
	public function get_project_fort_table_data()
	{
		$start = I('get.start')/1000;
		$end = I('get.end')/1000;
		$where = [
			'company_id' 	=> 0,
			'relevance_id' 	=> $this->userInfo['relevance_id'],
		];
		for ($z=1; $z < 6; $z++) 
		{ 
			for ($i=$start,$j = 0; $i < ($end + 1); $j++) { 
				$where['date'] = $i;
				$where['button_type'] = $z;
				$data = M('ButtonClickStatistics')->where($where)->getField('click_total');
				$result['click_total'][$z][] = $data?$data:0;
				$result['date'][$j]  = $i;
				$i += 86400;
			}
		}
		return $result;
	}

	// 商户概况
	public function get_project_fifth_table_data()
	{
		$where = [
				'relevance_id' 	=> $this->userInfo['relevance_id'],
				'start_time'	=> ['lt',time()],
				'end_time'		=> ['gt',time()],
				'status'		=> 0,
			];
		$res['count']  		= M('Company')->where($where)->count();

		$where['addtime'] 	= ['gt',strtotime('last month')];
		$res['new_count'] 	= M('Company')->where($where)->count();

		unset($where['addtime']);
		$where['end_time'] = ['lt',strtotime('+1 month')];
		$res['ready_out_count'] 	= M('Company')->where($where)->count();
		return $res;
	}

	public function get_project_six_table_data()
	{
		$where = [
				'relevance_id' 	=> $this->userInfo['relevance_id'],
				'start_time'	=> ['lt',time()],
				'end_time'		=> ['lt',strtotime('+1 month')],
				'status'		=> 0,
			];
		$field = 'id, company_name, principal, business_id, start_time, end_time, phone, email, address_info';
		$list 	= M('Company')->where($where)->select();
		foreach ($list as $v) {
			$v['business_name'] = M('Business')->where(['id' => $v['business_id']])->getField('business_name');
			$res[] = $v;
		}
		return $res;
	}
}
?>