<?php 
namespace PT2\Controller;

use Think\Controller;
use \PT2\Model\LoginModel;

class WasteBookController extends CommonController
{
	private $obj;

	public function __construct()
	{
		parent::__construct();
		$this->obj = new \PT2\Model\WasteBookModel();
		$_SESSION['visitorInfo'] = LoginModel::getUserInfo('', $this->userInfo['id']);
		// dump(LoginModel::getUserInfo('', $this->userInfo['id']));exit;
		
		$this->userInfo = $_SESSION['visitorInfo'];
	}

	// 我的钱包
	public function myWallet()
	{
		// dump($this->userInfo['wallet']);exit;
		$this->assign('wallet', $this->userInfo['wallet']);
		$this->display();
	}

	public function ajaxControl()
	{
		if (IS_AJAX) {
			$this->ajaxReturn($this->obj->ajaxControl(I('get.flag')));
		}
	}

	// 明细
	public function myWasteBook()
	{
		$list = $this->obj->myWasteBook();
		// dump($list);exit;
		$this->assign('list', $list);
		$this->display();
	}

	public function setPayPassWord()
	{
		if (IS_AJAX) {
			if (!I('post.password') || !I('post.repass')) {
				$this->ajaxReturn(['status' => 'false', 'err_msg' => '请输入密码和重复密码']);exit;
			}elseif(I('post.password') != I('post.repass')) {
				$this->ajaxReturn(['status' => 'false', 'err_msg' => '重复密码不一致']);exit;
			}
			$res = M('VisitorInfo')->where([
					'visitor_id' => $this->userInfo['id']
				])->save(['pay_pass_word' => password_hash(I('post.password'), PASSWORD_DEFAULT)]);
			if ($res) {
				$_SESSION['visitorInfo'] = LoginModel::getUserInfo('', $this->userInfo['id']);
				$this->ajaxReturn(['status' => 'true']);exit;
			}
			$this->ajaxReturn(['status' => 'false', 'err_msg' => '设置失败']);exit;
		}
		$this->display();
	}

	/**
	 * 重置密码
	 */
	public function reset_password()
	{
		// dump($this->userInfo);exit;
		// E('此页面升级中');exit;
		if (IS_AJAX) {
			
			if (!I('post.password') || !I('post.repass') || !I('post.old_pass')) {
				$this->ajaxReturn(['status' => 'false', 'err_msg' => '请输入旧密码,新密码和重复密码']);exit;
			}elseif(!pwd_hash(I('post.old_pass'),$this->userInfo['pay_pass_word'])){
				$this->ajaxReturn(['status' => 'false', 'err_msg' => '旧密码错误']);exit;
			}elseif(I('post.password') != I('post.repass')) {
				$this->ajaxReturn(['status' => 'false', 'err_msg' => '重复密码不一致']);exit;
			}
			$res = M('VisitorInfo')->where([
					'visitor_id' => $this->userInfo['id']
				])->save(['pay_pass_word' => password_hash(I('post.password'), PASSWORD_DEFAULT)]);
			if ($res) {
				$_SESSION['visitorInfo'] = LoginModel::getUserInfo('', $this->userInfo['id']);
				// $this->success('设置成功','/PT2/WasteBook/myWallet');exit;
				$this->ajaxReturn(['status' => 'true']);exit;
			}
			$this->ajaxReturn(['status' => 'false', 'err_msg' => '设置失败']);exit;
		}
		$this->display();
	}

	// 微信充值
	public function recharge_by_weixin()
	{
		if (!$this->userInfo['pay_pass_word']) {
			$this->redirect('WasteBook/setPayPassWord/');
		}
		$where = [
			'relevance_id' => $this->pInfo['id'], 
			'is_first_recharge' => '1',
			'start_time'	=> ['lt',time()],
			'end_time'	=> ['gt',time()],
			'status'	=> 0,
		];

		$field = 'recharge_price, present_price';

		$list['first_recharge'] = M('RechargeSetting')->where($where)->select();

		$where['is_first_recharge'] = 0;

		$list['other_recharge'] = M('RechargeSetting')->where($where)->select();
		$this->assign('first_recharge', $list['first_recharge']);
		$this->assign('other_recharge', $list['other_recharge']);
		$this->display();
	}

	public function recharge_by_card()
	{
		if (!$this->userInfo['pay_pass_word']) {
			$this->redirect('WasteBook/setPayPassWord/');
		}
		$this->display();
	}

	public function returnWXPay()
	{
		/*$info = S('test_order');

		$info = json_decode($info, true); 
		dump($info);exit;*/

		$res = $this->wechat->progressWxPayNotify();

		S('test_order', json_encode($res));

		list($resul, $notifyData, $replyData) = $res;
		/*if ($resul) {
		}*/
		$result = $this->obj->changeOrder($notifyData);
		if ($result) {
			$this->wechat->replyWxPayNotify($replyData);
		}
		exit();
	}
}

 ?>