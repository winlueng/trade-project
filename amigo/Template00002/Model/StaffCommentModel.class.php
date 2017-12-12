<?php
namespace Template00002\Model;

use Think\Model;

class StaffCommentModel extends CommonModel
{ 
	protected $insertFields = ['subscribe_id','staff_id','content','visitor_id','company_id','score','create_time','status','image'];

	public function __construct()
	{
		parent::__construct();
		$this->_auto = [
			['visitor_id', $this->userInfo['id'], self::MODEL_INSERT],
			['create_time', 'time', self::MODEL_INSERT ,'function'],
		];
	}

	public function insert()
	{
		if ($data = $this->create()) {
			
			$res = $this->add($data);


			if (!$res) {
				$this->error = '评论出错';return false;
			}
			M('SubscribeOrderForm')->where(['id' => $data['subscribe_id']])->setField('status', 4);
			return true;
		}
		return false;
	}
}