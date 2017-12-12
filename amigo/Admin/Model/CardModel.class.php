<?php 
namespace Admin\Model;

use Think\Model;

class CardModel extends CommonModel
{
	public function getWechatCardList()
	{
		$token = $this->wechat->get_card_list();
		$cardType = ['GROUPON','DISCOUNT','GIFT','CASH','GENERAL_COUPON'];
		$status = ['CARD_STATUS_VERIFY_OK', 'CARD_STATUS_DISPATCH'];
		foreach ($token->card_id_list as $v) {
			$json = '{"card_id":"'. $v .'"}';
			$info = $this->wechat->get_card_info($json)['card'];
			$type = strtolower($info['card_type']);
			if (in_array($info[$type]['base_info']['status'],$status) && in_array($info['card_type'], $cardType)) 
			{// 测试通过了验证并且是默认优惠券才加入数组
				$info[$type]['base_info']['card_type'] = $info['card_type'];
				$arr[] = $info[$type]['base_info'];
			}
		}
		return $arr;
	}

	public function getAddress()
	{
		return	$address = M('District')->field('district_id,name')->where(['parent_id'=>0])->select();
	}

	// ajax操作方法
	public function ajaxControl()
	{
		$flag = I('get.flag');
		$id = I('get.pid');
		switch ($flag) 
		{
			case 'address':
				$res = M('District')->field('district_id,name')->where(['parent_id'=>$id])->select();
				break;
			case 'region':
				$res = M('Region')->field('id, region_name')->where(['pid'=>$id,'status'=>0])->select();
				foreach ($res as $k => $v)
				{
					$list[$k]['district_id'] = $v['id'];
					$list[$k]['name'] = $v['region_name'];
				}
				return $list;exit;
				break;
			case 'merchant':
				$res = M('Company')->field('id, company_name')->where(['business_id'=>$id,'status'=>0])->select();
				foreach ($res as $k => $v)
				{
					$list[$k]['district_id'] = $v['id'];
					$list[$k]['name'] = $v['company_name'];
				}
				return $list;exit;
				break;
			case 'business':
				$res = M('Business')->field('business_name,id')->where(['region_id'=>$id])->select();
				foreach ($res as $k => $v)
				{
					$list[$k]['district_id'] = $v['id'];
					$list[$k]['name'] = $v['business_name'];
				}
				return $list;exit;
				break;
		}
		return $res;
	}
}





 ?>