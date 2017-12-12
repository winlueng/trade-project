<?php 
namespace PT2\Controller;

use Think\Controller;

// 预约订单
class GoodsCommentController extends CommonController
{
	private $obj;
	private $visitorInfoObj;
	public function __construct()
	{
		parent::__construct();
		$this->obj = new \PT2\Model\GoodsCommentModel();
		$this->visitorInfoObj = new \PT2\Model\VisitorInfoModel();
	}

	public function commentIns()
	{
		if (IS_AJAX) {
			$res = $this->obj->insert();
			if ($res) {
				$this->success('操作成功', 'GoodsComment/commentResult',2);
			}
			$this->error($this->obj->getError());
		}else{
			$orderInfo = D('OrderForm')->payBeforeGetOrderInfo();
			// dump($orderInfo);exit;
			$this->assign('info', $orderInfo);
			$this->display();
		}
	}

	public function commentResult()
	{
		$selYouLike		= $this->visitorInfoObj->selYouLike();
		$this->assign('sel_you_like', $selYouLike);
		$this->display();
	}
}

?>