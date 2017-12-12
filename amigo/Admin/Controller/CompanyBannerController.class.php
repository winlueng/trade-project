<?php 
namespace Admin\Controller;

use Think\Controller;

class CompanyBannerController extends CommonController
{
	private $obj;

	public function __construct()
	{
		parent::__construct();
		$this->obj = D('CompanyBanner');
	}

	public function bannerAdd()
	{
		if (IS_POST) {
			$res = $this->obj->posterAdd();

			if ($res) {
				$this->success('添加成功');exit;
			}
			$this->error($this->obj->getError());
		}
		$data = $this->obj->showList();
		$this->assign('list', $data['list']);
		$this->assign('page', $data['page']);
		$this->display();
	}

	public function bannerUpdate()
	{
		if (IS_POST) 
		{
			$res = $this->obj->posterUpdate();
			if ($res) 
			{
				$this->success('修改成功');exit;
			}
			
			$this->error($this->obj->getError());exit;
		}
	}

	public function ajaxControl()
	{
		if (IS_AJAX) {
			return $this->ajaxReturn($this->obj->ajaxControl(I('get.flag')));
		}
	}
}