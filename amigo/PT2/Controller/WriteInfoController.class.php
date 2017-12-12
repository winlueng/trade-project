<?php 
namespace PT2\Controller;

use Think\Controller;

class WriteInfoController extends CommonController
{
	public function about_us()
	{
		$info = M('WriteInfo')->field('principal,abstruct,phone,email,address_info')
				->where(['relevance_id' => $this->pInfo['id']])
				->find();
				
		$info['abstruct'] = htmlReturn($info['abstruct']);
		$this->assign('info', $info);
		$this->display();
	}
}