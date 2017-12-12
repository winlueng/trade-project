<?php 
namespace Home\Controller;

use Think\Controller;

class DiscountController extends CommonController
{

	/**
	 * 每周优惠
	 */
	public function discount()
	{
		$discount = new \Home\Model\DiscountModel;
		$list = $discount->showWeekCard();
		$poster = new \Home\Model\IndexModel();
    	$posterList = $poster->selPoster(2);

    	$this->assign('poster',$posterList);
		$this->assign('list',$list);
		$this->display();
	}


}


 ?>