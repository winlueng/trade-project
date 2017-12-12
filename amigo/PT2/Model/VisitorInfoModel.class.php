<?php 
namespace PT2\Model;

use Think\Model;

class VisitorInfoModel extends CommonModel
{
	private $update_field = [
		'phone', 'email', 'nick_name', 'real_name', 'city', 'sex', 'head_portrait', 'visitor_birthday'
	];
	public function __construct()
	{
		parent::__construct();
		if (!$this->userInfo) {
			return ['status' => 'false', 'err_msg' => 'ÇëµÇÂ¼'];
		}
	}

	public function ajaxControl($flag)
	{
		return $this->$flag();
	}

	public function infoUpdate()
	{
		if (in_array(I('post.field'), $this->update_field)) {
			$data = I('post.data');
			if (I('post.field') == 'city') {
				if (count(explode(',', $data)) > 1) 
				{
					$data = array_pop(explode(',', $data));
				}
			}elseif(I('post.field') == 'visitor_birthday'){
				list($year, $month, $day) = explode('-', date('Y-m-d', $data['visitor_birthday']));

				$save['constellation'] = constellationJudge($month, $day);
			}
			if(I('post.field') == 'email'){
				$res = M('WechatVisitor')->where(['id' => $this->userInfo['id']])->setField('email', $data);
				if ($res) {
					return ['status' => 'true'];
				}
			}

			$save[I('post.field')] = $data;
			
			$res = $this->where(['visitor_id' => $this->userInfo['id']])->save($save);
			if ($res) {
				$_SESSION['visitorInfo'] = D('Login')->getUserInfo('', $this->userInfo['id']);
				return ['status' => 'true'];
			}
			return ['status' => 'false', 'err_msg' => '修改失败'];
		}
		return ['status' => 'false', 'err_msg' => '字段不存在'];
	}

	/**
	 * Òì²½ÉÏ´«
	 */
	private function headPortraitUpload()
	{
		$path = fileUpload('/Uploads/userHeadPortrait/', 'head_portrait', 'one', 500000);

		if (isset($path['error_msg'])) return ['status' => 'false', 'err_msg' => $path['error_msg']];

		$path = thumbImage($path);

		$data['head_portrait'] = 'http://'.$_SERVER['HTTP_HOST'].'/Public/'.$path;

		$res = $this->where(['visitor_id' => $this->userInfo['id']])->save($data);

		if ($res) {
			$_SESSION['visitorInfo'] = D('Login')->getUserInfo('', $this->userInfo['id']);
			return ['status' => 'true', 'headUrl' => $data['head_portrait']];
		}
		return ['status' => 'false', 'err_msg' => '上传失败'];
	}

	public function getAddress()
	{
		return saveAddressList();
	}

	// 猜你喜欢
	public function selYouLike()
	{
		$today  = strtotime('Today');
		// $this->redis->delete('B_selYouLike_'.$this->userInfo['id'].'_date_'.$today); 
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
				// dump(M('Goods')->getLastSql());exit;
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
			$result = [];
			if ($count > 19) {
				// static $result = array();
				// static $z = array();
				for($i = 0;$i < 19;$i ++)
				{
					$y = mt_rand(0, $count-1);
					if (!in_array((string)$y, $z)) {
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
}

 ?>