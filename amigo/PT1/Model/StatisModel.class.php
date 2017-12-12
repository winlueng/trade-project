<?php
namespace PT1\Model;

use Think\Model\AdvModel;

class StatisModel extends AdvModel
{ 
	protected $autoCheckFields = false;

	private $redis;

	private $ip;

	public function __construct()
	{
		parent::__construct();
		$this->ip    = get_client_ip();
		$this->redis = new \Redis();
		$this->redis->connect('127.0.0.1', 6379);
	}

	public function saveStatis()
	{
		if (!S($_SESSION['projectInfo']['id'].'statis_website_by_'.$this->ip)) {
			$date = strtotime('today');

			$prefix = 'B_statis_host_visit_'.$date; // 统计前缀redis hash操作

			$name = $_SESSION['projectInfo']['id'].'_visit';

			if ($this->redis->hExists($prefix, $name)) 
			{
				$result = $this->redis->hIncrBy($prefix, $name, 1);
			}else{
				$result = $this->redis->hSet($prefix, $name, 1);
			}
			S($_SESSION['projectInfo']['id'].'statis_website_by_'.$this->ip, 1, 86400);// 记录浏览量
		}
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