<?php 
namespace Template00002\Controller;

use Think\Controller;
use \Template00002\Model\CommonModel;
// use \PT2\Controller\CommonController;

class CommonController extends Controller
{
	protected $userInfo;

	protected $redis;

	protected $companyInfo;

	protected $pInfo;

	public $wechat;

	// protected $imStaff;

	public function __construct()
	{
		parent::__construct();

		$this->redis = new \Redis();

		$this->redis->connect('127.0.0.1',6379);

		$this->checkProjectExist();
		$result = $this->checkCompanyExist();

		if (!$result) {
			$this->error('商户不存在或已撤场,请前往官网浏览其他优惠','http://'.$_SERVER['HTTP_HOST']);exit;
		}
		
		$loginObj = new \Template00002\Controller\LoginController();

		$this->userInfo = session('visitorInfo');

		// dump($this->userInfo);exit;
		
		if (!$this->userInfo['id'] && isWeixin()) {
			$loginObj->visitorLogin();
		}

		$url = $_SERVER['HTTP_HOST'];

		if ($this->userInfo['id']) {
			$setPassWordKey = $this->redis->get('B_setPassWordKey_cardwebsie_by_'.$this->userInfo['id']);
			if ($setPassWordKey == 1) {
				$this->success('正赶往部署属于你的密码', '/Home/Login/setPassWord');exit;
			}
		}

		if (S('signInPhone'.$_SESSION['visitor'])) // 一小时内验证手机了没设置密码的用户前往布置密码
		{
			$setPassWordKey = $this->redis->get('B_setPassWordKey_cardwebsie_by_'.$this->userInfo['id']);
			if ($setPassWordKey == 1) {
				$this->success('正赶往部署属于你的密码', '/Home/Login/setPassWord');exit;
			}
		}

		CommonModel::saveStatis('CompanyStatistics', $this->companyInfo['id']);
		$jssdk = $this->wechat->jssdkConfig();
		/*$this->imStaff = M('Staff')->where(['visitor_id' => $this->userInfo['id'], 'status' => 0])->getField('id');
        $this->assign('staff', $this->imStaff);*/
		$newsCount = M('SystemNews')->where(['obj_id' => $this->userInfo['id'], 'obj_type' => 1, 'status'=>['neq','-1'], 'is_read'=>0])->count();
		$this->assign('newsCount',$newsCount);
		$this->assign('companyInfo', $this->companyInfo);
		$this->assign('jssdk', $jssdk);
	}

	// 复查项目是否存在或过期
	public function checkProjectExist()
	{
		session('projectInfo', null);

		$url = sha1($_SERVER['HTTP_HOST']);
		$this->redis->delete('B_url_'.$url);
		// dump($this->redis->get('B_url_'.$url));exit;
		$this->pInfo = $this->redis->get('B_url_'.$url);

		$this->pInfo = json_decode($this->pInfo, true);

		if (!$this->pInfo) {

			$this->pInfo = M('Project')->field('id,template_id,category_id')
						->where(['project_link' => $_SERVER['HTTP_HOST'],'status' => 0])
						->find();
						
			$this->pInfo['template_path'] = M('TemplateChange')->where(['id' => $this->pInfo['template_id']])->getField('template_path');

			$info = M('WriteInfo')->field('market_name, principal, phone, project_logo, email, address_id, address_info, abstruct, app_id, app_secret, mch_id, mch_sectet')->where(['relevance_id' => $this->pInfo['id']])->find();

			$this->pInfo = array_merge($this->pInfo, $info);

			$save = json_encode($this->pInfo);

			$this->redis->setex('B_url_'.$url, 3600, $save);

		}
		$config = $this->getProjectConfig($this->redis, $this->pInfo);

		$this->wechat = new \Gaoming13\WechatPhpSdk\Api($config);

		$_SESSION['projectInfo'] = $this->pInfo;
	}

	/**
	 * 查询商户是否存在
	 */
	public function checkCompanyExist()
	{
		if (I('get.companyName')) {

			$host = $_SERVER['HTTP_HOST'];

			$relevanceId = M('Project')->where(['project_link' => $host])->getField('id');

			$where = array(
					'web_postfix' => I('get.companyName'),
					'status' => 0,
					'relevance_id' => $relevanceId,
				);

			$status = M('Company')->where($where)->getField('id');// 判断商户是否存在

			if (!$status) {
				return false;
			}

			// 提取redis缓存资料
			// $this->redis->delete('B_companyInfo_By_webpostfix_'.I('get.companyName')); // 清除缓存
			$this->companyInfo = $this->redis->get('B_companyInfo_By_webpostfix_'.I('get.companyName'));

			if (!$this->companyInfo) {
				$field = [
					'id',
					"company_name",
					"principal",
					"category_id",
					"relevance_id",
					"region_id",
					"address_info",
					"business_id",
					"phone",
					"template_id",
					'web_postfix',
					'app_id',
					// 'sx_data_base',
				];
				$this->companyInfo = M('Company')->field($field)->where(['id' => $status])->find();
				// return $this->companyInfo;
				$this->companyInfo['template_path'] = M('Template_change')->where(['id' => $this->companyInfo['template_id']])->getField('template_path');

				$this->companyInfo['company_logo'] = M('Company_picture')->where(['company_id' => $this->companyInfo['id']])->getField('company_logo');

				$this->companyInfo = json_encode($this->companyInfo);

				$this->redis->setex('B_companyInfo_By_webpostfix_'.I('get.companyName'), 3600, $this->companyInfo);
			}
			$this->companyInfo = json_decode($this->companyInfo, true);

			/*$config = $this->getCompanyConfig($this->redis);

			$this->wechat = new \Gaoming13\WechatPhpSdk\Api($config);*/

			session('companyInfo',$this->companyInfo);

			return $this->companyInfo;
		}
	}

	// 查询是否收藏
	protected function selIsSave()
	{
		if ($this->userInfo['id']) 
		{
			$list = M('VisitorCollect')->where(['visitor_id' => $this->userInfo['id']])->getField('company_collect');

			$companyId = $_SESSION['companyLinkId'];
			// return in_array($companyId, explode(',', $list));
			if (explode(',', $list) < 2) 
			{
				if ($companyId == $list) 
				{
					C('COMPANY_IS_SAVE', 1);
				}
			}else{
				C('COMPANY_IS_SAVE', in_array($companyId, explode(',', $list)));
			}
		}
	}

	/**
	 * 初始化公众号基本信息
	 */
	public function getProjectConfig($redis, $info)
	{
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
			'get_api_ticket'  => function ($appId) use ($redis){
				return $redis->get('B_ApiTicket_'.$appId);
			},
			'save_api_ticket' => function ($appId, $ticket) use ($redis) {
				return $redis->setex('B_ApiTicket_'.$appId, 7150, $ticket);
			},
		];
		return $config;
	}

	public function wechatTemplateReturn($number)
	{ 
		// $this->redis->delete('NewsTemplate_'. $number);
		$templateID = $this->redis->get('NewsTemplate_'. $number);

		if (!$templateID) {
			$templateID = $this->wechat->get_template_id($number);
			$this->redis->set('NewsTemplate_'. $number, $templateID->template_id);
			$templateID = $templateID->template_id;
		}
		return $templateID;
	}

	public function getArtwork()
	{
		if (IS_AJAX) {
			$this->ajaxReturn(getArtwork(I('get.url')));
		}
	}
}