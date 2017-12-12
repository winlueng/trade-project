<?php
namespace Gaoming13\WechatPhpSdk;

use Gaoming13\WechatPhpSdk\Utils\Prpcrypt;
use Gaoming13\WechatPhpSdk\Utils\SHA1;

class JSSDK 
{
  private $appId;
  private $appSecret;
  private $redis;

  /**
   * @param $appId 公众号id
   * @param $appSecret 公众号密钥
   * @param $cardId 卡券id
   */
  public function __construct($appId, $appSecret) {
    $this->appId = $appId;
    $this->appSecret = $appSecret;
    $this->redis = new \Redis();
    $this->redis->connect('127.0.0.1', 6379);
  }

  public function getSignPackage() {
    $jsapiTicket = $this->getJsApiTicket();
    $apiTicket   = $this->getJsApiCardTicket();

    // 注意 URL 一定要动态获取，不能 hardcode.
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $timestamp = time();
    $nonceStr  = $this->createNonceStr();

   //卡券ID

    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket={$jsapiTicket}&noncestr={$nonceStr}&timestamp={$timestamp}&url={$url}";

    $signature = sha1($string);

    $signPackage = array(
      "appId"       => $this->appId,
      "nonceStr"    => $nonceStr,
      "timestamp"   => $timestamp,
      "url"         => $url,
      "signature"   => $signature,
      "rawString"   => $string,
      "Card"        => $this->AddCard($this->cardId),
    );
    return $signPackage; 
  }

  public function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }

  //批量添加卡券
  public function AddCard($CardID) {
    $array = array();
    for ($i=0; $i < count($CardID); $i++) { 
      $timestamp = time();
      $nonceStr  = $this->createNonceStr();
      $apiTicket = $this->getJsApiCardTicket();
      $card_ticket_api = array(
        "timestamp" => $timestamp,
        "nonceStr"  => $nonceStr,
        "apiTicket" => $apiTicket,
        "cardId"    => $CardID[$i],
      );
      sort($card_ticket_api, SORT_STRING);
      $card_ticket = implode($card_ticket_api);
      $card_ticket = sha1($card_ticket);
      // $array[] = ('{cardId: "' . $CardID[$i] . '",cardExt:{"code": "", "openid": "", "timestamp": "' . $timestamp . '", "nonce_str": "' . $nonceStr . '", "signature": "' . $card_ticket . '"}}');//单引号换成双引号
      $array[] = array("CardID" => "{$CardID[$i]}", "timestamp" => $timestamp, "nonce_str" => "{$nonceStr}", "Card_Ticket" => "{$card_ticket}","apiTicket" => $apiTicket);
    }
    return $array;
  }

  public function getJsApiTicket() {
    // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = $this->redis->get('JsApiTicket_'.$this->appId);
    if (!$data) {
      $accessToken = $this->getAccessToken();
      // 如果是企业号用以下 URL 获取 ticket
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
      $res = json_decode($this->httpGet($url));
      $ticket = $res->ticket;
      $this->redis->set('JsApiTicket_'.$this->appId, $ticket, 7100);
    } else {
      $ticket = $data;
    }

    return $ticket;
  }

  public function getJsApiCardTicket() 
  {
    // api_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
     $data = $this->redis->get('ApiCardTicket_'.$this->appId);
    if(!$data) 
    {
      $accessToken = $this->getAccessToken();
      // 如果是企业号用以下 URL 获取 ticket
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$accessToken&type=wx_card";
      $res = json_decode($this->httpGet($url));
      $Cardticket = $res->ticket;
      $this->redis->set('ApiCardTicket_'.$this->appId, $Cardticket, 7100);
    } else {
      $Cardticket = $data;
    }
    return $Cardticket;
  }

  public function getAccessToken() 
  {
    // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = $this->redis->get('AccessToken_'.$this->appId);
    if (!$data) {
      // 如果是企业号用以下URL获取access_token
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
      $res = json_decode($this->httpGet($url));
      $access_token = $res->access_token;
      $this->redis->set('AccessToken_'.$this->appId, $access_token, 7100);
    } else {
      $access_token = $data;
    }
    return $access_token;
  }

  public function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
    // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
  }

}

