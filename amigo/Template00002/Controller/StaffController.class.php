<?php 
namespace Template00002\Controller;

use Think\Controller;

// 预约订单
class StaffController extends CommonController
{
	private $obj;
	public function __construct()
	{
		parent::__construct();
		$this->obj = new \Template00002\Model\StaffModel();
		if ($this->imStaff) {
			E('对不起,您是发型师,不能访问预约服务!');
		}
	}

	public function staffList()
	{
		$jobList = M('UserJob')->where(['company_id' => $this->companyInfo['id']])->order('create_time desc')->select();
		$list = $this->obj->staffList($jobList[0]['id']);
		// dump($jobList);dump($list);exit;
		$this->assign('jobList', $jobList);
		$this->assign('list', $list);
		$this->display();
	}

	public function staffInfo()
	{
		$info = $this->obj->staffInfo();
		// dump($info);exit;
		$this->assign('info',$info);
		$this->display();
	}

	public function ajaxControl()
	{
		if(!IS_AJAX) E('非法访问');

		$this->ajaxReturn($this->obj->ajaxControl(I('get.flag')));
	}
}

?>