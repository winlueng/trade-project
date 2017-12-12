<?php
namespace Admin\Controller;

use Think\Controller;

class GoodsClassifyController extends CommonController
{
	private $classifyObj;

	public function __construct()
	{
		parent::__construct();
		$this->classifyObj = D('GoodsClassify');
	}

	public function goodsClassifyAdd()
	{
		if (IS_POST) 
		{
			$result = $this->classifyObj->insert();
			if ($result) 
			{
				$this->success('添加成功');exit;
			}else{
				$this->error($this->classifyObj->getError());exit;
			}
		}else{
			$cate = $this->classifyObj->goodsClassifyList();
			$this->assign('showcate',$cate['list']);
			$this->assign('page',$cate['page']);
			$this->display();
		}
	}

	public function goodsClassifyUpdate()
	{
		$result = $this->classifyObj->update();
		if ($result) 
		{
			$this->success('修改成功');exit;
		}else{
			$this->error($this->classifyObj->getError());exit;
		}
	}

	public function ajaxControl()
	{
		$this->ajaxReturn($this->classifyObj->ajaxControl());exit;
	}

	/**
	 * 大门户产品分类
	 */
	public function goodsClassifyAddByProject()
	{
		if (IS_POST) 
		{
			$result = $this->classifyObj->insert();
			if ($result) {
				$this->success('添加成功');
				exit;
			}
				
			$this->error($this->classifyObj->getError());exit;
		}

		$where = [
			'company_id' => 0,
			'status' => ['neq','-1'],
			'relevance_id' => $this->userInfo['relevance_id'],
		];
		
		$result = $this->classifyObj->goodsClassifyList($where);
		$this->assign('list', $result['list']);
		$this->assign('page', $result['page']);
		$this->display();
	}
}
?>