<?php 
namespace Admin\Model;

use Think\Model;

class JobModel extends CommonModel
{	
	protected $_validate = array(
		array('job_name', 'require', '职位名不能为空！', 1, 'regex', 3),
		array('job_info', 'require', '职位详情不能为空！', 1, 'regex', 3),
		array('job_title', 'require', '职位标题不能为空！', 1, 'regex', 3),
		array('payment', 'require', '薪酬不能为空！', 1, 'regex', 3),
	);

	protected $_auto = array(
			array('addtime', 'time', 3, 'function'),
		);

	public function __construct()
	{
		parent::__construct();
		$this->_auto = [
			['addtime', 'time', 3, 'function'],
			['company_id', ($this->userInfo['company_id']?$this->userInfo['company_id']:0),3],
			['relevance_id', $this->userInfo['relevance_id'],3],
		];
	}

	// 查询公司简介
	public function selJobList()
	{
		$where = [
			'company_id' => $this->userInfo['company_id'],
			'relevance_id' => $this->userInfo['relevance_id'],
			'status' => ['neq','-1']
		];
		$count = $this->where($where)->count();
		$page  = new \Think\Page($count, 8);
		$res   = $this->where($where)
						->limit($page->firstRow.','.$page->listRows)
						->order('addtime desc')
						->select();
		foreach ($res as $v) {
			$v['visitTotal'] = M('JobStatistics')->where(['relevance_id' => $v['id']])->sum('visit_total');
			$newsList['list'][] = $v;
		}
		$newsList['page'] = $page->show();
		return $newsList;
	}

	// 保存招聘信息
	public function saveJobInfo()
	{	
		if ($data = $this->create()) 
		{
			$where = [
				'id'	 => I('get.id'),
				'status' => ['neq','-1']
			];
			$result = M('Job')->where($where)->save($data);
			if (!$result) 
			{
				$this->error = '更新信息与当前一致';return false;
			}
			return $result;
		}else{
			return false;
		}
	}

	public function ajaxControl()
	{
		$flag = I('get.flag');
		switch ($flag) {
			case 'jobDel':
				$result = $this->jobDel();
				break;
			case 'selJobInfo':
				$result = $this->selJobInfo();
				break;
			case 'changeJobStatus':
				$result = $this->changeJobStatus();
				break;
		}
		return $result;
	}

	public function jobAdd()
	{
		if ($data = $this->create()) 
		{
			$result = $this->add($data);
			if (!$result) 
			{
				$this->error = '添加失败';return false;
			}
			return $result;
		}
		return false;
	}

	public function jobDel()
	{
		return $this->where(['id' => I('get.id')])->save(['status' => '-1']);
	}

	public function selJobInfo()
	{
		$result = $this->field('id,job_name,job_title,job_info,payment')->where(['id' => I('get.id')])->find();
		$result['job_info'] = htmlspecialchars_decode(html_entity_decode($result['job_info']));
		return $result;
	}

	public function changeJobStatus()
	{
		$where = [
			'company_id' 	=> $this->userInfo['company_id'],
			'relevance_id' 	=> $this->userInfo['relevance_id'],
			'id'		 	=> I('get.id')
		];

		return $this->where($where)->save(['status' => I('get.status')]);
	}
}