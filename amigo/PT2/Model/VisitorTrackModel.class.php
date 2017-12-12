<?php 
namespace PT2\Model;

use Think\Model;

class VisitorTrackModel extends CommonModel
{
	public function __construct()
	{
		parent::__construct();
	}

	// 获取用户足迹数据
	public function myTrack()
	{
		// 处理超过一个月的足迹数据
		$this->where(['visit_date' => ['lt', strtotime('last month')]])->delete();
		// 根据用户id获取一个月内的足迹数据
		$track = $this->field('id_aggregate, visit_date')
				->where(['visitor_id' => $this->userInfo['id']])
				->order('visit_date desc')
				->select();

		if ($track) 
		{
			foreach ($track as $v) 
			{
				$v['id_aggregate'] = json_decode($v['id_aggregate'], true);
				foreach ($v['id_aggregate'] as $k => $vo) {
					switch ($vo['type']) {
						case '1':
							$vo['info'] = M('Goods')->field('id, goods_logo, goods_name, price, company_id')
											->where(['id' => $vo['id']])
											->find();
							// $info = M('Company')->field('company_link, company_name, template_id, web_postfix')->where(['id' => $vo['info']['company_id']])->find();
							$vo['link'] = $this->handleGoodsLink($vo['id']);
							/*$vo['company_link'] = U('Index/index', ['companyName' => $info['web_postfix']]);
							$vo['company_name'] = $info['company_name'];*/
							$sales = M('GoodsSalesVolume')->where(['goods_id' => $vo['id']])->sum('sales_total');
							$vo['sales'] = $sales?$sales:0;
							break;
						case '2':
							$vo['info'] = M('Staff')->field('id, store_nickname,professional_title, staff_logo, company_id')
											->where(['id' => $vo['id']])
											->find();
							$info = M('Company')->field('company_link, company_name, template_id, web_postfix')->where(['id' => $vo['info']['company_id']])->find();
							$vo['link'] = $this->handleStaffLink($vo['id']);
							$vo['company_link'] = U('Index/index', ['companyName' => $info['web_postfix']]);
							$vo['company_name'] = $info['company_name'];
							$vo['service_total'] = M('SubscribeOrderForm')->where(['staff_id' => $vo['id'], 'status' => 4])->count();
							break;
					}
					$arr[] = $vo;
				}

				$res['list'] = $arr;
				$res['track_date'] = $v['visit_date'];
				$result[] = $res;
				$arr = [];
			}
			return $result;
		}else{
			return $track;
		}
	}

}

 ?>