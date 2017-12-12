<?php 
namespace Template00003\Controller;

use Think\Controller;
// use \Template00002\Controller\CommonController;

class LoginController extends Controller
{
    private $loginObj;
    private $obj;

    public function __construct()
    {
        parent::__construct();

        $this->loginObj = new \Template00002\Model\LoginModel();
        $this->obj      = new \Template00002\Model\WechatVisitorModel;
    }
    
	// 登录
	public function visitorLogin()
	{
        if (!$this->loginObj->userInfo) 
        {
            // 判断是否微信客户端
            if (isWeixin()) 
            {
                $this->wechatLoginToWebsiteWithBaseMethod();
            }else{
                $this->redirect(MODULE_NAME.'/Login/defaultLogin');exit;
            }
        }else{
            $this->redirect(MODULE_NAME.'/Index/index');exit;
        }
	}

	// 浏览器普通登录
    public function defaultLogin()
    {
        if (IS_POST) 
        {
            $result = $this->loginObj->defaultLogin();
            if ($result) 
            {
                $this->success('登录成功','/'.MODULE_NAME.'/VisitorInfo/myCenter');exit;
            }else{
                $this->error($this->loginObj->getError());exit;
            }
        }else if(strlen($this->loginObj->userInfo['phone']) < 11) {
            $this->display();
        }else{
            $this->redirect(MODULE_NAME.'/Index/index');exit;
        }
    }

    /**
     * 调用微信登录接口
     * @param string $snsapi 授权方式(snsapi_base或snsapi_userinfo)
     */
	public function wechatLoginToWebsiteWithBaseMethod($snsapi = 'snsapi_base')
	{
        $redirect_uri  = 'http://'.$_SERVER['HTTP_HOST'].'/'.MODULE_NAME.'/Login/showInfo?companyName='.I('get.companyName');

        $url = $this->loginObj->wechat->get_authorize_url($snsapi, $redirect_uri, $snsapi);

		header('location:'.$url);exit;
	}

    public function showInfo()
    {
        $res = $this->loginObj->wechat->get_userinfo_by_authorize(I('get.state'));
        if (I('get.state') == 'snsapi_base') {
            $info = $this->loginObj->getUserInfo($res->openid);
            if (!$info) {
                $this->wechatLoginToWebsiteWithBaseMethod('snsapi_userinfo');
            }
        }else if(I('get.state') == 'snsapi_userinfo'){
            $info = $this->loginObj->visitorAdd($res);
            if (!$info) {
                /*dump($res);exit;*/$this->error($this->loginObj->getError());exit;
            }
        }
        $_SESSION['visitorInfo'] = $info;
        // $this->redirect(MODULE_NAME.'/VisitorInfo/myCenter',  ['companyName' => I('get.companyName')]);exit;
        header('location:'.session('temporary_url'));exit;
    }

    public function setPassWord()
    {
        $pass_key = $this->loginObj->redis->get($this->loginObj->ip.'_pass_key');
        if (IS_POST && $pass_key) 
        {   
            $result = $this->obj->visitor_add();
            if ($result) 
            {
                if (isWeixin()) {
                    $this->success('密码设置成功','/'.MODULE_NAME.'/VisitorInfo/myCenter',2);exit;
                }else{
                    $this->success('密码设置成功','/'.MODULE_NAME.'/Login/defaultLogin',2);exit;
                }
            }else{
                $this->error($this->loginObj->getError());exit;
            }
        }else{
            if ($pass_key) 
            {
                $this->display();
            }else{
                $this->error('密码令匙未生成!');exit;
            }
        }
    }

    // 普通用户注册->短信验证
    public function visitorSignIn()
    {
        if (IS_POST) 
        {
            $result = $this->loginObj->verifyCodeToMatch('default');
            if ($result) 
            {
                $this->success('验证成功','setPassWord',1);exit;
            }else{
                $this->error($this->loginObj->getError());exit;
            }
        }else{
            if ($this->loginObj->userInfo['phone'] && isWeixin()) {
                $this->redirect(MODULE_NAME.'/VisitorInfo/visitorInfoUpdate');exit;
            }else{
                $this->display();
            }
        }
    }

    public function forgetPassword()
    {
        if (IS_POST) 
        {
            $result = $this->loginObj->verifyCodeToMatch('default');
            if ($result) 
            {
                $this->success('验证成功','setPassWord',1);exit;
            }else{
                $this->error($this->loginObj->getError());exit;
            }
        }else{
            $this->display();
        }
    }

    public function ajaxControl()
    {
    	if (IS_AJAX) {
            $result = $this->loginObj->ajaxControl();
            $this->ajaxReturn($result);
        }
    }
}