<?php 
namespace Admin\Model;

use Think\Model;
use Think\Exception;

class CompanyModel extends CommonModel
{
	protected $insertFields = array('company_ip','id', 'region_id', 'business_id', 'principal', 'email', 'web_postfix', 'phone', 'company_name','start_time', 'end_time', 'addtime','address_info', 'city', 'district', 'province');

	protected $updateFields = array('company_ip', 'region_id', 'business_id', 'principal', 'email', 'web_postfix', 'phone', 'company_name', 'logo_path', 'code_path', 'news', 'company_type', 'template_id','pem_addr');

	// 自动验证
	protected $_validate = array( 
		array('web_postfix', 'require', '请完善域名后缀'),
		array('web_postfix','1,16','后缀长度暂支持1至16位字符',0,'length',3),
		array('address_info', 'require', '地址不能空'),
		array('company_ip', '', '商户编号已存在,请确认再添加', 1, 'unique'),
	);

	public function __construct()
	{
		parent::__construct();
		$this->_auto = array( 
			array('start_time', 'strtotime', 3, 'function'),
			array('end_time', 'strtotime', 3, 'function'),
			array('addtime', 'strtotime', 3, 'function'),
			array('relevance_id', $this->userInfo['relevance_id'], 3),
			array('category_id', $this->userInfo['category_id'], 3),
		);
	}

	/**
	 * 添加商品时选项卡里面的基本信息
	 * @return $res array  返回一个地址选项数组
	 */
	public function addSelect()
	{
		$address = M('District')->field('district_id,name')->where(['parent_id'=>0])->select();

		$business = M('Business')->field('business_name,id')->where(['status'=>0])->select();

		$res['ads'] = $address;

		$res['bus'] = $business;

		return $res;
	}

	/**
	 * 商户添加
	 * @param  $data 自动完成后的数据
	 * @return $res 返回插入数据是否成功
	 */
	public function companyAdd()
	{
		if ($data = $this->create()) 
		{
			try {
				// 查询开户限额
				$quota = M('Project')->where(['id' => $this->userInfo['relevance_id']])->getField('company_quota');

				$count = $this->where(['relevance_id' => $this->userInfo['relevance_id'], 'status' => 0])->count();

				if ($count >= (int)$quota) throw new Exception('开户数量已超出限额,你当前的限额是可开通'.$quota.'个商户,现已开通'.$count.'个商户.如需增加请联系总后台管理员.', 1);

				if (!$_FILES['business_license']['size'] || !$_FILES['person_code_front']['size'] || !$_FILES['person_code_rear']['size']) {
					throw new Exception('请上传商户营业执照和身份证资料', 2);
				}else{
					$path = fileUpload('/Uploads/companyImg/', 'business_license');
					if (isset($path['error_msg'])) {
						throw new Exception($path['error_msg'], 3);
					}
					$infoData['business_license'] = $path;

					$path = fileUpload('/Uploads/companyImg/', 'person_code_front');
					if (isset($path['error_msg'])) {
						throw new Exception($path['error_msg'], 4);
					}

					$infoData['person_code_front'] = $path;

					$path = fileUpload('/Uploads/companyImg/', 'person_code_rear');

					if (isset($path['error_msg'])) 
					{
						throw new Exception($path['error_msg'], 5);
					}

					$infoData['person_code_rear'] = $path;
				}

				$where = array(
						'relevance_id' => $this->userInfo['relevance_id'],
						'category_id'  => $this->userInfo['category_id'],
						'web_postfix'  => $data['web_postfix'],
					);

				$find = $this->where($where)->getField('id');

				if ($find) { 
					// 判断在大门户官网内后缀的唯一性
					throw new Exception('此后缀已注册,请确认后缀再进行添加', 6);
				}

				$data['template_id']  = M('TemplateChange')->where(['status' => 0, 'template_type' => 2])->min('id');

				$this->startTrans();

				if (!$data['company_ip']) {
					$data['company_ip'] = 'gdkbvip_'.time().'_'.mt_rand(111,999);
				}

				// list($data['x_coordinate'], $data['y_coordinate']) = explode(',', I('post.coordinate'));

				$res = $this->add($data);

				if (!$res) throw new Exception("添加商户失败", 7);

				$infoData['company_id'] = $res;

				$res = M('CompanyPicture')->add($infoData);

				if (!$res) throw new Exception("证件添加数据失败", 8);
				$this->commit();
				return true;
			} catch (Exception $e) {
				if ($e->getCode() == (7|8|9)) $this->rollback();

				$this->error = $e->getMessage();return false;
			}
		}
		return false;
	}

	/**
	 * 项目商户列表显示
	 */
	public function showCompanyList($type)
	{
		$where = [
			'company_type' => $type,
			'relevance_id' => $this->userInfo['relevance_id'],
			'category_id'  => $this->userInfo['category_id'],
		];

		if (I('get.selname')) 
		{
			$where['company_name'] = ['like','%'.I('get.selname').'%'];
		}

		$count    = $this->where($where)->count();

		$Page     = new \Think\Page($count,8);

		// 分页显示输出
		$mlist = $this->where($where)->order('start_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();

		foreach($mlist as $k => $v)
		{
			$v['company_address'] = findRegionInfo($v['region_id'], 'Region', 'region_name');

			$v['business'] = M('Business')->where(['id'=>$v['business_id']])->getField('business_name');

			$v['visit_total'] = M('CompanyStatistics')->where(['relevance_id' => $v['id']])->sum('visit_total');

			$companyList[] = $v;
		}

		// 查找模版
		$templateList = M('TemplateChange')->field('id, template_name, template_logo')->where(['template_type' => 2, 'status' => ['neq', '-1']])->select();
		$list['company'] = $companyList;
		$list['templateList'] = $templateList;
		$list['page'] = $Page->show();
		
		return $list;
	}

	// 店铺详情
	protected function selCompanyInfo()
	{
		$id = I('get.id');
		$res = $this->where(['id'=>$id])->find();
		$res['company_address'] = findRegionInfo($res['region_id'], 'Region', 'region_name');
		$res['business_name'] 	= M('Business')->where(['id' => $res['business_id']])->getField('business_name');
		return $res;
	}

	public function companyUpdate()
	{
		if ($data = $this->create())
		{
			$id   = I('get.id');
			
			if ($_FILES['logo_path']['size']) 
			{
				$path = fileUpload('/Uploads/companylogo/', 'logo_path');
				if (isset($path['error_msg'])) {
					$this->error = $path['error_msg'];return false;
				}
				$data['logo_path'] = $path;
				$del = D('Company')->where(['id' => $id])->getField('logo_path');
				unlink('./Public'.$del);
			}

			if($_FILES['company_pic']['size']){
				$path = fileUpload('/Uploads/companylogo/', 'company_pic');
				if (isset($path['error_msg'])) {
					$this->error = $path['error_msg'];return false;
				}
				$data['company_pic'] = $path;

				$del = D('Company')->where(['id' => $id])->getField('company_pic');

				unlink('./Public'.$del);
			}

			list($data['x_coordinate'], $data['y_coordinate']) = explode(',', I('post.coordinate'));

			if (!$data['region_id'] || !$data['business_id']) 
			{
				unset($data['region_id']);
				unset($data['business_id']);
			}
			$res = $company->where(['id' => $id])->save($data);

			return $res;
		}
			
		return false;
	}

	// ajax操作
	public function ajaxControl()
	{
		switch (I('get.flag')){
			case 'changeCompanyType':
				$res = $this->changeCompanyType();
				break;
			case 'selCompanyInfo':
				$res = $this->selCompanyInfo();
				break;
			case 'setCompanyControlTime':
				$res = $this->setCompanyControlTime();
				break;
			case 'selCompany':
				$res = $this->selCompany();
				break;
			case 'selCompanyList':
				$res = $this->selCompanyList();
				break;
			case 'changeCompanyStatus':
				$res = $this->changeCompanyStatus();
				break;
		}
		return $res;
	}

	protected function selCompany()
	{
		if (I('get.category_id') && I('get.address_id')) 
		{
			$where['category_id'] = I('get.category_id');
			$where['address_id'] = I('get.address_id');
			$result = $this->field('id, company_name')->where($where)->select();
			if (!$result) 
			{
				return '暂无搜索信息';
			}
			return $result;
		}else{	
			return '请选择好项目分类和地址!';
		}
	}

	protected function selCompanyList()
	{
		if (I('get.region_id') || I('get.business_id')) 
		{
			if (I('get.region_id')) 
			{
				$where['region_id'] = I('get.region_id');
			}

			if (I('get.business_id')) 
			{
				$where['business_id'] = I('get.business_id');
			}
			$where['relevance_id'] = $this->userInfo['relevance_id'];
			$result = $this->field('id, company_name')->where($where)->select();
			if (!$result) 
			{
				return '暂无搜索信息';
			}
			return $result;
		}else{	
			return '请选择好项目分类和地址!';
		}
	}

	// 查询公司简介
	public function companyNewsInfo()
	{
		$result = M('Company')->where(['id' => $this->userInfo['company_id']])->getField('news');
		$result = htmlReturn($result);
		return $result;
	}

	// 保存公司简介
	public function saveNewsInfo()
	{
		$id = $_SESSION['companyInfo']['company_id'];
		$data = I('post.');
		$result = M('Company')->where(['id' => $id])->save($data);
		return $result;
	}

	// 修改商户类型(0:普通 1:特色)
	protected function changeCompanyType()
	{
		$id['id'] = I('get.id');
		$status = $this->where($id)->getField('status');
		if ($status) return '商户已禁用,不能操作';

		$data['company_type'] = I('get.status');

		$res = $this->where($id)->save($data);
		if ($res) return '操作成功';

		return '操作失败';
	}

	public function setCompanyControlTime()
	{
		$where['id'] = I('get.id');
		$data['control_time'] = time();
		$res = $this->where($where)->save($data);
		if ($res) '操作成功';
			
		return '操作失败';
	}

	public function selCurrentCompanyInfo()
	{
		$res = $this->where(['id'=>$this->userInfo['company_id']])->find();
		$res['pictureInfo'] = M('Company_picture')->field('company_code, company_bgpic, company_logo, business_license,person_code_rear, person_code_front')->where(['company_id' => $this->userInfo['company_id']])->find();
		$res['ip_address'] = implode(';', json_decode($res['ip_address'], true));
		$res['company_address'] = findRegionInfo($res['region_id'], 'Region', 'region_name');
		$res['business_name'] = M('Business')->where(['id' => $res['business_id']])->getField('business_name');
		$link = M('Project')->where(['id' => $this->userInfo['relevance_id']])->getField('project_link');
		$res['company_link'] = $link.'/'.$res['web_postfix'];
		return $res;
	}

	public function companyInfoUpdate()
	{
		$data = I('post.');
		$redis = new \Redis();
		$redis->connect('127.0.0.1',6379);
		if (!I('get.id')) {
			$this->error = '非法数据';return false;
		}
		$companyId = I('get.id');

		$exist = M('Company')->where(['web_postfix' => $data['web_postfix'], 'relevance_id' => $_SESSION['marketInfo']['relevance_id'], 'id' => ['neq', $companyId]])->getField('id');
		
		if ($exist) {
			$this->error = '域名后缀以存在';return false;
		}

		$redis->delete('companyid_turn_template_by_'.$companyId.'_saveTime');// 为模版切换出千

		$saveTime = $redis->get('companyid_turn_template_by_'.$companyId.'_saveTime');

		if($saveTime > time()){
			$this->error = '每个商户一个月内只可切换一次模版和修改一次合约终止时间<br>距离下次可修改模版时间为'.date('Y年m月d日 H:i:s', $saveTime);return false;
		}else{
			$time = strtotime('+1 month');
			$redis->set('companyid_turn_template_by_'.$companyId.'_saveTime', $time);
			$data['end_time'] = strtotime($data['end_time']);
			if ($data['end_time'] > time()) {
				$data['status'] = 0;
			}
			$result = M('Company')->where(['id'=>$companyId])->save($data);
			if (!$result) 
			{
				$this->error = '更新失败';return false;
			}
			return $result;
		}
	}

	// 商家资料完善
	public function companyInfoSave()
	{
		$rules = array(
			array('principal', 'require', '请填写联系人'),
			array('phone', 'mobile', '请填写正确的联系电话'),
			array('phone', '', '联系电话已注册', 2, 'unique', 2),
			array('email', 'email', '请填写正确的邮箱地址'),
			array('email', '', '邮箱已注册', 2, 'unique', 2),
			array('app_id', 'require', '请填写公众号APP_ID'),
			array('app_secret', 'require', '请填写公众号app_secret'),
		);

		if ($this->validate($rules)->create()) 
		{
			try {
				$data = I('post.');
				if ($_FILES['company_code']['size']) 
				{
					$path = fileUpload('/Uploads/companyImg/', 'company_code');
					if (isset($path['error_msg'])) throw new Exception($path['error_msg'], 9);

					$picData['company_code'] = $path;
				}

				if ($_FILES['company_bgpic']['size']) 
				{
					$path = fileUpload('/Uploads/companyImg/', 'company_bgpic');
					if (isset($path['error_msg'])) throw new Exception($path['error_msg'], 10);

					$picData['company_bgpic'] = $path;
				}

				if ($_FILES['company_logo']['size']) 
				{
					$path = fileUpload('/Uploads/companyImg/', 'company_logo');
					if (isset($path['error_msg'])) throw new Exception($path['error_msg'], 11);

					$picData['company_logo'] = $path;
				}

				if(($_FILES['apiclient_cert']['size'] || $_FILES['apiclient_key']['size']) && (!$_FILES['apiclient_cert']['size'] || !$_FILES['apiclient_key']['size'])){
					throw new Exception('请同时上传双向证书,少一不行', 14);
				}

				if($_FILES['apiclient_cert']['size'] && $_FILES['apiclient_key']['size']){
					if (!$data['mch_id'] || !$data['api_key']) {
						throw new Exception('请设置好商户号和商户密钥,重新登录再上传双向证书', 17);
					}
					unlink('./Public/'.$this->userInfo['mch_id'].'/apiclient_key.pem');
					unlink('./Public/'.$this->userInfo['mch_id'].'/apiclient_cert.pem');
					
					$path = fileUpload('/Uploads/pem/'. $data['mch_id'] .'/', 'apiclient_cert', 'one', 3155444, 'apiclient_cert');
					if (isset($path['error_msg'])) throw new Exception($path['error_msg'], 15);

					$path = fileUpload('/Uploads/pem/'. $data['mch_id'] .'/', 'apiclient_key', 'one', 3155444, 'apiclient_key');
					if (isset($path['error_msg'])) throw new Exception($path['error_msg'], 16);
					$data['pem_addr'] = '/Public/Uploads/pem/'.$data['mch_id'];

				}

				$this->startTrans();

				if ($picData) 
				{
					$result = M('Company_picture')->where(['company_id' => $this->userInfo['company_id']])->save($picData);

					if (!$result) throw new Exception('保存图片失败', 12);
				}
				
				$data['ip_address'] = json_encode(explode(';', $data['ip_address']));
				$data['coordinate'] = explode(',', I('post.coordinate'));
				$data['x_coordinate'] = $data['coordinate'][0];
				$data['y_coordinate'] = $data['coordinate'][1];
				$res = $this->where(['id' => $this->userInfo['company_id']])->save($data);
				$this->commit();
				return true;
			} catch (Exception $e) {
				if($e->getCode() == (12|13)) $this->rollback();

				$this->error = $e->getMessage();return false;
			}
		}
		return false;
	}

	public function changeCompanyStatus()
	{
		$id = I('get.id');
		$data['status'] = I('get.status');
		// 查询限额
		if (!$data['status']) {
			$quota = M('Project')->where(['id' => $this->userInfo['relevance_id']])->getField('company_quota');
			$count = $this->where(['relevance_id' => $this->userInfo['relevance_id'], 'status' => 0])->count();
			if ($count >= (int)$quota) {
				$result = '开户数量已超出限额,你当前的限额是可开通'.$quota.'个商户,现已开通'.$count.'个商户.如需增加请联系总后台管理员.';
				return $result;
			}
		}
		$result = $this->where(['id' => $id])->save($data);
		M('User')->where(['company_id'=>$id])->save($data);
		return $result?'更新成功':'已经是当前状态';
	}
}


?>