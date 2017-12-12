<?php 
namespace Admin\Controller;

use Think\Controller;

/**
* 前台用户类
*/
class VisitorImageController extends CommonController
{
	private $obj;
	public function __construct()
	{
		parent::__construct();
		$this->obj = D('VisitorImage');

	}

	public function insert()
	{
		if (IS_POST) {
			/*dump($_POST);exit;*/
			$res = $this->obj->insert();
			/*dump($this->obj->getError());
			dump($res);exit;*/
			if ($res) {
				$this->success('感谢上传!');exit;
			}
			$this->error($this->obj->getError());exit;
		}else{
			E('非法访问');
		}
	}

	public function update()
	{
		if (IS_POST) {
			/*dump($_POST);
			dump($_FILES);
			exit;*/
			$res = $this->obj->update();
			// dump($res);exit;
			if ($res) {
				$this->success('感谢上传!');exit;
			}
			$this->error($this->obj->getError());exit;
		}else{
			E('非法访问');
		}
	}

	public function ajaxControl()
	{
		if(!IS_AJAX) E('非法访问');

		$this->ajaxReturn($this->obj->ajaxControl(I('get.flag'))) ;

		
	}
}

 ?>