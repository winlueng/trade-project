<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" />
   <!--  <meta name="renderer" content="webkit" />
    <meta http-equiv="renderer" content="webkit" /> -->
    <title>管理后台</title>
    <link rel="stylesheet" href="/Public/CSS/common.css"></link>
    <script type="text/javascript" src="/Public/JS/jquery-1.8.2.min.js"></script>
        <link rel="stylesheet" href="/Public/selfAdmin/selfAdminCSS/login/login.css"></link>

    <style>

    </style>
</head>
<body>
    <div id="shopAdminLogin">
        <div class="shopAdminLoginBox">
            <div class="shopAdminLoginBox-left fl">
                <img src="/Public/selfAdmin/selfAdminImages/loginLeft.jpg" alt="广告位图片" />
            </div>
            <div class="shopAdminLoginBox-right">
                <h2>旷邦科技管理后台登录</h2>
                <form action="<?php echo U('login');?>" method="post">
                    <p>
                      <label>账号：</label>
                      <input type="text" value="" name="username" placeholder="请输入账号" />
                    </p>
                    <p>
                      <label>密码：</label>
                      <input type="password" name="password" value="" placeholder="请输入密码" />
                    </p>
                    <p class="shopAdminLoginBox-right-remember fr">
                      <input id="shopAdminLoginRemember" type="checkbox" value="" />  
                      <label for="shopAdminLoginRemember"></label>
                      <b>记住账号</b>
                    </p>
                    <p class="">
                        <input type="submit" value="登录" />
                    </p>
                </form>
            </div>
        </div>
        <img class="shopAdminLoginBg" src="/Public/selfAdmin/selfAdminImages/architecture.jpg" alt="背景图片" />
    </div>
</body>
</html>