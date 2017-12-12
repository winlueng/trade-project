<?php 
namespace Admin\Controller;

use Think\Controller;

/**
 * 商户控制器
 */
class CompanyController extends CommonController
{
	private $companyObj;

	public function __construct()
	{
		parent::__construct();
		$this->companyObj = D('Company');
		$address = D('Card')->getAddress();
		$this->assign('address', $address);
	}

	/**
	 * 进行ajax操作
	 */
	public function ajaxControl()
	{
		$res = $this->companyObj->ajaxControl();
		$this->ajaxReturn($res);
	}

	// 添加商户进驻
	public function companyAdd()
	{
		if (IS_POST) {
			$result = $this->companyObj->companyAdd();
			if ($result) {
				$this->success('创建成功');exit;
			}else{
				$this->error($this->companyObj->getError());exit;
			}
		}else{
			$regionList = D('Region')->getRegionList();
			$this->assign('region',$regionList);
			$this->display();
		}
	}

	/**
	 * [companyInfo 公司简介更新和查看]
	 */
	public function companyInfo()
	{
		if (IS_POST) 
		{
			$res = $this->companyObj->saveNewsInfo();
			if ($res) 
			{
				$this->success('更新成功');
			}else{
				$this->error('更新失败');
			}
		}
	}

	public function companyList()
	{
		$company = $this->companyObj->showCompanyList(['in', '0,1']);
		// dump($company);exit;
		$this->assign('list', $company['company']);
		$this->assign('page', $company['page']);
		$this->assign('templateList', $company['templateList']);
		$this->display();
	}

	public function companyPictureInfo()
	{
		$where['company_id'] = $this->userInfo['company_id'];
		$result = M('CompanyPicture')->field('business_license,person_code,company_bgpic,company_code,company_logo')->where($where)->find();
		$this->assign('info', $result);
		$this->display();
	}

	public function companyPictureAdd()
	{
		$result = $this->companyObj->companyPictureAdd();
		if ($result) 
		{
			$this->success('添加成功');exit;
		}else{
			$this->error(D('Company')->getError());exit;
		}
	}

	public function featureCompanyList()
	{
		$company = $this->companyObj->showCompanyList('1');
		$this->assign('list', $company['company']);
		$this->assign('page', $company['page']);
		$this->display();
	}

	public function companyInfoUpdate()
	{
		if (IS_POST) 
		{
			$res = $this->companyObj->companyInfoUpdate();
			if ($res) 
			{
				$this->success('更新成功,一小时后生效');
			}else{
				$this->error($this->companyObj->getError());
			}
		}
	}

	public function companyInfoComplete()
	{
		if (IS_POST) 
		{
			$result = $this->companyObj->companyInfoSave();
			if ($result) 
			{
				$this->success('保存成功,资料将在一小时后生成');exit;
			}else{
				$this->error($this->companyObj->getError());exit;
			}
		}else{
			// dump($this->userInfo);exit;
			$companyInfo = $this->companyObj->selCurrentCompanyInfo();
			$newsInfo 	 = $this->companyObj->companyNewsInfo();
			$this->assign('newsInfo',$newsInfo);
			$this->assign('info', $companyInfo);
			$this->display();
		}
	}
}

?>