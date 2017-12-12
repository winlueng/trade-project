<?php 
namespace PT2\Model;

use Think\Model;

class CommonModel extends Model
{
	public $redis;// redis缓存

	public $ip;// 当前浏览者ip

	public $pInfo;

	public $wechat;

	public $userInfo;

	protected $tx_sms;// 腾讯云短信api

	public $config;

	public function __construct()
	{
		parent::__construct();

		$this->redis 	= new \Redis();

		$this->redis->connect('127.0.0.1', 6379);

		$this->ip 		= get_client_ip();

		$this->pInfo    = $this->redis->get('B_url_'.sha1($_SERVER['HTTP_HOST']));

		$this->pInfo 	= json_decode($this->pInfo, true);

        $this->config   = $this->get_config($this->redis,$this->pInfo);

        $this->wechat   = new \Gaoming13\WechatPhpSdk\Api($this->config);
        
		$this->userInfo = session('visitorInfo');

		$this->tx_sms   = new \wechat\SmsSingleSender(C('SMS_APPID'), C('SMS_APPKEY'));
	}

	/**
	 * 保存统计信息
	 * @return [type] [description]
	 */
	public function saveStatis($table = '', $id = '')
	{
		if (!$table || !$id) return false;
		
		if (!$this->redis->get('B_'.$table.'_'.$id .'_by_'.$this->userInfo['id'])) {// 记录统计
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
			$this->redis->setex('B_'.$table.'_'.$id .'_by_'.$this->userInfo['id'], 43200, '1');
		}
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
	 * 处理并返回员工完整路径
	 */
	/*public function handleStaffLink($id)
	{
		$companyID = M('Staff')->where(['id' => $id])->getField('company_id');
		$info = M('Company')->field('web_postfix, template_id, relevance_id')->where(['id' => $companyID])->find();
		$hostLink = M('Project')->where(['id' => $info['relevance_id']])->getField('project_link');
		$template = M('TemplateChange')->where(['id' => $info['template_id']])->getField('template_path');
		$result = 'http://'.$hostLink.'/'.$template.'/Staff/staffInfo/companyName/'.$info['web_postfix'].'/id/'.$id;
		return $result;
	}*/

	/**
	 * 根据地理坐标获取国家、省份、城市，及周边数据类(利用百度Geocoding API实现)
	 * 百度密钥获取方法：http://lbsyun.baidu.com/apiconsole/key?application=key（需要先注册百度开发者账号）
	 * Date:    2015-07-30
	 * Author:  fdipzone
	 * Ver: 1.0
	 *
	 * Func:
	 * Public  getAddressComponent 根据地址获取国家、省份、城市及周边数据
	 * Private toCurl              使用curl调用百度Geocoding API
	 */
	    // 百度Geocoding API
	    const API = 'http://api.map.baidu.com/geocoder/v2/';

	    // 不显示周边数据
	    const NO_POIS = 0;

	    // 显示周边数据
	    const POIS = 1; 

	    /**
	     * 根据地址获取国家、省份、城市及周边数据
	     * @param  String  $ak        百度ak(密钥)
	     * @param  Decimal $longitude 经度
	     * @param  Decimal $latitude  纬度
	     * @param  Int     $pois      是否显示周边数据
	     * @return Array
	     */
	    public function getAddressComponent($ak, $longitude, $latitude, $pois=self::NO_POIS){

	        $param = array(
	                'ak' => $ak,
	                'location' => implode(',', array($longitude, $latitude)),
	                'pois' => $pois,
	                'output' => 'json',
	                'callback' => 'renderReverse'
	        );
	        // 请求百度api
	        $response = self::toCurl(self::API, $param);
	        $result = array();

	        if($response){
	            $result = json_decode($response, true);
	        }

	        return $result;

	    }

	    /**
	     * 使用curl调用百度Geocoding API
	     * @param  String $url    请求的地址
	     * @param  Array  $param  请求的参数
	     * @return JSON
	     */
	    private function toCurl($url, $param=array()){

	        $ch = curl_init();

	        if(substr($url,0,5)=='https'){
	            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
	            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
	        }

	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($ch, CURLOPT_URL, $url);
	        curl_setopt($ch, CURLOPT_POST, true);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));

	        $response = curl_exec($ch);

	        if($error=curl_error($ch)){
	            return false;
	        }

	        curl_close($ch);

	        return $response;

	    }

}


 ?>