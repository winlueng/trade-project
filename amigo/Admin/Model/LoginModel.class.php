<?php
namespace Admin\Model;
use Think\Model;
use Think\Exception;
class LoginModel extends Model
{
	protected $autoCheckFields = false;

	private $redis;

	public function __construct()
	{
		parent::__construct();
		$this->redis = new \Redis();
		$this->redis->connect('127.0.0.1', 6379);
	}

	// 登录时表单验证的规则 
	protected $_validate = array(
		array('username', 'require', '用户名不能为空！', 1),
		array('password', 'require', '密码不能为空！', 1),
	);

	public function login()
	{
		// 清除登录信息
		session('adminInfo', null);
        session('companyInfo', null);
        session('marketInfo', null);
        // 根据域名分支赋值$group_type为下面判断是否对应后台登录
		switch ($_SERVER['HTTP_HOST']) 
		{
			case C('ADMIN_BACKGROUND'):
				$groupType = 1;
				break;
			case C('PROJECT_BACKGROUND'):
				$groupType = 3;
				break;
			case C('COMPANY_BACKGROUND'):
				$groupType = 2;
				break;
		}
		// 验证表单
		if ($data = $this->create()) 
		{
			$user = M('user')->field('id, user_name, password, category_id, relevance_id, company_id, last_login_ip, last_login_time')->where(['user_name'=>['eq',I('post.username')],'status'=>0])->select()[0];

			// 查询用户
			if ($user) 
			{
				$loginType = $this->redis->get('B_login_by_'.$user['id']);
				/*if ($loginType) {
					$this->error = '此帐号已在其他电脑登录,请确认帐号';return false;
				}*/

				// 匹配密码登录
				if (pwd_hash(I('post.password'),$user['password'])) 
				{
					$ruleGroupId = M('auth_group_access')->where(['uid'=>$user['id']])->getField('group_id');
				
					$userType = M('auth_group')->where(['id'=>$ruleGroupId])->getField('group_type');

					if ((int)$userType == 0) 
					{
						$userType = 1;
					}
					
					// 判断是否对应后台登录
					if ($groupType == $userType) {
						switch ($userType) 
						{
							case 1:
								$_SESSION['adminInfo'] = $user;
								$res['index'] = 'Index/adminIndex';
								$res['module'] = ['module' => M('Module')->getField('id')['id']];
								break;
							case 2:
								$info = M('Company')->field('pem_addr,company_name,mch_id')
										->where(['id' => $user['company_id'], 'end_time' => ['gt', time()], 'status' => 0])
										->find();
								if (!$info) {
									$this->error = '当前账户所属商户已过期或被禁用,请联系项目管理员进行整改';return false;
								}
								$info['sx_data_base'] = M('Project')->where(['id' => $user['relevance_id']])->getField('sx_data_base');

								M('Goods')->where(['company_id' => $user['company_id'], 'sales_end_time' => ['lt', time()]])->setField('is_promotion', 0);

								$_SESSION['companyInfo'] = array_merge($user, $info);

								$res['index'] = 'Index/companyIndex';
								break;
							case 3:
								$info = M('Project')->where(['id' => $user['relevance_id'], 'end_time' => ['gt', time()], 'status' => 0])->find();
								if (!$info) {
									$this->error = '当前账户所属大门户已过期或被禁用,请联系后台管理员进行整改';return false;
								}

								$pInfo = M('WriteInfo')->field('pem_addr,mch_id,market_name')->where(['relevance_id' => $user['relevance_id']])->find();

								
								$info  = array_merge($info, $pInfo);

								unset($info['id']);

								$_SESSION['marketInfo'] = array_merge($user, $info);

								$res['index'] = 'Index/projectIndex';

								$res['module'] = ['module' => 1];
								
								break;
						}
						$save['last_login_ip']   = get_client_ip();
						
						$save['last_login_time'] = time();

						M('user')->where(['id' => $user['id']])->save($save);

						$this->redis->setex('B_login_by_'.$user['id'], 1800, 1);

						return $res;
					}else{
						$this->error = '此帐号不属于此后台登录,请正确访问对应后台登录';return false;
					}
				}else{
					$this->error = '密码错误';return false;
				}
			}else{
				$this->error = '账号不存在或被禁用';return false;
			}
		}else{
			return false;
		}
	}

	public function passwordReset()
	{
		$rules = [
			['password', 'require', '请输入重置密码', 1],
			['repass', 'require', '请输入重复密码', 1],
			['repassword','password','确认密码不正确',1,'confirm'],
			['phone', 'require', '请输入验证手机号', 1]
		];

		if ($data = $this->validate($rules)->create()) {

			$save['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

			$this->startTrans();

			try {
				
				$res = M('User')->where(['phone' => $data['phone']])->save($save);

				if(!$res) throw new Exception("重置失败");
				
				return true;
				$this->commit();
			} catch (Exception $e) {
				$this->rollback();
				$this->error = $e->getMessage();return false;
			}
		}
		return false;
	}
	
	public function ajaxControl($flag)
	{
		return $this->$flag();
	}

	public function getCode()
	{
	    $phone = I('get.phone');

	    if (M('User')->where(['phone' => $phone])->find()) {
	    	$res = [
	    		'status'  => false,
	    		'err_msg' => '此手机未绑定任何用户',
	    	];
	    	return $res;
	    }

	    // 腾讯短信接口实例化
	    $singleSender = new \wechat\SmsSingleSender(C('SMS_APPID'), C('SMS_APPKEY'));

	    // 验证码
	    $verifyCode = mt_rand(1111,9999);

	    // 获取缓存发送状态
	    $status = S((string)$phone.'status');

	    // 判断60秒内是否发送过验证码
	    if ($status) 
	    {
	    	$res = [
	    		'status'  => false,
	    		'err_msg' => '60秒内发送过验证码',
	    	];
	    	return $res;
	    }

	    $temlID = 11111;//腾讯云模版id

	    $params = array((string)$verifyCode, '300', '300');//模版参数

	    // 模版单发单发
	    $result = $singleSender->sendWithParam("86", $phone, $temlID, $params);

	    $rsp = json_decode($result);

	    // 判断应答包是否发送成功
	    if ($rsp->errmsg == 'OK') 
	    {
	    	// 验证码存储在缓存内
	    	S((string)$phone.'Code', $verifyCode, 300);
	    	// 缓存发送状态
	    	S((string)$phone.'status', 1, 60);
	    	return true;
	    }else{
	    	// 不成功返回微信短信错误代号
	    	$res = [
	    		'status'  => false,
	    		'err_msg' => '发送失败,错误码:'.$rsp->result,
	    	];
	    	return $res;
	    }
	}
}