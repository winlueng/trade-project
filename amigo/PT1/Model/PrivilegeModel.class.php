<?php 
namespace PT1\Model;

use Think\Model;

class PrivilegeModel extends Model
{
	protected $autoCheckFields = false;

	public function showCardList()
	{
		$company = M('Company');
		$where = array(
			array('relevance_id' 		=> $_SESSION['projectInfo']['id'] ),
			array('category_id'  		=> $_SESSION['projectInfo']['category_id'] ),
			array('status'       		=> 0 ),
			array('card_type'       	=> 2 ),//联盟活动
			array('start_time'   		=> array('lt',time()) ),
			array('end_time'     		=> array('gt',time()) ),
		);

		$list = $this->field('card_ip, company_logo, company_id')->where($where)->order('control_time desc')->select();

		$newList = $this->getCardSignature($list);
		// return $newList;
		foreach($newList['list'] as $v)
		{
			$companyInfo = $company->field('company_name, web_postfix, address_info,x_coordinate,y_coordinate')->where(['id' => $v['company_id']])->select()[0];
			$v['address_info'] = $companyInfo['address_info'];
			$v['company_name'] = $companyInfo['company_name'];
			$v['company_link'] = $companyInfo['web_postfix'];
			$v['x_coordinate'] = $companyInfo['x_coordinate'];
			$v['y_coordinate'] = $companyInfo['y_coordinate'];
			$result[] = $v;
		}
		$newList['list'] = $result;
		return $newList;

	}

	public function getCardSignature($list)
	{
		foreach($list as $v)
		{
			$cardId[] = $v['card_ip'];
		}

		$package = new \Gaoming13\WechatPhpSdk\JSSDK($_SESSION['projectInfo']['app_id'],$_SESSION['projectInfo']['app_secret'],$cardId);
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