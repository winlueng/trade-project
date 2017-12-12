<?php 
namespace Admin\Controller;

use Think\Controller;

class PosterController extends CommonController
{
	private $posterObj;
	private $posterClassifyObj;

	public function __construct()
	{
		parent::__construct();
		$this->posterobj = D('Poster');
		$this->posterClassifyObj = D('Postertype');
	}

	/**
	 * 广告分类位置定义
	 * @return bool
	 */
	public function posterType()
	{
		if (IS_POST) 
		{	
			// 自动验证和字段映射
			$res = $this->posterClassifyObj->typeAdd();
			if ($res) 
			{
				$this->success('添加成功');exit;
			}
			
			$this->error($this->posterClassifyObj->getError());exit;
		}

		$arr = $this->posterClassifyObj->typeList();
		$this->assign('page',$arr['page']);
		$this->assign('list',$arr['list']);
		$this->assign('templateList',$arr['templateList']);
		$this->display();
	}

	public function posterTypeUpdate()
	{
		if (IS_POST) 
		{
			$res = $this->posterClassifyObj->posterTypeUpdate();
			if ($res) 
			{
				$this->success('修改成功');exit;
			}
			
			$this->error($this->posterClassifyObj->getError());exit;
		}
	}

	/**
	 * [posterUpdate 广告更新]
	 */
	public function posterUpdate()
	{
		if (IS_POST) 
		{
			$res = $this->posterobj->posterUpdate();
			if ($res) 
			{
				$this->success('修改成功');
			}else{
				$this->error('修改有误');
			}
		}else{
			$list = $this->posterobj->selPoster();
			$this->assign('type',$list['type']);
			$this->assign('poster',$list['list']);
			$this->display();
		}
	}

	/**
	 * 添加行业广告
	 * @return bool
	 */
	public function marketPosterAdd()
	{
		if(IS_POST)
		{
			$res = $this->posterobj->posterAdd(1);
			if ($res) 
			{
				$this->success('添加成功');exit;
			}else{
				$this->error($this->posterobj->getError());exit;
			}
		}else{
			$list = $this->posterobj->showList(1);
			$templateId = M('Project')->where(['id' => $_SESSION['marketInfo']['relevance_id']])->getField('template_id');
			$typeList = $this->posterClassifyObj->where(['template_id' => $templateId])->select();
			$this->assign('typelist', $typeList);
			$this->assign('list',$list['list']);
			$this->assign('page',$list['page']);
			$this->display();exit;
		}
	}

	/**
	 * ajax搜索
	 * @return json 返回json格式的数组
	 */
	public function ajaxControl()
	{
		$res = $this->posterobj->ajaxControl();
		$this->ajaxReturn($res);
	}

	public function companyPosterAdd()
	{
		if (IS_POST) 
		{
			$res = $this->posterobj->posterAdd(4);
			if ($res) 
			{
				$this->success('添加成功');exit;
			}else{
				$this->error($this->posterobj->getError());exit;
			}
		}else{
			$list = $this->posterobj->showList(4);
			$templateId = M('Company')->where(['id' => $this->userInfo['company_id']])->getField('template_id');
			$typeList = $this->posterClassifyObj->where(['template_id' => $templateId])->select();
			$this->assign('list',$list['list']);
			$this->assign('typeList', $typeList);
			$this->assign('page',$list['page']);
			$this->display();
		}
	}

	/**
	 * 添加普通位置广告
	 * @return bool
	 */
	public function cardCompanyPosterAdd()
	{
		if(IS_POST)
		{
			if ($this->posterobj->create()) 
			{	
				$res = $this->posterobj->posterAdd('company');
				if ($res) 
				{
					$this->success('添加成功');exit;
				}else{
					$this->error('添加有误');exit;
				}
			}else{
				$this->error($this->posterobj->getError());exit;
			}
		}else{
			$list = $this->posterobj->showList(1);
			$address = D('Card')->getAddress();
			$this->assign('address',$address);
			if ($list['news']) 
			{
				$this->assign('news',$list['news']);
			}else{
				$this->assign('list',$list['list']);
				$this->assign('page',$list['page']);
			}
			$this->display();
		}
	}
}
 ?>