<?php 
namespace Template00002\Controller;

use Think\Controller;
// use \Template00002\Controller\CommonController;

class LoginController extends Controller
{
    public $loginObj;

    public function __construct()
    {
        parent::__construct();

        $this->loginObj = new \Template00002\Model\LoginModel();
    }

   /* protected $userIp;

    protected $visitorId;

    protected $redis;

    public $wechat;

    private $loginObj;

    public function __construct()
    {
        parent::__construct();

        $this->redis = new \Redis();

        $this->redis->connect('127.0.0.1',6379);

        $config = CommonController::getProjectConfig($this->redis);
        
        $this->wechat = new \Gaoming13\WechatPhpSdk\Api($config);

        $this->loginObj = new \Template00002\Model\LoginModel();

        $this->userIp = get_client_ip();

        $this->visitorId = $_SESSION['visitorInfo']['id'];
    }*/
    
	// 登录
	public function visitorLogin()
	{
        if (!$this->loginObj->userInfo) 
        {
            $host = isWeixin();
            // 判断是否微信客户端
            if ($host) 
            {
                $this->wechatLoginToWebsiteWithBaseMethod();
            }else{
                $this->redirect('Login/defaultLogin');exit;
            }
        }else{
            $this->error('非法访问', '/Index/index');exit;
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
        }else{
            if (isWeixin()) 
            {
                $this->redirect(MODULE_NAME.'/VisitorInfo/myCenter');exit;
            }else{
                $this->display();
            }
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
        $this->redirect(MODULE_NAME.'/VisitorInfo/myCenter',  ['companyName' => I('get.companyName')]);exit;
    }

    public function setPassWord()
    {
        if (IS_POST && $_SESSION['setPassWordKey'] == 1) 
        {   
            $result = $this->loginObj->setPassWord();
            if ($result) 
            {
                $this->success('密码设置成功','/'.MODULE_NAME.'/VisitorInfo/myCenter',2);exit;
            }else{
                $this->error($this->loginObj->getError());exit;
            }
        }else{
            if ($_SESSION['setPassWordKey'] == 1) 
            {
                $this->display();
            }else{
                $this->error('您已经设置过密码,如想重置密码请前往忘记密码进行重置');exit;
            }
        }
    }

    // 普通用户注册->短信验证
    public function visitorSignIn()
    {
        if (I('get.')) 
        {
            $result = $this->loginObj->verifyCodeToMatch('default');
            if ($result) 
            {
                $_SESSION['setPassWordKey'] = 1;//可以设置密码的凭证
                $this->success('验证成功','setPassWord',2);exit;
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