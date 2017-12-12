<?php
namespace PT2\Model;

use Think\Model\AdvModel;
use Think\Model\Model;

class StatisModel extends CommonModel
{ 
	protected $autoCheckFields = false;

	public function __construct()
	{
		parent::__construct();
	}

	public function saveStatis()
	{
		if ($this->redis->get($this->companyInfo['id'].'_statis_website_by_'.$this->ip)) return 1;

		$data['web_host'] = $this->companyInfo['id'];

		$data['date'] = strtotime('today');

		$find = M('Statistics')->where($data)->find();

		if (!$find) 
		{
			M('Statistics')->data($data)->add();
		}else{
			M('Statistics')->where($data)->setInc("visit_total",1);
		}
		$this->redis->setex($this->companyInfo['id'].'_statis_website_by_'.$this->ip, 43200, '1');// 记录浏览量
	}

	public function saveActivityStatistics()
	{
		$activityId = I('get.activity_id');
		if (!S('activity_statis_'. $activityId .'_by_'.$this->ip)) {// 记录统计

			$date = strtotime('today');

			$prefix = 'B_statis_activity_visit_'.$date; // 统计前缀redis hash操作

			$name = $activityId.'_visit';
			
			if ($this->redis->hExists($prefix, $name)) 
			{
				$result = $this->redis->hIncrBy($prefix, $name, 1);
			}else{
				$result = $this->redis->hSet($prefix, $name, 1);
			}
			S('activity_statis_'. $activityId .'_by_'.$this->ip, '1', 86400);
			return $result;
		}
		return 'no_save';
	}

}