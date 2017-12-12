<?php 
namespace Admin\Controller;

use Think\Controller;

/**
* 前台用户类
*/
class StaffController extends CommonController
{
	private $obj;
	public function __construct()
	{
		parent::__construct();
		$this->obj = D('Staff');
	}

	public function staffList()
	{
		$list = $this->obj->staffList();
		// dump($this->insertJob());exit;
		$this->assign('jobList', $this->insertJob());
		$this->assign('list', $list['list']);
		$this->assign('page', $list['page']);
		$this->display();
	}

	public function staffUpdate()
	{
		if (IS_POST) {
			$res = $this->obj->update();
			if($res){
				$this->success('修改成功');exit;
			}
			$this->error($this->obj->getError());exit;
		}

		E('非法访问');
	}

	// 添加职位类型
	public function insertJob()
	{
		if (IS_POST) {
			$data['job_name'] 	 = I('post.job_name');
			$data['create_time'] = time();
			$data['company_id']  = $this->userInfo['company_id'];
			$res = M('UserJob')->add($data);
			if ($res) {
				$this->success('添加成功');exit;
			}
			$this->error('添加失败');exit;
		}else{
			return M('UserJob')->where(['company_id' => $this->userInfo['company_id']])
					->order('create_time desc')
					->select();
		}
	}

	public function changeJob()
	{
		if (IS_POST) {
			$data['job_id'] = I('post.job_id');
			$res = $this->obj->where(['id' => I('get.id'), 'company_id' => $this->userInfo['company_id']])->save($data);
			if ($res) {
				$this->success('操作成功');exit;
			}
			$this->error('操作失败');exit;
		}
		E('非法访问');
	}

	// 修改职位类型
	public function updateJob()
	{
		if (IS_POST) {
			$data['job_name'] = I('post.job_name');

			$data['update_time'] = time();

			$res = M('UserJob')->where(['id' => I('get.id')])->save($data);

			if ($res) {
				$this->success('添加成功');exit;
			}
			$this->error('添加失败');exit;
		}
	}

	public function ajaxControl()
	{
		if(!IS_AJAX) E('非法访问');

		$this->ajaxReturn($this->obj->ajaxControl(I('get.flag'))) ;
	}
}

 ?>