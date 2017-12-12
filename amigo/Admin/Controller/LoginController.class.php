<?php
namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller 
{
    public function __construct()
    {
        parent::__construct();
        
    }
    
    public function jumpLinkToLogin()
    {
        switch ($_SERVER['HTTP_HOST']) 
        {
            case C('ADMIN_BACKGROUND'):
                $this->redirect('Admin/Login/login');
                break;
            case C('PROJECT_BACKGROUND'):
                $this->redirect('Admin/Login/projectLogin');
                break;
            case C('COMPANY_BACKGROUND'):
                $this->redirect('Admin/Login/companyLogin');
                break;
        }
    }

    private function checkComming()
    {
        $arr = [C('ADMIN_BACKGROUND'),C('PROJECT_BACKGROUND'),C('COMPANY_BACKGROUND')];
        if(!in_array($_SERVER['HTTP_HOST'], $arr)) E('非法访问');
    }

	/**
     * 显示登录页面和登录操作
     */
    public function login()
    {
        if (IS_POST) {
            // 登录密码
            
            $model = new \Admin\Model\LoginModel();
			
            $result = $model->login(); 
            if ($result) 
            {
				$this->success('登录成功', U($result['index'], $result['module']), 2);exit;
            }else{
			    $this->error($model->getError());exit;
            }
        } else {
            if ($_SERVER['HTTP_HOST'] != C('ADMIN_BACKGROUND')) 
            {
                $this->jumpLinkToLogin();
            }elseif($_SESSION['adminInfo']){
                $this->redirect('Admin/Index/adminIndex');
            }
            $this->checkComming();
            $this->display();
        }
    }

    /**
     * 退出操作，清除session个
     */
    public function logout()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);
        if ($_SESSION['adminInfo']) {
            $redis->delete('B_login_by_'.$_SESSION['adminInfo']['id']);
        }elseif($_SESSION['companyInfo']){
            $redis->delete('B_login_by_'.$_SESSION['companyInfo']['id']);
        }elseif($_SESSION['marketInfo']){
            $redis->delete('B_login_by_'.$_SESSION['marketInfo']['id']);
        }
        session('adminInfo', null);
		session('companyInfo', null);
        session('marketInfo', null);
        $this->jumpLinkToLogin();
    }

    // 项目登录页面
    public function projectLogin()
    {
        if (IS_POST) {
            // 登录密码
            
            $model = new \Admin\Model\LoginModel();
            
            $result = $model->login(); 
            if ($result) 
            {
                $this->success('登录成功', U($result['index'], $result['module']), 2);exit;
            }else{
                $this->error($model->getError());exit;
            }
        } else {
            if ($_SERVER['HTTP_HOST'] != C('PROJECT_BACKGROUND')) 
            {
                $this->jumpLinkToLogin();
            }elseif($_SESSION['marketInfo']){
                $this->redirect('Admin/Index/projectIndex',['module', '1']);
            }
            $this->checkComming();
            $this->display();
        }
    }

    // 商户登录页面
    public function companyLogin()
    {
        if (IS_POST) {
            // 登录密码
            
            $model = new \Admin\Model\LoginModel();
            
            $result = $model->login(); 
            if ($result) 
            {
                $this->success('登录成功', U($result['index'], $result['module']), 2);exit;
            }else{
                $this->error($model->getError());exit;
            }
        } else {
            if ($_SERVER['HTTP_HOST'] != C('COMPANY_BACKGROUND')) 
            {
                $this->jumpLinkToLogin();
            }elseif($_SESSION['companyInfo']){
                $this->redirect('Admin/Index/companyIndex');
            }
            $this->checkComming();
            $this->display();
        }
    }

    public function forgetPassword()
    {
        if (IS_POST) {
            $res = D('Login')->passwordReset();
            if ($res) {
                $this->success('重置成功', $_SESSION['httpReferer']);
                unset($_SESSION['httpReferer']);exit;
            }
            $this->error(D('Login')->getError());exit;
        }else{
            $_SESSION['httpReferer'] = $_SERVER['HTTP_REFERER'];
            $this->display();exit;
        }
    }

    public function ajaxControl()
    {
        $this->ajaxReturn(D('Login')->ajaxControl(I('get.flag')));
    }
}