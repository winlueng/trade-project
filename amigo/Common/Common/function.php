<?php 
    function sendMail($to, $title, $content) {
     
        // require_once './ThinkPHP/Library/Org/Email/class.phpmailer.php';
        Vendor('PHPMailer.class#phpmailer');
        // require_once './ThinkPHP/Library/Org/Email/class.smtp.php';
        $mail = new PHPMailer(); //实例化
        $mail->IsSMTP(); // 启用SMTP
        $mail->Host=C('MAIL_HOST'); //smtp服务器的名称（这里以QQ邮箱为例）
        $mail->SMTPAuth = C('MAIL_SMTPAUTH'); //启用smtp认证
        $mail->Port = 465;  //邮件发送端口
        $mail->SMTPSecure = 'ssl';// 链接方式如果使用QQ邮箱；需要把此项改为  ssl
        $mail->Username = C('MAIL_USERNAME'); //你的邮箱名
        $mail->Password = C('MAIL_PASSWORD') ; //邮箱密码
        $mail->From = C('MAIL_FROM'); //发件人地址（也就是你的邮箱地址）
        $mail->FromName = C('MAIL_FROMNAME'); //发件人姓名
        $mail->AddAddress($to,"旷邦");
        $mail->WordWrap = 50; //设置每行字符长度
        $mail->IsHTML(C('MAIL_ISHTML')); // 是否HTML格式邮件
        $mail->CharSet=C('MAIL_CHARSET'); //设置邮件编码
        $mail->Subject =$title; //邮件主题
        $mail->Body = $content; //邮件内容
        $mail->AltBody = "这是一个纯文本的身体在非营利的HTML电子邮件客户端"; //邮件正文不支持HTML的备用显示
        return($mail->Send());
    }

    // 用户密码加密
    function pwd_hash($pwd,$hash='')
    { 
        if($hash === ''){
            $options = [ 'cost' => 12, 'salt' => 'usesomesillystringforsalt' ];
            //return password_hash($key,PASSWORD_DEFAULT );
            return password_hash($pwd, PASSWORD_BCRYPT, $options);
        }else{  
            return password_verify ($pwd,$hash);
        }
    }

    /**
     * [showNavList 根据当前模块ID获取当前用户可显示的信息]
     * @return [array] [返回处理后的左侧导航栏列表]
     */
    function showNavList($moduleid = '')
    {
        // 获取URL的模块ID
        $moduleId = $moduleid?$moduleid:$_GET['module'];
        // 实例化module对象
        $module = M('Module');
        // 实例化权限rule对象
        $rule = M('AuthRule');
        // 查询当前module的所拥有的功能
        $moduleList = $module->where(['id' => $moduleId])->getField('parent_rules');
        // 分解得到的模块权限数据
        // $rulesList = explode(',', $moduleList['parent_rules']);
        $rulesList = $rule->where(['id' => ['in',$moduleList]])->order('control_time desc')->getField('id', true);
        // 获取用户id
        if ($_SESSION["adminInfo"]["id"]) 
        {
            $id = $_SESSION["adminInfo"]["id"];
        }else if($_SESSION['marketInfo']['id']){
            $id = $_SESSION['marketInfo']['id'];
        }
       
        // 定界符写出SQL,获取当前用户的权限
        $sql = <<<SQL
SELECT g.rules FROM `market_auth_group_access` AS a INNER JOIN `market_auth_group` AS g ON g.id=a.group_id AND a.uid='$id';
SQL;
        // return M()->query($sql)[0]['rules'];
        // 获取到的用户权限解析成数组
        $userRules = explode(',', M()->query($sql)[0]['rules']);
        // 父级权限与当前用户所有权限取交集,得到可以显示的父级权限
        $parentRulesList = array_intersect($rulesList, $userRules);
        // 遍历当前模块的功能与用户所有的功能取交集并处理得到可以显示的功能数组
        // return $parentRulesList;
       foreach ($parentRulesList as $k => $v) 
        {
            // 获取当前模块下面的子权限
            $childRules = $rule->where(['parent_id' => $v,'display' => 0,'status' => 1])->order('control_time desc')->getField('id', true);
            // 得到当前父权限的中文名称
            $newRulesList[$k]['parent_name'] = $rule->field('title,alias,name')->where(['id'=>$v])->find();
            // 当前子权限与当前用户所拥有的权限取交集
            $newRulesList[$k]['rules'] = array_intersect($childRules, $userRules);
            // 得到交集处理后的新数组,获取此新数组详细信息
            foreach ($newRulesList[$k]['rules'] as $ki => $vo) 
            {
                // 获取子权限的详细信息
                $newRulesList[$k]['rules'][$ki] = $rule->field('id ,name, alias, title')->where(['id'=>$vo])->find();
            }
        }
        // dump($newRulesList);exit; 
        return $newRulesList;
    }

    /**
     * [showModuleList 根据用户ID获取可显示模块列表]
     * @return [array] [返回显示模块的数组]
     */
    function showModuleList()
    {
        $moduleList = M('module')->field('id, module_name')->select();
        foreach ($moduleList as $k => $v) 
        {
            $res = showNavList($v['id']);
            if ($res == null) 
            {
                unset($moduleList[$k]);
            }
        }
        return $moduleList;
    }

    /**
     * [showCompanyNavList 商户后台的功能列表]
     * @return [arr] 返回功能列表数组
     */
    function showCompanyNavList()
    {
        $rule = M('AuthRule');

        $id = $_SESSION["companyInfo"]["id"];

        $sql = "SELECT g.rules FROM `market_auth_group_access` AS a INNER JOIN `market_auth_group` AS g ON g.id=a.group_id AND a.uid='{$id}'";

        $userRules = explode(',', M()->query($sql)[0]['rules']);

        $parentRuleList = $rule->where(['parent_id'=>0,])->order('control_time desc')->getField('id',true);

        $canShowUserRule = array_intersect($parentRuleList, $userRules);

        foreach ($canShowUserRule as $k => $v) 
        {
            // 获取当前模块下面的子权限
            $childRules = $rule->where(['parent_id' => $v,'display' => 0,'status' => 1])->order('control_time desc')->getField('id', true);
            // 得到当前父权限的中文名称
            $newRulesList[$k]['parent_name'] = $rule->field('title, alias,name')->where(['id'=>$v])->find();
            // 当前子权限与当前用户所拥有的权限取交集
            $rules = array_intersect($childRules, $userRules);
            if (empty($rules) && $rules !== null) {
                unset($newRulesList[$k]);//break;
            }else{
                $newRulesList[$k]['rules'] = $rules;
                // 得到交集处理后的新数组,获取此新数组详细信息
                foreach ($newRulesList[$k]['rules'] as $ki => $vo) 
                {
                    // 获取子权限的详细信息
                    $newRulesList[$k]['rules'][$ki] = $rule->field('id ,name, alias, title')->where(['id'=>$vo])->find();
                }
            }

        }
        return $newRulesList;
    }

    /**
     * 分类处理
     * @param  array $data  数据库查出来的数据组
     * @param  integer $pid   顶级分类id
     * @param  integer $count 用于计算输出空格
     * @return array  $rec      返回一个全新的数组
     */
    function getCate ($data, $pid = '0', $count = 0) 
    {
    //声明一个新数组，用来保存处理之后的数组
        static $rec = array();
        //遍历数组
            foreach ($data as $v) {
                //判断该条分类的记录的父id， 是否我们传进来的$pid的值
                if ($v['parent_id'] == $pid) {
                    //为每个分类添加缩进的级别
                    $v['count'] = $count;
                    //var_dump($v);  
                    $rec[] = $v;
                    //递归：数组，该条记录的id
                    getCate($data, $v['id'], $count +1);
                }
            }
        return $rec;
    }

    // 获取用户真实ip
    function getIPaddress()
    {

        $IPaddress='';

        if (isset($_SERVER))
        {

            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
            {

                $IPaddress = $_SERVER["HTTP_X_FORWARDED_FOR"];

            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {

                $IPaddress = $_SERVER["HTTP_CLIENT_IP"];

            } else {

                $IPaddress = $_SERVER["REMOTE_ADDR"];

            }

        } else {

            if (getenv("HTTP_X_FORWARDED_FOR"))
            {

                $IPaddress = getenv("HTTP_X_FORWARDED_FOR");

            } else if (getenv("HTTP_CLIENT_IP")) {

                $IPaddress = getenv("HTTP_CLIENT_IP");

            } else {

                $IPaddress = getenv("REMOTE_ADDR");

            }
        }

        return $IPaddress;
    }

    /**
     * 在某些特定方法进行前查询限制
     * @param $table 数据表名
     * @param $where 条件数组
     * @return $bool 查询存在时返回false
     */
    function checkChildInfo($table,$where)
    {
        if (is_array($where)) 
        {
            $obj = M($table);
            $result = $obj->where($where)->find();
            if (!$result) 
            {
                return true;
            }
        }
        return false;
    }

    /**
     * 区域祥址
     * @param  void    $dataArr    数据库查询出来的数组或一个值(格式['parant_id' => x值,其他值]或二维数组)
     * @param  string  $table      数据表名
     * @param  string  $name       查询字段
     * @return array   $returnList 返回数组(新增address地址格式如:[省-市-区])
     */
    function findRegionInfo($dataArr, $table, $name, $idName = 'id')
    {
        // 实例化
        $obj = M($table);
        // 判断是否数组
        if (is_array($dataArr)) 
        {
            static $res = array();
            // 遍历一层数组
            foreach ($dataArr as $k => $v) 
            {
                $result = array();
                // 判断是否二维数组
                if (is_array($v)) 
                {
                    // 判断是否顶级区域
                    if ($v['parent_id'] != 0) 
                    {
                        // 不是顶级则回调查询
                        $v['address'] = findRegionInfo($v['parent_id'],$table,$name,$idName);
                    }else{
                        $v['address'] = '顶级区域';
                    }
                }else{
                    // 不是二维数组则去回调查询
                    if ($dataArr['parent_id'] != 0) 
                    {
                        $v['address'] = findRegionInfo($dataArr['parent_id'],$table,$name,$idName);
                    }else{
                        $v['address'] = '顶级区域';
                    }
                }
                $res[] = $v;
            }
            return $res;
        }else{
            // 判断是否顶级区域
            if ($dataArr != 0) 
            {
                // 不是则查询父级区域
                $data = $obj->field('parent_id,'.$name)->where([$idName => $dataArr])->select()[0];
                $result[] = $data[$name];
                // 判断查询结果是否顶级区域
                if ($data['parent_id'] != 0) 
                {
                    // 不是则再来查
                    $result[] = findRegionInfo($data['parent_id'],$table,$name,$idName);
                }
            }
                $arr = krsort($result);

                $returnList = implode('-', $result);

                return $returnList;
        }
    }

    /**
     * 查找统计信息
     * @param array $data 数据库查询出来的数据
     * @param string $table 数据库表名
     * @param string $clickTotal 统计的字段 
     * @param string $fieldId 根据那个字段去查询统计数据
     */
    function findStatistics($data, $table, $fieldId='relevance_id', $clickTotal='visit_total')
    {
        if (is_array($data)) 
        {
            $tableObj = M($table.'Statistics');
            foreach($data as $v)
            {
                $v['statistics'] = $tableObj->where([$fieldId => $v['id']])->sum($clickTotal);
                $result[] = $v;
            }
            return $result;
        }
    }

    /**
        * 导出数据为excel表格
        *@param $data    一个二维数组,结构如同从数据库查出来的数组
        *@param $title   excel的第一行标题,一个数组,如果为空则没有标题
        *@param $filename 下载的文件名
        *@example 
        $stu = M ('User');
        $arr = $stu -> select();
        exportexcel($arr,array('id','账户','密码','昵称'),'文件名!');
    */
    function exportexcel($data=array(),$title=array(),$filename='report'){
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");  
        header("Content-Disposition:attachment;filename=".$filename.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
        if (!empty($title)){
            foreach ($title as $k => $v) {
                $title[$k]=iconv("UTF-8", "GB2312",$v);
            }
            $title= implode("\t", $title);
            echo "$title\n";
        }
        if (!empty($data)){
            foreach($data as $key=>$val){
                foreach ($val as $ck => $cv) {
                    $data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
                }
                $data[$key]=implode("\t", $data[$key]);
                
            }
            echo implode("\n",$data);
        }
        exit;
    }

    // PHP“刚刚”、“几分钟前”、“昨天”、“前天”、"n年"等时间函数
    function tranTime($time) { 
        $rtime = date("m-d H:i", $time);
        $htime = date("H:i", $time);
        $ytime = date('Y', $time);
        $btime = date("Y-m-d H:i:s", $time);
        $time = time() - $time;
        if ($time < 60) { 
            $str = '刚刚'; 
        } elseif ($time < 60 * 60) { 
            $min = floor($time / 60); 
            $str = $min . '分钟前'; 
        } elseif ($time < 60 * 60 * 24) { 
            $h = floor($time / (60 * 60)); 
            $str = $h . '小时前 ' . $htime; 
        } elseif ($time < 60 * 60 * 24 * 3) { 
            $d = floor($time / (60 * 60 * 24)); 
            if ($d == 1) 
                $str = '昨天 ' . $rtime; 
            else 
                $str = '前天 ' . $rtime; 
        }elseif ($ytime < date('Y', time())){ 
            $str = $btime;
        }else{
            $str = $rtime;
        }
        return $str; 
    }

    // 把地址库存入Redis中
    function saveAddressList()
    {   
        $redis = new \Redis();

        $redis->connect('127.0.0.1',6379); 

        $res = $redis->get('address_save');

        if (!$res) 
        {
            $address = M('district');
            
            $addressList  = $address->field('district_id,name')->where(['parent_id' => 0])->select();

            foreach ($addressList as $v) 
            {
                $v['child'] = $address->field('district_id,name')->where(['parent_id' => $v['district_id']])->select();
                foreach ($v['child'] as $k => $vo) 
                {
                    $v['child'][$k]['child'] = $address->field('district_id,name')->where(['parent_id' => $vo['district_id']])->select();
                }

                $result[] = $v;
            }

            $res = json_encode($result);

            $redis->setex('address_save', 604800,$res);
            
        }

        return $res;
    }

    // 获取原图的函数
    function getArtwork($kw,$mark1 = '_',$mark2 = '.'){
        $st = strrpos($kw,$mark1);
        $ed = strrpos($kw,$mark2);
        if(($st==false||$ed==false)||$st>=$ed) return 0;
        $res1=substr($kw,0,$st);
        $res2=substr($kw,$ed);
        return $res1.$res2;
    }

    // 星座判断
    function constellationJudge($month, $day) 
    {
        // 检查参数有效性 
        if ($month < 1 || $month > 12 || $day < 1 || $day > 31) return false;

        // 星座名称以及开始日期
        $constellations = array(
         array( "20" => "宝瓶座"),
         array( "19" => "双鱼座"),
         array( "21" => "白羊座"),
         array( "20" => "金牛座"),
         array( "21" => "双子座"),
         array( "22" => "巨蟹座"),
         array( "23" => "狮子座"),
         array( "23" => "处女座"),
         array( "23" => "天秤座"),
         array( "24" => "天蝎座"),
         array( "22" => "射手座"),
         array( "22" => "摩羯座")
        );

        list($constellation_start, $constellation_name) = each($constellations[(int)$month-1]);

        if ($day < $constellation_start) list($constellation_start, $constellation_name) = each($constellations[($month -2 < 0) ? $month = 11: $month -= 2]);

        return $constellation_name;
    }

    /**
     * 缩略图方法
     * @param  $path   string 上传后得来的图片路径
     * @param  $dir    string 上传的公共文件夹位置
     * @param  $width  integer 宽度
     * @param  $heigth integer 高度
     * @return $result string 返回缩略图的路径
     */
    function thumbImage($path = '', $dir = './Public', $width = 400, $height = 400)
    {
        $image = new \Think\Image();

        $masterImage = $dir.$path;

        $res = $image->open($masterImage);

        if (!$res) {
            $result['error_msg'] = '打开图片路径失败';return $result;
        }

        $ext = substr($path, strrpos($path,'.'));

        $thumbnail = explode('.', $masterImage)[1].'_thumbnail'.$ext;

        $savePath = '.'.$thumbnail;

        $res = $image->thumb($width, $height)->save($savePath);
        if ($res) {
            return explode('.', $path)[0].'_thumbnail'.$ext;
        }else{
            $result['error_msg'] = '保存缩略图出错';return $result;
        }
    }

    /**
     * 文件上传
     * @param  string $path    上传文件夹路径
     * @param  string $flag    上传方式(可选单文件[填写'one']或多文件)
     * @param  string $name    单文件上传时用到的字段名称(单文件上传时必填)
     * @return string $result  返回上传后的完整路径
     */
    function fileUpload($path, $name = '', $flag = 'one', $maxSize = 3145728, $setName= '')
    {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize  = $maxSize;
        $upload->exts     = array('jpg', 'pem', 'png', 'jpeg', 'mp4');// 设置附件上传类型
        $upload->savePath = $path; // 保存路径
        $upload->subName  = array('date','Ymd');
        $upload->saveName = array('uniqid','');  
        if ($setName) {
            $upload->saveName = $setName;
            $upload->subName  = '';
        }
        $upload->rootPath = './Public/';
        $upload->autoSub  = true;

        if ($flag === 'one') 
        {
            $info   =   $upload->uploadOne($_FILES[$name]);
            if ($info) 
            {
                $result = $info['savepath'].$info['savename'];
            }
        }else{
            
            $info   =   $upload->upload();
            
            if($info) 
            {
                // 上传成功 获取上传文件信息    
                foreach($info as $file)
                {        
                    $result[] = $file['savepath'].$file['savename'];
                }
            }
        }

        if (!$info) 
        {
            $result['error_msg'] = $upload->getError();
            return $result;
        }
        
        return $result;
    }

    /**
     * 发送HTTP请求方法
     * @param  string $url    请求URL
     * @param  array  $params 请求参数
     * @param  string $method 请求方法GET/POST
     * @return array  $data   响应数据
     */
    function sendHttpWithCurl($url, $method = 'GET', $header = array("Content-type: text/html; charset=utf-8"), $multi = false)
    {
        $opts = array(
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_HTTPHEADER     => $header
        );
        /* 根据请求类型设置特定参数 */
        switch(strtoupper($method)){
            case 'GET':
                $opts[CURLOPT_URL] = $url;
                break;
            case 'POST':
                //判断是否传输文件
                $params = $multi ? $params : http_build_query($params);
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_POST] = 1;
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            default:
                throw new Exception('不支持的请求方式！');
        }
        /* 初始化并执行curl请求 */
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data  = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if($error) throw new Exception('请求发生错误：' . $error);
        return  $data;
    }

    /**
     * 判断是否微信客户端
     * @return bool true->是微信浏览器
     */
    function isWeixin()
    { 
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) 
        {
            return true;
        }  
            return false;
    }

    // 返回html实体
    function htmlReturn($str)
    {
        return htmlspecialchars_decode(html_entity_decode($str));
    }


    /**
     * 快递鸟Demo
     * Json方式  物流信息订阅
     *   $requestData="{".
     *              "'ShipperCode':'SF',". // 快递公司(顺丰)
     *              "'LogisticCode':'3100707578976".// 快递单号
     *              "}";
     */
    function orderTracesSubByJson($requestData){
        
        
        $datas = array(
            'EBusinessID' => C('EXPRESS_ID'),
            'RequestType' => '1008',
            'RequestData' => urlencode($requestData) ,
            'DataType' => '2',
        );
        $datas['DataSign'] = encrypt($requestData, C('EXPRESS_SECRET'));
        $result=sendPost(C('EXPRESS_TRUE_URL'), $datas);   
        
        //根据公司业务处理返回的信息......
        
        return $result;
    }

    /**
     * 快递鸟Demo
     *  post提交数据 
     * @param  string $url 请求Url
     * @param  array $datas 提交的数据 
     * @return url响应返回的html
     */
    function sendPost($url, $datas) {
        $temps = array();   
        foreach ($datas as $key => $value) {
            $temps[] = sprintf('%s=%s', $key, $value);      
        }   
        $post_data = implode('&', $temps);
        $url_info = parse_url($url);
        if(empty($url_info['port']))
        {
            $url_info['port']=80;   
        }
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader.= "Host:" . $url_info['host'] . "\r\n";
        $httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
        $httpheader.= "Connection:close\r\n\r\n";
        $httpheader.= $post_data;
        $fd = fsockopen($url_info['host'], $url_info['port']);
        fwrite($fd, $httpheader);
        $gets = "";
        $headerFlag = true;
        while (!feof($fd)) {
            if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
                break;
            }
        }
        while (!feof($fd)) {
            $gets.= fread($fd, 128);
        }
        fclose($fd);  
        
        return $gets;
    }

    /**
     * 快递鸟Demo
     * 电商Sign签名生成
     * @param data 内容   
     * @param appkey Appkey
     * @return DataSign签名
     */
    function encrypt($data, $appkey) {
        return urlencode(base64_encode(md5($data.$appkey)));
    }

    /*********************************微信订单退款demo****************************************/
    /**
     * 微信双向证书设置
     * @param  [type]  $url     https://api.mch.weixin.qq.com/secapi/pay/refund // 请求地址
     * @param  [type]  $vars    merchantid=1001000 // 商户平台商户id
     * @param  [type]  $path    证书位置
     * @param  integer $second  默认30秒有效
     * @param  array   $aHeader header头设置
     */
    function curl_post_ssl($url, $vars, $path, $second=30,$aHeader=array())
    {
        $ch = curl_init();
        //超时时间
        curl_setopt($ch,CURLOPT_TIMEOUT,$second);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '10.206.30.98');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        
        //以下两种方式需选择一种
        
        //第一种方法，cert 与 key 分别属于两个.pem文件
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT,getcwd().$path.'/apiclient_cert.pem');
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY,getcwd().$path.'/apiclient_key.pem');
        
        //第二种方式，两个文件合成一个.pem文件
        // curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');
     
        if( count($aHeader) >= 1 ){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
        }
     
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
        $data = curl_exec($ch);
        if($data){
            curl_close($ch);
            return $data;
        }
        else { 
            $error = curl_errno($ch);
            echo "call faild, errorCode:$error\n"; 
            curl_close($ch);
            return false;
        }
    }

    /**
     * 转换成距离时间
     * @param  int $time 指定日期的时间戳
     * @return [type]       [description]
     */
    function turnDistanceTime($time)
    {
        $dTime = $time - time();
        if ($dTime < 0) {
            return '过期了!';
        }

        $day  = floor($dTime/86400);
        $hour = floor(($dTime%86400)/3600);
        $min  = floor((($dTime%86400)%3600)/60);
        $day  = $day<1? '': $day.'天';
        $hour = $hour<1? '': $hour.'小时';
        $min  = $min<1? '': $min.'分';
        return $day.$hour.$min;
    }

    function wechatPayTime($time){
        $year   = substr($time, 0, 4);
        $month  = substr($time, 4, 2);
        $day    = substr($time, 6, 2);
        $hour   = substr($time, 8, 2);
        $min    = substr($time, 10, 2);
        $second = substr($time, 12, 2);
        return $year.'年'.$month.'月'.$day.'日 '.$hour.':'.$min.':'.$second;
    }

    function checkIsControl($nav, $companyID)
    {
        switch($nav) {
            case 'Admin/OrderForm/orderList':
                $table = 'OrderForm';
                $count = M($table)->where(['status' => 2, 'is_send_out' => 0, 'company_id' => $companyID, 'is_control' => 0])->count();
                // return M($table)->getLastSql();
                return $count;
                break;
            case 'Admin/SubscribeOrderForm/orderList':
                $table = 'SubscribeOrderForm';
                break;
            case 'Admin/WechatRefund/orderList':
                $table = 'WechatRefund';
                break;
        }
        // return $table;
        $count = M($table)->where(['status' => 0, 'company_id' => $companyID, 'is_control' => 0])->count();
        return $count;
    }

    /**
     * 冒泡降序排序(1-0)
     * @param  array    $array    传入数组
     * @param  string   $field    根据字段排序
     * @return array    $result   排序后的数组
     */
    function bubble_sort_top($array, $field)
    {
        $count = count($array);
        
        for ($k=0; $k < $count; $k++) { 
            for($j=$count-1;$j>$k;$j--){
                if($array[$j][$field]>$array[$j-1][$field])
                {
                    $temp = $array[$j];
                    $array[$j] = $array[$j-1];
                    $array[$j-1] = $temp;
                }
            }
        }
        return $array;
    }

    /**
     * 冒泡升序排序(0-1)
     * @param  array    $array    传入数组
     * @param  string   $field    根据字段排序
     * @return array    $result   排序后的数组
     */
    function bubble_sort_down($array, $field)
    {
        $count = count($array);
        for ($k=0; $k < $count; $k++) { 
            for($j=0;$j<$count-$k;$j++){
                if($array[$j][$field]<$array[$j-1][$field]){
                    $temp =$array[$j-1];
                    $array[$j-1] =$array[$j] ;
                    $array[$j] = $temp;
                }
            }
        }
        return $array;
    }

     /**
     *计算某个经纬度的周围某段距离的正方形的四个点
     *
     *@param lng float 经度
     *@param lat float 纬度
     *@param distance float 该点所在圆的半径，该圆与此正方形内切，默认值为0.5千米
     *@return array 正方形的四个点的经纬度坐标
     */
    function return_square_point($lng, $lat,$distance = 0.5)
    {
        
        $dlng =  2 * asin(sin($distance / (2 * C('EARTH_RADIUS'))) / cos(deg2rad($lat)));
        $dlng = rad2deg($dlng);
         
        $dlat = $distance/C('EARTH_RADIUS');
        $dlat = rad2deg($dlat);
         
        return [
                'left-top'      =>['lat' => $lat + $dlat, 'lng' => $lng - $dlng],
                'right-top'     =>['lat' => $lat + $dlat, 'lng' => $lng + $dlng],
                'left-bottom'   =>['lat' => $lat - $dlat, 'lng' => $lng - $dlng],
                'right-bottom'  =>['lat' => $lat - $dlat, 'lng' => $lng + $dlng]
            ];
    }

    /**
     * 获取两坐标点距离
     * @param  [type] $a_x [description]
     * @param  [type] $a_y [description]
     * @param  [type] $b_x [description]
     * @param  [type] $b_y [description]
     * @return [type]      [description]
     */
    function return_two_point_distance($a_y,$a_x,$b_y,$b_x)
    {
        $pk = 180 / 3.14169;
        $a1 = $a_y / $pk;
        $a2 = $a_x / $pk;
        $b1 = $b_y / $pk;
        $b2 = $b_x / $pk;
        $t1 = cos($a1) * cos($a2) * cos($b1) * cos($b2);
        $t2 = cos($a1) * sin($a2) * cos($b1) * sin($b2);
        $t3 = sin($a1) * sin($b1);
        $tt = acos($t1 + $t2 + $t3);
        return 6371000*$tt;
    }
 ?>