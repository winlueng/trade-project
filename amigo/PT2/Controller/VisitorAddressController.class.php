<?php 
namespace PT2\Controller;

use Think\Controller;

class VisitorAddressController extends CommonController
{
	private $obj;
	public function __construct()
	{
		parent::__construct();
		$this->obj = new \PT2\Model\VisitorAddressModel();
		if (!isWeixin() && !$this->v_info) {
			$this->redirect(MODULE_NAME.'/Login/defaultLogin');exit;
		}
	}

	public function addressList()
	{
		$list = $this->obj->addrList();
		// dump($list);exit;
		$this->assign('list',$list);
		$this->display();
	}

	public function orderAddress()
	{
		$list = $this->obj->addrList();
		// dump($list);exit;
		$this->assign('list',$list);
		$this->display();
	}

	public function addressInfo()
	{
		if (IS_AJAX) {
			$res = $this->obj->update();
			if($res){
				$this->ajaxReturn(['status'=>'true']);
			}
			$this->ajaxReturn([ 'status' => 'false', 'err_msg'=>$this->obj->getError()]);exit;
		}
		$info = $this->obj->info();
		// dump($info);exit;
		$this->assign('info',$info);
		$this->display();
	}

	public function addressAdd()
	{
		if (IS_AJAX) {
			// dump(I('post.'));exit;
			$res = $this->obj->insert();
			if($res){
				$this->ajaxReturn(['status'=>'true']);
			}
			$this->ajaxReturn([ 'status' => 'false', 'err_msg'=>$this->obj->getError()]);exit;
		}
		$this->display();
	}

	public function ajaxControl()
	{
		if(!IS_AJAX) E('非法访问');

		$this->ajaxReturn($this->obj->ajaxControl(I('get.flag')));
	}
}

?>