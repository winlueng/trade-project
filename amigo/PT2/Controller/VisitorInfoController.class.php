<?php 
namespace PT2\Controller;

use Think\Controller;

class VisitorInfoController extends CommonController
{
	private $obj;

	public function __construct()
	{
		parent::__construct();
		$this->obj = new \PT2\Model\VisitorInfoModel();
		if (!isWeixin() && !$this->v_info) {
			$this->redirect(MODULE_NAME.'/Login/defaultLogin');exit;
		}
	}

	public function myCenter()
	{
		$info = M('VisitorCollect')
				->field('goods_collect,company_collect')
				->where(['visitor_id' => $this->v_info['id']])
				->find();

        $goodsCollect = json_decode($info['goods_collect']);
        $companyCollect = json_decode($info['company_collect']);

        if ($goodsCollect) {
            $goodsCollect = M('Goods')->where([
		            	'id' => ['in', implode(',', $goodsCollect)], 
		            	'status' => ['not in', '-1, 3']
	            	])->count();
        }else{
            $goodsCollect = 0;
        }

        if ($companyCollect) {
            $companyCollect = M('Company')->where([
			            	'id' => ['in', implode(',', $companyCollect)], 
			            	'status' => ['not in', '-1, 1']
		            	])->count();
        }else{
            $companyCollect = 0;
        }
        $data['goodsCollect'] 	= (int)$goodsCollect;
        $data['companyCollect'] = (int)$companyCollect;
        $data['cartTotal'] = M('ShoppingCart')
					        ->join('__GOODS__ ON __GOODS__.status not in("-1","3") AND __SHOPPING_CART__.visitor_id='.$this->v_info['id'].' AND __GOODS__.id=__SHOPPING_CART__.goods_id')
					        ->count();
        /**
         * 订单状态提示
         */
        for ($i=1; $i < 7; $i++) { 
            $count[$i] = D('OrderForm')->orderList($i);
        }
        // dump($count);exit;
        $this->assign('data', $data);
        $this->assign('orderCount', $count);
		$this->display();
	}

	public function myCenterUpdate()
	{
		$this->display();
	}

	// 猜你喜欢
    public function selYouLike()
    {
        $result = $this->obj->selYouLike();
        // dump($result);exit;
        $this->assign('list', $result);
        $this->display();
    }

	public function ajaxControl()
	{
		if (IS_AJAX) {
			$this->ajaxReturn($this->obj->ajaxControl(I('get.flag')));
		}
	}
}

 ?>