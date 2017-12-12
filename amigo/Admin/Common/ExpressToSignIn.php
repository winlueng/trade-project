<?php 
	date_default_timezone_set('PRC');//设置北京时间

	include('config.php');//加载配置文件和函数库

	include('MySql.class.php');//记载自己封装的model类

	$order_obj = new Mysql('order_form');
	// 还没签收的系统自动签收
	$where = [
				'is_send_out' 	=> 2, 
				'gt' 			=> ['update_time' => (time() - 86400*7)],
				'status'		=> 2,
			];
	$res = $order_obj->where($where)->update(['status' => 4]);
	echo date('Y-m-d', time());
	echo '\n';
	var_dump($res);
	$where = [
				'status' 		=> 4, 
				'gt' 			=> ['update_time' => (time() - 86400*14)],
			];
	// 还没评价的系统帮他评价
	$res = $order_obj->where($where)->update(['goods_score' => 5, 'express_score' => 5, 'server_attitude' => 5]);
	echo '\n';
	var_dump($res);
	