<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController 
{
    public function index()
    {
    	$poster = new \Home\Model\IndexModel();

    	$list = $poster->selPoster(1);
        $second = $poster->selPoster(8);
        $this->assign('list',$list);
    	$this->assign('second',$second);
        $this->display();
    }

    public function ajaxControl()
    {
    	$plus = I('get.plus');
    	if ($plus) 
    	{
    		M('Statistics')->where(['id'=>1])->setInc('num');
    	}
    }
}