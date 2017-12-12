<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,maximum-scale=1,minimum-scale=1,user-scalable=0">
    <title>阿密购商城</title>
    <link rel="shortcut icon" href="/Public/trading/images/favicon.ico">
<link rel="stylesheet" href="/Public/CSS/mbase.css?v=1" />
<link rel="stylesheet" href="/Public/trading/style/trading.css" />
<link rel="stylesheet" href="/Public/trading/script/swiper/swiper.min.css" />
<script src="/Public/trading/script/zepto.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    
  <style>
     
  </style>

</head>
<body>

  <header id="Header" class="kb_header flexLayout-center ">
    <nav>
      
  <a href="<?php echo U('OrderForm/orderList');?>?show=2" class="icon-back w"></a>

    </nav>
    <h2 class="kb_header-title">
    
支付结果

    </h2>
    <nav>
    
 

    </nav>
  </header>


  <section id="Main" class="kb_main bc kb_notFooter dl_payResult ">
    <article class="main_bg pb30 pt20">
      <h1 class="tc dl_payResult-info">
        <img src="/Public/trading/images/tr-success.png" alt="" />
        <em>支付成功</em>
      </h1>
      <p class="tg_ft-default tc f14 mb10">￥<?php echo ($total); ?></p>
      <ul class="tg_list-cell dl_payResult-href bc tg_list-cell_two">
      <?php if($_GET['order_id']): ?><li class="tg_list-bd tc">
           <a  href="<?php echo U('OrderForm/orderDetail',['id' => $_GET['order_id']]);?>?companyName=<?php echo I('get.companyName');?>&tem=<?php echo I('get.tem');?>" class="kb_btn kb_btnMini tg_btn-default w50">查看订单</a>
        </li><?php endif; ?>
        <!-- <li class="tg_list-bd tc">
        <?php if($_GET['companyName'] AND $_GET['tem']): ?><a  href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/<?php echo I('get.tem');?>/Index/index?companyName=<?php echo I('get.companyName');?>" class="kb_btn kb_btnMini tg_btn-default w50">返回首页</a>
        <?php else: ?>
            <a  href="<?php echo U('Index/index');?>" class="kb_btn kb_btnMini tg_btn-default w50">返回首页</a><?php endif; ?>
        </li> -->
      </ul>
    </article>
  <?php if(!empty($sel_you_like)): ?><article class="dl_newGoods  main_bg mb10 pt10">
    <h1 class="dl_cellTitle dl_cellTitleBG">
      <b class="dl_cellTitle-txt">猜你喜欢</b>
    </h1>
    <ul class="tg_list-cell tg_list-cell_two p10">
    <?php if(is_array($sel_you_like)): foreach($sel_you_like as $key=>$v): ?><li class="tg_list-bd mb20">
          <a href="<?php echo ($v['link']); ?>">
          <p class="imgW w">
            <img src="/Public<?php echo ($v['goods_logo']); ?>" alt="" />
          </p>
          </a>
          <h3 class="mb15 mt20"><?php echo ($v['goods_name']); ?></h3>
          <p class="flexLayout-center dl_between ">
            <em class="tg_ft-price f14">￥<?php echo ($v['is_promotion']==1?$v['promotion_price']:$v['price']); ?></em>
            <em class="tg_ft-default f12s">销量:<?php echo ($v['sales']?$v['sales']:0); ?></em>
          </p>
      </li><?php endforeach; endif; ?>
    </ul>
  </article><?php endif; ?>
    <!-- <article class="main_bg mt20">
      <h1  class="dl_cellTitle dl_cellTitleBG">
          <b class="dl_cellTitle-txt">猜你喜欢</b>
      </h1>
      <ul class="tg_list-cell tg_list-cell_two p10">
      
        <li class="tg_list-bd mb20">
            <p class="imgW w">
              <img src="images/1.jpg" alt="" />
            </p>
            <h3 class="mb10">商品名字商品名字商品名字商品名字</h3>
            <p class="flexLayout-center dl_between ">
              <em class="tg_ft-price">￥130.00</em>
              <em class="tg_ft-default">销量:200</em>
            </p>
        </li>
        
      </ul>
    </article> -->
  </section>


  


<script src="/Public/trading/script/vue.js"></script>
<script src="/Public/trading/script/alertmodule.js"></script>
<script src="/Public/trading/script/swiper/swiper-3.4.2.jquery.min.js"></script>
<script>
	wx.config({
      	debug: false,
      	appId: "<?php echo ($jssdk["appId"]); ?>",
      	timestamp: "<?php echo ($jssdk["timestamp"]); ?>",
      	nonceStr:  "<?php echo ($jssdk["nonceStr"]); ?>",
      	signature: "<?php echo ($jssdk["signature"]); ?>",
      	jsApiList: [
        	'checkJsApi',
        	'onMenuShareTimeline',
        	'onMenuShareAppMessage',
        	'onMenuShareQQ',
        	'onMenuShareWeibo',
        	'onMenuShareQZone',
        	'hideMenuItems',
        	'showMenuItems',
        	'hideAllNonBaseMenuItem',
        	'showAllNonBaseMenuItem',
        	'translateVoice',
        	'startRecord',
        	'stopRecord',
        	'onVoiceRecordEnd',
        	'playVoice',
        	'onVoicePlayEnd',
        	'pauseVoice',
        	'stopVoice',
        	'uploadVoice',
        	'downloadVoice',
        	'chooseImage',
        	'previewImage',
        	'uploadImage',
        	'downloadImage',
        	'getNetworkType',
        	'openLocation',
        	'getLocation',
        	'hideOptionMenu',
        	'showOptionMenu',
        	'closeWindow',
        	'scanQRCode',
        	'chooseWXPay',
        	'openProductSpecificView',
        	'addCard',
        	'chooseCard',
        	'openCard'
      	]
  	});
   
</script>


<script>
    $(function(){
      $('.mark-moreMenu').on('click',function(){
        $('.moreMenu').show();
      })
       $('.Cover').on('click',function(){
        $('.moreMenu').hide();
      })
    })
  </script>
 
    <script>
      wx.ready(function(){
          wx.onMenuShareAppMessage({
             title: '阿密购商城', // 分享标题
             desc: '欢迎光临Imigo阿密购商城，这里有您想要的一切优质实惠商品', // 分享描述
             link: window.location.href, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
             imgUrl: 'http://www.chinaimigo.com/Public/trading/images/kblogo.jpg', // 分享图标
             type: '', // 分享类型,music、video或link，不填默认为link
             dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
             success: function () { 
                 // 用户确认分享后执行的回调函数
                 console.log("asdasdasd");
             },
             cancel: function () { 
                 // 用户取消分享后执行的回调函数
             }
         });
           wx.onMenuShareTimeline({
             title: '阿密购商城', // 分享标题
             link: window.location.href, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
             imgUrl: 'http://www.chinaimigo.com/Public/trading/images/kblogo.jpg', // 分享图标
             success: function () { 
                 // 用户确认分享后执行的回调函数
             },
             cancel: function () { 
                 // 用户取消分享后执行的回调函数
             }
         });
            wx.onMenuShareQQ({
                title: '阿密购商城', // 分享标题
             desc: '欢迎光临Imigo阿密购商城，这里有您想要的一切优质实惠商品', // 分享描述
             link: window.location.href, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
             imgUrl: 'http://www.chinaimigo.com/Public/trading/images/kblogo.jpg', // 分享图标
               success: function () { 
                  // 用户确认分享后执行的回调函数
               },
               cancel: function () { 
                  // 用户取消分享后执行的回调函数
               }
           });
           wx.onMenuShareQZone({
                title: '阿密购商城', // 分享标题
             desc: '欢迎光临Imigo阿密购商城，这里有您想要的一切优质实惠商品', // 分享描述
             link: window.location.href, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
             imgUrl: 'http://www.chinaimigo.com/Public/trading/images/kblogo.jpg', // 分享图标
               success: function () { 
                  // 用户确认分享后执行的回调函数
               },
               cancel: function () { 
                   // 用户取消分享后执行的回调函数
               }
           });
           wx.onMenuShareWeibo({
                title: '阿密购商城', // 分享标题
             desc: '欢迎光临Imigo阿密购商城，这里有您想要的一切优质实惠商品', // 分享描述
             link: window.location.href, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
             imgUrl: 'http://www.chinaimigo.com/Public/trading/images/kblogo.jpg', // 分享图标
               success: function () { 
                  // 用户确认分享后执行的回调函数
               },
               cancel: function () { 
                   // 用户取消分享后执行的回调函数
               }
           });
       });
    </script>
  

  <script>
    
  </script>

</body>
</html>