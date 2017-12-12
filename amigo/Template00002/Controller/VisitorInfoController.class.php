<?php 
namespace Template00002\Controller;

use Think\Controller;

/**
 * 个人中心控制器
 */
class VisitorInfoController extends CommonController
{
    private $visitorObj;

    public function __construct()
    {
        parent::__construct();
        if ($this->userInfo) {
            $this->visitorObj = new \Template00002\Model\VisitorInfoModel();
        }
        
        $this->assign('info', $this->userInfo);
    }

    // 个人中心首页
    public function myCenter()
    {
        $info = M('VisitorCollect')->field('goods_collect,staff_collect')->where(['visitor_id' => $this->userInfo['id']])->find();
        $goodsCollect = json_decode($info['goods_collect']);
        $staffCollect = json_decode($info['staff_collect']);
        if ($goodsCollect) {
            $goodsCollect = M('Goods')->where(['id' => ['in', implode(',', $goodsCollect)], 'status' => ['not in', '-1, 3']])->count();
        }else{
            $goodsCollect = 0;
        }

        if ($staffCollect) {
            $staffCollect = M('Staff')->where(['id' => ['in', implode(',', $staffCollect)], 'status' => ['not in', '-1, 1']])->count();
        }else{
            $staffCollect = 0;
        }
        $data['goodsCollectTotal'] = (int)$goodsCollect + (int)$staffCollect;
        $data['subscribeTotal'] = M('SubscribeOrderForm')->where(['visitor_id' => $this->userInfo['id'],'status' => ['in','0,1,2,3']])->count();
        $data['cartTotal'] = M('ShoppingCart')->where(['visitor_id' => $this->userInfo['id']])->count();
        /**
         * 订单状态提示
         */
        for ($i=1; $i < 7; $i++) { 
            $count[$i] = D('OrderForm')->orderList($i);
        }
        // dump($count);exit;
        $this->assign('data', $data);
        $this->assign('count', $count);
        $this->display();
    }
   
    // 收藏店铺列表
    public function toSaveCompanyList()
    {
        $result = $this->visitorObj->showSaveCompanyList();
        // dump($result);exit;
        $this->assign('collectList', $result);
        $this->display();
    }

    /**
     * 我的收藏(收藏商品和员工)
     */
    public function myCollect()
    {
    	$list = $this->visitorObj->myCollect();
    	// dump($list);exit;
    	$this->assign('list', $list);
    	$this->display();
    }

    // 用户足迹
    public function visitorTrack()
    {
        $result = $this->visitorObj->getVisitorTrackData();
        // dump($result);exit;
        $this->assign('track', $result);
        $this->display();
    }

    public function ajaxControl()
    {
        $result = $this->visitorObj->ajaxControl();
        $this->ajaxReturn($result);
    }

    // 推荐列表
    public function showRecommendList()
    {
        $result = $this->visitorObj->showRecommendGoodsList();
        $this->assign('recommendGoodsList', $result);
        $this->display();
    }

    // 猜你喜欢
    public function selYouLike()
    {
        $result = $this->visitorObj->selYouLike();
        // dump($result);exit;
        $this->assign('youLikeList', $result);
        $this->display();
    }

    // 精选动态
    public function splendidNews()
    {
        $result  = $this->visitorObj->splendidNews();
        $this->assign('newsList', $result);
        $this->display();
    }

}

?>