<?php
namespace Template00002\Model;

use Think\Model\AdvModel;
use Think\Model;

class StatisModel extends CommonModel
{ 
	protected $autoCheckFields = false;

	public function saveStatis()
	{
		$ip = get_client_ip();
		if ($this->redis->get($this->companyInfo['id'].'_statis_website_by_'.$ip)) {
			return 1;
		}
		$data['web_host'] = $this->companyInfo['id'];
		$data['date'] = strtotime('today');
		$find = M('Statistics')->where($data)->find();
		if (!$find) 
		{
			M('Statistics')->data($data)->add();
		}else{
			M('Statistics')->where($data)->setInc("visit_total",1);
		}
		$this->redis->setex($this->companyInfo['id'].'_statis_website_by_'.$ip, 43200, '1');// 记录浏览量
	}

}