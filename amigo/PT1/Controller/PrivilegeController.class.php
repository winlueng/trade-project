<?php 
namespace PT1\Controller;

use Think\Controller;

class PrivilegeController extends CommonController
{
	public function privilegeList()
	{
		$card = new \PT1\Model\PrivilegeModel('Card');
		$index = new \PT1\Model\IndexModel('Poster');
		$info = $card->showCardList();
		$posterList = $index->selPoster(C('POSTER_PRIVILEGE'), 1);
		// dump($info);exit;
		$this->assign('cardList', $info['list']);
		$this->assign('wechat', $info['wechat']);
		// dump($posterList);exit;
		$this->assign('posterList', $posterList);
		$this->display();
	}
}