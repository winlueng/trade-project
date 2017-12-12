<?php 
namespace PT1\Model;

use Think\Model;

class ActivityModel extends Model
{
	protected $autoCheckFields = false;
	
	public function showNowActivityList()
	{
		$where = array(
			array('relevance_id' 	=> $_SESSION['projectInfo']['id'] ),
			array('category_id'  	=> $_SESSION['projectInfo']['category_id'] ),
			array('status'       	=> 0 ),
			array('activity_type'   => array('in', '1,2') ),//联盟活动
			array('start_time'   	=> array('lt',time())),
			array('end_time'     	=> array('gt',time())),
		);

		$list = $this->field('id, activity_name, activity_cover, start_time, end_time')->where($where)->select();
		return $list;
	}

	public function showOldActivityList()
	{
		$where = array(
			array('relevance_id' 	=> $_SESSION['projectInfo']['id'] ),
			array('category_id'  	=> $_SESSION['projectInfo']['category_id'] ),
			array('status'       	=> 0 ),
			array('activity_type'   => array('in', '1,2,3') ),//联盟活动
			array('end_time'     	=> array('lt',time())),
		);

		$list = $this->field('id, activity_name, start_time, end_time, title, activity_cover')->where($where)->select();
		
		return $list;
	}

}