<?php 
namespace PT1\Controller;

use Think\Controller;

class ActivityController extends CommonController
{

	public function showActivityList()
	{
		$activity = new \PT1\Model\ActivityModel('Activity');
		$oldList = $activity->showOldActivityList();
		$nowList = $activity->showNowActivityList();
		// dump($nowList);exit;
		$this->assign('nowList', $nowList);
		$this->assign('oldList', $oldList);
		$this->display();
	}

	public function activityDetail()
	{
		$where['relevance_id'] = $_SESSION['projectInfo']['id'];
		$where['category_id'] = $_SESSION['projectInfo']['category_id'];
		$where['id'] = I('get.id');
		$info = M('Activity')->field('activity_name, start_time, end_time, activity_details')->where($where)->select()[0];
		$info['activity_details'] = htmlspecialchars_decode(html_entity_decode($info['activity_details']));
		$this->assign('info', $info);
		/*dump($_SESSION);
		dump($info);exit;*/
		$this->display();
	}

	public function ajaxControl()
	{
		if (IS_AJAX) 
		{
			$statis = new \PT1\Model\StatisModel();
			$result = $statis->saveActivityStatistics();
			$this->ajaxReturn($result);
		}
	}
}