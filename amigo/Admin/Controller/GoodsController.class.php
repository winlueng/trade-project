<?php
namespace Admin\Controller;

use Think\Controller;
use Admin\Controller\GoodsClassifyController;

class GoodsController extends CommonController
{
	private $goodsObj;

	public function __construct()
	{
		parent::__construct();
		$this->goodsObj = D('Goods');
		// $this->goodsObj->where(['sales_end_time'=>['lt',time()]])->setField('goods_type','0');
	}

	public function goodsList()
	{
		$classify = M('GoodsClassify')->where([
						'status' => ['not in', '-1,1'],
						'company_id' => $this->userInfo['company_id'],
						'relevance_id' => $this->userInfo['relevance_id']
					])->select();
		$result = $this->goodsObj->goodsList();
		// dump($result);exit;
		$this->assign('page', $result['page']);
		$this->assign('list', $result['list']);
		$this->assign('classify',$classify);
		$this->display();
	}

	public function goodsAdd()
	{
		if (IS_POST) 
		{
			$result = $this->goodsObj->goodsAdd();
			// dump($result);exit;
			if ($result) {
				$this->success('添加成功', U('Goods/goodsList'));exit;
			}
			$this->error($this->goodsObj->getError());exit;
		}
		$classify  = M('GoodsClassify')->where(['status' => ['not in', '-1,1'],'company_id' => $this->userInfo['company_id']])->select();
		$brandList = M('GoodsBrand')->where(['status' => ['not in', '-1,1'],'company_id' => $this->userInfo['company_id']])->select();
		$this->assign('classify',$classify);
		$this->assign('brandList',$brandList);
		$this->display();
	}

	public function goodsUpdate()
	{	
		if (IS_POST) {
			// dump(I('post.'));exit;
			$result = $this->goodsObj->goodsUpdate();
			// dump($result);exit;
			if ($result) 
			{
				$this->success('修改成功', U('goodsList'));exit;
			}
			
			$this->error('修改失败');exit;
		}
		$res = $this->goodsObj->selGoodsInfo();
		// dump($res);exit;
		$classify  = M('GoodsClassify')->where([
						'status' => ['not in', '-1,1'],
						'company_id' => $this->userInfo['company_id']
					])->select();
		$brandList = M('GoodsBrand')->where([
						'status' => ['not in', '-1,1'],
						'company_id' => $this->userInfo['company_id']
					])->select();
		$this->assign('classify',$classify);
		$this->assign('brandList',$brandList);
		// dump($res);exit;
		$this->assign('info', $res['goodsInfo']);
		$this->assign('attr', $res['goodsAttr']);
		$this->display();
	}

	public function preview()
	{
		$info = $this->goodsObj->selGoodsInfo();
		// dump($info);exit;
		$this->assign('info', $info['goodsInfo']);
		$this->assign('attr', $res['goodsAttr']);
		$this->display();
	}

	// 置顶审核列表
	public function auditGoodsList()
	{
		$result = $this->goodsObj->goodsTopList(1);
		$this->assign('list', $result['list']);
		$this->assign('region', $result['regionList']);
		$this->assign('page', $result['page']);
		$this->display();
	}

	public function goodsAuditRecord()
	{
		$result = $this->goodsObj->goodsTopList(['in', '1,2,3,4']);
		$this->assign('list', $result['list']);
		$this->assign('region', $result['regionList']);
		$this->assign('page', $result['page']);
		$this->display();
	}

	public function allGoodsSalesList()
	{
		$result = $this->goodsObj->goodsTopList('2');
		// $classifyList = GoodsClassifyController::marketClassifyList();
		$this->assign('list', $result['list']);
		// $this->assign('classifyList', $classifyList);
		$this->assign('region', $result['regionList']);
		$this->assign('page', $result['page']);
		$this->display();
	}

	/**
	 * 商品概况(子门户)
	 */
	public function goodsData()
	{
		$res = $this->goodsObj->goodsData();
		if (I('get.getExcel')) {
			$result = $this->getExcel($res['dateData']);
			// dump($result);exit;
		}
		// dump($res);exit;
		unset($res['dateData']['name']);
		$this->assign('info',$res);
		$this->display();
	}

	/**
	 * 商品概况(大门户)
	 */
	public function goodsDataByProject()
	{
		$res = $this->goodsObj->goodsData();
		if (I('get.getExcel')) {
			$result = $this->getExcel($res['dateData']);
			// dump($result);exit;
		}
		// dump($res);exit;
		unset($res['dateData']['name']);
		$this->assign('info',$res);
		$this->display();
	}

	public function getExcel($res)
	{
		Vendor('PHPExcel.PHPExcel');
		Vendor('PHPExcel.PHPExcel.IOFactory');
		Vendor('PHPExcel.PHPExcel.Style.Alignment');
		$alignment = new \PHPExcel_Style_Alignment();
		// return $res;
		$name = $res['name'];
		$phpexcel = new \PHPExcel(); 
		$phpexcel->getActiveSheet()->setTitle($name);
		$phpexcel->getActiveSheet()  
                  ->setCellValue('A1','序号')  
                  ->setCellValue('B1','日期')  
                  ->setCellValue('C1','订单数')  
                  ->setCellValue('D1','商品成交量')  
                  ->setCellValue('E1','成交额(元)')  
                  ->setCellValue('F1','商品浏览量');
        $i = 2;
        unset($res['name']);
		foreach ($res as $k => $v) {
			$phpexcel->getActiveSheet()   
                        ->setCellValue('A'.$i, $i-1)  
                        ->setCellValue('B'.$i, $k)  
                        ->setCellValue('C'.$i, $v['orderTotal'])
                        ->setCellValue('D'.$i, $v['goodsSales'])
                        ->setCellValue('E'.$i, $v['priceTotal']?$v['priceTotal']:0)
                        ->setCellValue('F'.$i, $v['goodsStatic']); 
            $i++;
		}
		// return $result;
		$phpexcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(40);
		$phpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$phpexcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$phpexcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$phpexcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$phpexcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$phpexcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$phpexcel->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal($alignment::HORIZONTAL_CENTER);
		$phpexcel->getActiveSheet()->getDefaultStyle()->getAlignment()->setVertical($alignment::VERTICAL_CENTER);
		// $obj      	= new \PHPExcel_IOFactory();  
        $obj_Writer = \PHPExcel_IOFactory::createWriter($phpexcel,'Excel5');  
        //设置header  
        header("Content-Type: application/force-download");   
        header("Content-Type: application/octet-stream");   
        header("Content-Type: application/download");   
        header('Content-Disposition:inline;filename="'.$name.'.xls"');   
        header("Content-Transfer-Encoding: binary");   
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");   
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");   
        header("Pragma: no-cache");   
        $obj_Writer->save('php://output');//输出
	}
	
	public function ajaxControl()
	{
		$result = $this->goodsObj->ajaxControl();
		$this->ajaxReturn($result);exit;
	}

	/**
	 * 大门户商品添加
	 */
	public function goodsAddByProject()
	{
		if (IS_POST) 
		{
			$result = $this->goodsObj->goodsAdd();
			if ($result) {
				$this->success('添加成功', U('Goods/goodsListByProject').'?module=2');exit;
			}
			$this->error($this->goodsObj->getError());exit;
		}else{
			$classify  = M('GoodsClassify')->where(['status' => ['not in', '-1,1'], 'company_id' => $this->userInfo['company_id'], 'relevance_id' => $this->userInfo['relevance_id']])->select();
			$brandList = M('GoodsBrand')->where(['status' => ['not in', '-1,1'], 'company_id' => $this->userInfo['company_id'],'relevance_id' => $this->userInfo['relevance_id']])->select();
			$this->assign('classify',$classify);
			$this->assign('brandList',$brandList);
			$this->display();
		}
	}

	/**
	 * 大门户商品列表
	 */
	public function goodsListByProject()
	{
		$classify = M('GoodsClassify')->where([
						'status' => ['not in', '-1,1'],
						'relevance_id' => $this->userInfo['relevance_id'], 
						'company_id' => $this->userInfo['company_id']
					])->select();
		$where = [
			'relevance_id'  => $this->userInfo['relevance_id'],
			'status'		=> ['neq', '-1']
		];
		$result = $this->goodsObj->goodsList();
		// dump($result);exit;
		$this->assign('page', $result['page']);
		$this->assign('list', $result['list']);
		$this->assign('classify',$classify);
		$this->display();
	}

	/**
	 * 大门户商品修改
	 */
	public function goodsUpdateByProject()
	{	
		if (IS_POST) {
			$result = $this->goodsObj->goodsUpdate();
			if ($result) 
			{
				$this->success('修改成功', '/Admin/Goods/goodsListByProject/module/'.I('get.module'));exit;
			}
			
			$this->error('修改失败');exit;
		}
		$res = $this->goodsObj->selGoodsInfo();
		$classify  = M('GoodsClassify')->where(['status' => ['not in', '-1,1'], 'company_id' => $this->userInfo['company_id'],'relevance_id' => $this->userInfo['relevance_id']])->select();
		$brandList = M('GoodsBrand')->where(['status' => ['not in', '-1,1'], 'company_id' => $this->userInfo['company_id'],'relevance_id' => $this->userInfo['relevance_id']])->select();
		$this->assign('classify',$classify);
		$this->assign('brandList',$brandList);
		$this->assign('info', $res['goodsInfo']);
		$this->assign('attr', $res['goodsAttr']);
		$this->display();
	}
}
?>