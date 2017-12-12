<?php 
namespace Home\Controller;

use Think\Controller;

class CooperationController extends CommonController
{
	// 合作商户
	public function cooperationMerchant()
	{
		if (IS_GET) 
		{
			$cooperation = new \Home\Model\CooperationModel();
			$list = $cooperation->selMerchant();
			$poster = new \Home\Model\IndexModel();
	    	$posterList = $poster->selPoster(I('get.region_id'),2);
	    	$this->assign('poster',$posterList);
			$this->assign('company',$list['company']);
			$this->assign('business',$list['business']);
			$this->display();
		}else{
			$this->error('非法操作');
		}
	}

	/**
	 * 合作加盟
	 */
	public function cooperationJion()
	{
		$poster = new \Home\Model\IndexModel();
    	$list = $poster->selPoster(6);
    	$this->assign('list',$list);
		$this->display();
	}
	//类型属性(0=>广告位置投放,1=>商户位置投放,2=>商圈位置投放,3=>行业位置投放,4=>商户卡券速递,5=>商户微官网位置)
	public function ajaxControl()
	{
		if ($_GET['flag'] == 1) 
		{
			$merchant = M('Company');
			$poster = new \Home\Model\IndexModel();
			$group = D('auth_group_access');
			$companyId = $group->where(['group_id'=>['in','11,12']])->getField('uid',true);
			$canShowCompanyId = implode(',', $companyId);
			$res['company'] = $merchant->field('uid,company_pic')->where(['start_time'=>['lt',time()],'end_time'=>['gt',time()],'uid' => ['in', $canShowCompanyId],'business_id'=>I('get.businessid')])->select();
			foreach($res['company'] as $k => $v)
			{
				$status = M('User')->where(['id' => $v['uid']])->getField('status');
				if ($status) 
				{
					unset($res['company'][$k]);
				}
			}
			$res['poster'] = $poster->selPoster(I('get.businessid'),3);
			$this->ajaxReturn($res);
		}
	}

}
