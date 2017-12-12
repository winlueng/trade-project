<?php
namespace Home\Model;

use Think\Model;

class CooperationModel extends Model
{

	protected $autoCheckFields = false;

	public function selMerchant()
	{
		$id = I('get.region_id');
		$merchant = M('Company');
		$business = M('Business');
		$group = M('auth_group_access');
		$companyId = $group->where(['group_id'=>['in','11,12']])->getField('uid',true);
		$canShowCompanyId = implode(',', $companyId);
		$res['business'] = $business->field('id,business_name')->where(['status'=>0,'region_id'=>$id])->select();
		$res['company'] = $merchant->field('uid,company_pic')->where(['status'=>0,'start_time'=>['lt',time()],'end_time'=>['gt',time()],'region_id'=>$id,'business_id'=>$res['business'][0]['id'], 'uid' => ['in', $canShowCompanyId]])->select();
		return $res;
	}
}