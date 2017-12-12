<?php
namespace PT2\Model;

use Think\Model;

class SystemNewsModel extends CommonModel
{
	/**
	 * 消息列表
	 */
	public function newsList()
	{
		$where = [
				'obj_id' => $this->userInfo['id'], 
				'obj_type' => 1, 
				'status'=>['neq','-1']
			];
		$count = $this->where($where)->count();
		$page = new \Think\Page($count, 10);
		$newsList = $this
					->where($where)
					->order('create_time desc')
					->limit($page->firstRow.','.$page->listRows)
					->select();
		$result = '';
		foreach ($newsList as $v) {
			$result[date('Y-m-d',$v['create_time'])][] = $v;
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