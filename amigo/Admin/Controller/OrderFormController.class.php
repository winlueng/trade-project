<?php
namespace Admin\Controller;

use Think\Controller;

class OrderFormController extends CommonController
{
	private $obj;	

	public function __construct()
	{
		parent::__construct();
		$this->obj = D('OrderForm');
		// dump($this->userInfo);exit;
	}

	public function orderList()
	{
		$where = [
			'company_id' => $this->userInfo['company_id'],
			'relevance_id' => $this->userInfo['relevance_id'],
		];
		$result = $this->obj->orderList($where);
		if (I('get.getExcel')) {
			$res = $this->getExcel($where);
			// dump($res);exit;
		}
		// dump($result);exit;
		$express = M('Express')->select();
		$this->assign('list', $result['list']);
		$this->assign('express', $express);
		$this->assign('page', $result['page']);
		$this->display();
	}

	public function orderInfo()
	{
		if (IS_POST) {
			$data['admin_remark'] = I('post.admin_remark');
			$res = $this->obj->where(['id' => I('get.id'), 'company_id' => $this->userInfo['company_id']])->save($data);
			if ($res) {
				$this->success('备注成功!');exit;
			}
			$this->error('备注异常!');exit;
		}
		$info = $this->obj->orderInfo();
		// dump($info);exit;
		$this->assign('info', $info);
		$this->display();
	}

	public function visitorOrder()
	{
		$result = $this->obj->orderList();
		if (I('get.getExcel')) {
			$res = $this->getExcel();
			// dump($res);exit;
		}
		// dump($result);exit;
		$express = M('Express')->select();
		$this->assign('list', $result['list']);
		$this->assign('express', $express);
		$this->assign('page', $result['page']);
		$this->display();
	}

	public function getExcel($where = [])
	{
		Vendor('PHPExcel.PHPExcel');
		Vendor('PHPExcel.PHPExcel.IOFactory');
		Vendor('PHPExcel.PHPExcel.Style.Alignment');
		$alignment = new \PHPExcel_Style_Alignment();
		$res = $this->obj->excelBefore($where);
		// return $res;
		// dump($res);exit;
		$phpexcel = new \PHPExcel(); 
		$phpexcel->getActiveSheet()->setTitle($res['name']);
		$phpexcel->getActiveSheet()  
                  ->setCellValue('A1','序号')  
                  ->setCellValue('B1','订单状态')  
                  ->setCellValue('C1','订单号')  
                  ->setCellValue('D1','微信订单号')  
                  ->setCellValue('E1','商品信息')  
                  ->setCellValue('F1','运费')  
                  ->setCellValue('G1','支付方式')  
                  ->setCellValue('H1','支付金额(元)')  
                  ->setCellValue('I1','买家信息')  
                  ->setCellValue('J1','商户备注') 
                  ->setCellValue('K1','交易时间') 
                  ->setCellValue('L1','交易完成时间')
                  ->setCellValue('M1','所属商户'); 
        $i = 2;
		foreach ($res['list'] as $k => $v) {
			$arr = [];
			foreach ($v['goods_data'] as $vo) {
				$arr[] = '商品名称:'.$vo['goodsInfo'].';件数:'.$vo['total'].';共'.$vo['price']."元";
			}
			$v['address_id'] = implode("\n",$v['address_id']);
			$v['goods_data'] = implode("\n",$arr);
			$phpexcel->getActiveSheet()   
                        ->setCellValue('A'.$i, $k+1)  
                        ->setCellValue('B'.$i, $v['status'])  
                        ->setCellValue('C'.$i, $v['order_number'])  
                        ->setCellValue('D'.$i, $v['wechat_order_number']?' '.$v['wechat_order_number']:'空')  
                        ->setCellValue('E'.$i, $v['goods_data'])  
                        ->setCellValue('F'.$i, $v['express_price'])    
                        ->setCellValue('G'.$i, $v['pay_type'] == 1?'微信支付':'钱包支付')    
                        ->setCellValue('H'.$i, $v['wechat_total'])    
                        ->setCellValue('I'.$i, $v['address_id'])    
                        ->setCellValue('J'.$i, $v['admin_remark'])       
                        ->setCellValue('K'.$i, $v['create_time'])
                        ->setCellValue('L'.$i, $v['pay_time'])
                        ->setCellValue('M'.$i, $v['company_name']?$v['company_name']:'大平台');  
            $i++;
            $result[] = $v;
		}
		// return $result;
		$phpexcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(40);
		$phpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$phpexcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$phpexcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$phpexcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$phpexcel->getActiveSheet()->getColumnDimension('E')->setWidth(60);
		$phpexcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$phpexcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$phpexcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
		$phpexcel->getActiveSheet()->getColumnDimension('I')->setWidth(600);
		$phpexcel->getActiveSheet()->getColumnDimension('J')->setWidth(50);
		$phpexcel->getActiveSheet()->getColumnDimension('K')->setWidth(50);
		$phpexcel->getActiveSheet()->getColumnDimension('L')->setWidth(50);
		$phpexcel->getActiveSheet()->getColumnDimension('M')->setWidth(50);
		$phpexcel->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal($alignment::HORIZONTAL_CENTER);
		$phpexcel->getActiveSheet()->getDefaultStyle()->getAlignment()->setVertical($alignment::VERTICAL_CENTER);
		// $obj      	= new \PHPExcel_IOFactory();  
        $obj_Writer = \PHPExcel_IOFactory::createWriter($phpexcel,'Excel5');  
        //设置header  
        header("Content-Type: application/force-download");   
        header("Content-Type: application/octet-stream");   
        header("Content-Type: application/download");   
        header('Content-Disposition:inline;filename="'.$res['name'].'.xls"');   
        header("Content-Transfer-Encoding: binary");   
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");   
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");   
        header("Pragma: no-cache");   
        $obj_Writer->save('php://output');//输出
	}

	public function recontent()
	{
		if(IS_POST){
			$res = $this->obj->recontent();
			// dump($res);exit;
			if ($res) {
				$this->success('回复评价成功');exit;
			}
			$this->error('回复评价失败');exit;
		}
	}

	public function ajaxControl()
	{
		if(!IS_AJAX) E('非法访问');

		$this->ajaxReturn($this->obj->ajaxControl(I('get.flag')));
	}

	public function orderExpressUpdate()
	{
		if (IS_POST) {
			// dump(I('post.'));exit;
			$res = $this->obj->sendExpress();
			if ($res) {

				$this->success('发货成功!');exit;
			}
			$this->error($this->obj->getError());exit;
		}
	}

	/**
	 * 平台订单
	 */
	public function projectOrderList()
	{
		$where = [
			'company_id' => 0,
			'relevance_id' => $this->userInfo['relevance_id'],
		];
		$result = $this->obj->orderList($where);
		if (I('get.getExcel')) {
			$res = $this->getExcel($where);
			// dump($res);exit;
		}
		// dump($result);exit;
		$express = M('Express')->select();
		$this->assign('list', $result['list']);
		$this->assign('express', $express);
		$this->assign('page', $result['page']);
		$this->display();
	}

	// 平台订单详情
	public function orderDetailByProject()
	{
		$where = [
			'status' => ['neq', '-1'],
			'company_id' => '0',
			'relevance_id' => $this->userInfo['relevance_id'],
			'id' => I('get.id')
		];
		if (IS_POST) {
			$data['admin_remark'] = I('post.admin_remark');
			$res = $this->obj->where($where)->save($data);
			if ($res) {
				$this->success('备注成功!');exit;
			}
			$this->error('备注异常!');exit;
		}
		$info = $this->obj->orderInfo($where);
		$this->assign('info', $info);
		$this->display();
	}

	/**
	 * 商盟订单
	 */
	public function companyOrderList()
	{
		$where = [
			'company_id' => ['neq', '0'],
			'relevance_id' => $this->userInfo['relevance_id'],
		];
		if (I('get.company_id')) {
			$where['company_id'] = I('get.company_id');
		}
		$result = $this->obj->orderList($where);
		if (I('get.getExcel')) {
			$res = $this->getExcel($where);
			// dump($res);exit;
		}
		// dump($result);exit;
		$express = M('Express')->select();
		$regionList = D('Region')->getRegionList();
		$this->assign('region',$regionList);
		$this->assign('list', $result['list']);
		$this->assign('express', $express);
		$this->assign('page', $result['page']);
		$this->display();
	}

	// 商盟订单详情
	public function companyOrderDetailByProject()
	{
		$where = [
			'status' => ['neq', '-1'],
			'company_id' => ['neq', '0'],
			'relevance_id' => $this->userInfo['relevance_id'],
			'id' => I('get.id')
		];
		if (IS_POST) {
			$data['admin_remark'] = I('post.admin_remark');
			$res = $this->obj->where($where)->save($data);
			if ($res) {
				$this->success('备注成功!');exit;
			}
			$this->error('备注异常!');exit;
		}
		$info = $this->obj->orderInfo($where);
		$info['company_name'] = M('Company')->where(['id' => $info['company_id']])->getField('company_name');
		$this->assign('info', $info);
		$this->display();
	}
}
?>