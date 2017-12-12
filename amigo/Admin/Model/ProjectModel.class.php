<?php
namespace Admin\Model;

use Think\Model;

class ProjectModel extends CommonModel
{
	protected $_validate = array(     
			array('project_name', 'require', '请填写项目名称'),
			array('principal', 'require', '请填写项目联系人'),
			array('phone', 'require', '请填写项目联系人手机号码'),
			array('phone','mobile','手机格式不正确'), // 在新增的时候验证name字段是否唯一     
			array('email', 'require', '请填写项目联系人邮箱'),
			array('email', 'email', '邮箱格式不正确', 2, 'regex'),
			array('address_info', 'require', '请填写项目详细地址'),
			array('address_id', 'require', '请选择项目详细地址'),
			array('agreement_number', 'require', '请填写项目协议编号'),
			array('project_link', 'require', '请填写项目域名'),
			array('category_id', 'require', '请填写项目所属分类'),
			array('agreement_number', 'require', '请填写项目协议编号'),
			array('start_time', 'require', '请填写项目开始时间'),
			array('end_time', 'require', '请填写项目结束时间'),
			array('company_quota', 'require', '请填写商户开通限额'),
		);

	protected $_auto = array(
			array('start_time', 'strtotime', 3, 'function'),
			array('end_time', 'strtotime', 3, 'function'),
			array('addtime', 'time', 3, 'function'),
			array('control_time', 'time', 3, 'function'),
		);

	// 项目列表
	public function selProjectList($flag = 0)
	{
		$where['status'] = $flag;

		$companyObj = M('Company');

		$field = 'id, project_name, category_id, address_id, address_info, principal, phone, email,status,control_time,addtime,company_quota';
		if (I('get.selname') || I('get.category_id')) 
		{
			$where['project_name'] = ['like', '%'.I('get.selname').'%'];
			$where['category_id'] = I('get.category_id');
		}
		$count = $this->where($where)->count();

		$page = new \Think\Page($count, 8);

		$list = $this->field($field)->where($where)->order('addtime desc')->limit($page->firstRow.','.$page->listRows)->select();

		$dueTime = strtotime('-1 month');

		foreach ($list as $v) 
		{
			$v['address'] = findRegionInfo($v['address_id'], 'District', 'name', 'district_id');

			$idList = $companyObj->where(['relevance_id' => $v['id']])->getField('id', true);

			if ($idList) 
			{
				$condition = ['in', implode(',', $idList)];
				$v['exist'] = M('User')->where(['id' => $condition, 'status' => 0])->count();
				$v['leave'] = M('User')->where(['id' => $condition, 'status' => 1,'control_time'=>['gt', $dueTime]])->count();
			}else{
				$v['exist'] = 0;
				$v['leave'] = 0;
			}
			$v['category_name'] = M('Category')->where(['id' => $v['category_id']])->getField('category_name');
			$newList[] = $v;

		}

		$result['page'] = $page->show();
		$result['list'] = $newList;
		return $result;
	}

	// 项目添加
	public function projectInfoAdd()
	{
		if ($data = $this->create()) 
		{
			if ($_FILES['identity_card_front']['size'] && $_FILES['identity_card_rear']['size'] && $_FILES['business_license']['size']) 
			{
				$identity_card_front = fileUpload('/Uploads/ProjectImg/', 'identity_card_front');

				if (isset($identity_card_front['error_msg'])) {
					$this->error = $identity_card_front['error_msg'];return false;
				}

				$identity_card_rear = fileUpload('/Uploads/ProjectImg/', 'identity_card_rear');

				if (isset($identity_card_rear['error_msg'])) {
					$this->error = $identity_card_rear['error_msg'];return false;
				}

				$business_license = fileUpload('/Uploads/ProjectImg/', 'business_license');

				if (isset($business_license['error_msg'])) {
					$this->error = $business_license['error_msg'];return false;
				}
				
				$data['identity_card_front'] = $identity_card_front;
				$data['identity_card_rear']  = $identity_card_rear;
				$data['business_license']    = $business_license;
				// $data['project_second_link'] = implode(';', I('post.project_second_link'));
				$data['template_id']  = M('TemplateChange')->where(['status' => 0, 'template_type' => 1])->getField('id');
				$data['sx_data_base'] = $data['agreement_number'].'_base';
				$result = $this->add($data);
			// dump($data);exit;

				if (!$result) 
				{
					$this->error = '添加项目失败';return false;
				}
				
				M('WriteInfo')->add(['relevance_id' => $result]);

				$str = "project.name = ". $data['sx_data_base'] ."
project.default_charset = utf-8
server.index  = 8383
server.search = 8384
[id]
type = id

[goods_name]
type = title
tokenizer = default

[price]
type = numeric

[promotion_price]
type = numeric

[company_id]
index = self
tokenizer = full

[addtime]
type = numeric

[goods_logo]";

				$file = file_put_contents('./ThinkPHP/Library/Vendor/XSsdk/php/app/'.$data['sx_data_base'].'.ini', $str);
				chmod('./ThinkPHP/Library/Vendor/XSsdk/php/app/'.$data['sx_data_base'].'.ini', 0777);
				return $result;
			}else{
				$this->error = '请完善上传身份证正反面和营业执照资料';return false;
			}
		}else{
			return false;
		}
	}


	public function ajaxControl()
	{
		$flag = I('get.flag');
		switch ($flag) {
			case 'selProjectInfo':
				$result = $this->selProjectInfo();//查看项目详细信息
				break;
			case 'categoryDel':
				$result = $this->categoryDel();
				break;
			case 'selCategoryInfo':
				$result = $this->selCategoryInfo();
				break;
			case 'passOrRefuse':
				$result = $this->passOrRefuse();
				break;
			case 'selProject':
				$result = $this->selProject();
				break;
		}
		return $result;
	}
	
	// 查看项目详细信息
	protected function selProjectInfo()
	{
		$result = $this->where(['id' =>I('get.id')])->find();

		$result['address'] = findRegionInfo($result['address_id'], 'district', 'name', 'district_id');

		$result['category_name'] = M('Category')->where(['id' => $result['category_id']])->getField('category_name');

		return $result;
	}

	// 项目分类删除
	protected function categoryDel()
	{
		$where['id'] = I('get.id');
		$count = $this->where(['category_id' => I('get.id')])->count();
		if ($count > 0) 
		{
			return '此分类下还存在项目,不能删除';
		}else{
			$result = M('Category')->where($where)->save(['status' => '-1']);
			if ($result) 
			{
				return '删除成功';
			}else{
				return '删除失败';
			}
		}
	}

	// 查询分类详细信息
	protected function selCategoryInfo()
	{
		return M('Category')->where(['id' => I('get.id')])->find();
	}

	// 拒绝跟同过项目审核
	public function passOrRefuse()
	{
		$where['id'] = I('get.id');
		$data['control_time'] = time();
		$data['status'] = I('get.status');
		$result = $this->where($where)->save($data);
		if ($result) 
		{
			if (!$data['status']) 
			{
				$newData = $this->field('address_id,address_info')->where($where)->select()[0];
				$newData['relevance_id'] = I('get.id');
				M('write_info')->add($newData);
			}
			$news = $data['status']==0?'通过成功':'已拒绝';
			return $news;
		}else{
			return '操作失败';
		}

	}	

	// ajax搜索地址和分类下项目信息
	protected function selProject()
	{
		if (I('get.category_id') && I('get.address_id')) 
		{
			$where['category_id'] = I('get.category_id');
			$where['address_id'] = I('get.address_id');
			$result = $this->field('id, project_name')->where($where)->select();
			if (!$result) 
			{
				return '暂无搜索信息';
			}
			return $result;
		}else{	
			return '请选择好项目分类和地址!';
		}
	}

}