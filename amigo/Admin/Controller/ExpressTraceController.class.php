<?php
namespace Admin\Controller;

use Think\Controller;

// 物流轨迹类
class ExpressTraceController extends Controller 
{
    public function __construct()
    {
        parent::__construct();
    }

    // 接收快递鸟推送轨迹
    public function receiveExpress()
    {
        $data = file_get_contents('php://input');
        $msg  = explode("&", $data);  
        foreach ($msg as $k => $v) {  
            $p = explode("=", $v);  
            if ($p[0] == "RequestData") {  
                $result[$p[0]] = json_decode(urldecode($p[1]),true);  
            } else {  
                $result[$p[0]] = urldecode($p[1]);  
            }  
        }
        $res = D('ExpressTrace')->traceUpdate($result['RequestData']['Data']);
        /*echo '<pre>';
        print_r($res);exit;*/
        echo '{
                "EBusinessID": "'.$result['RequestData']['EBusinessID'].'",
                "UpdateTime": "'. date('Y-m-d H:i:s', time()) .'",
                "Success": "'. $res['status'] .'",
                "Reason": "'. $res['err_msg'] .'"
            }';
    }
/*
    public function testTrace()
    {
        $data = [
            'ShipperCode'   => 'HTKY',
            'LogisticCode'  => '50552289809689',
            'OrderCode'     => '123'
        ];
        $express = orderTracesSubByJson(json_encode($data));
            // $this->redis->setex('express_'.$info['express_name'].$info['express_number'], 3600, $express);
        $show = json_decode($express, true);
        dump($data);
        dump($show);
    }*/
}
?>