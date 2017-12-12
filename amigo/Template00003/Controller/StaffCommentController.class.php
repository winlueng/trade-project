<?php 
namespace Template00003\Controller;

use Think\Controller;

// 预约订单
class StaffCommentController extends CommonController
{
	private $obj;
	public function __construct()
	{
		parent::__construct();
		$this->obj = new \Template00002\Model\StaffCommentModel();
	}

	public function commentIns()
	{
		if (IS_POST) {
			/*dump(I('post.'));
			dump($_FILES);exit;*/
			$res = $this->obj->insert();
			if ($res) {
				$this->success('评论成功!', U('SubscribeOrderForm/SubscribeOrderInfo', ['companyName' => I('get.companyName'), 'id' => I('get.id')]));exit;
			}
			$this->error($this->obj->getError());exit;
		}else{
			$orderInfo = D('SubscribeOrderForm')->orderInfo();
			// dump($orderInfo);exit;
			$this->assign('info', $orderInfo);
			$this->display();
		}
	}
}

?>