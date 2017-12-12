<?php 
namespace Home\Model;

use Think\Model;

class DiscountModel extends Model
{
	protected $autoCheckFields = false;

	public function showWeekCard()
	{
		$card = M('Card');
		$cardList = $card->field('id, card_ip,card_bgaddress,card_code,card_name,card_desc')->where(['activity'=>1,'status'=>0,['end_time'=>['gt',time()]],['start_time'=>['lt',time()]]])->select();

		return $cardList;
	}



}