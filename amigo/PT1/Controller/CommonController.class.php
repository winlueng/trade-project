<?php 
namespace PT1\Controller;

use Think\Controller;

class CommonController extends Controller
{
	private $redis;

	public function __construct()
	{
		parent::__construct();

		$redis = new \Redis();

		$redis->connect('127.0.0.1', 6379);

		$this->redis = $redis;
		
		$this->checkProjectExist();

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

		$statis = new \PT1\Model\StatisModel();

		$statis->saveStatis();
	}

	private function checkProjectExist()
	{
		session('projectInfo', null);
		$url = sha1($_SERVER['HTTP_HOST']);
		$projectInfo = $this->redis->get('B_url_'.$url);
		$projectInfo = json_decode($projectInfo, true);
		if (!$projectInfo) {
			$projectInfo = M('Project')->field('id,template_id,category_id')->where(['project_link' => $_SERVER['HTTP_HOST'],'status' => 0])->select()[0];
			$projectInfo['template_path'] = M('Template_change')->where(['id' => $projectInfo['template_id']])->getField('template_path');
			$info = M('write_info')->field('phone,email,principal,market_name,project_logo,app_id,app_secret')->where(['relevance_id' => $projectInfo['id']])->select()[0];
			$projectInfo['phone'] = $info['phone'];
			$projectInfo['email'] = $info['email'];
			$projectInfo['principal'] = $info['principal'];
			$projectInfo['market_name'] = $info['market_name'];
			$projectInfo['project_logo'] = $info['project_logo'];
			$projectInfo['app_id'] = $info['app_id'];
			$projectInfo['app_secret'] = $info['app_secret'];
			$save = json_encode($projectInfo);
			$this->redis->setex('B_url_'.$url, 3600, $save);
		}
		$_SESSION['projectInfo'] = $projectInfo;
	}
}