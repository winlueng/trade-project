<?php
namespace Admin\Controller;

use Think\Controller;

class NewsController extends CommonController
{
	private $newsObj;

	public function __construct()
	{
		parent::__construct();
		$this->newsObj = D('News');
	}

	public function companyNewsList()
	{
		$result   = $this->newsObj->showNewsList();
		$where = [
			'company_id' => $this->userInfo['company_id'],
			'status'	 => ['not in', '-1,1'],
			'relevance_id' => $this->userInfo['relevance_id']
		];
		$classify = M('NewsClassify')->field('news_type_name,id')->where($where)->select();
		$this->assign('classify', $classify);
		$this->assign('page', $result['page']);
		$this->assign('list', $result['list']);
		$this->assign('classify', $classify);
		$this->display();
	}

	public function companyNewsAdd()
	{
		if (IS_POST) {
			$result = $this->newsObj->newsAdd();
			if ($result) 
			{
				$this->success('添加成功','/Admin/News/companyNewsAdd');exit;
			}else{
				$this->error($this->newsObj->getError());exit;
			}
		}
		$goods_classify  = M('GoodsClassify')->where([
				'status' => ['not in', '-1,1'],
				'relevance_id' => $this->userInfo['relevance_id'],
				'company_id' => $this->userInfo['company_id'],
			])->select();
		$this->assign('goods_classify',$goods_classify);
		// dump($goods_classify);exit;
		$result   = $this->newsObj->showNewsList();
		$where = [
			'company_id' => $this->userInfo['company_id'],
			'status'	 => ['not in', '-1,1'],
			'relevance_id' => $this->userInfo['relevance_id']
		];
		$classify = M('NewsClassify')->field('news_type_name,id')->where($where)->select();
		$this->assign('classify', $classify);
		$this->assign('page', $result['page']);
		$this->assign('list', $result['list']);
		$this->assign('classify', $classify);
		$this->display();
	}

	public function preview()
	{
		$info = $this->newsObj->selNewsInfo();
		// dump($info);exit;
		$this->assign('info', $info);
		$this->display();
	}

	// 动态修改
	public function companyNewsUpdate()
	{
		$result = $this->newsObj->newsUpdate();
		if ($result) 
		{
			$this->success('修改成功');exit;
		}else{
			$this->error($this->newsObj->getError());exit;
		}
	}

	// ajax操作
	public function ajaxControl()
	{
		if (IS_AJAX) {
			$this->ajaxReturn($this->newsObj->ajaxControl());
		}
	}

	// 动态置顶审核列表
	public function showNewsAuditList()
	{
		$result = $this->newsObj->showNewsAuditList();
		$this->assign('list', $result['list']);
		$this->assign('page', $result['page']);
		$this->display();
	}

	public function newsListByProject()
	{
		$result   = $this->newsObj->showNewsList();
		$classify = M('NewsClassify')
		           ->where([
			           	'company_id' => 0, 
			           	'status' => ['not in','-1,1'],
			           	'relevance_id' => $this->userInfo['relevance_id']
		           ])->select();
		$this->assign('page', $result['page']);
		$this->assign('list', $result['list']);
		$this->assign('classify', $classify);
		$this->display();
	}

	public function newsAddByProject()
	{
		if (IS_POST) {
			$result = $this->newsObj->newsAdd();
			if ($result) 
			{
				$this->success('添加成功','/Admin/News/newsListByProject/module/'.I('get.module'));exit;
			}else{
				$this->error($this->newsObj->getError());exit;
			}
		}
		$goods_classify  = M('GoodsClassify')->where(['status' => ['not in', '-1,1'],'relevance_id' => $this->userInfo['relevance_id']])->select();
		$this->assign('goods_classify',$goods_classify);
		$where = [
			'company_id' => $this->userInfo['company_id'],
			'status'	 => ['not in', '-1,1'],
			'relevance_id' => $this->userInfo['relevance_id']
		];
		$classify = M('NewsClassify')->field('news_type_name,id')->where($where)->select();
		$this->assign('classify', $classify);
		$this->display();
	}

	public function newsUpdateByProject()
	{
		if (IS_POST) {
			// dump($_FILES);exit;
			$result = $this->newsObj->newsUpdate();
			if ($result) 
			{
				$this->success('修改成功','/Admin/News/newsListByProject/module/'.I('get.module'));exit;
			}else{
				$this->error($this->newsObj->getError());exit;
			}
		}
		$goods_classify  = M('GoodsClassify')->where(['status' => ['not in', '-1,1'],'relevance_id' => $this->userInfo['relevance_id']])->select();
		$where = [
			'company_id' => $this->userInfo['company_id'],
			'status'	 => ['not in', '-1,1'],
			'relevance_id' => $this->userInfo['relevance_id']
		];
		$classify = M('NewsClassify')->field('news_type_name,id')->where($where)->select();
		$info = $this->newsObj->selNewsInfo();
		$this->assign('info',$info);
		$this->assign('goods_classify',$goods_classify);
		$this->assign('classify', $classify);
		$this->display();
	}
}