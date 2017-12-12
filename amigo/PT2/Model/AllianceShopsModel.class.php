<?php 
namespace PT2\Model;

use Think\Model;
use Think\Exception;

class AllianceShopsModel extends CommonModel
{
	protected $autoCheckFields = false;

	public function ajaxControl($flag)
	{
		return $this->$flag();
	}

	public function regionList()
	{
		$where = array(
			array('relevance_id' => $this->pInfo['id']),
			array('status'       => 0),
			array('parent_id'    => 0)
		);

		$regionList = M('Region')->field('id, region_name')->where($where)->select();

		return $regionList;
	}

	public function businessList()
	{
		$where = array(
			array('relevance_id' => $this->pInfo['id']),
			array('status'       => 0),
		);

		$businessList = M('business')->field('id, business_name')->where($where)->select();

		return $businessList;

	}

	protected function selNextRegionInfo()
	{
		$region = M('Region');
		if (I('get.region_id')) 
		{
			$where['parent_id'] = I('get.region_id');
			$where['status']    = 0;
			$result['region'] = $region->field('id, region_name')->where($where)->select();
		}

		if (!$result['region']) 
		{
			unset($result['region']);
 			if (I('get.region_id')) 
			{
				$find['region_id'] = I('get.region_id');
				$find['status'] = 0;
				$result['business'] = M('Business')->field('id, business_name')->where($find)->select();
			}
			
			if (!$result['business']) 
			{
				unset($result['business']);
			}

			$result['companyList'] = $this->get_company_list();
		}
			return $result;
	}

	public function get_company_list()
	{

		$where = [
			'relevance_id' 	=> $this->pInfo['id'],
			'status'		=> 0,
			'end_time'		=> ['gt', time()]
		];

		// 如经纬度存在
		if (I('get.x_point') && I('get.y_point')) {
			// x=113.321258,y=23.107025 ,经典居
			// 横纬竖经
			$res = $this->get_nearby_company_list($where);
			if ($res['status'] == 'true') {
				return $res;
			}
			return $res;
		}
		
		if (I('get.region_id') || I('get.business_id')) 
		{
			if (I('get.region_id')) 
			{
				$where['region_id'] = I('get.region_id');
			}
			
			if (I('get.business_id')) 
			{
				$where['business_id'] = I('get.business_id');
			}
		}

		$count = M('Company')->where($where)->count();
		$page = new \Think\Page($count, 6);
		if ($count) {
			/*if ($flag) 
			{
				$where['company_type'] = 1;
				$list = M('Company')
						->field('id, company_name, region_id, address_info, web_postfix, x_coordinate, y_coordinate')
						->where($where)
						->limit(4)
						->order('control_time desc')
						->limit($page->firstRow.','.$page->listRows)
						->select();
			}else{*/
			$list = M('Company')
					->field('id, company_name, region_id, address_info, web_postfix, x_coordinate, y_coordinate')
					->where($where)
					->order('control_time desc')
					->limit($page->firstRow.','.$page->listRows)
					->select();
			// }

			foreach ($list as $v) 
			{
				if (I('get.x_point') && I('get.y_point')) {
					$v['distance'] = return_two_point_distance(I('get.x_point'), I('get.y_point'), $v['x_coordinate'], $v['y_coordinate']);
				}
				$data  = M('CompanyPicture')->field('company_bgpic,company_logo')->where(['company_id' => $v['id']])->find();
				$c_list[] = array_merge($v, $data);
			}
			return ['status' => 'true',  'err_code' => 0, 'data' => $c_list];
			
		}else{
			return ['status' => 'false',  'err_code' => 4, 'err_msg' => '暂无商家进驻'];
		}
	}

	public function get_nearby_company_list($where)
	{
		// 1. 进行5公里范围内检索商铺
		$point_arr = return_square_point(I('get.y_point'), I('get.x_point'), 5);

		$where['y_coordinate'] = [['lt', $point_arr['left-top']['lng']],['gt',$point_arr['right-top']['lng']]];
		$where['x_coordinate'] = [['gt', $point_arr['left-bottom']['lat']],['lt',$point_arr['left-top']['lat']]];
		$count = M('Company')->where($where)->count();
		try {
			if (!$count) {
				// 2. 不存在检索范围内店铺则进行本区->市->省进行范围递增检索
				unset($where['y_coordinate']);
				unset($where['x_coordinate']);
				$info = $this->getAddressComponent(C('BAIDU_API_KEY'), I('get.y_point'), I('get.x_point'));
				if ($info['status'] == 0) {
					$district_id = M('District')// 获得区的id
									->where(['name' => $info['result']['addressComponent']['district']])
									->getField('district_id');
					$where['district'] = $district_id;
					$count = M('Company')->where($where)->count();
					if (!$count) {
						unset($where['district']);
						$city_id = M('District')// 获得市的id
								->where(['name' => $info['result']['addressComponent']['city']])
								->getField('district_id');
						$where['city'] = $city_id;
						$count = M('Company')->where($where)->count();
						if (!$count) {
							unset($where['city']);
							$province_id = M('District')// 获取省的id
										->where(['name' => $info['result']['addressComponent']['province']])
										->getField('district_id');
							$where['province'] = $province_id;
							$count = M('Company')->where($where)->count();
							if (!$count) {
								throw new Exception("本省未有商户进驻", 2);
							}
						}
					}

				}else{
					throw new Exception("定位获取数据失败", 1);
				}
			}
			
			$page  = new \Think\Page($count, 6);
			$list  = M('Company')
					->field('id, company_name, region_id, address_info, web_postfix, x_coordinate, y_coordinate')
					->where($where)
					->limit($page->firstRow.','.$page->listRows)
					->select();

			foreach ($list as $v) {
				$v['distance'] = return_two_point_distance(I('get.y_point'), I('get.x_point'), $v['y_coordinate'], $v['x_coordinate']);
				$v['distance'] = round($v['distance'], 2);
				$data  = M('CompanyPicture')->field('company_bgpic,company_logo')->where(['company_id' => $v['id']])->find();
				$c_list[] = array_merge($v, $data);
			}

			$res = bubble_sort_down($c_list, 'distance');
			
			return ['status' => 'true',  'err_code' => 0, 'data' => $res];
		} catch (Exception $e) {
			return ['status' => 'false', 'err_code' => $e->getCode(), 'err_msg' => $e->getMessage()];
		}
	}
}