<?php 
namespace Admin\Controller;

use Think\Controller;
use Admin\Model\CommonModel;
use Think\Auth;

/**
 * 所有controller的祖类,用于以后有用户登录和权限控制所设定的类
 */
class CommonController extends Controller
{
	private $redis;
	public $userInfo;
	public $userID;
	public $wechat;

	public function __construct()
	{
		parent::__construct();
		$this->redis = new \Redis();
		$this->redis->connect('127.0.0.1', 6379);
		CommonModel::checkHTTP();// 检测http来路请求是否合法
		CommonModel::setUserID();// 记录用户信息
		$this->commonCheckOut();
		// dump($this->wechat);exit;
		/*if (!Auth::check(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME,$this->userID))
		{
			$this->error('无权访问');exit;
		}*/

		$this->redis->setex('B_login_by_'.$this->userID, 1800, 1);
		$arr = ['Admin/OrderForm/orderList', 'Admin/SubscribeOrderForm/orderList', 'Admin/WechatRefund/orderList'];
		// dump($this->userInfo);exit;
		// dump(array_sum($this->getOrderCount()));exit;
		$this->assign('orderConut', $this->getOrderCount());
		$this->assign('showNumberArr', $arr);
		$this->assign('userInfo',$this->userInfo);
		$this->assign('companyID', $this->userInfo['company_id']);

	}

	public function companyStatusCheck()
	{
		$companyId = M('Company')->where(['end_time' => ['lt', time()]])->setField(['status' => 1]);
	}

	// 登录状态检查
	public function commonCheckOut()
	{	
		$loginObj = new \Admin\Controller\LoginController();

		if ($_SESSION['adminInfo']) {
			$loginType = $this->redis->get('B_login_by_'.$this->userInfo['id']);
			if ($_SERVER['HTTP_HOST'] != C('ADMIN_BACKGROUND') && !$loginType) 
			{
				$loginObj->logout();
			}
		}else if($_SESSION['companyInfo']){
			$loginType = $this->redis->get('B_login_by_'.$this->userInfo['id']);
			if ($_SERVER['HTTP_HOST'] != C('COMPANY_BACKGROUND') && !$loginType) 
			{
				$loginObj->logout();
			}
			$config = $this->getCompanyConfig($this->redis);
			$this->wechat = new \Gaoming13\WechatPhpSdk\Api($config);
		}else if($_SESSION['marketInfo']){
			$loginType = $this->redis->get('B_login_by_'.$this->userInfo['id']);
			if ($_SERVER['HTTP_HOST'] != C('PROJECT_BACKGROUND') && !$loginType) 
			{
				$loginObj->logout();
			}
			$config = $this->getCompanyConfig($this->redis);
			$this->wechat = new \Gaoming13\WechatPhpSdk\Api($config);
		}else{
			$this->companyStatusCheck();
			$loginObj->jumpLinkToLogin();
		}
	}

	/**
	 * 初始化公众号基本信息
	 */
	public function getCompanyConfig($redis, $id = '')
	{
		if (!$id) $id = $this->userInfo['relevance_id'];

		$info = M('WriteInfo')->field('app_id, app_secret, mch_id, mch_sectet')
				->where(['relevance_id' => $id])
				->find();

		$config = [
			'appId' 			=> $info['app_id'],
			'appSecret' 		=> $info['app_secret'],
			'mchId'				=> $info['mch_id'],
			'key'				=> $info['mch_sectet'],
			'get_access_token'  => function ($appId) use ($redis){
				return $redis->get('B_AccessToken_'.$appId);
			},
			'save_access_token' => function ($appId, $token) use ($redis){
				return $redis->setex('B_AccessToken_'.$appId, 7150, $token);
			} ,
			'get_jsapi_ticket'  => function ($appId) use ($redis){
				return $redis->get('B_JsApiTicket_'.$appId);
			},
			'save_jsapi_ticket' => function ($appId, $ticket) use ($redis) {
				return $redis->setex('B_JsApiTicket_'.$appId, 7150, $ticket);
			},
		];
		return $config;
	}

	public function getOrderCount()
	{
		
    	$count[0] = (int)M('OrderForm')->where([
		    		'status' => 2, 'is_send_out' => 0, 
		    		'company_id' => $this->userInfo['company_id'],
		    		'relevance_id' => $this->userInfo['relevance_id'],
		    		'is_control' => 0
	    		])->count();
    	$count[1] = (int)M('SubscribeOrderForm')->where(['status' => 0, 'company_id' => $this->userInfo['company_id'], 'is_control' => 0])->count();
    	$count[2] = (int)M('WechatRefund')->where([
	    		'status' => 0, 
	    		'company_id' => 0, 
	    		'is_control' => 0,
	    		'relevance_id' => $this->userInfo['relevance_id'],
    		])->count();
    	$count[3] = (int)M('WechatRefund')->where([
	    		'status' => 0, 
	    		'company_id' => ['neq','0'], 
	    		'is_control' => 0,
	    		'relevance_id' => $this->userInfo['relevance_id'],
    		])->count();
    	$count[4] = (int)M('WechatRefund')->where([
	    		'status' => 0, 
	    		'company_id' => $this->userInfo['company_id'], 
	    		'is_control' => 0,
	    		'relevance_id' => $this->userInfo['relevance_id'],
    		])->count();
        return $count;
	}
}
 



 ?>