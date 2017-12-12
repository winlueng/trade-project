<?php 
namespace Template00003\Controller;

use Think\Controller;

class ExpressController extends CommonController
{
	public function showExpressInfo()
	{
		if (I('get.id')) {
			$info = M('OrderForm')->field('order_number,update_time,express_name,express_number')
					->where(['id' => I('get.id'), 'visitor_id' => $this->userInfo['id']])
					->find();
			$info['expressName'] = M('Express')->where(['coding' => $info['express_name']])->getField('name');
			$data = [
				'ShipperCode'  => $info['express_name'],
				'LogisticCode' => $info['express_number'],
			];

			$info['express'] = orderTracesSubByJson(json_encode($data));
			$info['express'] = json_decode($info['express'], true);
			$info['express']['expressLast'] = array_pop($info['express']['Traces']);
			array_push($info['express']['Traces'],$info['express']['expressLast'] );
			$this->assign('info', $info);
			$this->display();
		}else{
			E('无任何参数');
		}
	}

}