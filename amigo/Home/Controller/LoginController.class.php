<?php 
namespace Home\Controller;

use Think\Controller;

/**
* 
*/
class LoginController extends Controller
{
    protected $redis;

    protected $userIp;

    protected $visitorId;

    public function __construct()
    {
        parent::__construct();

        $redis = new \Redis();

        $redis->connect('127.0.0.1',6379); 

        $this->redis = $redis;

        $this->userIp = get_client_ip();

        $this->visitorId = $_SESSION['visitorInfo']['id'];
    }

    // 登录
    public function visitorLogin()
    {
        if (!$this->visitorId) 
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
        $visitorObj = new \Home\Model\LoginModel();
        if (IS_POST) 
        {
            $result = $visitorObj->defaultLogin();
            if ($result) 
            {
                $this->success('登录成功','/'.MODULE_NAME.'/VisitorInfo/myCenter');exit;
            }else{
                $this->error($visitorObj->getError());exit;
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
     * @param string $state  传参标志,方便做分支判断
     */
    public function wechatLoginToWebsiteWithBaseMethod($snsapi = 'snsapi_base',$state = 'default', $redirectUrl='')
    {
        $appId = C('APP_ID');

        if ($redirectUrl) {
            $redirectUrl = 'http://'.C('WECHAT_HOST_LINK').'/'.MODULE_NAME.'/Login/'. $redirectUrl .'.html';
        }else{
            $redirectUrl = 'http://'.C('WECHAT_HOST_LINK').'/'.MODULE_NAME.'/Login/showWechatInfo.html';
        }
        $redirectUri = urlencode($redirectUrl);

        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=". $appId ."&redirect_uri=". $redirectUri ."&response_type=code&scope=". $snsapi ."&state=". $state ."#wechat_redirect";

        header('location:'.$url);
    }

    // 获取微信信息
    public function showWechatInfo()
    {
        $code = I('get.code');
        $state = I('get.state');
        $visitorObj = new \Home\Model\LoginModel();

        // state为openid将其存入数据库
        if ($state == 'saveOpenId') 
        {
            $res = $visitorObj->getVisitorInfo('userinfo', $code);
            // 授权登录完成跳转到个人中心首页
            $this->redirect(MODULE_NAME.'/VisitorInfo/myCenter');
        }
        // 初始判断openid
        $res = $visitorObj->getVisitorInfo('', $code);

        // 不存在进入分支
        if ($state == 'saveLoginType') 
        {
            $_SESSION['loginType'] = 1;
            $this->redirect($_SESSION['temporary']);exit;
        }else if(!$res){
            // 传参让用户授权获取openid
            $this->wechatLoginToWebsiteWithBaseMethod('snsapi_userinfo', 'saveOpenId');exit;
        }else{
            $this->redirect(MODULE_NAME.'/VisitorInfo/myCenter');exit;
        }
    }

    public function showWechatInfoByCompanyLink()
    {
        $code = I('get.code');

        $state = I('get.state');

        $stateList = explode('_', $state);
        
        $visitorObj = new \Home\Model\LoginModel();

        if ($state == 'saveOpenId') 
        {
            $res = $visitorObj->getVisitorInfo('userinfo', $code);
            // 授权登录完成跳转到个人中心首页
            header('location:'.$_SESSION['temporary'].'/visitorId/'.$_SESSION['visitorInfo']['id']);
            
            exit;
        }

        $status = $stateList[0];

        $res = $visitorObj->getVisitorInfo('', $code);

        $_SESSION['temporary'] = $stateList[1];

        if(!$res){
            $this->wechatLoginToWebsiteWithBaseMethod('snsapi_userinfo', 'saveOpenId', 'showWechatInfoByCompanyLink');exit;
        }else{
            $code = mt_rand();// 获取随机登录码

            $idCode = sha1((string)$code);// sha1加密登录码

            $this->redis->setex($idCode,5,$_SESSION['visitorInfo']['id']);

            header('location:'.$_SESSION['temporary'].'?code='.$idCode);exit;
        }
    }

    public function setPassWord()
    {
        $visitorObj = new \Home\Model\LoginModel();
        $visitorId = $_SESSION['visitorInfo']['id'];
        $setPassWordKey = $this->redis->get('setPassWordKey_cardwebsie_by_'.$visitorId);
        if (IS_POST && $setPassWordKey == 1) 
        {   

            $result = $visitorObj->setPassWord();
            if ($result) 
            {
                $this->redis->delete('setPassWordKey_cardwebsie_by_'.$visitorId);
                $this->success('密码设置成功','/'.MODULE_NAME.'/VisitorInfo/myCenter',2);exit;
            }else{
                $this->error($visitorObj->getError());exit;
            }
        }else{
            if ($setPassWordKey == 1) 
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
        $visitorObj = new \Home\Model\LoginModel();
        if (I('get.')) 
        {
            $result = $visitorObj->verifyCodeToMatch('default');
            if ($result) 
            {
                $this->success('验证成功','setPassWord',2);exit;
            }else{
                $this->error($visitorObj->getError());exit;
            }
        }else{
            $this->display();
        }
    }

    public function ajaxControl()
    {
        $visitorObj = new \Home\Model\LoginModel();
        $result = $visitorObj->ajaxControl();
        $this->ajaxReturn($result);
    }
}