<?php 
namespace Home\Controller;

use Think\Controller;

class SuggestController extends CommonController
{

	public function suggest()
	{
		$poster = new \Home\Model\IndexModel();
    	$posterList = $poster->selPoster(7);

    	$this->assign('poster', $posterList);
		$this->display();
	}

	public function sendMail()
	{
		// dump(I('post.'));exit;
        $Time = date('Y/m/d H:i:s');
        $content = "网站留言通知：<br />姓名：" . $_POST["name"] . "<br />手机号码：" . $_POST["tel"] . "<br />邮箱：" . $_POST["email"] . "<br />留言内容：" . $_POST["suggest"] . "<br />留言时间：" . $Time;
		if(SendMail('jaychow@gdkbvip.com', '反馈意见', $content))
		{
            $this->success('发送成功!');
		}else{
            $this->error('发送失败');
        }
	}
}
