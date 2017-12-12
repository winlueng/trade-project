<?php 
namespace Template00003\Controller;

use Think\Controller;

class VisitorAddressController extends CommonController
{
	private $obj;
	public function __construct()
	{
		parent::__construct();
		$this->obj = new \Template00002\Model\VisitorAddressModel();
	}

	public function addressList()
	{
		$list = $this->obj->addrList();
		// dump($list);exit;
		$this->assign('list',$list);
		$this->display();
	}

	public function addressInfo()
	{
		if (IS_POST) {
			$res = $this->obj->update();
			if($res){
				if(I('get.order')){
					$str = 'OrderForm/orderDetail';
					$arr = ['companyName' => $_GET['companyName'], 'id' => I('get.order')];
					$adr = $this->obj->field('consignee,phone,address_str')
						->where(['visitor_id' => $this->userInfo['id'], 'id' => I('get.id')])
						->find();
					M('OrderForm')->where(['id' => I('get.order')])->setField('address_id', json_encode($adr));
				}else{
					$str = 'VisitorAddress/addressList';
					$arr = ['companyName' => $_GET['companyName']];
				}
				$this->redirect($str, $arr);
			}
			$this->error($this->obj->getError());exit;
		}
		$info = $this->obj->info();
		// dump($info);exit;
		$this->assign('info',$info);
		$this->display();
	}

	public function addressAdd()
	{
		if (IS_POST) {
			// dump(I('post.'));exit;
			$res = $this->obj->insert();
			if($res){
				if(I('get.order')){
					$str = 'OrderForm/orderDetail';
					$arr = ['companyName' => $_GET['companyName'], 'id' => I('get.order')];
					$adr = $this->obj->field('consignee,phone,address_str')
						->where(['visitor_id' => $this->userInfo['id'], 'id' => $res])
						->find();
					M('OrderForm')->where(['id' => I('get.order')])->setField('address_id', json_encode($adr));
				}else{
					$str = 'VisitorAddress/addressList';
					$arr = ['companyName' => $_GET['companyName']];
				}
				$this->redirect($str, $arr);
			}
			$this->error($this->obj->getError());exit;
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