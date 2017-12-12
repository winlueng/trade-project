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
		$field = 'id, goods_logo, goods_name, is_promotion, promotion_price, price, discount';
		$list = M('Goods')
				->field($field)
		        ->where([
					'company_id' => $this->companyInfo['id'],
					'status' => '2'
				])->limit(4)
				->select();
		foreach ($list as $v) {
			$v['salesTotal'] = M('GoodsSalesVolume')->where(['goods_id' => $v['id']])->sum('sales_total');
			$v['link']		 = $this->handleGoodsLink($v['id']);
			$result[] = $v;
		}
		return $result;
	}

	public function selNewGoods()
	{
		$field = 'id, goods_logo, goods_name, is_promotion, promotion_price, price, discount';
		$list = M('Goods')
				->field($field)
		        ->where([
					'company_id' => $this->companyInfo['id'],
					'status' => '4'
				])->limit(4)
				->select();
		foreach ($list as $v) {
			$v['salesTotal'] = M('GoodsSalesVolume')->where(['goods_id' => $v['id']])->sum('sales_total');
			$v['link']		 = $this->handleGoodsLink($v['id']);
			$result[] = $v;
		}
		return $result;
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

	public function topNewsList()
	{
		$where = [
			'relevance_id' 	=> $this->companyInfo['relevance_id'],
			'company_id' 	=> $this->companyInfo['id'],
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