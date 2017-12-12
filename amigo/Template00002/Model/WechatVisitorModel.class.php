<?php 
namespace Template00002\Model;

use Think\Model;
use \Template00002\Model\LoginModel;

class WechatVisitorModel extends CommonModel
{
	protected $_validate = [
		['repass','password','重复密码不正确',0,'confirm'], //   验证确认密码是否和密码一致     
	    ['password','6,12','请设置6到12位长度密码',0,'length',3], // 自定义函数验证密码格式
	];

	public function visitor_add()
	{
		if ($data = $this->create()) {
			$save = [
				'password' 		=> password_hash($data['password'], PASSWORD_DEFAULT),
				'phone'			=> $this->redis->get($this->ip.'_pass_key'),
				'update_time'	=> time()
			];
			if (isWeixin()) {
				$res = $this->where(['open_id' => $this->userInfo['open_id']])->save($save);
				$_SESSION['visitorInfo'] = LoginModel::getUserInfo('', $this->userInfo['id']);
				$str = '绑定微信失败';
			}else{
				if ($this->userInfo) {
					$res = $this->where(['id' => $this->userInfo['id']])->save($save);
				}else{
					$save['addtime'] = time();
					$save['relevance_id'] = $this->pInfo['id'];
					$res = $this->add($save);
					M('VisitorInfo')->add(['visitor_id' => $res]);
				}
				$str = '设置密码失败';
			}
			if ($res) return true;

			$this->error = $str;return false;
		}
		return false;
	}
}


 ?>