<?php
namespace Admin\Model;

use Think\Model;
use Admin\Controller\CommonController;

class CommonModel extends Model
{
	public $userInfo;
	public $userID;
	public $wechat;
	public $redis;

	public function __construct()
	{
		parent::__construct();
		$this->redis = new \Redis();
		$this->redis->connect('127.0.0.1', 6379);
		$this->setUserID();
		$this->checkHTTP();
		$config = CommonController::getCompanyConfig($this->redis, $this->userInfo['relevance_id']);
		$this->wechat = new \Gaoming13\WechatPhpSdk\Api($config);
	}

	public function setUserID()
	{
		if ($_SESSION['adminInfo']) {
			$this->userInfo = $_SESSION['adminInfo'];
		}else if($_SESSION['companyInfo']){
			$this->userInfo = $_SESSION['companyInfo'];
		}else if($_SESSION['marketInfo']){
			$this->userInfo = $_SESSION['marketInfo'];
		}
		$this->userID = $this->userInfo['id'];
	}

	/**
	 * 验证http提交合法性
	 */
	public function checkHTTP()
	{
		$http = explode('/', $_SERVER['HTTP_REFERER'])[2];
		$arr = [C('ADMIN_BACKGROUND'), C('PROJECT_BACKGROUND'), C('COMPANY_BACKGROUND')];
		if (!$http || !in_array($http,$arr)) {
			$this->error = '非法提交数据';return false;
		}
	}

	/**
	 * 获取商户域名和后缀
	 */
	public function getHostUrl()
	{
		$pInfo 	= M('Project')->field('project_link, template_id')->where(['id' => $this->userInfo['relevance_id']])->find();
		$res[0] = 'http://'.$pInfo['project_link'];
		$info = M('Company')->field('template_id, web_postfix')->where(['id' => $this->userInfo['company_id']])->find();
		$res[1] = $info['web_postfix'];
		if ($this->userInfo['company_id'] == 0) {
			$res['tem'] = M('TemplateChange')->where(['id' => $pInfo['template_id']])->getField('template_path');
		}else{
			$res['tem'] = M('TemplateChange')->where(['id' => $info['template_id']])->getField('template_path');
		}
		return $res;
	}

	/**
	 * 微信消息模版ID获取和储存
	 * @param  string $number 模版编码
	 * @return string         模版ID
	 */
	public function wechatTemplateReturn($number)
	{ 
		// $this->redis->delete('NewsTemplate_'. $number);
		$templateID = $this->redis->get('NewsTemplate_'.$this->pInfo['id'].'_'. $number);

		if (!$templateID) {
			$templateID = $this->wechat->get_template_id($number);
			$this->redis->set('NewsTemplate_'.$this->pInfo['id'].'_'. $number, $templateID->template_id);
			$templateID = $templateID->template_id;
		}
		return $templateID;
	}

}


 ?>