<?php 
namespace PT2\Controller;

use Think\Controller;

class DiscountController extends CommonController
{
	public function privilegeList()
	{
		
		$token = $this->wechat->get_card_list();
		$cardType = ['GROUPON','DISCOUNT','GIFT','CASH','GENERAL_COUPON'];
		$status = ['CARD_STATUS_VERIFY_OK', 'CARD_STATUS_DISPATCH'];
		foreach ($token->card_id_list as $v) {
			$json = '{"card_id":"'. $v .'"}';
			$info = $this->wechat->get_card_info($json)['card'];
			$type = strtolower($info['card_type']);
			if (in_array($info[$type]['base_info']['status'],$status) && in_array($info['card_type'], $cardType) && $info[$type]['base_info']['sku']['quantity']) {// 测试并且是默认优惠券通过了验证库存也不为0才加入数组
				$info[$type]['base_info']['card_type'] = $info['card_type'];
				$arr[] = $info[$type]['base_info'];
			}
		}
		// dump($arr);exit;
		$this->assign('list', $arr);
		$this->display();
	}

	public function ajaxControl()
	{
		if(!IS_AJAX) E('非法访问');
		$flag = I('get.flag');
		$this->ajaxReturn($this->$flag());
	}

	public function addCard()
	{
		$res = $this->wechat->add_Card(I('get.cardID'));
		$this->ajaxReturn(json_encode($res));
	}
}