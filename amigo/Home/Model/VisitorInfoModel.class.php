<?php
namespace Home\Model;

use Think\Model;

/**
 * 个人中心分类
 */
class VisitorInfoModel extends Model
{
	protected $autoCheckFields = false;

	private   $redis;

	private   $visitorId;// 用户id

	public function __construct()
	{
		parent::__construct();

		$redis = new \Redis();

        $redis->connect('127.0.0.1',6379); 

		$this->redis = $redis; 

		$this->visitorId = $_SESSION['visitorInfo']['id'];
	}

	public function myCenter()
	{
		$info = M('visitor_info')->field('nick_name,head_thumbnail,head_portrait')->where(['visitor_id' => $this->visitorId])->select()[0];
        if ($info['head_thumbnail']) {
            $_SESSION['visitorInfo']['head_portrait'] = $info['head_thumbnail'];
        }else{
            $_SESSION['visitorInfo']['head_portrait'] = $info['head_portrait'];
        }
        $_SESSION['visitorInfo']['nick_name'] = $info['nick_name'];
	}

	// 获取当前帐号的个人信息
	public function selMyCenterInfo()
	{
		$result = M('visitor_info')->field('nick_name, sex, city, head_thumbnail, visitor_birthday, real_name, constellation, visitor_title')->where(['visitor_id' => $this->visitorId])->select()[0];
		if ($result['city']) 
		{
			$result['address'] = findRegionInfo($result['city'], 'District', 'name', 'district_id');
		}
		$result['phone'] = M('wechat_visitor')->where(['id' => $this->visitorId])->getField('phone');

		return $result;
	}

	// 用户信息更新
	public function myCenterInfoUpdate()
	{
		// 数据验证
		$rules = array(
			array('nick_name', 'require', '请填写昵称'),
			array('sex', 'require', '请选择性别'),
			array('city', 'require', '请填写城市'),
		);

		$auto = array(
			array('visitor_birthday','strtotime',3,'function'),
		);

		if ($data = $this->validate($rules)->auto($auto)->create()) 
		{
			if ($_FILES['head_portrait']['size']) 
			{
				$oldHeadPath = M('visitor_info')->field('head_thumbnail,head_portrait')->where(['visitor_id' => $this->visitorId])->select()[0];

				$path = substr($oldHeadPath['head_portrait'],strripos($oldHeadPath['head_portrait'],'/',-44));
				$thumbPath = substr($oldHeadPath['head_thumbnail'],strripos($oldHeadPath['head_thumbnail'],'/',-57));
				unlink('./Public'.$path);
				unlink('./Public'.$thumbPath);

				$uploadPath = fileUpload('/Uploads/userHeadPortrait/', 'one', 'head_portrait');

				if (!$uploadPath['error_msg']) 
				{
					$this->error = $uploadPath['error_msg'];return false;
				}

				$image = new \Think\Image(); // 实例化图片处理类
				$path  = './Public'.$uploadPath;
				$thumbnail = explode('.', $path)[1];
				$image->open($path);
				$mime = explode('/', $image->mime())[1]; 
				$day = date('Ymd',strtotime('Today'));
				$savePath = '.'.$thumbnail.'_thumbnail.'.$mime;
				$image->thumb(150, 150)->save($savePath);// 保存缩略图
				$data['head_thumbnail'] = 'http://'.$_SERVER['HTTP_HOST'].$thumbnail.'_thumbnail.'.$mime;
				$data['head_portrait'] = 'http://'.$_SERVER['HTTP_HOST'].$path;
				$_SESSION['visitorInfo']['head_portrait'] = $data['head_thumbnail'];
			}

			if (count(explode(',', $data['city'])) > 1) 
			{
				$data['city'] = (int)substr($data['city'],strripos($data['city'],',')+1);
			}

			list($year, $month, $day) = explode('-', date('Y-m-d', $data['visitor_birthday']));

			$data['constellation'] = constellationJudge($month, $day);

			$result = M('visitor_info')->where(['visitor_id' => $this->visitorId])->save($data);

			if (!$result) 
			{
				$this->error = '保存信息失败';return false;
			}


			return $result;
		}else{
			return false;
		}
	}

	// 收藏店铺列表
	public function showSaveCompanyList()
	{
		$collectList = M('visitor_collect')->where(['visitor_id' => $this->visitorId])->getField('company_collect');

		if (!$collectList) 
		{
			return '';
		}

		$where = array(
				'uid' => ['in', $collectList],
			);

		$count = count(explode(',', $collectList));

		$page = new \Think\Page($count,10);

		$companyList = M('company')->field('uid, company_pic, company_name, company_link')->where($where)->limit($page->firstRow.','.$page->listRows)->select();

		$companyStats = M('statistics');

		foreach($companyList as $v)
		{
			$v['collect_total'] = $companyStats->where(['web_host' => $v['company_link']])->sum('visit_total');
			$result[] = $v;
		}

		return $result;
	}

	// 获取用户足迹数据
	public function getVisitorTrackData()
	{
		$visitObj = M('Visitor_track');
		// 处理超过一个月的足迹数据
		$visitObj->where(['visit_date' => ['lt', strtotime('last month')]])->delete();
		// 根据用户id获取一个月内的足迹数据
		$track = $visitObj->field('id_aggregate, visit_date')->where(['visitor_id' => $this->visitorId])->order('visit_date desc')->/*cache(true,120)->*/select();

		if ($track) 
		{
			$goods = M('Goods');
			foreach ($track as $v) 
			{
				$v['goodsList'] = $goods->field('id, goods_logo, goods_name, price, uid')->where(['id' => ['in', $v['id_aggregate']]])->order("field(id,". $v['id_aggregate'] .")")->select();
				foreach ($v['goodsList'] as $k => $vo) {
					$hostInfo = M('company')->field('company_link, template_id, company_name')->where(['uid' => $vo['uid']])->select()[0];
					$template = M('Template_change')->where(['id' => $hostInfo['template_id']])->getField('template_path');
					$v['goodsList'][$k]['link'] = 'http://'.$hostInfo['company_link'].'/'. $template .'/Goods/goodsDetail/id/'.$vo['id'];
					$v['goodsList'][$k]['company_link'] = $hostInfo['company_link'];
					$v['goodsList'][$k]['company_name'] = $hostInfo['company_name'];
					$v['goodsList'][$k]['company_name'] = M('goods_statistics')->where(['goods_id' => $vo['id']])->sum('click_total');
				}
				
				$result[] = $v;
			}

			return $result;

		}else{
			return $track;
		}
	}

	public function ajaxControl()
	{
		if (!$this->visitorId) 
		{
			return 0;
		}

		$flag = I('get.flag');
		switch ($flag) {
			case 'collectCompany'://收藏店铺
				$result = $this->collectCompany();
				break;
			case 'delCollectCompany'://取消收藏
				$result = $this->delCollectCompany();
				break;
			case 'showSaveCompanyList':
				$result = $this->showSaveCompanyList();
				break;
			case 'showRecommendGoodsList':// 推荐商品列表
				$result = $this->showRecommendGoodsList();
				break;
			case 'showRecommendCardList':// 推荐优惠列表
				$result = $this->showRecommendCardList();
				break;
			case 'splendidNews':// 精选动态
				$result = $this->splendidNews();
				break;
			case 'allNews':// 全部动态
				$result = $this->allNews();
				break;
			case 'getAddress':
				$result = saveAddressList();
				break;
		}
		return $result;
	}

	/**
	 * ajax收藏店铺
	 */
	protected function collectCompany()
	{
		$companyId = $_SESSION['companyLinkId'];

		

		// 查询用户收藏数据
		$list = M('visitor_collect')->field('company_collect, id')->where(['visitor_id' => $this->visitorId])->select()[0];
		$collectList = explode(',', $list['company_collect']);
		if (!$list['company_collect'] && !$list['id']) 
		{
			$result = M('visitor_collect')->add(['visitor_id' => $this->visitorId, 'company_collect' => $companyId]);
			return $result;
		}


		if (!in_array($companyId, $collectList)) 
		{
			$result = array_push($collectList, $companyId);
			if ($result) 
			{
				$data = implode(',', $collectList);
				$res = M('visitor_collect')->where(['visitor_id' => $this->visitorId])->save(['company_collect' => $data]);
				if ($res) 
				{
					// 商户redis记录
					$list    = $this->redis->get('todayCollectList');
					$delList = $this->redis->get('todayDelCollectList');// 取消收藏列表
					if (!$list) 
					{//加入今天店铺收藏列表
						$this->redis->set('todayCollectList', (string)$companyId);
					}else{
						$this->redis->append('todayCollectList', ','.(string)$companyId);
					}


					if (in_array($companyId, explode(',', $delList))) {// 如果存在今天的取消收藏列表,把他剔除
						$delList = array_diff(explode(',', $delList), array($companyId));
						$saveList = implode(',', $delList);
						if (count($delList) < 1) {
							$saveList = '';
						}
						$this->redis->set('todayDelCollectList', $saveList);
					}

					$visitorList = $this->redis->get('todayCollectVisitor_'.$companyId);
					if (!in_array($this->visitorId, explode(',', $visitorList))) {
						if ($visitorList) {
							$this->redis->append('todayCollectVisitor_'.$companyId, ','.(string)$this->visitorId);
						}else{
							$this->redis->set('todayCollectVisitor_'.$companyId, (string)$this->visitorId);
						}
					}

					$visitorDelList = $this->redis->get('todayDelCollectVisitor_'.$companyId);
				
					if ($visitorDelList) {
						$list = explode(',', $visitorDelList);
						if (in_array($this->visitorId, $list)) {
							$list = array_diff($list, array($this->visitorId));
							$save = implode(',', $list);
							$this->redis->set('todayDelCollectVisitor_'.$companyId, $save);
						}
					}
					// return $this->redis->get('todayCollectList');
					return true;
				}
				return '添加失败';
			}
			return '店铺id压入数组出现异常';
		}else{
			return '店铺已收藏';
		}

	}

	/**
	 * ajax取消收藏
	 */
	protected function delCollectCompany()
	{
		$companyId = $_SESSION['companyLinkId'];

		if (I('get.company_id')) {
			$companyId = I('get.company_id');
		}

		// 查询用户收藏数据
		$list = M('visitor_collect')->where(['visitor_id' => $this->visitorId])->getField('company_collect');

		$collectList = explode(',', $list);

		if (in_array($companyId, $collectList)) 
		{
			foreach ($collectList as $v) 
			{
				if ($v != $companyId) 
				{
					$res[] = $v;
				}
			}

			$data = implode(',', $res);

			$res = M('visitor_collect')->where(['visitor_id' => $this->visitorId])->save(['company_collect' => $data]);

			if ($res) 
			{
				// 商户redis记录
				$list    = $this->redis->get('todayCollectList');
				$delList = $this->redis->get('todayDelCollectList');// 取消收藏列表
				if (!$delList) 
				{//加入今天店铺收藏列表
					$this->redis->set('todayDelCollectList', (string)$companyId);
				}else{
					$this->redis->append('todayDelCollectList', ','.(string)$companyId);
				}

				if (in_array($companyId, explode(',', $list))) {// 如果存在今天的收藏列表,把他剔除
					$list = array_diff(explode(',', $list), array($companyId));
					$saveList = implode(',', $list);
					if (count($list) < 1) {
						$saveList = '';
					}
					$this->redis->set('todayCollectList', $saveList);
				}

				$visitorList = $this->redis->get('todayCollectVisitor_'.$companyId);
				
				if ($visitorList) {
					if (in_array($this->visitorId, explode(',', $visitorList))) {
						$list = array_diff(explode(',', $visitorList), array($this->visitorId));
						$save = implode(',', $list);
						$this->redis->set('todayCollectVisitor_'.$companyId, $save);
					}
				}

				$visitorDelList = $this->redis->get('todayDelCollectVisitor_'.$companyId);
				if (!in_array($this->visitorId, explode(',', $visitorDelList))) {
					if ($visitorDelList) {
						$this->redis->append('todayDelCollectVisitor_'.$companyId, ','.(string)$this->visitorId);
					}else{
						$this->redis->set('todayDelCollectVisitor_'.$companyId, (string)$this->visitorId);
					}
				}

				return true;
			}
			return '收藏店铺更新失败';
		}else{
			return '店铺未收藏';
		}
	}

	// 推荐商品列表
	public function showRecommendGoodsList()
	{
		$timeForNow = strtotime('-1 Sunday');

		// 查询用户收藏数据
		$list = M('visitor_collect')->where(['visitor_id' => $this->visitorId])->getField('company_collect');

		$companyList = explode(',', $list);

		// 查询redis数据库
		$recommendGoodsList = $this->redis->get('A_recommendGoodsList'.$timeForNow);
		// return json_decode($recommendGoodsList,true);
		$arr = json_decode($recommendGoodsList, true);

		// 过滤差集
		foreach ($arr as $k => $v) 
		{
			if (!in_array($v['company_id'], $companyList)) 
			{
				$status = M('user')->where(['id' => $v['company_id']])->getField('status');
				if (!$status) {
					$info = M('Goods')->field('goods_name,price,addtime,goods_logo,website_classify_id,status')->where(['id' => $v['goods_id']])->select()[0];
					$arr[$k]['goods_name'] = $info['goods_name'];
					$arr[$k]['price'] = $info['price'];
					$arr[$k]['addtime'] = $info['addtime'];
					$arr[$k]['goods_logo'] = $info['goods_logo'];
					$arr[$k]['website_classify_id'] = $info['website_classify_id'];
					$companyInfo = M('Company')->field('logo_path,company_name,company_link,template_id')->where(['uid' => $v['company_id']])->select()[0];
					$template    = M('template_change')->where(['id' => $companyInfo['template_id']])->getField('template_path');
					$arr[$k]['logo_path']    = $companyInfo['logo_path'];
					$arr[$k]['company_name'] = $companyInfo['company_name'];
					$arr[$k]['goods_link'] = 'http://'.$companyInfo['company_link'].'/'.$template.'/Goods/goodsDetail/id/'.$v['goods_id'];
					if (!$info) {
						unset($arr[$k]);
					}else{
						$recommendList[] = $arr[$k];
					}
				}
			}
		}

		// 模拟分页开始(10条数据一页)
		$count = count($recommendList);

		// 不够一页完整返回
		if ($count < 11) 
		{
			return $recommendList;
		}

		$page = 0;

		if (I('get.p')) 
		{
			$page = (int)I('get.p') -1;
		}

		$returnList = array_chunk($recommendList, 10);

		$result = $returnList[$page]?$returnList[$page]:false;

		return $result;
	}

	// 推荐优惠列表
	public function showRecommendCardList()
	{
		// 查询用户收藏数据
		$list = M('visitor_collect')->where(['visitor_id' => $this->visitorId])->getField('company_collect');

		$companyList = explode(',', $list);

		$where = array(
				'start_time' => ['lt', time()],
				'end_time'   => ['gt', time()],
				'status'     => 0,
				'card_type'  => 1,
			);

		$recommendcardList = M('card')->field('id,card_ip,addtime,start_time,end_time,card_name,card_desc,card_code,card_bgaddress,company_id,click_total')->where($where)->order('click_total desc')->select();

		// return $recommendcardList;

		// 过滤差集
		foreach ($recommendcardList as $k => $v) 
		{
			if (!in_array($v['company_id'], $companyList)) 
			{
				$status = M('user')->where(['id' => $v['company_id']])->getField('status');
				if (!$status) {
					$companyInfo = M('Company')->field('logo_path,company_name,company_link')->where(['uid' => $v['company_id']])->select()[0];
					$recommendcardList[$k]['logo_path'] = $companyInfo['logo_path'];
					$recommendcardList[$k]['company_name'] = $companyInfo['company_name'];
					$recommendcardList[$k]['company_link'] = $companyInfo['company_link'];
					$recommendList[] = $recommendcardList[$k];
				}
			}
		}

		// 模拟分页开始(10条数据一页)
		$count = count($recommendList);

		// 不够一页完整返回
		if ($count < 11) 
		{
			return $recommendList;
		}

		$page = 0;

		if (I('get.p')) 
		{
			$page = (int)I('get.p') -1;
		}

		$returnList = array_chunk($recommendList, 10);

		$result = $returnList[$page]?$returnList[$page]:false;

		return $result;
	}

	// 猜你喜欢
	public function selYouLike()
	{
		$visitorId = $this->visitorId;

		$timeForNow = strtotime('-1 Sunday');

		$today      = strtotime('Today');

		$yesterday  = strtotime('-1 day');

		$this->redis->delete($yesterday.'selYouLike'.$visitorId);// 删除昨天的推荐列表

		$this->redis->delete($today.'selYouLike'.$visitorId);

		$result = $this->redis->get($today.'selYouLike'.$visitorId);

		if (!$result || $result == 'null') 
		{
			$visitObj = M('Visitor_track');
			$where = array(
					'visitor_id' => $visitorId, 
					'visit_date' => ['gt', strtotime('last week')], // 指向一周内
					'visit_type' => 1,// 指向商品类
				);

			// 根据用户id获取一个月内的足迹数据
			$track = $visitObj->field('id_aggregate')->where($where)->order('visit_date desc')->select();

			// 查询redis数据库	
			$recommendGoodsList = $this->redis->get('A_recommendGoodsList'.$timeForNow);

			$goodsList = json_decode($recommendGoodsList, true);

			$goods = M('Goods');


			if ($track) 
			{
				static $trackArr = [];
				foreach ($track as $v) {
					$trackArr = array_merge(explode(',', $v['id_aggregate']), $trackArr);
				}

				$classifyList = $goods->where(['id' => ['in', implode(',', $trackArr)]])->getField('website_classify_id',true);
				
				$classifyList = array_unique($classifyList);//过滤重复值
				// 取大门户商品分类交集
				foreach ($goodsList as $v) 
				{
					if (in_array($v['website_classify_id'], $classifyList) ) 
					{
						$status = M('user')->where(['id' => $v['company_id']])->getField('status');
						if (!$status) {
							$info = M('Goods')->field('goods_name,price,addtime,goods_logo,website_classify_id,status')->where(['id' => $v['goods_id']])->select()[0];
							$v['goods_name'] = $info['goods_name'];
							$v['price'] = $info['price'];
							$v['addtime'] = $info['addtime'];
							$v['goods_logo'] = $info['goods_logo'];
							$v['website_classify_id'] = $info['website_classify_id'];
							$companyInfo = M('Company')->field('logo_path,company_name,company_link,template_id')->where(['uid' => $v['company_id']])->select()[0];
							$template    = M('template_change')->where(['id' => $companyInfo['template_id']])->getField('template_path');
							$v['logo_path']    = $companyInfo['logo_path'];
							$v['company_name'] = $companyInfo['company_name'];
							$v['goods_link'] = 'http://'.$companyInfo['company_link'].'/'.$template.'/Goods/goodsDetail/id/'.$v['goods_id'];
							if (!$info) {
								unset($v);
							}else{
								$arr[] = $v;
							}
						}
					}
				}
			}else{
				foreach ($goodsList as $v) 
				{
					$status = M('user')->where(['id' => $v['company_id']])->getField('status');
					if (!$status) {
						$info = M('Goods')->field('goods_name,price,addtime,goods_logo,website_classify_id,status')->where(['id' => $v['goods_id']])->select()[0];
						$v['goods_name'] = $info['goods_name'];
						$v['price'] = $info['price'];
						$v['addtime'] = $info['addtime'];
						$v['goods_logo'] = $info['goods_logo'];
						$v['website_classify_id'] = $info['website_classify_id'];
						$companyInfo = M('Company')->field('logo_path,company_name,company_link,template_id')->where(['uid' => $v['company_id']])->select()[0];
						$template    = M('template_change')->where(['id' => $companyInfo['template_id']])->getField('template_path');
						$v['logo_path']    = $companyInfo['logo_path'];
						$v['company_name'] = $companyInfo['company_name'];
						$v['goods_link'] = 'http://'.$companyInfo['company_link'].'/'.$template.'/Goods/goodsDetail/id/'.$v['goods_id'];
						if (!$info) {
							unset($v);
						}else{
							$arr[] = $v;
						}
					}
				}
			}

			if ($count > 10) {
				static $result = array();
				static $z = array();
				for($i = 0;$i < 10;$i ++)
				{
					$y = mt_rand(0, $count);
					if (!in_array($y, $z)) {
						$z[] = $y;
						$result[] = $arr[$y];
					}else{
						$i --;
					}
				}
			}else{
				$result = $arr;
			}
			$result = json_encode($result);
			$this->redis->setex($today.'selYouLike'.$visitorId,3600, $result);
		}
			return json_decode($result, true);
	}

	// 精选动态
	public function splendidNews()
	{
		$timeForNow = strtotime('-1 Sunday');

		// 查询用户收藏数据
		$list = M('visitor_collect')->where(['visitor_id' => $this->visitorId])->getField('company_collect');

		$recommendNewsList = $this->redis->get('A_recommendNewsList'.$timeForNow);// 查询redis数据库,精选动态

		$arr = json_decode($recommendNewsList, true);
		// return $arr;
		if ($list) {

			$companyList = explode(',', $list);	
			// 过滤差集
			foreach ($arr as $k => $v) 
			{
				if (in_array($v['company_id'], $companyList)) 
				{
					$recommendList[] = $arr[$k];
				}
			}
		}else{
			$recommendList = $arr;
		}

		// 模拟分页开始(10条数据一页)
		$count = count($recommendList);

		// 不够一页完整返回
		if ($count < 11) 
		{
			return $recommendList;
		}

		$showList = array_slice($recommendList, 0, 20);// 截取前20个数据

		$page = 0;

		if (I('get.p')) 
		{
			$page = (int)I('get.p') -1;
		}

		$returnList = array_chunk($showList, 10);

		$result = $returnList[$page]?$returnList[$page]:false;

		return $result;
	}

	// 所有动态
	protected function allNews()
	{
		$timeForNow = strtotime('-1 Sunday');

		// 查询用户收藏数据
		$list = M('visitor_collect')->where(['visitor_id' => $this->visitorId])->getField('company_collect');

		$companyList = explode(',', $list);

		$companyNewsList   = $this->redis->get('A_companyNewsList'.$timeForNow);// 查询redis数据库

		$arr = json_decode($companyNewsList, true);

		$recommendList = array();

		// 过滤差集
		foreach ($arr as $k => $v) 
		{
			if (in_array($k, $companyList)){
				$total = 0;
				for($i = 0;$i < count($arr[$k]);$i ++)
				{
					$total += $v[$i]['click_total'];
				}
				$arr[$k]['visit_total'] = $total;
				$recommendList[] = $arr[$k];
			}
		}

		// 模拟分页开始(10条数据一页)
		$count = count($recommendList);

		// 不够一页完整返回
		if ($count < 6) 
		{
			return $recommendList;
		}

		$page = 0;

		if (I('get.p')) 
		{
			$page = (int)I('get.p') -1;
		}

		$returnList = array_chunk($recommendList, 5);

		$result = $returnList[$page]?$returnList[$page]:false;

		return $result;
	}

}

?>