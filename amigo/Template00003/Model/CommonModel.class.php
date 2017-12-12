<?php 
namespace Template00002\Model;

use Think\Model;

class CommonModel extends Model
{
	public $redis;// redis缓存

	public $ip;// 当前浏览者ip

	public $companyInfo;// 店铺资料

	public $wechat;

	public $userInfo;

	public $tx_sms;// 腾讯云短信api

	public $pInfo;

	public function __construct()
	{
		parent::__construct();

		$this->redis 		= new \Redis;

		$this->redis->connect('127.0.0.1', 6379);

		$this->pInfo    	= $this->redis->get('B_url_'.sha1($_SERVER['HTTP_HOST']));

		$this->pInfo 		= json_decode($this->pInfo, true);

		$config 			= $this->get_config($this->redis,$this->pInfo);
        
        $this->wechat 		= new \Gaoming13\WechatPhpSdk\Api($config);

		$this->ip 			= get_client_ip();

		$this->companyInfo 	= $this->redis->get('B_companyInfo_By_webpostfix_'.I('get.companyName'));

		$this->companyInfo 	= json_decode($this->companyInfo, true);

		$this->userInfo 	= session('visitorInfo');

		$this->tx_sms   	= new \wechat\SmsSingleSender(C('SMS_APPID'), C('SMS_APPKEY'));
	}

	/**
	 * 保存统计信息
	 * @return [type] [description]
	 */
	public function saveStatis($table = '', $id = '')
	{
		if (!$table || !$id) return false;
		if (!S('B_'.$table.'_'.$id .'_by_'.$this->ip)) {// 记录统计
			$obj = M($table);
			$where = array(
				'relevance_id' => $id,
				'date'	  => strtotime('today'),
			);
			$find = $obj->where($where)->find();

			if (!$find) 
			{
				$obj->data($where)->add();
			}else{
				$obj->where($where)->setInc("visit_total",1);
			}
			S('B_'.$table.'_'.$id .'_by_'.$this->ip, '1', 43200);
		}
	}

	/**
     * 初始化公众号基本信息
     */
    public function get_config($redis, $info)
    {
        $config = [
            'appId'             => $info['app_id'],
            'appSecret'         => $info['app_secret'],
            'mchId'             => $info['mch_id'],
            'key'               => $info['mch_sectet'],
            'get_access_token'  => function ($appId) use ($redis){
                return $redis->get('B_AccessToken_'.$appId);
            },
            'save_access_token' => function ($appId, $token) use ($redis){
                return $redis->setex('B_AccessToken_'.$appId, 7150, $token);
            } ,
            'get_jsapi_ticket'  => function ($appId) use ($redis){
                return $redis->get('B_JsApiTicket_'.$appId);
            },
            'save_jsapi_ticket' => function ($appId, $ticket) use ($redis) {
                return $redis->setex('B_JsApiTicket_'.$appId, 7150, $ticket);
            },
            'get_api_ticket'  => function ($appId) use ($redis){
                return $redis->get('B_ApiTicket_'.$appId);
            },
            'save_api_ticket' => function ($appId, $ticket) use ($redis) {
                return $redis->setex('B_ApiTicket_'.$appId, 7150, $ticket);
            },
        ];
        return $config;
    }

	/**
	 * 处理并返回商品完整路径
	 */
	public function handleGoodsLink($id)
	{
		$info = M('Goods')->field('company_id, relevance_id')->where(['id' => $id])->find();
		$pInfo = M('Project')->field('project_link, template_id')->where(['id' => $info['relevance_id']])->find();
		
		if ($info['company_id'] == '0') {
			$data['template_id'] = $pInfo['template_id'];
			$str  = '';
		}else{
			$data = M('Company')->field('web_postfix, template_id')->where(['id' => $info['company_id']])->find();
			$str  = '?companyName='.$data['web_postfix'];
		}

		$template = M('TemplateChange')->where(['id' => $data['template_id']])->getField('template_path');
		return 'http://'.$pInfo['project_link'].'/'.$template.'/Goods/goodsDetail/id/'.$id.$str;
	}

	/**
	 * 处理并返回员工完整路径
	 */
	public function handleStaffLink($id)
	{
		$companyID = M('Staff')->where(['id' => $id])->getField('company_id');
		$info = M('Company')->field('web_postfix, template_id, relevance_id')->where(['id' => $companyID])->find();
		$hostLink = M('Project')->where(['id' => $info['relevance_id']])->getField('project_link');
		$template = M('TemplateChange')->where(['id' => $info['template_id']])->getField('template_path');
		$result = 'http://'.$hostLink.'/'.$template.'/Staff/staffInfo/companyName/'.$info['web_postfix'].'/id/'.$id;
		return $result;
	}
}


 ?>