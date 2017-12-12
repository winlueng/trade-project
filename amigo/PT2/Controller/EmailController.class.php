<?php 
namespace PT2\Controller;

use Think\Controller;

class EmailController extends CommonController
{
	public function sendMail()
	{
		if (!$this->v_info['email'] || strlen($this->v_info['phone']) < 10) 
		{
			$this->success('请先前往个人资料进行手机验证和填写邮箱,再进行建议反馈', U('MyCenter/myCenterInfoUpdate'), 1);exit;
		}

		if (IS_POST) 
		{
	        $content = "网站留言通知：<br />用户姓名：".$this->v_info['real_name'].
	        			"<br />商城昵称：".$this->v_info['nick_name'].
	        			"<br />手机号码：".$this->v_info['phone'].
	        			"<br />邮箱：".$this->v_info['email'].
	        			"<br />留言时间：".date('Y年m月d日 H:i:s', time()).
	        			"<br />留言内容：".I('post.content');

			if(SendMail($this->pInfo['email'], '反馈意见', $content))
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
