<?php
namespace Template00003\Model;

use Think\Model;
use Think\Exception;


class LoginModel extends CommonModel
{
	protected $autoCheckFields = false;

	// 短信验证
	public function smsToVisitorVerify()
	{
	    $phoneNumber = I('get.phone');

	    $exist = M('WechatVisitor')->where(['phone' => $phoneNumber])->getField('id');

    	if ($exist['id']) {// 已注册
    		return 5;
    	}

	    // 验证码
	    $verifyCode = (string)mt_rand(1111,9999);

	    // 获取缓存发送状态
	    $status = S((string)$phoneNumber.'status');

	    // 判断60秒内是否发送过验证码
	    if ($status) 
	    {
	    	return 4;
	    }else{
	    	// 验证码存储在缓存内
	    	S((string)$phoneNumber.'Code', $verifyCode, 300);
	    	// 缓存发送状态
	    	S((string)$phoneNumber.'status', 1, 60);
	    }

	    $temlID = 29320;//腾讯云模版id

	    $params = [$verifyCode, 300];//模版参数

	    // 模版单发单发 
	    $result = $this->tx_sms->sendWithParam("86", $phoneNumber, $temlID, $params);

	    $rsp = json_decode($result);

	    // 判断应答包是否发送成功
	    if ($rsp->errmsg == 'OK') 
	    {
	    	return 1;
	    }else{
	    	// 不成功返回微信短信错误代号
	    	return $rsp->result;
	    }
	}

	// ajax请求分支
	public function ajaxControl()
	{
		$flag = I('get.flag');
		switch ($flag) 
		{
			case 'smsToVisitorVerify':
				$result = $this->smsToVisitorVerify();//短信验证接口
				break;
			case 'bindingPhone':
				$result = $this->verifyCodeToMatch('wechat');//ajax提交匹配手机验证码
				break;
		}
		return $result;
	}

	/**
	 * 验证码匹对
	 * @param string $flag 分支判定
	 * @return void  $result 返回布尔值信息
	 */
	public function verifyCodeToMatch($flag)
	{
		$phone 		= I('post.phone');
        $code 		= S($phone.'Code');
        $phoneCode 	= I('post.code');

        if ($code != $phoneCode) 
        {
        	$this->error = '验证码有误';return false;
        }

        $this->redis->setex($this->ip.'_pass_key', 3600, $phone);
        return true;
	}

	// 浏览器登录
	public function defaultLogin()
	{
		try {
			$data = I('post.');

			if (!$data['phone'] || !$data['password']) throw new Exception("请填写完毕登录账户和密码");

			$info = M('WechatVisitor')
					->field('password, id, open_id')
					->where(['phone' => $data['phone']])
					->find();
			if (!$info) {

				throw new Exception("账户不存在");

			}else if (!pwd_hash($data['password'],$info['password'])) {

				throw new Exception("密码错误");

			}else if (($info['open_id'] != $this->userInfo['open_id']) && isWeixin() && $info['open_id']) {

				throw new Exception("登录帐号已绑定微信端且不是同一微信端帐号登录.");

			}else if(($data['phone'] != $this->userInfo['phone']) && isWeixin() && $this->userInfo['phone']){

				throw new Exception("登录帐号已绑定手机与当前微信端绑定手机号不一致");

			}else if(!$this->userInfo['phone'] && isWeixin()){// 未绑定手机情况下,当前登录手机绑定为当前微信端帐号

				$this->startTrans();
				$res = M('WechatVisitor')
					->where(['phone' => $data['phone']])
					->save(['open_id' => $this->userInfo['open_id']]);
				if (!$res) throw new Exception("自动绑定失败");
				
				$res = M('WechatVisitor')->where(['open_id' => $this->userInfo['open_id']])->delete();

				if (!$res) throw new Exception("更新OPENID失败");
			}
			
			$_SESSION['visitorInfo'] = $this->getUserInfo('', $info['id']);
			$this->commit();
			return true;
		} catch (Exception $e) {
			$this->rollback();
			$this->error = $e->getMessage();return false;
		}
	}

	/**
	 * 根据openid获取用户信息
	 * @param  string $openid 用户的openid
	 * @return 用户信息数组         
	 */
	public function getUserInfo($openid = '', $uid = '')
	{
		$field = [
			'id',
			'phone',
			'email',
			'open_id',
		];
		if ($openid) $where['open_id'] = $openid;
		
		if ($uid) $where['id'] = $uid;
		
		$res = M('WechatVisitor')->field($field)->where($where)->find();
		if (!$res) return false;

		$info = M('VisitorInfo')->where(['visitor_id' => $res['id']])->find();

		if ($info['city']) 
		{
			$info['address'] = findRegionInfo($info['city'], 'District', 'name', 'district_id');
		}

		$info['wallet']	= M('WasteBook')
							->where(['visitor_id' => $res['id'], 'relevance_id' => $this->pInfo['id']])
							->order('id desc')
							->getField('balance');

		M('VisitorInfo')->where(['visitor_id' => $res['id']])->setField('wallet',$info['wallet']);

		if (!$info) return $res;

		$result = array_merge($res, $info);

		return $result;
	}

	public function visitorAdd($data)
	{
		$address = M('District')->where(['name' => ['like','%'. $data->city .'%']])->getField('district_id');
		$this->startTrans();

		try {
			$save = [
				'open_id' 	 	=> $data->openid,
				'addtime' 	 	=> time(),
				'company_id'   	=> $this->companyInfo['id'],
				'relevance_id' 	=> $this->pInfo['id'],
			];

			$res = M('WechatVisitor')->add($save);

			if (!$res) {
				throw new Exception("记录信息失败1", 1);
			}
			$save = [
				'visitor_id' 	=> $res,
				'nick_name'  	=> $data->nickname,
				'sex' 		 	=> $data->sex,
				'head_portrait' => $data->headimgurl,
				'city' 			=> $address,
			];

			$result = M('VisitorInfo')->add($save);
			if (!$result) {
				throw new Exception("记录信息失败2", 1);
			}
			$result = $this->getUserInfo($data->openid);
			$this->commit();
			return $result;
		} catch (Exception $e) {
			$this->rollback();
			$this->error = $e->getMessage();
			return false;
		}
	}
}