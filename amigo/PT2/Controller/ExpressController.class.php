<?php 
namespace PT2\Controller;

use Think\Controller;

// 物流类
class ExpressController extends CommonController
{
	private $visitorInfoObj;

	public function __construct()
	{
		parent::__construct();
		$this->visitorInfoObj = new \PT2\Model\VisitorInfoModel;

	}

	public function showExpressInfo()
	{
		if (I('get.id')) {
			$info['order_number'] = M('OrderForm')
					->where(['id' => I('get.id'), 'visitor_id' => $this->userInfo['id'], 'relevance_id' => $this->pInfo['id']])
					->getField('order_number');

			$express = M('ExpressTrace')->field('trace,express_coding,express_number')->where(['order_number' => $info['order_number']])->find();
			if ($express['trace']) {
				$express['trace'] = json_decode($express['trace'], true);
			}
			// dump($express);exit;
			$info['express']['trace'] = $express['trace'];
			$info['express']['express_number'] = $express['express_number'];
			$info['express']['expressLast'] = array_pop($info['express']['trace']);
			$info['express']['name'] = M('Express')->where(['coding' => $express['express_coding']])->getField('name');
			array_push($info['express']['trace'],$info['express']['expressLast'] );
			// dump($info);exit;
			$this->assign('info', $info);
			$this->display();
		}else{
			E('无任何参数');
		}
	}

	public function received()
	{
		$selYouLike		= $this->visitorInfoObj->selYouLike();
		$this->assign('sel_you_like', $selYouLike);
		$this->display();
	}

}