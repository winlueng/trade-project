<?php 
namespace PT2\Model;

use Think\Model;

class IndexModel extends CommonModel
{
	protected $autoCheckFields = false;

	public function __construct()
	{
		parent::__construct();
	}

	public function bannerList()
	{
		$where = [
			'status' => ['not in', '-1,1'],
			'project_id' => $this->pInfo['id'],
		];

		$list = M('ProjectBanner')->field('id,banner_pic,banner_url,banner_type,banner_title')->where($where)->select();
		foreach ($list as $v) {
			$res[$v['banner_type']][] = $v;
		}
		return $res;
	}

	// 置顶商品
	public function showStickGoods()
	{
		$where = [
			'relevance_id' 	=> $this->pInfo['id'],
			'start_time'	=> ['lt', time()],
			'end_time'	=> ['gt', time()],
			'status'	=> 1,
		];
		$field = 'id, goods_logo, goods_name, is_discount, promotion_price, price, discount, sales_start_time, sales_end_time';

		for ($i=1; $i < 4; $i++) { 
			$where['stick_classify'] = $i;
			$idList = M('GoodsStick')->where($where)->getField('goods_id', true);
			if ($idList) {
				$list = M('Goods')->field($field)->where(['id' => ['in', implode(',', $idList)], 'status' => ['not in', '-1,3']])->select();
				foreach ($list as $v) {
					$v['salesTotal'] = M('GoodsSalesVolume')->where(['goods_id' => $v['id']])->sum('sales_total');
					$v['link']		 = $this->handleGoodsLink($v['id']);
					$res[$i][] = $v;
				}
			}else{
				$res[$i]=[];
			}
		}
		return $res;
	}


	// 统计用的ajax操作
	public function ajaxControl()
	{
		$flag = I('get.flag');
		return $this->$flag();
	}

	// 计算主页按钮点击次数
	protected function indexButtonClickStatistics()
	{
		$obj  = M('ButtonClickStatistics');
		$where = array(
			'company_id' => 0,
			'date'	  => strtotime('today'),
			'button_type' => I('get.buttonType'),
			'relevance_id' => $this->pInfo['id'],
		);

		$find = $obj->where($where)->find();

		if (!$find) 
		{
			return $obj->data($where)->add();
		}else{
			return $obj->where($where)->setInc("click_total",1);
		}
	}

	public function topNewsList()
	{
		$where = [
			'relevance_id' 	=> $this->pInfo['id'],
			'company_id' 	=> 0,
			'status' 		=> 0,
			'is_top'		=> 1,
		];
		$list = M('News')->field('id, news_logo, news_name, title, video, is_video')
				->where($where)
				->order('addtime desc')
				->limit(6)
				->select();
		foreach ($list as $v) {
			$v['news_logo'] 	= json_decode($v['news_logo'], true);
			$result[] = $v;
 		}
		return $result;
	}

	protected function bannerStatistics()
	{
		$this->saveStatis('ProjectBannerStatistics', I('get.id'));
	}
}


 ?>