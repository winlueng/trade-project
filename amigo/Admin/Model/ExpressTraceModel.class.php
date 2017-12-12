<?php 
namespace Admin\Model;

use Think\Model;
use Think\Exception;

class ExpressTraceModel extends CommonModel
{
	protected $_validate = [
		['order_number','','订单号已经存在！',0,'unique',1],
		['express_number','','物流单号已经存在！',0,'unique',1]
	];

	public function __construct()
	{
		parent::__construct();
	}

	// 物流发货
	public function expressSend($data)
	{
		if ($this->validate($this->_validate)->create()) {
			$res = $this->add($data);
			if (!$res) return ['status' => 'false', 'err_msg' => '添加轨迹初始数据失败'];
			$express = [
				'ShipperCode'  => $data['express_coding'],
				'LogisticCode' => $data['express_number'],
				'OrderCode'    => $data['order_number'],
			];
			$res = orderTracesSubByJson(json_encode($express));
			$res = json_decode($res, true);
			if ($res['Success']) {
				return ['status' => 'true'];
			}
			return ['status' => 'false', 'err_msg' => '请求快递鸟接口失败,请再次重试'];
		}
		return ['status' => 'false', 'err_msg' => $this->getError()];
	}

	/**
	 * 快递鸟推送接收接口
	 * @param  array $data 接收回来的物流轨迹
	 * @return array       ['status' => true/false, 'err_msg' => '']
	 * @remark state: 0-无轨迹,1-已揽收,2-在途中 201-到达派件城市,3-签收,4-问题件
	 */
	public function traceUpdate($data)
	{
		$this->startTrans();
		try {
			foreach ($data as $v) {
				if (!$v['Success']) throw new Exception("其中一条数据推送出错");
				
				if ($v['EBusinessID'] != C('EXPRESS_ID')) throw new Exception("其中一条数据不属于当前商户");

				$save = [
					'trace' => json_encode($v['Traces']),
					'state' => $v['State'],
					'update_time' => time(),
				];

				$where = [
					'express_coding'	=> $v['ShipperCode'],
					'express_number'	=> $v['LogisticCode'],
				];

				$res = $this->where($where)->save($save);
				if($res) 
				{
					$order_number = $this->where($where)->getField('order_number');
					if (in_array((string)$v['State'], ['1','3'])) {// 快递揽收或已签收时, 会发送消息提醒
						$content = [
							1 => '已揽收',
							3 => '已签收',
						];
						$info = $this->getExpressInfo($order_number);
						$newsData = [
							'obj_id'  		=> $info['visitor_id'],
							'title' 		=> '您好,您的快递订单'.$content[$v['State']],
							'create_time' 	=> time(),
							'url'			=> $info['url'],
							'content'		=> '订单编号为'.$order_number.'有更新,请点击查看详情',
						];
						
						M('SystemNews')->add($newsData);
						$sendNews = [
							'state' 	=> $content[$v['State']],
							'consignee' => $info['address_id']['consignee'],
							'phone'		=> $info['address_id']['phone'],
							'url'		=> $info['url'],
							'visitor_id'=> $info['visitor_id']
						];
						$where = array_merge($where, $sendNews);
						$this->sendNews($where);
						if ($v['State'] == '3') {
							$res = M('OrderForm')->where(['order_number' => $order_number])->save(['is_send_out' => 2, 'update_time' => time()]);
							if(!$res) throw new Exception("修改订单状态失败");
						}
					}
				}
			}
			$this->commit();
			return ['status' => 'true', 'err_msg' => ''];
		} catch (Exception $e) {
			$this->rollback();
			return ['status' => 'false', 'err_msg' => $e->getMessage()];
		}
	}

	public function getExpressInfo($order_number)
	{
		$info = M('OrderForm')->field('id, relevance_id, visitor_id, address_id')->where(['order_number' => $order_number])->find();
		$pInfo 	= M('Project')->field('project_link, template_id')->where(['id' => $info['relevance_id']])->find();
		$res[0] = 'http://'.$pInfo['project_link'];
		$res[1] = M('TemplateChange')->where(['id' => $pInfo['template_id']])->getField('template_path');
		
		$info['url'] = $res[0].U($res[1].'/Express/showExpressInfo', ['id' => $info['id']]);
		$info['address_id'] = json_decode($info['address_id'], true);
		return $info;
	}

	public function sendNews($info)
	{
		$openID = M('WechatVisitor')
				->where(['id' => $info['visitor_id']])
				->getField('open_id');
		$express_name = M('Express')
					->where(['coding' => $info['express_coding']])
					->getField('name');
		$templateID = $this->wechatTemplateReturn('OPENTM408645906');
		$news =  [
				'first' 	=> ['value' => '您的物流运单状态已更新'],
				'keyword1' 	=> ['value' => $info['state']],
				'keyword2' 	=> ['value' => $express_name],
				'keyword3' 	=> ['value' => $info['express_number']],
				'keyword4' 	=> ['value' => $info['consignee']],
				'keyword5' 	=> ['value' => $info['phone']],
				'remark' 	=> ['value' => '谢谢您的支持,亲.']
			];
		$url = $info['url'];
		$this->wechat->send_template_news($openID, $templateID, $news, $url);// 发送消息给用户
	}
}

 ?>