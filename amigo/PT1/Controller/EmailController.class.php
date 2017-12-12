<?php 
namespace PT1\Controller;

use Think\Controller;

class EmailController extends CommonController
{
	public function sendMail()
	{
		if (IS_POST) 
		{
	        $Time = date('Y/m/d H:i:s');
	        $content = "网站留言通知：<br />姓名：" . $_POST["name"] . "<br />手机号码：" . $_POST["tel"] . "<br />邮箱：" . $_POST["email"] . "<br />留言内容：" . $_POST["suggest"] . "<br />留言时间：" . $Time;
	        // dump($_SESSION['projectInfo']['email']);exit;
			if(SendMail($_SESSION['projectInfo']['email'], '反馈意见', $content))
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
