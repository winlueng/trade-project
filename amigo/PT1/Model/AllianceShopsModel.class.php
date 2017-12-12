<?php 
namespace PT1\Model;

use Think\Model;

class AllianceShopsModel extends Model
{
	protected $autoCheckFields = false;

	public function ajaxControl()
	{
		$flag = I('get.flag');
		switch ($flag) 
		{
			case 'selNextRegionInfo':
				$result = $this->selNextRegionInfo();
				break;
		}

		return $result;
	}

	public function regionList()
	{
		$where = array(
			array('relevance_id' => $_SESSION['projectInfo']['id']),
			array('category_id'  => $_SESSION['projectInfo']['category_id']),
			array('status'       => 0),
			array('parent_id'    => 0)
		);

		$regionList = M('Region')->field('id, region_name')->where($where)->select();

		return $regionList;
	}

	public function businessList()
	{
		$where = array(
			array('relevance_id' => $_SESSION['projectInfo']['id']),
			array('category_id'  => $_SESSION['projectInfo']['category_id']),
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
			$index = new \PT1\Model\IndexModel();
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

			$result['companyList'] = $index->showFeatureShop();
		}
			return $result;
	}
}