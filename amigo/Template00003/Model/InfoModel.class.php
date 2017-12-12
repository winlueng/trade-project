<?php 
namespace Template00002\Model;

use Think\Model;

class InfoModel extends CommonModel
{
	protected $autoCheckFields = false;
	
	public function getCompanyInfo()
	{
		$result = M('Company')->where(['id' => $this->companyId])->getField('news');
		$companyNews = htmlspecialchars_decode(html_entity_decode($result));
		return $companyNews;
	}
}