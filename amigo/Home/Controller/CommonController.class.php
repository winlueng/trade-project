<?php 
namespace Home\Controller;

use Think\Controller;

/**
 * 所有controller的祖类,用于以后有用户登录和权限控制所设定的类
 */
class CommonController extends Controller
{
	private $pInfo; // 大门户数据

	protected $redis;
	public function __construct()
	{
		parent::__construct();

		$loginObj = new \Admin\Controller\LoginController();

		$loginObj->jumpLinkToLogin();

		$this->redis = new \Redis();

		$this->redis->connect('127.0.0.1', 6379);

		$url = $_SERVER['HTTP_HOST'];

		session('projectInfo',null);
		session('companyInfo', null);

		$this->pInfo = M('Project')->field('id,template_id,category_id')
					->where(['project_link' => $url,'status' => 0])
					->find();

		if (!$this->pInfo) 
		{
			E('商户异常');exit;
		}

		if(!I('get.companyUserName'))
		{
			$this->findProjectInfoToHost();
		}

		/*// 卡券速递网站统计
		$statis = new \Home\Model\StatisModel();

		$statis->saveStatis();*/
	}

	public function findProjectInfoToHost()
	{
		$projectInfo = M('WriteInfo')->field('phone,email,principal,market_name,project_logo,app_id,app_secret')
					->where(['relevance_id' => $this->pInfo['id']])
					->find();
		$_SESSION['projectInfo']  =  array_merge($this->pInfo ,$projectInfo);
		$_SESSION['projectInfo']['template_path'] = M('TemplateChange')->where(['id' => $this->pInfo['template_id']])->getField('template_path');

		// dump($_SESSION['projectInfo']['template_path'].'/Index/index');exit;
		$this->redirect('/'.$_SESSION['projectInfo']['template_path'].'/Index/index');
	}

	public function jumpToCompanyHost($jumpToLink='',$companyId='')
	{
		$companyUserName = I('get.companyUserName');

		$postfix = substr($companyUserName,strripos($companyUserName,'.'));

		if ($postfix != '.php' && $postfix != '.html') 
		{
			$host = $_SERVER['HTTP_HOST'];

			$where = array(
					'web_postfix' => $companyUserName,
					'relevance_id' => $this->pInfo['id'],
					'status' => 0
				);

			$company = M('Company');

			$companyStatus = $company->where($where)->getField('status');
			if ($companyStatus) 
			{
				$_SESSION = null;
				$this->error('对不起,商户未开通.请您先前往官网浏览','http://'.$_SERVER['HTTP_HOST'],1);exit;
			}
			// $this->redis->delete('companyInfo_By_relevanceId_'.$this->pInfo['id'].'_and_webpostfix_'.$companyUserName);
			$companyInfo = $this->redis->get('companyInfo_By_relevanceId_'.$this->pInfo['id'].'_and_webpostfix_'.$companyUserName);

			if (!$companyInfo) {

				$companyInfo = $company->field('id, company_name, phone, email, template_id, web_postfix')->where($where)->select()[0];

				$companyInfo['template_path'] = M('Template_change')->where(['id' => $companyInfo['template_id']])->getField('template_path');

				$companyInfo['company_logo']  = M('CompanyPicture')->where(['company_id' => $companyInfo['id']])->getField('company_logo');

				$companyInfo = json_encode($companyInfo);

				$this->redis->set('companyInfo_By_relevanceId_'.$this->pInfo['id'].'_and_webpostfix_'.$companyUserName, $companyInfo, 3600);
			}

			$companyInfo = json_decode($companyInfo, true);

			$_SESSION['companyInfo'] = $companyInfo;
			
			if ($jumpToLink) {
				$this->redirect($companyInfo['template_path'].$jumpToLink);exit;
			}else{
				$this->redirect($companyInfo['template_path'].'/Index/index', ['companyName' => $companyUserName]);exit;
			}

		}else{
			$this->error('对不起,不了解你在找什么','http://'.$_SERVER['HTTP_HOST'], 1);exit;
		}
	}
}




 ?>