<?php 
namespace Admin\Controller;

use Think\Controller;

class CardController extends CommonController
{	
	private $cardObj;

	public function __construct()
	{
		parent::__construct();
		$this->cardObj = D('Card');
	}

	// 卡券添加
	public function cardAdd()
	{
		if (IS_POST) 
		{ 
			if ($data = $this->cardObj->create()) 
			{
				$res = $this->cardObj->cardAdd();
				if ($res) 
				{
					$this->success('添加成功');exit;
				}else{
					$this->error('添加失败');exit;
				}
			}else{
				$this->error($this->cardObj->getError());exit;
			}
		}else{
			$address = $this->cardObj->getAddress();
			$this->assign('address',$address);
			$this->display();
		}
	}

	/**
	 * 自身卡券
	 */
	public function marketCardList()
	{
		if (IS_POST) 
		{
			$result = $this->cardObj->marketCardAdd();
			if ($result) 
			{
				$this->success('添加成功');exit;
			}else{
				$this->error($this->cardObj->getError());exit;
			}
		}else{
			$list = $this->cardObj->showCardList();
			$this->assign('list',$list['list']);
			$this->assign('page',$list['page']);
			$this->assign('region',$list['region']);
			$this->display();
		}
	}

	public function marketCardUpdate()
	{
		if (IS_POST) 
		{
			$res = $this->cardObj->marketCardUpdate();
			if ($res) 
			{
				$this->success('修改成功');exit;
			}else{
				$this->success($card->getError());exit;
			}
		}
	}

	/**
	 * 卡券修改
	 */
	public function cardUpdate()
	{
		if (IS_POST) 
		{
			$res = $this->cardObj->cardUpdate();
			if ($res['bool']) 
			{
				if ($_SESSION['companyInfo']) 
				{
					$this->success('修改成功');exit;
				}
				$this->success('修改成功');exit;
			}else{
				$this->error('修改失败');exit;
			}
		}else{
			$list = $this->cardObj->selCardInfo();
			$address = $this->cardObj->getAddress();
			$this->assign('address',$address);
			$this->assign('card',$list);
			$this->display();
		}
	}

	public function companyCardAdd()
	{
		if (IS_POST) 
		{ 
			$res = $this->cardObj->cardAdd();
			if ($res) 
			{
				$this->success('添加成功');exit;
			}else{
				$this->error($this->cardObj->getError());exit;
			}
		}else{
			$cardList = $this->cardObj->getWechatCardList();
			// dump($cardList);exit;
			$this->assign('empty', '<center>暂未生成卡券</center>');
			$this->assign('cardList', $cardList);
			$this->display();
		}
	}

	/**
	 * [ajaxControl 接受ajax数据进行处理]
	 * @return [json] [返回处理结果json数组]
	 */
	public function ajaxControl()
	{
		$res = $this->cardObj->ajaxControl();
		$this->ajaxReturn($res);exit;
	}

}