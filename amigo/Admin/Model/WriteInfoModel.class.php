<?php
namespace Admin\Model;

use Think\Model;

class WriteInfoModel extends CommonModel
{
	protected $_validate = array(     
			array('phone','mobile','手机格式不正确'), // 在新增的时候验证name字段是否唯一     
			array('market_name', 'require', '请填写贵司名称'),
			array('principal', 'require', '请填写贵司联系人'),
			array('phone', 'require', '请填写贵司联系人手机号码'),
			array('email', 'require', '请填写贵司联系人邮箱'),
			array('address_id', 'require', '请选择地址位置'),
			array('email', 'email', '邮箱格式不正确'),
			array('address_info', 'require', '请填写贵司详细地址'),
			array('abstruct', 'require', '请填写贵司简介'),
			array('app_id', 'require', '请填写贵司公众号AppID'),
			array('app_secret', 'require', '请填写贵司公众号密钥'),
		);

	protected $_auto = [
		['update_time', 'time', 3, 'function']
	];

	public function __construct()
	{
		parent::__construct();
	}

	public function infoUpdate()
	{
		$where['relevance_id'] = $this->userInfo['relevance_id'];

		if ($data = $this->create()) 
		{
			if ($_FILES['project_logo']['size']) 
			{
				
				$path = fileUpload('/Uploads/goodsImg/', 'project_logo');

				if (isset($path['error_msg'])) {
					$this->error = $path['error_msg'];return false;
				}
				$data['project_logo'] = $path;

				$oldPath = $this->where($where)->getField('project_logo');
			}

			if (!$this->userInfo['pem_addr'] && (!$_FILES['apiclient_cert']['size'] || !$_FILES['apiclient_key']['size'])) {
				$this->error = '请同时上传双向证书,少一不行';return false;
			}

			if($_FILES['apiclient_cert']['size'] && $_FILES['apiclient_key']['size']){
				if (!$data['mch_id'] || !$data['mch_sectet']) {
					$this->error ='请设置好商户号和商户密钥,重新登录再上传双向证书';return false;
				}
				unlink('./Public/Uploads/pem/'.$this->userInfo['mch_id'].'/apiclient_key.pem');
				unlink('./Public/Uploads/pem/'.$this->userInfo['mch_id'].'/apiclient_cert.pem');
				
				$path = fileUpload('/Uploads/pem/'. $data['mch_id'] .'/', 'apiclient_cert', 'one', 3155444, 'apiclient_cert');
				if (isset($path['error_msg'])) {
					$this->error = $path['error_msg'];return false;
				}

				$path = fileUpload('/Uploads/pem/'. $data['mch_id'] .'/', 'apiclient_key', 'one', 3155444, 'apiclient_key');

				if (isset($path['error_msg'])) {
					$this->error = $path['error_msg'];return false;
				}

				$data['pem_addr'] = '/Public/Uploads/pem/'.$data['mch_id'];

			}

			$res = $this->where($where)->save($data);

			if (!$res)
			{
				$this->error = '完善资料失败';return false;
			}
			unlink('./Public'.$oldPath);
			return $res;
		}else{
			return false;
		}
	}

	// 项目自身详情
	public function selMarketInfo()
	{
		$where['relevance_id'] = $this->userInfo['relevance_id'];

		$result = $this->where($where)->find();

		$result['abstruct'] = htmlspecialchars_decode(html_entity_decode($result['abstruct']));

		return $result;
	}
}