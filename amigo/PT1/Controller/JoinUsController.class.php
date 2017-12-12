<?php 
namespace PT1\Controller;

use Think\Controller;

class JoinUsController extends CommonController
{

	public function projectInfo()
	{
		$obj = new \PT1\Model\JoinUsModel();
		$info = $obj->showProjectInfo();
		$this->assign('info', $info);
		$this->display();
	}
}