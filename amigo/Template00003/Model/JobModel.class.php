<?php 
namespace Template00002\Model;

use Think\Model;

class JobModel extends CommonModel
{
	public function showJobList()
	{
		$result = $this->field('id, job_name, job_title')
				->where(['company_id' => $this->companyInfo['id'], 'status' => ['neq', '1']])
				->order('addtime desc')
				->select();
		return $result;
	}

	public function selJobInfo()
	{
		$id = I('get.id');
		$result = $this->field('job_name, addtime, job_info')
				->where(['id' => $id,'company_id' => $this->companyInfo['id'], 'status' => ['neq', '1']])
				->find();
		$result['job_info'] = htmlspecialchars_decode(html_entity_decode($result['job_info']));
		$result['addtime'] = date('Y-m-d H:i:s', $result['addtime']);
		$this->saveStatis('JobStatistics', $id);
		return $result;
	}



}