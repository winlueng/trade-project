<?php 
namespace PT2\Model;

use Think\Model;

class WriteInfoModel extends CommonModel
{
	public function getCompanyInfo()
	{
		$result = M('WriteInfo')->where(['relevance_id' => $this->pInfo['id']])->getField('abstruct');
		return htmlspecialchars_decode(html_entity_decode($result));
	}
}