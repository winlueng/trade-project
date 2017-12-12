<?php
namespace Admin\Controller;

use Think\Controller;

class SubscribeOrderFormController extends CommonController
{
	private $obj;	

	public function __construct()
	{
		parent::__construct();
		$this->obj = D('SubscribeOrderForm');
	}

	public function orderList()
	{
		$result = $this->obj->orderList();
		// dump($result);exit;
		if (I('get.getExcel')) {
			$res = $this->getExcel();
			// dump($res);exit;
		}
		$this->assign('list', $result['list']);
		$this->assign('page', $result['page']);
		$this->display();
	}

	public function visitorOrder()
	{
		$result = $this->obj->orderList();
		// dump($result);exit;
		$this->assign('list', $result['list']);
		$this->assign('page', $result['page']);
		$this->display();
	}

	public function orderDetail()
	{
		$info = $this->obj->where(['id' => I('get.id'), 'company_id' => $this->userInfo['company_id']])->find();
		$info['staffInfo'] = M('Staff')->field('staff_logo,store_nickname,professional_title,speciality')
					       ->where(['id' => $info['staff_id']])->find();
		if ($info['status'] == 4) {
			$info['comment'] = M('StaffComment')->where(['subscribe_id' => $info['id']])->find();
			$info['visitorInfo'] = M('VisitorInfo')->where(['visitor_id' => $info['visitor_id']])->find();
		}
		// dump($info);exit;
		$this->assign('info', $info);			
		$this->display();
	}

	// 商品概况
	public function orderData()
	{
		$data = $this->obj->orderData();
		// dump($data);exit;
		$this->assign('yesData', $data['yesterdayData']);
		$this->display();
	}

	public function firstOrderTable()
	{
		$data = $this->obj->firstOrderTable();
		$this->assign('count', $data['count']);
		// dump($data);exit;
		if (I('get.getExcel')) {
			$res = $this->getFirstOrderTableExcel($data);
			// dump($res);exit;
		}
		$this->assign('data', $data['list']);
		$this->display();
	}

	public function getFirstOrderTableExcel($res)
	{
		Vendor('PHPExcel.PHPExcel');
		Vendor('PHPExcel.PHPExcel.IOFactory');
		Vendor('PHPExcel.PHPExcel.Style.Alignment');
		// return $res;
		$alignment = new \PHPExcel_Style_Alignment();
		$phpexcel = new \PHPExcel(); 
		$phpexcel->getActiveSheet()->setTitle($res['name']);
		$phpexcel->getActiveSheet()  
                  ->setCellValue('A1','序号')  
                  ->setCellValue('B1','日期')  
                  ->setCellValue('C1','订单数')  
                  ->setCellValue('D1','取消订单数')  
                  ->setCellValue('E1','成交量')  
                  ->setCellValue('F1','成交额(元)');
        
        $i = 2;
		foreach ($res['list'] as $k => $v) {
			$phpexcel->getActiveSheet()   
                        ->setCellValue('A'.$i, $i - 1)  
                        ->setCellValue('B'.$i, $k)  
                        ->setCellValue('C'.$i, $v['orderTotal'])  
                        ->setCellValue('D'.$i, $v['cancelOrderCount'])  
                        ->setCellValue('E'.$i, $v['orderCount'])  
                        ->setCellValue('F'.$i, $v['priceTotal']?$v['priceTotal']:0);  
            $i++;
            $result[] = $v;
		// return $v;
		}
		// return $result;
		$phpexcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(40);
		$phpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$phpexcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$phpexcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$phpexcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$phpexcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
		$phpexcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
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

	public function secondOrderTable()
	{
		$data = $this->obj->secondOrderTable();
		// dump($data);exit;
		if (I('get.getExcel')) {
			$res = $this->getSecondOrderTableExcel($data);
			// dump($res);exit;
		}
		$this->assign('list', $data['list']);
		$this->assign('page', $data['page']);
		$this->display();
	}

	public function getSecondOrderTableExcel($res)
	{
		Vendor('PHPExcel.PHPExcel');
		Vendor('PHPExcel.PHPExcel.IOFactory');
		Vendor('PHPExcel.PHPExcel.Style.Alignment');
		// return $res;
		$alignment = new \PHPExcel_Style_Alignment();
		$phpexcel = new \PHPExcel(); 
		$phpexcel->getActiveSheet()->setTitle($res['name']);
		$phpexcel->getActiveSheet()  
                  ->setCellValue('A1','序号')  
                  ->setCellValue('B1','日期')  
                  ->setCellValue('C1','设计师名称')  
                  ->setCellValue('D1','服务项目')  
                  ->setCellValue('E1','服务金额(元)')  
                  ->setCellValue('F1','支付类型');
        
        $i = 2;
		foreach ($res['list'] as $k => $v) {
			$phpexcel->getActiveSheet()   
                        ->setCellValue('A'.$i, $i - 1)  
                        ->setCellValue('B'.$i, $v['complete_time'])  
                        ->setCellValue('C'.$i, $v['staff_name'])  
                        ->setCellValue('D'.$i, $v['service_content'])  
                        ->setCellValue('E'.$i, $v['total'])  
                        ->setCellValue('F'.$i, $v['is_offline_pay']);  
            $i++;
            $result[] = $v;
		// return $v;
		}
		// return $result;
		$phpexcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(40);
		$phpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$phpexcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$phpexcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$phpexcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$phpexcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
		$phpexcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
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

	public function addRemark()
	{
		if(IS_POST){
			$res = $this->obj->where(['id' => I('get.id')])->setField('admin_remark',I('post.admin_remark'));
			if ($res) {
				$this->success('备注成功');exit;
			}
			$this->error('备注失败');exit;
		}
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

	public function getExcel()
	{
		Vendor('PHPExcel.PHPExcel');
		Vendor('PHPExcel.PHPExcel.IOFactory');
		Vendor('PHPExcel.PHPExcel.Style.Alignment');
		$alignment = new \PHPExcel_Style_Alignment();
		$res = $this->obj->excelBefore();
		// return $res;
		$phpexcel = new \PHPExcel(); 
		$phpexcel->getActiveSheet()->setTitle($res['name']);
		$phpexcel->getActiveSheet()  
                  ->setCellValue('A1','序号')  
                  ->setCellValue('B1','订单状态')  
                  ->setCellValue('C1','支付形式')  
                  ->setCellValue('D1','预约订单号')  
                  ->setCellValue('E1','微信订单号(线上支付才会生成)')  
                  ->setCellValue('F1','预约信息')  
                  ->setCellValue('G1','支付金额(元)')  
                  ->setCellValue('H1','买家信息')  
                  ->setCellValue('I1','商户备注') 
                  ->setCellValue('J1','交易时间') 
                  ->setCellValue('K1','交易完成时间'); 
        $i = 2;
		foreach ($res['list'] as $k => $v) {
			
			$v['staff_data'] = '发型师:'.$v['staffInfo']['store_nickname'].';服务项目:'.($v['service_content']?$v['service_content']:'未进行服务');
			$phpexcel->getActiveSheet()   
                        ->setCellValue('A'.$i, $k+1)  
                        ->setCellValue('B'.$i, $v['status'])  
                        ->setCellValue('C'.$i, $v['is_offline_pay'])  
                        ->setCellValue('D'.$i, $v['subscribe_number'])  
                        ->setCellValue('E'.$i, $v['wechat_order_number']?' '.$v['wechat_order_number']:'无线上支付操作')  
                        ->setCellValue('F'.$i, $v['staff_data'])  
                        ->setCellValue('G'.$i, $v['wechat_total'])    
                        ->setCellValue('H'.$i, $v['buyer'])    
                        ->setCellValue('I'.$i, $v['admin_remark'])       
                        ->setCellValue('J'.$i, date('Y年m月d日 H:i:s',$v['create_time']))
                        ->setCellValue('K'.$i, $v['complete_time']?date('Y年m月d日 H:i:s',$v['complete_time']):'未完成');  
            $i++;
            $result[] = $v;
		// return $v;
		}
		// return $result;
		$phpexcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(40);
		$phpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$phpexcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$phpexcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$phpexcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$phpexcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
		$phpexcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
		$phpexcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$phpexcel->getActiveSheet()->getColumnDimension('H')->setWidth(50);
		$phpexcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
		$phpexcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$phpexcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
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
}
?>