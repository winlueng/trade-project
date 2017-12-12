<?php
return array(
    //'配置项'=>'配置值'
    'DB_TYPE'               =>  'mysql',        // 数据库类型
    'DB_HOST'               =>  '10.66.119.252',  // 服务器地址
    'DB_NAME'               =>  'amigo',           // 数据库名
    'DB_USER'               =>  'root',         // 用户名
    'DB_PWD'                =>  'sheng0123',         // 密码
    'DB_PORT'               =>  '3306',         // 端口
    'DB_PREFIX'             =>  'market_',          // 数据库表前缀

    'URL_MODEL'             =>  2,// 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
    'TMPL_L_DELIM'          =>  '{{',// 模板引擎普通标签开始标记
    'TMPL_R_DELIM'          =>  '}}',// 模板引擎普通标签结束标记
    //'SHOW_PAGE_TRACE'         =>  true,// 显示页面Trace信息
    //'SHOW_ERROR_MSG' => true,//显示错误位置
    'URL_CASE_INSENSITIVE'  => false,//URL区分大小写(true不区分大小写,false区分大小写)
    'READ_DATA_MAP'         =>  true,
    // 'LAYOUT_ON'             =>  true,
    // 配置邮件发送服务器
    'MAIL_HOST'     =>'smtp.exmail.qq.com',//smtp服务器的名称
    'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
    'MAIL_USERNAME' =>'message@gdkbvip.com',//你的邮箱名
    'MAIL_FROM'     =>'message@gdkbvip.com',//发件人地址
    'MAIL_FROMNAME' =>'旷邦科技留言通知',//发件人姓名
    'MAIL_PASSWORD' =>'x11K8T6TXlocHkXVLPEUuF8KEBC7z6EW',//邮箱密码
    'MAIL_CHARSET'  =>'utf-8',//设置邮件编码
    'MAIL_ISHTML'   =>TRUE, // 是否HTML格式邮件

    'SUPER_USER_ID' => 1,       //超级管理员ID
    // 'CARD_EXPRESS_URL'      => 'trade.gdkbvip.com',
    'ADMIN_BACKGROUND'      => 'admin.chinaimigo.com',// 总管理后台
    'PROJECT_BACKGROUND'    => 'project.chinaimigo.com',// 大门户后台
    'COMPANY_BACKGROUND'    => 'company.chinaimigo.com',// 子商户后台

    'MODULE_ALLOW_LIST' => array('Home','Admin','Common','PT1','PT2','Template00002','Template00003'),
    'URL_ROUTER_ON'     => true,
    'URL_ROUTE_RULES'   => array(
        ':companyUserName$' => 'Home/Common/jumpToCompanyHost',
        ),

    /*'TOKEN_ON'      =>    true,          // 是否开启令牌验证 默认关闭
    'TOKEN_NAME'    =>    '__hash__',    // 令牌验证的表单隐藏字段名称，默认为__hash__
    'TOKEN_TYPE'    =>    'md5',         //令牌哈希验证规则 默认为MD5
    'TOKEN_RESET'   =>    true, */         //令牌验证出错后是否重置令牌 默认为true

    // 'CARD_EXPRESS_URL'          => 'new.gdkbvip.com',
    /***村村通公众号***/
    'MCH_ID'                    => '1317829401', //微信支付商户号
    'API_KEY'                   => 'kuangbangweixinzhifuhaohaodeyong',// API 密钥
    /***旷邦短信业务***/  
    'SMS_APPID'                 => 1400051436,  //腾讯云短信验证的appid
    'SMS_APPKEY'                => '7acf86c5fdee3ee115d26902a3025b6c',  //腾讯云短信验证的appkey
    
    'WECHAT_HOST_LINK'          => 'salon.gdkbvip.com',  // 绑定公众号的安全域名
    'IMG_DIR'                   => './Public',

    'EXPRESS_ID'                => '1306130',// 快递鸟id,
    'EXPRESS_SECRET'            => '93f8a59d-a27b-441c-a5e3-369bc0886bd1',// 快递鸟密匙
    'ReqURL'                    => 'http://testapi.kdniao.cc:8081/api/dist',// 快递鸟测试接口
    'EXPRESS_TRUE_URL'          => 'http://api.kdniao.cc/api/dist', // 快递鸟正式访问

    'BAIDU_API_KEY'             => '9hDsI3BU4MI8HU0opHDIA8hC9H7fNMek',// 百度地图接口KEY
    'EARTH_RADIUS'              => 6371,// 地球平均半径
);
