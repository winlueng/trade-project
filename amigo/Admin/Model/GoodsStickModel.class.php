<?php 
namespace Admin\Model;

use Think\Model;
use Think\Exception;

class GoodsStickModel extends CommonModel
{
	protected $_validate = array(
		array('goods_id', 'require', '请提交商品id'),
		array('stick_classify', 'require', '请选择置顶分类'),
		array('end_time', 'require', '请选择置顶结束时间'),
	);

	public function __construct()
	{
		parent::__construct();
		$this->_auto = array(
			['create_time', 'time', 1, 'function'],
			['start_time', 'strtotime', 1, 'function'],
			['end_time', 'strtotime', 1, 'function'],
			['relevance_id', $this->userInfo['relevance_id'], 1],
		);
	}

	// 商户申请推荐
	public function insert()
	{
		if (!I('get.goods_id')) {
			return ['err_msg'=>'请提交商品id','status' => false];
		}
		$where = ['goods_id'	=> I('get.goods_id')];

		$data = [
			'company_id' 	=> $this->userInfo['company_id'],
			'create_time' 	=> time(),
			'goods_id'		=> I('get.goods_id'),
			'status'		=> 0,
			'stick_classify'=> 0,
		];
		if ($this->where($where)->find()) {
			$res = $this->where($where)->save($data);
		}else{
			$res = $this->add($data);
		}

		if ($res) return ['status' => true];

		return ['err_msg'=>'置顶失败','status' => false];
	}

	// 大门户置顶商品
	public function stickByProject()
	{
		$where = [
			'relevance_id' 	 => $this->userInfo['relevance_id'],
			'stick_classify' => I('post.stick_classify'),
			'end_time'	 => ['gt',time()],
			'status'	 => 1
		];
		$count = $this->where($where)->count();
		if ($count > 5) {
			return ['err_msg'=>'置顶已超过6个商品','status' => false];
		}

		if ($data = $this->create()) {
			$data['status'] = 1;
			$where = ['goods_id'	=> I('post.goods_id')];
			if ($this->where($where)->find()) {
				$res = $this->where($where)->save($data);
			}else{
				$res = $this->add($data);
			}

			if ($res) return ['status' => true];

			return ['err_msg'=>'置顶失败','status' => false];
		}
		return ['err_msg'=>$this->getError(),'status' => false];
	}

	public function company_stick_to_project()
	{
		$this->startTrans();
		try {
			$where = [
				'company_id' 	 => $this->userInfo['company_id'],
				'status'		 => 0
			];
			if($this->where($where)->count() > 6) throw new Exception("你最近置顶已超过6个");
			
			$data = [
				'company_id' 	 => $this->userInfo['company_id'],
				'relevance_id' 	 => $this->userInfo['relevance_id'],
				'goods_id'		 => I('get.id'),
			];

			$res = $this->where($data)->find();
			if ($res) {
				if ($res['update_time'] == 0 && $res['status'] == 0) {
					throw new Exception("商品已申请推荐");
				}else if ($res['update_time'] > strtotime('-1 month') && $res['status'] != 0) {
					throw new Exception("此商品在一月内置顶过");
				}else{
					$res = $this->where($data)->save(['status' => 0]);
					if (!$res) {
						throw new Exception("申请失败");
					}
				}
			}

			$data['create_time'] = time();

			$res = $this->add($data);
			if (!$res) throw new Exception("申请失败");
			$this->commit();
			return ['status' => 'true'];
		} catch (Exception $e) {
			$this->rollback();
			return ['err_msg' => $e->getMessage(),'status' => 'false'];
		}

	}

	// 置顶列表
	public function stickList($status = '=0')
	{
		$count = $this
		        ->alias('s')
				->join('__GOODS__ as g ON s.status'.$status.' AND s.relevance_id='.$this->userInfo['relevance_id'].' AND g.status<>-1 AND g.id=s.goods_id')
				->join('__COMPANY__ as c ON g.company_id=c.id')
				->count();
				
		$page = new \Think\Page($conut, 10);

		$list = $this
				->alias('s')
				->field(['s.*', 'g.is_discount', 'g.goods_name', 'g.addtime', 'c.region_id', 'c.business_id', 'c.company_name'])
				->join('__GOODS__ as g ON s.status'.$status.' AND s.relevance_id='.$this->userInfo['relevance_id'].' AND g.status<>-1 AND g.id=s.goods_id')
				->join('__COMPANY__ as c ON g.company_id=c.id')
				->limit($page->firstRow.','.$page->listRows)
				->select();

		// dump($list);exit;
		// join查询goods_id和对应总销售量,热销推荐用
		$sql =<<<SQL
SELECT s.goods_id,SUM(v.sales_total) as sales_total
FROM (market_goods_stick as s INNER JOIN market_goods as g ON
s.goods_id=g.id AND s.relevance_id="{$this->userInfo['relevance_id']}" AND g.status<>'-1' AND g.is_discount<>'1') INNER JOIN market_goods_sales_volume as v ON
v.goods_id=s.goods_id GROUP BY s.goods_id;
SQL;

		$arr = M()->query($sql);
		$arr = bubble_sort_top($arr, 'sales_total');
		$hot_arr = array_chunk($arr, 6)[0];// 截取前6个商品
		foreach ($hot_arr as $v) {
			$hotSales[] = $v['goods_id'];
		}

		foreach ($list as $v) {
			
			$v['region'] 	  = findRegionInfo($v['region_id'], 'Region', 'region_name');

			$v['business'] 	  = M('Business')->where(['id' => $v['business_id']])->getField('business_name');
			$v['visit_total'] = M('GoodsStatistics')->where(['relevance_id' => $v['goods_id']])->sum('visit_total');
			$v['visit_total'] = $v['visit_total']?$v['visit_total']:0;
			if ($v['is_discount']) {
				$v['system_stick'][] = [
					'stick_classify'=>1,
					'stick_name'	=> '折扣区',
				];
			}

			if (in_array($v['goods_id'], $hotSales)) {
				$v['system_stick'][] = [
					'stick_classify'=>2,
					'stick_name'	=> '热销区',
				];
			}

			if (time() < ($v['addtime'] + 7*86400)) {
				$v['system_stick'][] = [
					'stick_classify'=>3,
					'stick_name'	=> '新品区',
				];
			}

			$res[] = $v;
			
		}

		$result['list'] = $res;
		$result['page'] = $page->show();
		return $result;
	}

	public function goods_to_no_stick()
	{
		return $this->where(['goods_id'=>I('get.id'), 'relevance_id'=>$this->userInfo['relevance_id']])->save(['status' => '-1']);
	}

	// 审核记录列表
	public function historyList()
	{
		$where = [
			'status' => ['not in', '-1, 0'], 
			'relevance_id' => $this->userInfo['relevance_id'],
			'stick_classify' => ['neq', '0'],
			'company_id'	 => ['neq', '0']
		];
		$count = $this->where($where)->count();
		$page = new \Think\Page($count, 10);
		$list = $this->where($where)->limit($page->firstRow.','.$page->listRows)->order('update_time desc')->select();
		foreach ($list as $v) {
			$v['company_name'] 	= M('Company')->where(['id' => $v['company_id']])->getField('company_name');
			$v['goods_name']	= M('Goods')->where(['id' => $v['goods_id']])->getField('goods_name');
			$res['list'][] 		= $v;
		}
		$res['page'] = $page->show();
		return $res;
	} 

	//	通过或拒绝申请
	public function passOrRefuse()
	{
		try {
			$where = [
				'goods_id' => I('get.goods_id'),
				'relevance_id' => $this->userInfo['relevance_id']
			];
			$newsData = [
				'title'			=> '您好,您的商品推荐已通过',
				'obj_id'  		=> $this->where($where)->getField('company_id'),
				'obj_type'		=> 2,
				'create_time' 	=> time(),
				'url'			=> 'javasprict:;',
			];
			switch (I('get.status')) {
				case '1':// 同意申请
					if (I('get.stick_classify') == '') {
						throw new Exception("请选择置顶区域");
					}else{
						$where = [
							'relevance_id' 		=> $this->userInfo['relevance_id'],
							'stick_classify' 	=> I('get.stick_classify'),
							'company_id'		=> ['neq', '0'],
							'status'			=> 1,
							'end_time'			=> ['gt', time()],
						];

						$count = $this->where($where)->count();

						if ($count > 5) throw new Exception("该区域已置顶6个商户产品");

						switch (I('get.stick_classify')) {
							case '1':// 折扣区
								$result = $this->passForDiscount($count);
								$newsData['content'] = '您的商品id为'.I('get.goods_id').'推荐位置被选为折扣区';
								break;
							case '2':// 热销区
								$result = $this->passForHot($count);
								$newsData['content'] = '您的商品id为'.I('get.goods_id').'推荐位置被选为热销区';
								break;
							case '3':// 新品区
								$result = $this->passForNew($count);
								$newsData['content'] = '您的商品id为'.I('get.goods_id').'推荐位置被选为新品区';
								break;
						}
					}
					if (!$result) throw new Exception($this->error);
					
					break;
				case '2':// 拒绝申请
					$result = $this->where($where)->save(['status' => 2]);

					if (!$result) throw new Exception("拒绝失败");
				
					$newsData['title'] 	 = '您好,商品置顶被拒绝';

					$newsData['content'] = I('post.refuse_remark');
					break;
			}

			M('SystemNews')->add($newsData);
			return ['status' => 'true'];
		} catch (Exception $e) {
			return [
				'err_msg'  	=> $e->getMessage(),
				'status'	=> 'false'
			];
		}
	}

	// 通过选择折扣区
	public function passForDiscount($count)
	{	
		
		try {
			$sql =<<<SQL
SELECT s.goods_id,SUM(v.sales_total)
FROM (market_goods_stick as s INNER JOIN market_goods as g ON
s.goods_id=g.id AND s.relevance_id="$this->userInfo['relevance_id']" AND g.status<>'-1' AND s.company_id='0' AND s.stick_classify='1') 
INNER JOIN market_goods_sales_volume as v ON
v.goods_id=s.goods_id;
SQL;

			$arr = M()->query($sql);
			$p_count = $this->where([
					'relevance_id'	 => $this->userInfo['relevance_id'],
					'status'		 => ['neq', '-1'],
					'company_id'	 => 0,
					'stick_classify' => 1,
				])->count();
			$this->startTrans();
			if ($arr[0]['goods_id'] && (((int)$p_count+(int)$count) > 5)) {
				$arr = bubble_sort_down($arr, 'SUM(v.sales_total)');
				$this->where(['goods_id' => $arr[0]['goods_id']])->save(['status' => '-1']);
			}

			$data = I('get.');
			unset($data['flag']);
			$data['update_time'] = time();
			$res = $this->where(['goods_id' => $data['goods_id'], 'relevance_id' => $this->userInfo['relevance_id']])->save($data);
			if(!$res) throw new Exception("推荐失败");
			
			$this->commit();
			return true;
		} catch (Exception $e) {
			$this->rollback();
			$this->error = $e->getMessage();return false;
		}
	}

	public function passForHot($count)
	{
		try {
			$sql =<<<SQL
SELECT s.goods_id,SUM(v.sales_total)
FROM (market_goods_stick as s INNER JOIN market_goods as g ON
s.goods_id=g.id AND s.relevance_id="$this->userInfo['relevance_id']" AND g.status<>'-1' AND s.company_id='0' AND s.stick_classify='2') 
INNER JOIN market_goods_sales_volume as v ON
v.goods_id=s.goods_id;
SQL;
			$arr = M()->query($sql);
			$p_count = $this->where([
					'relevance_id'	 => $this->userInfo['relevance_id'],
					'status'		 => ['neq', '-1'],
					'company_id'	 => 0,
					'stick_classify' => 2,
				])->count();
			$this->startTrans();
			if ($arr[0]['goods_id'] && (((int)$p_count+(int)$count) > 5)) {
				$arr = bubble_sort_down($arr, 'SUM(v.sales_total)');
				$this->where(['goods_id' => $arr[0]['goods_id']])->save(['status' => '-1']);
			}

			$data = I('get.');
			unset($data['flag']);
			$data['update_time'] = time();
			$res = $this->where(['goods_id' => $data['goods_id'], 'relevance_id' => $this->userInfo['relevance_id']])->save($data);
			if(!$res) throw new Exception("推荐失败");
			
			$this->commit();
			return true;
		} catch (Exception $e) {
			$this->rollback();
			$this->error = $e->getMessage();return false;
		}
	}

	public function passForNew($count)
	{
		try {
			$sql =<<<SQL
SELECT s.goods_id,SUM(g.addtime)
FROM market_goods_stick as s INNER JOIN market_goods as g ON
s.goods_id=g.id AND s.relevance_id="$this->userInfo['relevance_id']" AND g.status<>'-1' AND s.company_id='0' AND s.stick_classify='3';
SQL;
			$arr = M()->query($sql);
			$p_count = $this->where([
					'relevance_id'	 => $this->userInfo['relevance_id'],
					'status'		 => ['neq', '-1'],
					'company_id'	 => 0,
					'stick_classify' => 3,
				])->count();
			$this->startTrans();
			if ($arr[0]['goods_id'] && (((int)$p_count+(int)$count) > 5)) {
				$arr = bubble_sort_down($arr, 'SUM(g.addtime)');
				$this->where(['goods_id' => $arr[0]['goods_id']])->save(['status' => '-1']);
			}

			$data = I('get.');
			unset($data['flag']);
			$data['update_time'] = time();
			$res = $this->where(['goods_id' => $data['goods_id'], 'relevance_id' => $this->userInfo['relevance_id']])->save($data);
			if(!$res) throw new Exception("推荐失败");
			
			$this->commit();
			return true;
		} catch (Exception $e) {
			$this->rollback();
			$this->error = $e->getMessage();return false;
		} 
	}

	public function ajaxControl($flag)
	{
		return $this->$flag();
	}
}