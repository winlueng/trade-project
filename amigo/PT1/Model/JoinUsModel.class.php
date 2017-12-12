<?php 
namespace PT1\Model;

use Think\Model;

class JoinUsModel extends Model
{
	protected $autoCheckFields = false;
	
	public function showProjectInfo()
	{
		$obj = M('write_info');
		$where = array(
			array('relevance_id' 		=> $_SESSION['projectInfo']['id'] ),
		);

		$list = $obj->field('abstruct, project_logo, phone, email, address_id, address_info, principal')->where($where)->select()[0];

		$list['abstruct'] = htmlspecialchars_decode(html_entity_decode($list['abstruct']));

		$address = findRegionInfo($list['address_id'], 'district', 'name', 'district_id');
		$list['address'] = implode('',explode('-', $address));

		return $list;
	}

}