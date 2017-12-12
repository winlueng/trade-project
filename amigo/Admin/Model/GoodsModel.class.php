<?php 
namespace Admin\Model;

use Think\Model;
use Think\Exception;

class GoodsModel extends CommonModel
{
	/*protected $_validate = array(
		array('goods_name', 'require', '商品名称不能为空'),
		array('classify_id', 'require', '请选择商品分类'),
		array('goods_title', 'require', '请填写商品详情'),
		array('brand_id', 'require', '请选择商品品牌'),
	);*/

	private $XS;
	private $doc;
	private $XSindex;
	private $where;

	public function __construct()
	{
		parent::__construct();

		$this->_auto = array(
			array('start_time', 'strtotime', 3, 'function'),
			array('end_time', 'strtotime', 3, 'function'),
			array('addtime', 'time', 1, 'function'),
			array('update_time', 'time', 3, 'function'),
			array('control_time', 'time', 3, 'function'),
			array('company_id', $this->userInfo['company_id']),
			array('relevance_id', $this->userInfo['relevance_id']),
		);

		$this->where = [
			'status' 	 => ['neq', '-1'],
			'company_id' => $this->userInfo['company_id'],
		];
		if (I('get.id')) {
			$this->where['id'] = I('get.id');
		}

		if ( I('get.classify_id')) 
		{
			$this->where['classify_id'] = I('get.classify_id');
		}
		// dump($this->userInfo);exit;
		vendor('XSsdk.php.lib.XS');
		$this->XS  		= new \XS($this->userInfo['sx_data_base']);
		$this->doc 		= new \XSDocument();
		$this->XSindex	= $this->XS->index;
	}

	public function goodsList($setWhere = '')
	{
		if ($setWhere) {
			$this->where = $setWhere;
		}

		if (I('get.classify_id')) {
			$this->where['classify_id'] = I('get.classify_id');
		}

		if (I('get.selName')) {
			$this->where['goods_name'] = [ 'like', '%'.I('get.selName').'%'];
		}

		$count = $this->where($this->where)->count();

		$page = new \Think\Page($count,8);

		$goodsList = $this->field('id,goods_name,status,price,classify_id,addtime,goods_logo')->where($this->where)->order('addtime desc')->limit($page->firstRow.','.$page->listRows)->select();

		foreach ($goodsList as $k => $v) 
		{
			$v['classify_name'] = M('GoodsClassify')->where(['id' => $v['classify_id']])->getField('classify_name');
			$v['click_total']   = M('GoodsStatistics')->where(['relevance_id' => $v['id']])->sum('visit_total');
			$info = M('GoodsStick')->field('stick_classify, status')
				->where([
					'goods_id' 	=> $v['id'],
					'status'	=> ['neq','-1']
				])->find();
			$v['stick_classify'] = $info['stick_classify'];
			$v['goods_type'] 	 = $info['status'];
			$result['list'][] 	 = $v;
		}

		$result['page'] = $page->show();

		return $result;
	}

	/**
	 * 商品概况
	 */
	public function goodsData()
	{
		$goodsID = $this->where([
						'company_id' 	=> $this->userInfo['company_id'], 
						// 'status' 		=> ['neq', '-1'],
						'relevance_id'	=> $this->userInfo['relevance_id']
					])->getField('id', true);
		
		$info['salesTotal'] = M('GoodsSalesVolume')->where(['goods_id' 	=> ['in', implode(',', $goodsID)]])->count('sales_total');// 总销售额
		if ($goodsID) {
			$info['inventoryTotal'] = M('GoodsAttribute')->where(['goods_id' => ['in', implode(',', $goodsID)]])->sum('inventory_total');
		}

		if (I('get.start') && I('get.end')) {
			$start = I('get.start')/1000;
			$end = I('get.end')/1000;
			$info['dateData']['name'] = date('Y-m-d', I('get.start')/1000).'至'.date('Y-m-d', I('get.end')/1000).$name.'商品概况表';
		}else{
			$start = strtotime(date('Y-m-d',strtotime('-7 day')));
			$end = strtotime('Today');
			$info['dateData']['name'] = '近7日商品概况表';
		}
		// return $day.'+'.$end;
		for ($i=$end; $i > $start-1;) { 
			// echo $i.'<br>';
			$info['dateData'][date('Y-m-d', $i)] = [
				'goodsSales' =>  $goodsID?M('GoodsSalesVolume')
								->where([
									'date' 		=> $i,
									'goods_id' 	=> ['in', implode(',', $goodsID)]
								])->sum('sales_total'):0,
				'orderTotal' =>  M('OrderForm')
								->where([
										'create_time' 	=> [['gt', $i-1], ['lt', $i+86399]], 
										'status' 		=> ['in','2,4'], 
										'company_id' 	=> $this->userInfo['company_id'],
										'relevance_id'	=> $this->userInfo['relevance_id']
									])->count(),
				'priceTotal' =>  M('OrderForm')
								->where([
									'pay_time' 		=> [['gt',  date('YmdHis',$i-1)], ['lt', date('YmdHis',$i+86399)]], 
									'company_id' 	=> $this->userInfo['company_id'],
									'relevance_id'	=> $this->userInfo['relevance_id']
								])->sum('total'),
				'goodsStatic'=>  $goodsID?M('GoodsStatistics')
								->where([
									'date' => $i,
									'relevance_id' 	=> ['in', implode(',', $goodsID)]
								])->sum('visit_total'):0,
				'time'		 => $i,
			];
			$i -= 86400;
		}

		$yesterday = strtotime(date('Y-m-d',strtotime('yesterday')));

		$info['yesterdayData'] = [
				'goodsSales' =>  $goodsID?M('GoodsSalesVolume')
								->where([
									'date' 		=> $yesterday,
									'goods_id' 	=> ['in', implode(',', $goodsID)]
								])->sum('sales_total'):0,
				'orderTotal' =>  M('OrderForm')
								->where([
									'create_time' 	=> [['gt', $yesterday], ['lt', strtotime('Today')]], 
									'status' 		=> ['in','2,4'],
									'company_id' 	=> $this->userInfo['company_id'],
									'relevance_id'	=> $this->userInfo['relevance_id']
								])->count(),
				'priceTotal' =>  M('OrderForm')
								->where([
								'pay_time' => [['gt',  date('YmdHis',$yesterday-1)], ['lt',  date('YmdHis',strtotime('Today')+1)]],
								'company_id' 	=> $this->userInfo['company_id'],
								'relevance_id'	=> $this->userInfo['relevance_id']
								])->sum('total'),
				'goodsStatic'=>  $goodsID?M('GoodsStatistics')->where([
								'date' => $yesterday,
								'relevance_id' => ['in', implode(',', $goodsID)]
							])->sum('visit_total'):0,
				// 'time'		 => M('GoodsSalesVolume')->getLastSql(),
		];

		return $info;
	}

	public function goodsAdd()
	{
		if ($data = $this->create()) 
		{
			unset($_FILES['attrPic']);
			if ($_FILES['goods_logo']['size'] != 0 && $_FILES['pic_path']['size'][0] != 0) 
			{
				if (count($_FILES['pic_path']['name']) > 5 ) {
					$this->error = '商品图片最大上传张数为5张';return false;
				}

				$path = fileUpload('/Uploads/goodsImg/', 'goods_logo');

				if (isset($path['error_msg'])) {
					$this->error = $path['error_msg'];return false;
				}

				unset($_FILES['goods_logo']);

				$data['goods_logo'] = $path;

				$goodsPicture = fileUpload('/Uploads/goodsImg/', '', 'more');

				if (isset($goodsPicture['error_msg'])) 
				{
					$this->error = $goodsPicture['error_msg'];return false;
				}

				/*foreach ($goodsPicture as $v) 
				{
					$arr[] = thumbImage($v);
				}*/

				$data['goods_picture'] 	= json_encode($goodsPicture);
				if ($data['is_discount']) {// 判断是否促销
					$data['sales_start_time'] 	= $data['sales_start_time']/1000;
					$data['sales_end_time'] 	= $data['sales_end_time']/1000;
				}
				$this->startTrans();
				try {
					$goodsid = $this->add($data);

					if (!$goodsid) throw new Exception('商品添加失败');

					$res = D('GoodsAttribute')->insert($goodsid);

					if (!$res) {
						throw new Exception(D('GoodsAttribute')->getError());
					}
					$saveData = [
						'id'				=> $goodsid,
						'price' 		    => $data['price'],
						'describe' 	    	=> $data['describe'],
						'goods_name'     	=> $data['goods_name'],
						'promotion_price'	=> $data['promotion_price'],
						'addtime' 			=> $data['addtime'],
						'goods_logo' 		=> $path,
						'company_id'      	=> $this->userInfo['company_id'],
					];

					$this->doc->setFields($saveData);
					$this->XSindex->add($this->doc);
					$this->commit();
					return true;
				} catch (Exception $e) {
					$this->rollback();
					$this->error = $e->getMessage();return false;
				}
			}
			$this->error = '请上传商品图片或商品封面';return false;
		}
		return false;
	}

	public function ajaxControl()
	{
		$flag = I('get.flag');
		return $this->$flag();
	}

	protected function changeGoodsStatus()
	{
		$data['status'] = I('get.status');
		
		$result = $this->where($this->where)->save($data);

		if ($result) return '修改状态成功';

		return '修改状态有误';
	}

	protected function goodsDel()
	{
		$result = $this->where($this->where)->setField('status','-1');
		M('GoodsStick')->where(['goods_id' => I('get.id'), 'relevance_id' => $this->userInfo['relevance_id']])->setField('status','-1');
		if (!$result) {
			return '删除失败';	
		}
		$this->XSindex->del(I('get.id'));
		return '删除成功';
	}

	public function goodsUpdate()
	{
		if ($data = $this->create()) {
			$where = [
				'id' => I('get.id'),
				'status' => ['neq', '-1'],
			];

			if ($_FILES['goods_logo']['size'] != 0) 
			{
				$path = fileUpload('/Uploads/goodsImg/', 'goods_logo');
				
				if (isset($path['error_msg'])) {
					$this->error = $path['error_msg'];return false;
				}
				$data['goods_logo'] = $path;

				$goodsPic = $this->where($where)->getField('goods_logo');
				
				$saveData['goods_logo'] = $path;
			}

			unset($_FILES['goods_logo']);

			if ($_FILES['pic_path']['size'][0] != 0) 
			{

				$goodsPicture = fileUpload('/Uploads/goodsImg/', '', 'more');

				if (isset($goodsPicture['error_msg'])) {

					$this->error = $goodsPicture['error_msg'];return false;

				}

				/*foreach ($goodsPicture as $v) {
					$arr[] = thumbImage($v);
				}*/

				// $data['goods_picture'] += $arr;
				$data['goods_picture'] = json_encode($goodsPicture);
			}

			if ($data['is_promotion']) {
				$data['sales_start_time'] 	= $data['sales_start_time']/1000;
				$data['sales_end_time'] 	= $data['sales_end_time']/1000;
			}
			// return $data;
			$this->startTrans();
			try {
				$result = $this->where($where)->save($data);

				if (!$result) throw new Exception('修改失败');

				$saveData['id'] 		= I('get.id');
				$saveData['price'] 		= $data['price'];
				$saveData['describe'] 	= $data['describe'];
				$saveData['goods_name'] = $data['goods_name'];
				// return $saveData;
				$this->commit();

				$this->doc->setFields($saveData);

				$this->XSindex->update($this->doc);

				unlink('./Public'.$goodsPic);

				return true;
			} catch (Exception $e) {
				$this->rollback();
				$this->error = $e->getMessage();return false;
			}
		}
		return false;
	}

	// 删除商品图片
	protected function delGoodsPicture()
	{
		$pic = $this->where(['id' => I('get.id')])->getField('goods_picture');
		$pic = json_decode($pic, true);
		foreach ($pic as $v) {
			if (I('get.goods_picture') != $v) {
				$save[] = $v;
			}
		}
		$res = $this->where(['id' => I('get.id')])->save(['goods_picture' => json_encode($save)]);
		
		if ($res) {
			return true;
		}
		return false;
	}

	// 获取下级区域
	protected function selNextRegionInfo()
	{
		$region = M('Region');
		$where['parent_id'] = I('get.id');
		$where['status']    = 0;
		$where['relevance_id'] = $this->userInfo['relevance_id'];
		$result['region'] = $region->field('id, region_name')->where($where)->select();
		if ($result['region']) 
		{
			return $result;exit;
		}else{
			$find['region_id'] = I('get.id');
			$result['region'] = '';
			$result['business'] = M('Business')->field('id, business_name')->where($find)->select();
			return $result;exit;
		}
	}

	public function setControlTimeToTop()
	{
		$where['id'] = I('get.id');

		$result = $this->where($where)->setField('control_time', time());

		if ($result) return '操作成功';
			
		return '操作失败';
	}

	public function selGoodsInfo()
	{
		$res = $this->where([
				'id' 			=> I('get.id'),
				'relevance_id' 	=> $this->userInfo['relevance_id'],
				'company_id'	=> $this->userInfo['company_id']
			])->find();
		// dump($this->getLastSql());exit;
		$res['goods_picture'] 	= json_decode($res['goods_picture'], true);
		$res['goods_title'] 	= htmlReturn($res['goods_title']);
		$result['goodsInfo'] 	= $res;
		$result['goodsAttr'] 	= D('GoodsAttribute')->goodsList(I('get.id'));
		return $result;
	}

	// 商户置顶到主页
	public function stickByCompany()
	{
		$this->startTrans();
		try {
			$where = [
				'status' => I('get.status'),
				'company_id' => $this->userInfo['company_id'],
			];

			if($this->where($where)->count() > 3) throw new Exception("当前置顶位置已超过4个商品");
			
			$res = $this->where([
					'company_id' => $this->userInfo['company_id'],
					'id'		 => I('get.id')
				])->save(['status' => I('get.status')]);

			if(!$res) throw new Exception("置顶失败");
			

			$this->commit();
			return ['status' => 'true'];
		} catch (Exception $e) {
			$this->rollback();
			return ['status' => 'false', 'err_msg' => $e->getMessage()];
		}
	}
}