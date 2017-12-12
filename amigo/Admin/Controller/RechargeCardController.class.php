<?php 
namespace Admin\Controller;

use Think\Controller;

/**
* 流水账类
*/
class RechargeCardController extends CommonController
{
	private $obj;
	public function __construct()
	{
		parent::__construct();
		$this->obj = D('RechargeCard');
	}

	// 
	public function cardList()
	{
		$list = $this->obj->cardList();
		// dump($list);exit;
		$this->assign('list', $list['list']);
		$this->assign('page', $list['page']);
		$this->display();
	}

	// 未使用卡
	public function not_use_card_info()
	{
		$info = $this->obj->card_info('1');
		// dump($info);exit;
		if (I('get.downloadExcel')) {
			$this->downloadExcel('1');
		}
		$this->assign('list', $info['list']);
		$this->assign('page', $info['page']);
		$this->display();
	}

	// 已使用卡
	public function used_card_info()
	{
		$info = $this->obj->card_info('2');
		if (I('get.downloadExcel')) {
			$this->downloadExcel('2');
		}
		$this->assign('list', $info['list']);
		$this->assign('page', $info['page']);
		$this->display();
	}

	public function cardAdd()
	{
		if (IS_POST) {
			$res = $this->obj->cardAdd();
			if ($res) {
				$this->success('生成成功', '/Admin/RechargeCard/not_use_card_info/module/2/card_id/'.$res);exit;
			}
			$this->error($this->obj->getError());exit;
		}
		$this->display();
	}

	public function ajaxControl()
	{
		if(IS_AJAX) {
			$this->ajaxReturn($this->obj->ajaxControl(I('get.flag'))) ;
		}
	}

	public function downloadExcel($flag)
	{
		Vendor('PHPExcel.PHPExcel');
		Vendor('PHPExcel.PHPExcel.IOFactory');
		Vendor('PHPExcel.PHPExcel.Style.Alignment');
		$alignment = new \PHPExcel_Style_Alignment();
		$res  = $this->obj->downloadExcelBefore($flag);
		// dump($res);exit;
		$name = '充值卡';
		$phpexcel = new \PHPExcel(); 
		$phpexcel->getActiveSheet()->setTitle($name);
		$phpexcel->getActiveSheet()  
                  ->setCellValue('A1','序号')  
                  ->setCellValue('B1','会员卡号')  
                  ->setCellValue('C1','充值序列号')  
                  ->setCellValue('D1','充值金额')  
                  ->setCellValue('E1',$flag =='2'?'用户昵称':'')
                  ->setCellValue('F1',$flag =='2'?'用户手机':'');
        $i = 2;
		foreach ($res as $k => $v) {
			$phpexcel->getActiveSheet()   
                        ->setCellValue('A'.$i, $i-1)  
                        ->setCellValue('B'.$i, $v['card_number'])  
                        ->setCellValue('C'.$i, $v['serial_number'])
                        ->setCellValue('D'.$i, $v['money'])
                        ->setCellValue('E'.$i, $flag =='2'?$v['nick_name']:'')
                        ->setCellValue('F'.$i, $flag =='2'?$v['phone']:''); 
            $i++;
		}
		// return $result;
		$phpexcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(40);
		$phpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$phpexcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$phpexcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		$phpexcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$phpexcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
		$phpexcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
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

}

 ?>