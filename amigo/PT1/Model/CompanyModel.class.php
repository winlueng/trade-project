<?php 
namespace Template00002\Model;

use Think\Model;

class CompanyModel extends Model
{
	public function getCompanyInfo()
	{
		$result = $this->where(['uid' => $_SESSION['projectInfo']['id']])->getField('news');
		$companyNews = htmlspecialchars_decode(html_entity_decode($result));
		return $companyNews;
	}
}