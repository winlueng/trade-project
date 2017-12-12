<?php 
namespace Template00002\Model;

use Think\Model;

class IndexModel extends CommonModel
{
	protected $autoCheckFields = false;

	public function __construct()
	{
		parent::__construct();
	}

	/*public function selIndexPoster()
	{
		$posterList['top'] = $this->selPoster(C('POSTER_TOP'));//首页头部位置广告
		$posterList['foot'] = $this->selPoster(C('POSTER_FOOT'));//首页尾部位置广告
		return $posterList;
	}

	public function selPoster($correlation_id,$typeid=4)
	{
		// poster_type广告位置(1=>默认官网首页,2=>区域广告,3=>行业广告,4=>店铺微官网广告)
		$where = array(
				array('website_id' => $this->companyInfo['id']),
				array('poster_type'  => $typeid),
				array('correlation_id' => $correlation_id),
				array('start_time'   => array('lt',time())),
				array('end_time'     => array('gt',time())),
				array('status'       =>0)
			);

		$list = M('Poster')->field('id,poster_pic,poster_url,poster_title')->where($where)->select();
		return $list;
	}*/

	public function selHotGoods()
	{
		// dump($this->companyInfo);exit;
		$result = M('Goods')->where(['company_id' => $this->companyInfo['id'],'status' => 2])
				->limit(8)
				->select();
		$result = array_chunk($result, 4);
		return $result;
	}

	// 统计用的ajax操作
	public function ajaxControl()
	{
		$flag = I('get.flag');
		switch ($flag) {
			case 'indexButtonClickStatistics':
				$this->indexButtonClickStatistics();
				break;
			case 'otherVisitStatistics':
				$result = $this->otherVisitStatistics();
				break;
		}
		return $result;
	}

	// 计算主页按钮点击次数
	protected function indexButtonClickStatistics()
	{
		$obj  = M('ButtonClickStatistics');

		$where = array(
			'company_id' => $this->companyInfo['id'],
			'date'	  => strtotime('today'),
			'button_type' => I('get.button')
		);

		$find = $obj->where($where)->find();

		if (!$find) 
		{
			return $obj->data($where)->add();
		}else{
			return $obj->where($where)->setInc("click_total",1);
		}
	}

	protected function otherVisitStatistics()
	{
		$type = I('get.type');
		$id = I('get.id');
		if ($type == 'poster') 
		{
			if (!S('poster_statis_'. $id .'_by_'.$this->ip)) {

				$date = strtotime('today');

				$prefix = 'B_statis_poster_visit_'.$date; // 统计前缀redis hash操作

				$name = $id.'_visit';
				
				if ($this->redis->hExists($prefix, $name)) 
				{
					$result = $this->redis->hIncrBy($prefix, $name, 1);
				}else{
					$result = $this->redis->hSet($prefix, $name, 1);
				}

				S('poster_statis_'. $id .'_by_'.$this->ip, '1', 86400);
			}	
		}
	}
}


 ?>