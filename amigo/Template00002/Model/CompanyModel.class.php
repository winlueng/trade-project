<?php 
namespace Template00002\Model;

use Think\Model;

class CompanyModel extends CommonModel
{
	public function getCompanyInfo()
	{
		$result = $this->field('news, principal, email, address_info, phone')->where(['id' => $this->companyInfo['id']])->find();
		$result['news'] = htmlReturn($result['news']);
		return $result;
	}
}