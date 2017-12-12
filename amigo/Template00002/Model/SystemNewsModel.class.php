<?php
namespace Template00002\Model;

use Think\Model;

class SystemNewsModel extends CommonModel
{

	/**
	 * 消息列表
	 */
	public function newsList()
	{
		$count = $this->where(['obj_id' => $this->userInfo['id'], 'obj_type' => 1, 'status'=>['neq','-1']])->count();
		$page = new \Think\Page($count, 10);
		$newsList = $this
					->where(['obj_id' => $this->userInfo['id'], 'obj_type' => 1, 'status'=>['neq','-1']])
					->order('create_time desc')
					->limit($page->firstRow.','.$page->listRows)
					->select();
		$result = '';
		foreach ($newsList as $v) {
			$result[$v['create_time']][] = $v;
		}

		return $result;

	}

	public function isRead()
	{
		$this->where(['id' => I('get.id')])->setField('is_read', 1);
	}

	public function ajaxControl($flag)
	{
		return $this->$flag();
	}
}