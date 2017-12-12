<?php 
namespace Home\Controller;

use Think\Controller;

/**
 * 商户控制器
 */
class MerchantController extends CommonController
{
	public function merchant()
	{
		if (IS_GET) 
		{
			$merchant = new \Home\Model\MerchantModel();
			$list = $merchant->selMerchant();
			if ($list) 
			{
		    	$posterList = $merchant->selPoster(I('get.id'),1);
		    	$this->assign('poster',$posterList);
		    	$this->assign('name',$list['mname']);
				$this->assign('league',$list['league']['list']);
				$this->assign('wechat',$list['league']['wechat']);
				$this->assign('common',$list['common']);
				// 如果没提交任何数据,就显示页面
				$this->display();exit();
			}else{
				$this->error('商户不存在');exit;
			}
		}else{
			$this->error('错误操作');
		}

	}

	public function ajaxControl()
	{
		$merchant = new \Home\Model\MerchantModel();
		$result = $merchant->ajaxControl();
		$this->ajaxReturn($result);
	}
}

 ?>