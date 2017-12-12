<?php
namespace Admin\Model;

use Think\Model;

class TemplateModel extends Model
{
	public function templateAdd()
	{
		$data = I('post.');
		if($_FILES['template_logo']['size'] != 0)
		{
			$path = fileUpload('/Uploads/GoodsBrand/', 'template_logo');

			if (isset($path['error_msg'])) {
				$this->error = $path['error_msg'];return false;
			}
			$data['template_logo'] = $path;
			$result = $this->add($data);
			if (!$result) 
			{
				$this->error = '上传失败';return false;
			}
			return $result;
		}else{
			$this->error = '请上传模版封面';
			return false;
		}
	}

	public function showTemplateList()
	{
		$list = $this->field('id, template_name, template_logo, template_path')->select();
		return $list;
	}

	public function ajaxControl()
	{
		$flag = I('get.flag');
		switch ($flag) 
		{
			case 'selTemplateInfo':
				$result = $this->selTemplateInfo();
				break;
			case 'delTemplate':
				$result = $this->delTemplate();
				break;
		}
		return $result;
	}

	public function selTemplateInfo()
	{
		$id = I('get.id');
		$result = $this->field('id, template_name, template_type, template_logo, template_path')->where(['id' => $id])->select()[0];
		return $result;
	}

	public function delTemplate()
	{
		$id = I('get.id');
		$logoPath = $this->where(['id' => $id])->getField('template_logo');
		$result = $this->where(['id' => $id])->delete();
		if ($result) 
		{
			unlink('./Public'.$logoPath);
			return $result;
		}else{
			return false;
		}
	}

	public function templateUpdate()
	{
		$id = I('get.id');
		$data = I('post.');
		$poster = D('poster');
		if ($_FILES['template_logo']['size'] != 0) 
		{
			$logoPath = $poster->picUpload('/Uploads/cardimg/');
			if ($logoPath) 
			{
				$oldLogoPath = $this->where(['id' => $id])->getField('template_logo');
				unlink('./Public'.$oldLogoPath);
				$data['template_logo'] = $logoPath[0];
			}else{
				$this->error = $poster->getError();
				return false;
			}
		}
		$result = $this->where(['id' => $id])->save($data);
		if ($result) 
		{
			return $result;
		}else{
			$this->error = '修改信息失败';
			return false;
		}
	}

	public function getCompanyTemplate()
	{
		$uid = $_SESSION['companyInfo']['id'];
		$templateId = M('Company')->where(['uid' => $uid])->getField('template_id');
		return $templateId;
	}

	public function templateChange()
	{
		$uid = $_SESSION['companyInfo']['id'];
		$data = I('post.');
		$result = M('Company')->where(['uid' => $uid])->save($data);
		return $result;
	}
}