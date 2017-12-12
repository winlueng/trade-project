<?php 
	date_default_timezone_set('PRC');//设置北京时间

	include('config.php');//加载配置文件和函数库

	include('MySql.class.php');//记载自己封装的model类

	$date = strtotime('yesterday');

	$activityObj = new Mysql('activity_statistics');

	$list = $redis->hGetAll('B_statis_activity_visit_'.$date);

	$data['date'] = $date;
	$res = [];
	foreach ($list as $k => $v) {
		// $data = [];
		$data['activity_id'] = explode('_', $k)[0];
		$data['click_total'] = $v;
		$res[] = $activityObj->insert($data);
	}
	var_dump($redis->hGetAll('B_statis_activity_visit_'.$date));
	echo '<br />';
	echo date('Y-m-d H:i:s', time());
	
	$redis->delete('B_statis_activity_visit_'.$date);

	var_dump($res);
 ?>