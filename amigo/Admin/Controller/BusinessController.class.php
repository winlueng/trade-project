<?php 
namespace Admin\Controller;

use Think\Controller;

class BusinessController extends CommonController
{
	private $businessObj;

	public function __construct()
	{
		parent::__construct();
		$this->businessObj = D('Business');
	}

	/**
	 * 商户行业添加
	 */
	public function businessAdd()
	{
		if (IS_POST) 
		{
			$result = $this->businessObj->businessAdd();
			if ($result) 
			{
				$this->success('添加成功');exit;
			}else{
				$this->error($this->businessObj->getError());exit;
			}
		}else{
			$list = $this->businessObj->businessSel();
			$this->assign('list', $list['list']);
			$this->assign('region', $list['region']);
			$this->assign('page', $list['page']);
			$this->display();
		}
	}

	// 行业修改
	public function businessUpdate()
	{
		if (IS_POST) {
			// dump(I('post.'));exit;
			$res = $this->businessObj->businessUpdate();
			if ($res) 
			{
				$this->success('修改成功');exit;
			}else{
				$this->error($this->businessObj->getError());exit;
			}
		}
	}

	// ajax操作
	public function ajaxControl()
	{
		$res = $this->businessObj->ajaxControl();
		$this->ajaxReturn($res);
	}
}