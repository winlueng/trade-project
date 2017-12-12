<?php 
namespace Admin\Model;

use Think\Model;

/**
* 前台用户model类
*/
class VisitorInfoModel extends CommonModel
{
	private $visitorObj;
	function __construct()
	{
		parent::__construct();
		$this->visitorObj=M('WechatVisitor');
	}

	public function getVisitorList($setWhere = '')
	{
		$field = [
			'id',
			'phone',
		];

		$where = ['company_id' => $this->userInfo['company_id']];

		if ($setWhere) $where = $setWhere;

		if(I('get.visitor_id')) $where['id'] = I('get.visitor_id');

		if(I('get.sel_name')) {
			$idList = $this
					->where(['nick_name' => ['like', '%'. I('get.sel_name') .'%']])
					->getField('visitor_id', true);

			$where['id'] = ['in', implode(',', $idList)];
		}
		// return $idList;

		$count = $this->visitorObj->where($where)->count();

		$page = new \Think\Page($count, 10);

		$list = $this->visitorObj->field($field)
				->where($where)
				->order('addtime desc')
				->limit($page->firstRow.','.$page->listRows)
				->select();
		foreach ($list as $v) {
			$res = $this->where(['visitor_id'=>$v['id']])->find();
			// $res = [];
			$v['pay_total'] = M('OrderForm')->where(['pay_status' => 1, 'visitor_id' => $v['id'], 'relevance_id' => $this->userInfo['relevance_id']])->count();
			// $v['subscribe_total'] = M('SubscribeOrderForm')->where(['pay_status' => 1, 'visitor_id' => $v['id'], 'relevance_id' => $this->userInfo['relevance_id']])->count();
			$field = [
				'COUNT(*)' => 'recharge_total',
				'SUM(recharge_total)' => 'recharge_sum',
			];
			$recharge_info = M('WasteBook')->field($field)->where([
								'visitor_id' => $v['id'],
								'recharge_or_buy' => 1,
								'pay_status' => 1,
								'pay_type' => ['in','1,2'],
							])->find();
			$v = array_merge($v, $recharge_info);
			$vlist[] = array_merge($v, $res);
		}
		$result['list'] = $vlist;
		$result['page'] = $page->show();
		return $result;
	}

	public function visitorInfo($visitorID='')
	{
		if (I('get.visitor_id')) $visitorID = I('get.visitor_id');

		$info = $this->where(['visitor_id'=> $visitorID])->find();

		$data = $this->visitorObj->field('phone,email,company_id')->where(['id'=> $visitorID,'relevance_id' => $this->userInfo['relevance_id']])->find();

		if (!$data) return ['status' => false];
		
		if ($data['company_id']) $data['company_name'] = M('Company')->where(['id' => $data['company_id']])->getField('company_name');
		else $data['company_name'] = '主门户';
		
		$info = array_merge($info, $data);
		/*$field = [
			'COUNT(*)' => 'recharge_total',
			'SUM(recharge_total)' => 'recharge_sum',
		];
		$recharge_info = M('WasteBook')->field($field)->where(['visitor_id' => $info['visitor_id']])->find();
		$info = array_merge($info, $recharge_info);*/
		$info['pay_total'] = M('OrderForm')->where(['pay_status' => 1, 'visitor_id' => $info['visitor_id'], 'relevance_id' => $this->userInfo['relevance_id']])->count();
		$info['visitor_birthday'] = date('Y-m-d', $info['visitor_birthday']);
		return ['status' => true, 'info' => $info];
	}

	/**
	 * ajax的操作
	 * @param  string $flag 传递过来的get参数
	 */
	public function ajaxControl($flag)
	{
		return $this->$flag();
	}

	public function joinInStaff()
	{
		return D('Staff')->insert(I('get.id'));
	}
}

 ?>