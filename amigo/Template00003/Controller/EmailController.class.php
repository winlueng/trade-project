<?php 
namespace Template00003\Controller;

use Think\Controller;

class EmailController extends CommonController
{
	public function sendMail()
	{
		/*$info = M('WechatVisitor')->field('email, phone')->where(['id' => $this->userInfo['id']])->find();
		if (!$info['email'] || !$info['phone']) 
		{
			$this->success('请先前往个人资料进行手机验证和填写邮箱,再进行建议反馈', U('MyCenter/myCenterInfoUpdate'), 1);exit;
		}*/
		$name = M('VisitorInfo')->field('real_name, nick_name')
				->where(['visitor_id' => $this->userInfo['id']])
				->find();

		if (IS_POST) 
		{
	        $email 	 = M('Company')->where(['id' => $this->companyInfo['id']])->getField('email');
	        $content = "网站留言通知：<br />用户姓名：".$name['real_name'].
	        			"<br />商城昵称：".$name['nick_name'].
	        			"<br />手机号码：".$info['phone'].
	        			"<br />邮箱：".$info['email'].
	        			"<br />留言时间：".date('Y年m月d日 H:i:s', time()).
	        			"<br />留言内容：".I('post.content');

			if(SendMail($email, '反馈意见', $content))
			{
	            $this->success('发送成功!');
			}else{
	            $this->error('发送失败');
	        }
		}else{
			$this->display();
		}
	}
}
