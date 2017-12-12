<?php
namespace Admin\Controller;

use Think\Controller;

class IndexController extends CommonController 
{
    private $indexObj;

    public function __construct()
    {
        parent::__construct();
        $this->indexObj = new \Admin\Model\IndexModel();
    }

    public function adminIndex()
    {
        $this->display();
    }

    public function companyIndex()
    {
    	$this->display();
    }

    public function projectIndex()
    {
        $this->display();
    }

    public function ajaxControl()
    {
        return $this->ajaxReturn($this->indexObj->ajaxControl(I('get.flag')));
    }
}