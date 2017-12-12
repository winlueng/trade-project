<?php
namespace Template00002\Model;

use Think\Model;

/**
 * 个人中心分类
 */
class VisitorInfoModel extends CommonModel
{
	protected 	$autoCheckFields = false;

	private   	$visitorId;// 用户id

	private 	$where;

	protected $_validate = array(
			array('nick_name', 'require', '请填写昵称'),
			array('sex', 'require', '请选择性别'),
			array('city', 'require', '请填写城市'),
			array('email', 'require', '请填写邮箱地址'),
			array('email', 'email', '邮箱地址不正确'),
		);

	public function __construct()
	{
		parent::__construct();

		$this->visitorId = $this->userInfo['id'];

		$this->where = ['visitor_id' => $this->visitorId];

		$this->_auto = array(
			array('visitor_birthday','strtotime',3,'function'),
		); 
	}


	// 获取当前帐号的个人信息
	public function selMyCenterInfo()
	{
		$result = M('visitor_info')->field('nick_name, sex, city, head_thumbnail, visitor_birthday, real_name, constellation, visitor_title')->where($this->where)->find();
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
		if ($data = $this->create()) 
		{
			if ($_FILES['head_portrait']['size'] != 0) 
			{
				$oldHeadPath = M('visitor_info')->field('head_thumbnail,head_portrait')->where(['visitor_id' => $this->visitorId])->find();

				$path = substr($oldHeadPath['head_portrait'],strripos($oldHeadPath['head_portrait'],'/',-44));
				unlink('./Public'.$path);

				$uploadPath = fileUpload('/Uploads/userHeadPortrait/', 'head_portrait', 'one');

				if (isset($uploadPath['error_msg'])) 
				{
					$this->error = $uploadPath['error_msg'];return false;
				}

				$path = thumbImage($uploadPath);
				
				$data['head_portrait'] = 'http://'.$_SERVER['HTTP_HOST'].'/Public/'.$path;
			}

			if (count(explode(',', $data['city'])) > 1) 
			{
				$data['city'] = (int)substr($data['city'],strripos($data['city'],',')+1);
			}

			list($year, $month, $day) = explode('-', date('Y-m-d', $data['visitor_birthday']));

			$data['constellation'] = constellationJudge($month, $day);

			$result = M('VisitorInfo')->where(['visitor_id' => $this->visitorId])->save($data);

			$res    = M('WechatVisitor')->where(['id' => $this->visitorId])->setField('email', $data['email']);

			/*if (!$result && !$res) 
			{
				$this->error = '保存信息失败';return false;
			}*/

			$openID = M('WechatVisitor')->where(['id' => $this->userInfo['id']])->getField('open_id');

			$info = D('Login')->getUserInfo($opendID);
			
			$_SESSION['visitorInfo'] = $info;
			
			return true;
		}else{
			return false;
		}
	}

	// 收藏店铺列表
	public function showSaveCompanyList()
	{
		$collectList = M('VisitorCollect')->where(['visitor_id' => $this->visitorId])->getField('company_collect');

		if (!$collectList) 
		{
			return '';
		}

		$where = array(
				'id' => ['in', $collectList],
			);

		$count = count(explode(',', $collectList));

		$page = new \Think\Page($count,10);

		$companyList = M('Company')->field('id, company_pic, company_name')
					->where($where)
					->limit($page->firstRow.','.$page->listRows)
					->select();

		foreach($companyList as $v)
		{
			$v['collect_total'] = M('CompanyStatistics')->where(['relevance_id' => $v['id']])->sum('visit_total');
			$result[] = $v;
		}

		return $result;
	}

	/**
	 * 我的收藏
	 */
	public function myCollect()
	{
		$list = M('VisitorCollect')->where(['visitor_id' => $this->userInfo['id']])->find();

		switch (I('get.show')) {
			case '1':
				$list = implode(',', json_decode($list['goods_collect'],true));
				if (!$list) {
					return false;
				}
				$where = [
					'status' 	 => ['not in','-1,3'],
					'id'		 => ['in', $list],
				];

				$list = M('Goods')->field('id,goods_name, price,goods_logo,describe')->where($where)->select();
				foreach ($list as $v) {
					$v['salesTotal'] = M('GoodsSalesVolume')->where(['goods_id' => $v['id']])->sum('sales_total');
					$result[] = $v;
				}
				return $result;
				break;
			case '2':
				$list = implode(',', json_decode($list['staff_collect'],true));
				if (!$list) {
					return false;
				}
				$where = [
					'status' 	 => ['not in','-1,1'],
					'id'		 => ['in', $list],
				];

				$list = M('Staff')->where($where)->select();

				foreach($list as $v)
				{
					$v['service_total'] = M('SubscribeOrderForm')->where(['staff_id' => $v['id'], 'status' => 4])->count();
					$result[] = $v;
				}
				return $result;
				break;
		}


	}

	// 获取用户足迹数据
	public function getVisitorTrackData()
	{
		$visitObj = M('VisitorTrack');
		// 处理超过一个月的足迹数据
		$visitObj->where(['visit_date' => ['lt', strtotime('last month')]])->delete();
		// 根据用户id获取一个月内的足迹数据
		$track = $visitObj->field('id_aggregate, visit_date')->where(['visitor_id' => $this->visitorId])->order('visit_date desc')->select();

		if ($track) 
		{
			foreach ($track as $v) 
			{
				$v['id_aggregate'] = json_decode($v['id_aggregate'], true);

				foreach ($v['id_aggregate'] as $k => $vo) {
					switch ($vo['type']) {
						case '1':
							$vo['info'] = M('Goods')->field('id, goods_logo, goods_name, price, company_id')
											->where(['id' => $vo['id']])
											->find();
							$info = M('Company')->field('company_link, company_name, template_id, web_postfix')->where(['id' => $vo['info']['company_id']])->find();
							$vo['link'] = $this->handleGoodsLink($vo['id']);
							$vo['company_link'] = U('Index/index', ['companyName' => $info['web_postfix']]);
							$vo['company_name'] = $info['company_name'];
							$sales = M('GoodsSalesVolume')->where(['goods_id' => $vo['id']])->sum('sales_total');
							$vo['sales'] = $sales?$sales:0;
							break;
						case '2':
							$vo['info'] = M('Staff')->field('id, store_nickname,professional_title, staff_logo, company_id')
											->where(['id' => $vo['id']])
											->find();
							$info = M('Company')->field('company_link, company_name, template_id, web_postfix')->where(['id' => $vo['info']['company_id']])->find();
							$vo['link'] = $this->handleStaffLink($vo['id']);
							$vo['company_link'] = U('Index/index', ['companyName' => $info['web_postfix']]);
							$vo['company_name'] = $info['company_name'];
							$vo['service_total'] = M('SubscribeOrderForm')->where(['staff_id' => $vo['id'], 'status' => 4])->count();
							break;
					}
					$arr[] = $vo;
				}

				$v['list'] = $arr;
				$result[] = $v;
				$arr = [];
			}
			return $result;
		}else{
			return $track;
		}
	}

	public function ajaxControl()
	{
		$flag = I('get.flag');
		switch ($flag) {
			case 'collectCompany'://收藏店铺
				$result = $this->collectCompany();
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

	// 收藏或取消收藏店铺
	public function collectCompany()
	{
		$companyId = $this->companyInfo['id'];
		$status = I('get.status');
		$where = ['visitor_id' => $this->userInfo['id']];
		// 查询用户收藏商品数据
		$list = $this->collectObj->where($where)->getField('company_collect');
		if (!$list && $status == '1') 
		{

			$result = $this->collectObj->add(['visitor_id' => $this->userInfo['id'], 'company_collect' => json_encode($companyId)]);
			return $result;
		}else if(!$list && $status == '2'){
			return '非法操作';
		}

		$list = json_decode($list,true);

		if (!in_array($companyId, $list) && $status == '1') // 判断是否已经收藏过
		{
			array_push($list, $companyId);
			$data = json_encode($list);
			return $this->collectObj->where($where)->setField('company_collect',$data);
		}else{
			return '商品已收藏';
		}

		if (in_array($companyId, $list) && $status == '2') // 判断是否已经收藏过
		{
			$list = array_diff($list, [$companyId]);
			$data = json_encode($list);
			return $this->collectObj->where($where)->setField('company_collect',$data);
		}else{
			return '商品未收藏';
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
					$info = M('Goods')->field('goods_name,price,addtime,goods_logo,website_classify_id,status')->where(['id' => $v['goods_id']])->find();
					$arr[$k]['goods_name'] = $info['goods_name'];
					$arr[$k]['price'] = $info['price'];
					$arr[$k]['addtime'] = $info['addtime'];
					$arr[$k]['goods_logo'] = $info['goods_logo'];
					$arr[$k]['website_classify_id'] = $info['website_classify_id'];
					$companyInfo = M('Company')->field('logo_path,company_name,company_link,template_id')->where(['uid' => $v['company_id']])->find();
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
					$companyInfo = M('Company')->field('logo_path,company_name,company_link')->where(['uid' => $v['company_id']])->find();
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
		$today  = strtotime('Today');
		$this->redis->delete('B_selYouLike_'.$this->userInfo['id'].'_date_'.$today);
		$result = $this->redis->get('B_selYouLike_'.$this->userInfo['id'].'_date_'.$today);
		// return json_decode($result, true);
		if (!$result || $result == 'null') 
		{
			$where = array(
					'visitor_id' => $this->userInfo['id'], 
					'visit_date' => ['gt', strtotime('last week')], // 指向一周内
				);

			M('VisitorTrack')->where(['visit_date' => ['lt', strtotime('-1 month')]])->delete();// 删除一个月前的足迹

			// 根据用户id获取一个月内的足迹数据
			$track = M('VisitorTrack')->field('id_aggregate')->where($where)->order('visit_date desc')->select();

			if ($track) 
			{
				static $trackArr = [];
				
				foreach ($track as $v) {
					$arr = json_decode($v['id_aggregate'],true);
					$data = [];
					foreach ($arr as $v) {
						if ($v['type'] == '1') {
							$data[] = $v['id'];
						}
					}
					$trackArr += $data;
				}
				$trackArr = array_unique($trackArr);

				$classifyList = M('Goods')->where(['id' => ['in', implode(',', $trackArr)], 'status' => ['not in','-1,3']])->getField('classify_id', true);
				
				if (!$classifyList) {
					return false;
				}
				$classifyList = array_unique($classifyList);//过滤重复值

				$where = [
					// 'id' => ['not in', implode(',', $trackArr)],
					'classify_id' => ['in', implode(',', $classifyList)],
					'status' => ['not in','-1,3']
				];

				$field = [
					'id',
					'goods_name',
					'company_id',
					'relevance_id',
					'goods_logo',
					'promotion_price',
					'is_promotion',
					'price',
					'discount',
					'addtime',
				];

				$list = M('Goods')->field($field)->where($where)->select();

				if (!$list) {// 商品数据不足, 返回false;
					return false;
				}

				foreach ($list as $v) {
					$v['sales'] = M('GoodsSalesVolume')->where(['goods_id' => $v['id']])->sum('sales_total');// 商品销量
					$v['link'] = $this->handleGoodsLink($v['id']);
					$res[] = $v;
				}
			}

			$count = count($res);

			if ($count > 15) {
				static $result = array();
				static $z = array();
				for($i = 0;$i < 15;$i ++)
				{
					$y = mt_rand(0, $count);
					if (!in_array($y, $z)) {
						$z[] = $y;
						$result[] = $res[$y];
					}else{
						$i --;
					}
				}
			}else{
				$result = $res;
			}
			$result = json_encode($result);

			$this->redis->setex('B_selYouLike_'.$this->userInfo['id'].'_date_'.$today, 3600, $result);
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