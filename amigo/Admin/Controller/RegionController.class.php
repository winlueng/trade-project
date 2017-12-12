<?php 
namespace Admin\Controller;

use Think\Controller;

class RegionController extends CommonController
{
	private $regionObj;

	public function __construct()
	{
		parent::__construct();
		$this->regionObj = D('Region');
	}

	public function regionAdd()
	{
		if (IS_POST) 
		{
			$result = $this->regionObj->regionAdd();
			if ($result) 
			{
				$this->success('添加成功');exit;
			}else{
				$this->error($this->regionObj->getError());exit;
			}
		}else{

			$list = $this->regionObj->showList();
			$this->assign('list',$list);
			$this->display();
		}
	}

	// ajax操作
	public function ajaxControl()
	{
		$res = $this->regionObj->ajaxControl();
		$this->ajaxReturn($res);
	}

	// 修改区域
	public function regionUpdate()
	{
		if (IS_POST) 
		{
			$result = $this->regionObj->regionUpdate();
			if ($result) 
			{
				$this->success('修改成功');exit();
			}else{
				$this->error($this->regionObj->getError());exit;
			}
		}
	}
}