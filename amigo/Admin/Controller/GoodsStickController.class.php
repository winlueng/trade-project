<?php
namespace Admin\Controller;

use Think\Controller;

class GoodsStickController extends CommonController 
{
    private $obj;

    public function __construct()
    {
        parent::__construct();
        $this->obj = D('GoodsStick');
    }

    public function auditList()
    {
        $result = $this->obj->stickList();
        $this->assign('list', $result['list']);
        $this->assign('page', $result['page']);
        $this->display();
    }

    // 审核记录
    public function historyList()
    {
        $result = $this->obj->historyList();
        // dump($result);exit;
        $this->assign('list', $result['list']);
        $this->assign('page', $result['page']);
        $this->display();
    }

    // 商盟产品
    public function coalitionGoods()
    {
        $result = $this->obj->stickList('<>-1');
        // dump($result);exit;
        $this->assign('list', $result['list']);
        $this->assign('page', $result['page']);
        $this->display();
    }

    public function ajaxControl()
    {
        if (IS_AJAX) {
            $this->ajaxReturn($this->obj->ajaxControl(I('get.flag')));
        }
    }
}