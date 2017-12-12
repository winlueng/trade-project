<?php 
namespace Admin\Model;

use Think\Model;

/**
* 前台用户model类
*/
class StaffModel extends CommonModel
{
	private $visitorObj;

	protected $updateFields = ['store_nickname','professional_title','speciality','style','introduce','job_id'];

	protected $_validate = [
		['store_nickname', 'require', '请输入店铺花名！', 0, 'regex', 2],
		['professional_title', 'require', '请输入职称！', 0, 'regex', 2],
		['speciality', 'require', '请输入特长！', 0, 'regex', 2],
		['style', 'require', '请输入擅长风格！', 0, 'regex', 2],
		['introduce', 'require', '请输入员工简介！', 0, 'regex', 2],
	];

	public function __construct()
	{
		parent::__construct();
		$this->visitorObj = M('VisitorInfo');
		$this->_auto = [
			['style', 'json_encode', 3, 'function'],
			['update_time', 'time', 3, 'function'],
		];
	}

	public function insert($id)
	{
		$data = [
			'create_time' 	=> time(),
			'visitor_id'	=> $id,
			'company_id'	=> $this->userInfo['company_id'],
			'store_nickname'=> I('get.nick_name'),
		];

		if($this->where(['visitor_id'=>$id])->find()) {
			return $this->where(['visitor_id'=>$id])->setField('status', '0');
		}

		$res = $this->add($data);

		if($res) return true;

		return false;
	}

	public function staffList()
	{
		$where = [
			'company_id' => $this->userInfo['company_id'],
			'status'	 => ['neq', '-1']
		];
		if (I('get.name')) $where['store_nickname'] = ['like','%'.I('get.name').'%'];

		if (I('get.job_id')) $where['job_id'] = I('get.job_id');

		$count = $this->where($where)->count();

		$page = new \Think\Page($count, 10);

		$list = $this->where($where)
				->order('create_time desc')
				->limit($page->firstRow.','.$page->listRows)
				->select();

		foreach ($list as $v) {
			$v['sex'] = M('VisitorInfo')->where(['visitor_id' => $v['visitor_id']])->getField('sex');
			$v['subscribe_total'] = M('SubscribeOrderForm')->where(['company_id' => $this->userInfo['company_id'], 'staff_id' => $v['id'], 'status' => ['in','3,4']])->count();
			$v['phone'] 	= M('WechatVisitor')->where(['id' => $v['visitor_id']])->getField('phone');
			$v['job_name'] 	= M('UserJob')->where(['id' => $v['job_id']])->getField('job_name');
			$vlist[] = $v;
		}
		$result['list'] = $vlist;
		$result['page'] = $page->show();
		return $result;
	}

	public function staffInfo($id)
	{
		if(I('get.id')) $id = I('get.id');

		$info = $this->where(['id'=>$id,'company_id' => $this->userInfo['company_id']])->find();
		$info['introduce'] = htmlReturn($info['introduce']);
		$info['staff_image'] = json_decode($info['staff_image'], true);
		return $info;
	}

	/**
	 * ajax的操作
	 * @param  string $flag 传递过来的get参数
	 */
	public function ajaxControl($flag)
	{
		return $this->$flag();
	}

	public function update()
	{
		if ($data = $this->create()) 
		{
			$where = ['id' => I('get.id'), 'company_id' => $this->userInfo['company_id']];
			if($_FILES['staff_logo']['size'] != 0 )
			{
				$path = fileUpload('/Uploads/goodsClassify/', 'staff_logo');

				if (isset($path['error_msg'])) {
					$this->error = $path['error_msg'];return false;
				}
				$oldPath =  $this->where($where)->getField('staff_logo');

				unlink('./Public'.$oldPath);

				$data['staff_logo'] = thumbImage($path);

			}
				unset($_FILES['staff_logo']);

			if ($_FILES['staff_image']['size'][0] != 0) {

				$path = fileUpload('/Uploads/goodsClassify/', '' ,'more');

				if (isset($path['error_msg'])) {
					$this->error = $path['error_msg'];return false;
				}
				$oldPath =  $this->where($where)->getField('staff_image');

				unlink('./Public'.$oldPath);
				foreach ($path as $v) {
					$arr[] = thumbImage($v);
				}
				$data['staff_image'] = json_encode($arr);
			}
			// return $data;
			$data['style']  = I('post.style');
			$res = $this->where($where)->save($data);

			if ($res) return $res;

			$this->error = '完善员工资料失败';return false;
		}
		return false;
	}

	public function changeStatus()
	{
		return $this->where(['id' => I('get.id')])->setField('status', I('get.status'));
	}

	public function delJob()
	{
		return M('UserJob')->where(['id' => I('get.id'),'company_id' => $this->userInfo['company_id']])->delete();
	}

	public function del()
	{
		return $this->where(['id' => I('get.id'),'company_id' => $this->userInfo['company_id']])->setField('status', I('get.status'));
	}

	
}

 ?>