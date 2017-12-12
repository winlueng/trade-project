<?php 
namespace Home\Model;

use Think\Model;

class LeagueModel extends Model
{	
	protected $autoCheckFields = false;

	/**
	 * 前台联盟商户列表
	 */
	public function showLeague()
	{
		$merchant = M('Company');
		$group = D('auth_group_access');
		$companyId = $group->where(['group_id'=>['in','11,12']])->getField('uid',true);
		$canShowCompanyId = implode(',', $companyId);
		$list['merchant'] = $merchant->field('company_pic,company_link')->where(['company_type'=>1,'uid' => ['in',$canShowCompanyId],'status'=>0,['end_time'=>['gt',time()]],['start_time'=>['lt',time()]]])->select();

		return $list;

	}

	public function showCard()
	{
		$card = M('Card');
		$list = $card->field('card_ip,id,card_bgaddress')->where(['activity'=>2,'cardtype'=>2,'status'=>0,['end_time'=>['gt',time()]],['start_time'=>['lt',time()]]])->select();

		return $list;
	}

	public function getCardSignature($list)
	{
		foreach($list as $v)
		{
			$cardId[] = $v['card_ip'];
		}

		$package = new \Gaoming13\WechatPhpSdk\JSSDK('wxd85b9860c072dfe8','bc3d350e7180669ea3404ad8b599ab36',$cardId);
		$wechat = $package->GetSignPackage();
		foreach($wechat['Card'] as $k => $v)
		{
			$list[$k]['nonce_str'] = $v['nonce_str'];
			$list[$k]['timestamp'] = $v['timestamp'];
			$list[$k]['Card_Ticket'] = $v['Card_Ticket'];
			$list[$k]['apiTicket'] = $v['apiTicket'];
		}
		$res['wechat'] = $wechat;
		$res['list'] = $list;
		return $res;
	}
}



 ?>