<?php 
namespace PT1\Model;

use Think\Model;

class IndexModel extends Model
{
	protected $autoCheckFields = false;

	private $ip;

	private $projectId;

	private $redis;

	public function __construct()
	{
		parent::__construct();
		$this->ip = get_client_ip();
		$this->projectId = $_SESSION['projectInfo']['id'];
		$this->redis = new \Redis();
		$this->redis->connect('127.0.0.1', 6379);
	}

	public function selIndexPoster($top, $foot)
	{
		$posterList['top'] = $this->selPoster($top,1);//首页头部位置广告
		$posterList['foot'] = $this->selPoster($foot,1);//首页尾部位置广告
		return $posterList;
	}

	// 广告列表
	public function selPoster($correlation_id,$typeid=0)
	{
		// poster_type广告位置(1=>默认官网首页,2=>区域广告,3=>行业广告,4=>店铺微官网广告)
		$where = array(
				array('relevance_id' => $this->projectId),
				array('poster_type'  => $typeid),
				array('correlation_id'  => $correlation_id),
				array('start_time'   => array('lt',time())),
				array('end_time'     => array('gt',time())),
				array('status'       =>0)
			);

		$list = M('Poster')->field('id,poster_pic,poster_url,poster_title')->where($where)->select();
		return $list;
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
				$this->otherVisitStatistics();
				break;
			case 'showGoodsFromClassify'://通过classify分类id搜索项目下推荐的商品
				$result = $this->showGoodsFromClassify();
				break;
			case 'showFeatureShop'://搜索对应区域和行业的店铺列表
				$result = $this->showFeatureShop();
				break;
			case 'indexTypeClickStatistics':
				$this->indexTypeClickStatistics();
				break;
		}
		return $result;
	}

	// 计算主页按钮点击次数
	protected function indexButtonClickStatistics()
	{
		$date = strtotime('today');

		$prefix = 'B_statis_project_index_button_click_'.$date; // 统计前缀redis hash操作

		$name = $this->projectId.'_project_'. I('get.buttonType') .'_visit';
		
		if ($this->redis->hExists($prefix, $name)) 
		{
			$result = $this->redis->hIncrBy($prefix, $name, 1);
		}else{
			$result = $this->redis->hSet($prefix, $name, 1);
		}
		// return $result;
	}

	// 商品点击统计
	protected function otherVisitStatistics()
	{
		$type = I('get.type');
		$id = I('get.id');
		
		if (!S($type.'_statis_by_id_'.$id.'_with_'.$this->ip)) {
			
			$date = strtotime('today');

			$prefix = 'B_statis_poster_visit_'.$date; // 统计前缀redis hash操作

			$name = $id.'_visit';
			
			if ($this->redis->hExists($prefix, $name)) 
			{
				$result = $this->redis->hIncrBy($prefix, $name, 1);
			}else{
				$result = $this->redis->hSet($prefix, $name, 1);
			}

			S($type.'_statis_by_id_'.$id.'_with_'.$this->ip, '1', 86400);
			return $result;
		}
		// return $result;
	}

	// 通过项目分类id查找置顶商品
	public function showGoodsFromClassify($classifyId = '')
	{
		$company = M('company');

		$template = M('template_change');

		$goods = M('Goods');

		$where['market_classify_id'] = $classifyId;

		if (I('get.market_classify_id')) 
		{
			$where['market_classify_id'] = I('get.market_classify_id');
		}

		$where['relevance_id'] = $this->projectId;

		$where['goods_type'] = 2;
		
		$where['sales_end_time'] = ['gt', time()];

		$list = $goods->field('id, goods_logo, company_id, price, goods_name')->where($where)->limit(5)->order('control_time desc')->/*cache(true,3600)->*/select();

		foreach ($list as $v) 
		{	
			$sql = '';
			$sql = "SELECT t.template_path, c.web_postfix FROM market_template_change as t, market_company as c WHERE c.id=". $v['company_id'] ." AND t.id=c.template_id";
			$info = $goods->query($sql)[0];
			$v['web_link'] = 'http://'.$_SERVER['HTTP_HOST'].'/'. $info['template_path'] .'/Goods/goodsDetail/id/'.$v['id'].'/companyName/'.$info['web_postfix'];
			$result[] = $v;
		}

		return $result;
	}

	// 项目分类别表
	public function showClassifyList()
	{
		$classify = M('goods_classify');
		$where['category_id'] = $_SESSION['projectInfo']['category_id'];
		$where['relevance_id'] = $this->projectId;
		$list = $classify->field('id, classify_name')->where($where)->order('control_time desc')->select();
		return $list;
	}

	// 推荐店铺列表
	public function showFeatureShop($region='', $business='', $flag=false)
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
		}else if($region && $business){
			$where['region_id']   = $region;
			$where['business_id'] = $business;
		}

		$company = M('Company');

		$companyPic = M('company_picture');

		$where['category_id'] = $_SESSION['projectInfo']['category_id'];

		$where['relevance_id'] = $this->projectId;

		$where['status'] = 0;

		$where['end_time']     = ['gt', time()];

		if ($flag) 
		{
			$where['company_type'] = 1;
			$list = $company->field('id, company_name, region_id, address_info, web_postfix')->where($where)->limit(4)->order('control_time desc')->select();
		}else{
			$list = $company->field('id, company_name, region_id, address_info, web_postfix')->where($where)->order('control_time desc')->select();
		}

		foreach ($list as $v) 
		{
			// $v['address'] = findRegionInfo($v['region_id'], 'Region', 'region_name').$v['address_info'];
			$data  = $companyPic->field('company_bgpic,company_logo')->where(['company_id' => $v['id']])->select()[0];
			$v['bgpic']   = $data['company_bgpic'];
			$v['company_logo']   = $data['company_logo'];
			$result[] = $v;
		}
		return $result;
	}

	// 项目正在办的活动列表
	public function showActivityList()
	{
		$activity = M('Activity');

		$where = array(
			'relevance_id' 		=> $this->projectId ,
			'category_id'  		=> $_SESSION['projectInfo']['category_id'],
			array('start_time'  => array('lt',time()) ),
			array('end_time'    => array('gt',time()) ),
			'status'       		=> 0 ,
			'activity_type'     => 2 ,//联盟活动
		);

		$result = $activity->field('id, start_time, end_time, activity_name, activity_cover, activity_link')->where($where)->select();

		return $result;
	}

	// 首页顶部推荐动态文章列表
	public function showNewsList()
	{
		$news = M('News');

		$where = array(
			array('relevance_id' 		=> $this->projectId ),
			array('status'       		=> 0 ),
			array('stick'       		=> 1 ),//联盟活动
			array('set_end_time'        => ['gt', time()]),//联盟活动
		);

		$result = $news->field('id, news_logo, title')->where($where)->select();

		return $result;
	}

	public function topNewsList()
	{
		$company = M('company');

		$template = M('template_change');
		$where = array(
				'relevance_id' 		=> $this->projectId ,
				'stick'				=> 1,
				array('set_end_time'=> array('gt',time()) ),
				'status'			=> 0,
				'is_top'			=> 0,
			);
		$news = M('News');

		$list = $news->field('id, company_id, news_logo, news_name')->where($where)->select();

		foreach ($list as $v) 
		{
			$sql = '';
			$sql = "SELECT t.template_path, c.web_postfix FROM market_template_change as t, market_company as c WHERE c.id=". $v['company_id'] ." AND t.id=c.template_id";

			$info = $news->query($sql)[0];

			$v['web_link'] = 'http://'.$_SERVER['HTTP_HOST'].'/'. $info['template_path'] .'/News/newsDetail/id/'.$v['id'].'/companyName/'.$info['web_postfix'];

			$result[] = $v;
		}

		return $result;
	}

	protected function indexTypeClickStatistics()
	{
		$date = strtotime('today');

		$prefix = 'B_statis_index_type_click_'.$date; // 统计前缀redis hash操作

		$name = $this->projectId.'_project_'. I('get.statistics_type') .'_visit';
		
		if ($this->redis->hExists($prefix, $name)) 
		{
			$result = $this->redis->hIncrBy($prefix, $name, 1);
		}else{
			$result = $this->redis->hSet($prefix, $name, 1);
		}
		
	}
}


 ?>