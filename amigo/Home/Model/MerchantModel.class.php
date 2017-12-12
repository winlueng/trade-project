<?php 
namespace Home\Model;

use Think\Model\AdvModel;

class MerchantModel extends AdvModel
{
	protected $autoCheckFields = false;

	public function selMerchant()
	{
		$card = M('Card');
		$status = M('User')->where(['id' => I('get.id')])->getField('status');
		if (!$status) 
		{
			$res['mname'] = M('Company')->where(['uid'=>I('get.id')])->getField('company_name');
			$list = $card->field('card_ip,id,card_bgaddress')->where(['card_type'=>2,'status'=>0,['end_time'=>['gt',time()]],['start_time'=>['lt',time()]],'company_id'=>I('get.id')])->select();
			// 调用微信api(微信框架属于github仓库里)
			$league = new \Home\Model\LeagueModel();
			$wechat = $league->getCardSignature($list);

			$res['league'] = $wechat;
			$res['common'] = $card->field('card_code,id,card_name,card_desc')->where(['card_type'=>1,'status'=>0,['end_time'=>['gt',time()]],['start_time'=>['lt',time()]],'company_id'=>I('get.id')])->select();
			return $res;
		}else{
			return false;
		}
	}

	public function selPoster($relevance_id,$typeid=0)
	{
		// typeid类型属性(0=>广告位置投放,1=>商户位置投放,2=>商圈位置投放,3=>行业位置投放,4=>商户微官网位置)
		$poster = M('Poster');
		$list = $poster->field('poster_pic,poster_url')->where(['type_id'=>$typeid,'website_id' => $relevance_id,'start_time'=>['lt',time()],'end_time'=>['gt',time()],'status'=>0])->select();
		return $list;
	}


	public function ajaxControl()
	{
		$flag = I('get.flag');
		$cardIp = I('get.cardip');
		$card = M('Card');
		switch ($flag) 
		{
			case 'clickAdd':
				$card->where(['id' => $cardIp])->setInc("click_total",1);
				break;
			case 'getAdd':
				$card->where(['id' => $cardIp])->setInc("get_total",1);
				break;
			case 'otherDataStatistics':
				$result = $this->otherDataStatistics();
				break;
		}

		return $result;
	}


	protected function otherDataStatistics()
	{
		$type = I('get.type');
		$id = I('get.id');
		switch ($type) {
			case 'poster':
				$table = 'poster_statistics';
				$name = 'click_total';
				$where['poster_id'] = $id;
				break;
			case 'company':
				$table = 'cardcompany_statistics';
				$where['uid'] = $id;
				$name = 'visit_total';
				break;
		}

		$where['date'] = strtotime('today');
		$obj = M($table);
		$find = $obj->where($where)->find();
		if (!$find) 
		{
			$result = $obj->data($where)->add();
		}else{
			$result = $obj->where($where)->setInc($name,1);
		}
		return $result;
	}
}


 ?>