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
  .dl_waller-tip{
    height:20px;
    line-height:22px;
    text-indent:15px;
  }
  .dl_waller-tip img{
    position:relative;
    top:3px;
  }
  .dl_waller-oparting{
    width:90%;
  }
  .forgetPaw{
    position:relative;
    padding-right:10px;
  }
  .forgetPaw::before{
    content:'';
    display:block;
    width:5px;
    height:5px;
    border-top:1px solid #000;
    border-right:1px solid #000;
    transform:rotate(45deg);
    position:absolute;
    top:0;
    bottom:0;
    right:0;
    margin:auto;
  }
  .kb_btn{
    padding-left: 0;
    padding-right: 0;
  }
  .dl_wasteBook{
    line-height:40px;
  }
  .dl_waller-oparting .kb_btn{
    height:32px;
    line-height:32px;
  }
  .f15{
    font-size: 15px;
  }
  .f25{
    font-size: 25px;
  }
</style>
<?php ?>

</head>
<body>

  <header id="Header" class="kb_header flexLayout-center ">
    <nav>
      
  <?php if($_GET['companyName'] AND $_GET['tem']): ?><a href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/<?php echo I('get.tem');?>/VisitorInfo/myCenter?companyName=<?php echo I('get.companyName');?>" class="icon-back w"></a>
  <?php else: ?>
    <a href="<?php echo U('VisitorInfo/myCenter');?>" class="icon-back w"></a><?php endif; ?>

    </nav>
    <h2 class="kb_header-title">
    
  钱包

    </h2>
    <nav>
    
  <a href="<?php echo U('WasteBook/myWasteBook');?>?companyName=<?php echo I('get.companyName');?>&tem=<?php echo I('get.tem');?>" class="dl_wasteBook w tc f15">明细</a>

    </nav>
  </header>


  <section id="Main" class="kb_main bc  kb_notFooter tg_myself">
    <!-- <p class="imgH dl_waller-tip mb10">
      <img src="/Public/trading/images/gold-drill.png" alt="" class="mr5 mt5 " style="height:15px" />
      <b>福利来了，首充即送福利</b>
    </p> -->
    <p class="tc mb10 mt30">
      <img src="/Public/trading/images/tr-wallet.png" alt="" class="w70 h70" />
    </p>
    <p class="tc fb mb10 ">我的密条</p>
    <p class="tc fb f25"><?php echo ($wallet?$wallet:0); ?><em class="f15 ml10 fb">密条</em></p>
    <p class="dl_waller-oparting bc">
      <a href="<?php echo U('WasteBook/recharge_by_weixin');?>?companyName=<?php echo I('get.companyName');?>&tem=<?php echo I('get.tem');?>" class="kb_btn  kb_btn-main w mb10 mt50 f18 ">立即购买</a>
    </p>
    <p class="dl_waller-oparting bc">
      <a href="<?php echo U('WasteBook/recharge_by_card');?>?companyName=<?php echo I('get.companyName');?>&tem=<?php echo I('get.tem');?>" class="kb_btn kb_btnPlain-main w mb10  f18">充值密条</a>
    </p>
    <p class="tr dl_waller-oparting mb10">
      <a class="forgetPaw" href="<?php echo U('reset_password');?>?companyName=<?php echo I('get.companyName');?>&tem=<?php echo I('get.tem');?>">重置密码</a>
    </p>
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
  




</body>
</html>