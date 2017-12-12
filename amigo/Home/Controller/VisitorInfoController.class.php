<?php 
namespace Home\Controller;

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
        if ($this->visitorId) {
            $this->visitorObj = new \Home\Model\VisitorInfoModel();
        }
    }

    // 个人中心首页
    public function myCenter()
    {
        if ($this->visitorObj) {
            $this->visitorObj->myCenter();
        }
        $this->display();
    }
   
    // 收藏店铺列表
    public function toSaveCompanyList()
    {
        if ($this->visitorObj) {
            $result = $this->visitorObj->showSaveCompanyList();
            // dump($result);
            $this->assign('collectList', $result);
        }
        $this->display();
    }

    // 用户足迹
    public function visitorTrack()
    {
        if ($this->visitorObj) {
        $result = $this->visitorObj->getVisitorTrackData();
            // dump($result);exit;
            $this->assign('track', $result);
        }
        $this->display();
    }

    public function ajaxControl()
    {
        if ($this->visitorObj) {
            $result = $this->visitorObj->ajaxControl();
            $this->ajaxReturn($result);
        }
    }

    // 推荐列表
    public function showRecommendList()
    {
        if ($this->visitorObj) {
            $result = $this->visitorObj->showRecommendGoodsList();
            // dump($result);exit;
            $this->assign('recommendGoodsList', $result);
        }
        $this->display();
    }

    // 猜你喜欢
    public function selYouLike()
    {
        if ($this->visitorObj) {
            $result = $this->visitorObj->selYouLike();
            // dump($result);exit;
            $this->assign('youLikeList', $result);
        }
        $this->display();
    }

    // 精选活动
    public function splendidNews()
    {
        if ($this->visitorObj) {
            $result  = $this->visitorObj->splendidNews();
            // dump($result);exit;
            $this->assign('newsList', $result);
        }
        $this->display();
    }

}

?>