<?php 
namespace Home\Controller;


use Think\Controller;

class LeagueController extends CommonController
{

	public function leagueCard()
	{
		$league = new \Home\Model\LeagueModel();
		$list = $league->showCard();
		// 调用微信api(微信框架属于github仓库里)
		$wechat = $league->getCardSignature($list);
		$poster = new \Home\Model\IndexModel();
    	$posterList = $poster->selPoster(4);

    	$this->assign('poster',$posterList);
		$this->assign('wechat',$wechat['wechat']);
		$this->assign('list',$wechat['list']);
		$this->display();
	}

	public function leagueMerchant()
	{
		$league = new \Home\Model\LeagueModel();
		$list = $league->showLeague();
		$poster = new \Home\Model\IndexModel();
    	$posterList = $poster->selPoster(5);

    	$this->assign('poster',$posterList);
		$this->assign('region',$list['region']);
		$this->assign('list',$list['merchant']);
		$this->display();
	}



}
