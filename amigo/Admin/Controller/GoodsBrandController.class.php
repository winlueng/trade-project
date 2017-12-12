<?php 
namespace Admin\Controller;

use Think\Controller;

class GoodsBrandController extends CommonController
{
	private $brandObj;

	public function __construct()
	{
		parent::__construct();
		$this->brandObj = D('GoodsBrand');

	}

	public function brandList()
	{
		if (IS_POST) {
			$res = $this->brandObj->insert();
			if ($res) {$this->success('添加成功');exit;}

			$this->error($this->brandObj->getError());exit;
		}else{
			$res = $this->brandObj->selBrandList();
			$this->assign('list', $res['list']);
			$this->assign('page', $res['page']);
			$this->display();
		}
	}

	public function brandUpdate()
	{
		if (IS_POST) {
			$res = $this->brandObj->update();
			if ($res) {$this->success('修改成功');exit;}

			$this->error($this->brandObj->getError());exit;
		}
		$this->error('非法访问');exit;
	}

	public function ajaxControl()
	{
		$res = $this->brandObj->ajaxControl();
		$this->ajaxReturn($res);
	}

	/**
	 * 大门户品牌管理
	 */
	public function brandAdd()
	{
		if (IS_POST) {
			$res = $this->brandObj->insert();
			if ($res) {$this->success('添加成功');exit;}

			$this->error($this->brandObj->getError());exit;
		}else{
			$where = [
				'relevance_id'  => $this->userInfo['relevance_id'],
				'status'		=> ['neq', '-1'],
			];
			$res = $this->brandObj->selBrandList($where);
			$this->assign('list', $res['list']);
			$this->assign('page', $res['page']);
			$this->display();
		}
	}
}

 ?>