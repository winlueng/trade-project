<?php 
namespace Admin\Controller;

use Think\Controller;
use Think\Exception;

/**
* 前台用户类
*/
class WechatRefundController extends CommonController
{
	private $obj;
	public function __construct()
	{
		parent::__construct();
		$this->obj = D('WechatRefund');

	}

	/**
	 * 自营退款
	 */
	public function orderListByProject()
	{
		$where = [
			'company_id' => '0',
			'relevance_id' => $this->userInfo['relevance_id'],
			'status'	=> ['neq', '-1']
		];
		$res = $this->obj->orderList($where);
		if (I('get.getExcel')) {
			$res = $this->getExcel($where);
			// dump($res);exit;
		}
		$this->assign('list', $res['list']);
		$this->assign('page', $res['page']);
		$this->display();
	}

	// 商盟退款
	public function companyOrderListByProject()
	{
		$where = [
			'company_id' => ['neq', '0'],
			'relevance_id' => $this->userInfo['relevance_id'],
			'status'	=> ['neq', '-1']
		];
		$res = $this->obj->orderList($where);
		if (I('get.getExcel')) {
			$res = $this->getExcel($where);
			// dump($res);exit;
		}
		$companyList = M('Company')->field('id, company_name')->where(['relevance_id' => $this->userInfo['relevance_id']])->select();
		$this->assign('companyList', $companyList);
		$this->assign('list', $res['list']);
		$this->assign('page', $res['page']);
		$this->display();
	}

	public function orderDetailByProject()
	{
		$where = [
			'company_id' => '0',
			'relevance_id' => $this->userInfo['relevance_id'],
			'status'	=> ['neq', '-1'],
			'id'		=> I('get.id')
		];
		$info = $this->obj->orderInfo($where);
		// dump($info);exit;
		$this->assign('info', $info);
		$this->display();
	}

	public function companyOrderDetailByProject()
	{
		$where = [
			'company_id' => ['neq', '0'],
			'relevance_id' => $this->userInfo['relevance_id'],
			'status'	=> ['neq', '-1'],
			'id'		=> I('get.id')
		];
		$info = $this->obj->orderInfo($where);
		$this->assign('info', $info);
		$this->display();
	}

	

	public function ajaxControl()
	{
		if(!IS_AJAX) E('非法访问');

		$this->ajaxReturn($this->obj->ajaxControl(I('get.flag'))) ;		
	}

	public function getExcel($where)
	{
		Vendor('PHPExcel.PHPExcel');
		Vendor('PHPExcel.PHPExcel.IOFactory');
		Vendor('PHPExcel.PHPExcel.Style.Alignment');
		$alignment = new \PHPExcel_Style_Alignment();
		$res = $this->obj->excelBefore($where);
		// return $res;
		$phpexcel = new \PHPExcel(); 
		$phpexcel->getActiveSheet()->setTitle($res['name']);
		$phpexcel->getActiveSheet()  
                  ->setCellValue('A1','序号')  
                  ->setCellValue('B1','退款状态')  
                  ->setCellValue('C1','原销售订单号')  
                  ->setCellValue('D1','退款订单号')  
                  ->setCellValue('E1','微信退款单号')  
                  ->setCellValue('F1','订单金额(元)')  
                  ->setCellValue('G1','退款金额(元)')  
                  ->setCellValue('H1','商品信息')  
                  ->setCellValue('I1','买家信息') 
                  ->setCellValue('J1','退款理由') 
                  ->setCellValue('K1','同意或拒绝理由') 
                  ->setCellValue('L1','申请时间')
                  ->setCellValue('M1','完成时间'); 
        if ($where['company_id'][0] == 'neq') {
			$phpexcel->getActiveSheet()->setCellValue('N1','商盟店铺名称');
		}
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
                        ->setCellValue('C'.$i, ' '.$v['out_trade_no'])  
                        ->setCellValue('D'.$i, ' '.$v['out_refund_no'])  
                        ->setCellValue('E'.$i, $v['refund_id']?' '.$v['refund_id']:'未操作')  
                        ->setCellValue('F'.$i, $v['total_fee'])  
                        ->setCellValue('G'.$i, $v['refund_fee'])    
                        ->setCellValue('H'.$i, $v['goods_data'])    
                        ->setCellValue('I'.$i, $v['address_id'])    
                        ->setCellValue('J'.$i, $v['refund_remark'])       
                        ->setCellValue('K'.$i, $v['admin_remark'])       
                        ->setCellValue('L'.$i, date('Y-m-d H:i:s',$v['create_time']))
                        ->setCellValue('M'.$i, $v['update_time']?date('Y-m-d H:i:s',$v['update_time']):'未操作'); 
            if ($v['company_id']) {
				$v['company_name'] = M('Company')->where(['id' => $v['company_id']])->getField('company_name');
				$phpexcel->getActiveSheet()->setCellValue('N'.$i, $v['company_name']);
			}
            $i++;
            $result[] = $v;
		}
		// return $result;
		$phpexcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(40);
		$phpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$phpexcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$phpexcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		$phpexcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$phpexcel->getActiveSheet()->getColumnDimension('E')->setWidth(33);
		$phpexcel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
		$phpexcel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
		$phpexcel->getActiveSheet()->getColumnDimension('H')->setWidth(600);
		$phpexcel->getActiveSheet()->getColumnDimension('I')->setWidth(100);
		$phpexcel->getActiveSheet()->getColumnDimension('J')->setWidth(60);
		$phpexcel->getActiveSheet()->getColumnDimension('K')->setWidth(60);
		$phpexcel->getActiveSheet()->getColumnDimension('L')->setWidth(60);
		$phpexcel->getActiveSheet()->getColumnDimension('M')->setWidth(60);
		if ($where['company_id'][0] == 'neq') {
			$phpexcel->getActiveSheet()->getColumnDimension('N')->setWidth(60);
		}
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