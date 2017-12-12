<?php 
namespace Admin\Controller;

use Think\Controller;

class GoodsAttributeController extends CommonController
{
	private $attrObj;
	public function __construct()
	{
		parent::__construct();
		$this->attrObj = D('GoodsAttribute');
	}

	public function update()
	{
		if (!IS_POST) return '非法操作';

		$res = $this->attrObj->update();

		if ($res) return true;
		
		return false;
	}

	public function ajaxControl()
	{
		if (!IS_AJAX) return '非法操作';

		$result = $this->attrObj->ajaxControl();

		$this->ajaxReturn($result);
	}
}

 ?>