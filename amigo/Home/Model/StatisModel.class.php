<?php
namespace Home\Model;

use Think\Model\AdvModel;

class StatisModel extends AdvModel
{ 
	protected $autoCheckFields = false;

	public function saveStatis()
	{
		if (!$_SESSION['visitor']) 
		{
			$statistics = M('statistics');
			$data['web_host'] = $_SERVER['HTTP_HOST'];
			$data['date'] = strtotime('today');
			$find = $statistics->where($data)->find();
			$_SESSION['visitor'] = getIPaddress();
			if (!$find) 
			{
				$statistics->data($data)->add();
			}else{
				$statistics->where($data)->setInc("visit_total",1,300);
			}
		}
	}

}