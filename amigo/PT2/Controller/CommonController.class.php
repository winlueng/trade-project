<?php 
namespace PT2\Controller;

use Think\Controller;
use \PT2\Model\CommonModel;

class CommonController extends Controller
{
	protected 	$redis;
	protected 	$pInfo;
	public   	$wechat;
	protected	$v_info;
	protected	$login;

	public function __construct()
	{
		parent::__construct();

		$this->redis = new \Redis();

		$this->redis->connect('127.0.0.1', 6379);

		$this->checkProjectExist();

		$this->v_info = session('visitorInfo');

		$this->login = new \PT2\Controller\LoginController();
		
		$str = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];

		session('temporary_url', $str);

		if (isWeixin() && !$this->v_info) {
			$this->login->visitorLogin();
		}


		// dump($this->pInfo);exit;
		if ($_SESSION['projectInfo']) 
		{
			if ($_SESSION['projectInfo']['template_path'] != MODULE_NAME) 
			{
				$this->redirect($_SESSION['projectInfo']['template_path'].'/Index/index');
			}
		}else{
			$_SESSION = null;
			$this->redirect('http://'.$_SERVER['HTTP_HOST']);
		}

		$this->saveStatis('Statistics', $this->pInfo['id']);
		
		$newsCount = M('SystemNews')->where([
					'obj_id' 	=> $this->v_info['id'], 
					'obj_type' 	=> 1, 
					'status'	=> ['neq','-1'], 
					'is_read'	=> 0
				])->count();
		// dump($this->v_info);exit;
		$jssdk = $this->wechat->jssdkConfig();// 微信jssdk库
		$this->assign('newsCount',$newsCount);// 判断是否有系统消息
		$this->assign('jssdk', $jssdk);
		$this->assign('pInfo', $this->pInfo);// 大平台数据
		$this->assign('userInfo', $this->v_info);
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

			$this->pInfo = M('Project')->field('id,template_id,category_id,sx_data_base')
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

	// 返回公众号信息模版id
	public function wechatTemplateReturn($number)
	{ 
		// $this->redis->delete('NewsTemplate_'. $number);
		$templateID = $this->redis->get('NewsTemplate_'.$this->pInfo.'_'. $number);

		if (!$templateID) {
			$templateID = $this->wechat->get_template_id($number);
			$this->redis->set('NewsTemplate_'. $number, $templateID->template_id);
			$templateID = $templateID->template_id;
		}
		return $templateID;
	}

	/**
	 * 保存统计信息
	 * @return [type] [description]
	 */
	public function saveStatis($table = '', $id = '')
	{
		if (!$table || !$id) return false;
		
		if (!$this->redis->get('B_'.$table.'_'.$id .'_by_'.$this->v_info['id'])) {// 记录统计
			$obj = M($table);

			$where = array(
				'relevance_id' => $id,
				'date'	  => strtotime('today'),
			);
			$find = $obj->where($where)->find();

			if (!$find) 
			{
				$obj->data($where)->add();
			}else{
				$obj->where($where)->setInc("visit_total",1);
			}
			$this->redis->setex('B_'.$table.'_'.$id .'_by_'.$this->v_info['id'], 43200, '1');
		}
	}
}