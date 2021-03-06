<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" />
    <meta name="renderer" content="webkit" />
    <meta http-equiv="renderer" content="webkit" />
    <title>阿密购管理后台</title>
    <link href="/Public/loginimg/mbase.css" rel="stylesheet"></link>
    <style>
    .dl_header{
        background-color: #f94800
    }
    .dl_title{
      width:50%;
      color:#fbccb0;
      padding:10px 0;
      
    }
    .dl_content{
      position:relative;
      z-index:3;
      overflow: hidden;
      height: calc(100% - 75px - 41px);
    }
    .dl_bg{
     
    }
    .dl_login{
        width:440px;
        height:380px;
        position: absolute;
        right: 15%;
        top:10%;
        background-color: #fff;
        border-radius: 5px;
        padding:20px 0;
        border:1px solid #eee;

    }
    hr.eee{
        height:1px;
        background-color:#eee;
        border:0;
    }
    .dl_login-box{
        width: 80%;
        padding-top:20px;
    }
    .dl_login-box .kb_cell{
        border:1px solid #ddd;
        border-radius: 5px;
    }
    .dl_login-box .kb_label{
        width:50px;
    }
    .dl_login .kb_input{
        font-size:16px;
    }
    .dl_footer{
        background-color:#f5f6fa;
        color:rgba(162,163,166,0.8);
    }
    .dl_footer .kb_cell{
        background-color: transparent;
    }
    .dl_footer-list{
        width:40%;
    }
    .dl_footer-listOther{
        width:50%;
    }
    .dl_footer-list li{
        border-right: 1px solid rgba(162,163,166,0.8);
        text-align:center;
    }
    .dl_footer-list li:last-child{
        border-right:0;
    }
    .dl_beta{
       display:inline-block;
       font-size:12px;
       background-color:#999;
       color:#fff;
       padding:0 2px;
       font-style:normal;
       position: relative;
       top:-8px;
       left: 5px;
    }
    .dl_btn-main{
        background-color: #ea1c00;
        color: #fff;
    }
  </style>
</head>
<body>
  <div class="dl_header">
      <h1 class="dl_title bc f16">后台登陆</h1>
  </div>
  <div class="dl_content">
    <div class="dl_login">
      <h2 class="tc pb10">管理员登陆</h2>
      <hr class="eee" />
      <section class="dl_login-box bc">
        <form <?php echo U('projectLogin');?>" method="post" >
          <article class="kb_cell mb20">
            <p class="kb_cell-hd">
                <label class="kb_label"><img src="/Public/loginimg/account.png" alt="账号" class="ml10" /></label>
            </p>
            <p class="kb_cell-bd">
                <input type="text" name="username"  placeholder="请输入账号" class="kb_input f16  w" />
            </p>
          </article>
          <article class="kb_cell">
            <p class="kb_cell-hd">
                <label class="kb_label"><img src="/Public/loginimg/password.png" alt="账号" class="ml10" /></label>
            </p>
            <p class="kb_cell-bd">
                <input type="password" name="password" placeholder="请输入密码" class="kb_input   w f16" />
            </p>
          </article>
          <p class=" mt20 mb50"> 
            <label class="kb_choose ml10">
                <input type="checkbox" value="" >
                <span class=" kb_choose-check">
                    <b class="kb_choose-check-default kb_choose-check_default"></b>
                </span>
            </label>
            <span style="position:relative;top:-5px">记住账号</span>
            <a href="javascript:;" class="kb_cell-hrefMore fr">忘记密码?</a>
          </p>
          <button class="kb_btn dl_btn-main w300 bc f18">登陆</button>
        </form>
      </section>
    </div>
    <img src="/Public/loginimg/as.jpg" alt="" class="  dl_bg" />
  </div>
  <footer class="dl_footer">
    <ul class="kb_cell dl_footer-list bc">
      <li class="kb_cell-bd tc">服务协议</li>
      <li class="kb_cell-bd tc">运营规范</li>
      <li class="kb_cell-bd tc">辟谣中心</li>
      <li class="kb_cell-bd tc">客服中心</li>
      <li class="kb_cell-bd tc">联系邮箱</li>
      <li class="kb_cell-bd tc">侵权投诉</li>
      <li class="kb_cell-bd tc">侵权投诉</li>
    </ul>   
    <div class="kb_cell dl_footer-listOther bc f14">
      <p class="kb_cell-bd">粤ICP备16039183号-3</p>
      <p class="kb_cell-bd ">广东旷邦信息科技有限公司</p>
      <p class="kb_cell-bd">地址：广州市海珠区广州大桥南桃花街159号1301</p>
      <p class="kb_cell-bd">020-86925320</p>
    </div>
  </footer>
</body>
</html>