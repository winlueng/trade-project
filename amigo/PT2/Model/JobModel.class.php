<?php 
namespace PT2\Model;

use Think\Model;

class JobModel extends CommonModel
{
	public function job_list()
	{
		$field = 'id, job_name,job_title,addtime';

		$list = $this->field($field)->where([
				'company_id' 	=> '0',
				'relevance_id'	=> $this->pInfo['id'],
				'status'		=> ['neq','-1']
			])->order('addtime desc')
			->select();
		return $list;
	}

	public function job_info()
	{
		$info = $this->where([
				'company_id' 	=> '0',
				'relevance_id'	=> $this->pInfo['id'],
				'status'		=> ['neq','-1'],
				'id'			=> I('get.id')
			])->find();
		$this->saveStatis('JobStatistics', I('get.id'));
		$info['job_info'] = htmlReturn($info['job_info']);
		return $info;
	}

}