<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,maximum-scale=1,minimum-scale=1,user-scalable=0">
    <title>阿密购商城</title>
    <link rel="shortcut icon" href="/Public/trading/images/favicon.ico">
<link rel="stylesheet" href="/Public/CSS/mbase.css" />
<link rel="stylesheet" href="/Public/trading/style/trading.css" />
<link rel="stylesheet" href="/Public/trading/script/swiper/swiper.min.css" />
<script src="/Public/trading/script/zepto.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    
<style>
   .dl_recharge{
    width:94%;
   }
  .dl_recharge .kb_btn{
    height:44px;
    line-height: 32px;
   }
   .dl_wasteBook{
    line-height:40px;
  }
</style>

</head>
<body>

  <header id="Header" class="kb_header flexLayout-center ">
    <nav>
      
  <?php if($_GET['companyName'] AND $_GET['tem']): ?><a href="<?php echo U('WasteBook/myWallet');?>?companyName=<?php echo I('get.companyName');?>&tem=<?php echo I('get.tem');?>" class="icon-back w"></a>
  <?php else: ?>
    <a href="<?php echo U('WasteBook/myWallet');?>" class="icon-back w"></a><?php endif; ?>

    </nav>
    <h2 class="kb_header-title">
    
  钱包

    </h2>
    <nav>
    
  <a href="<?php echo U('WasteBook/myWasteBook');?>?companyName=<?php echo I('get.companyName');?>&tem=<?php echo I('get.tem');?>" class="kb_btn f15 dl_wasteBook">明细</a>

    </nav>
  </header>


  <section id="Main" class="kb_main bc  kb_notFooter tg_myself main_bg">
      <article class="kb_cell f14">
        <p class="kb_cell-hd">
          <label class="kb_label">充值方式</label>
        </p>
        <p class="kb_cell-bd tr">
          <b>微信支付</b>
        </p>
        
      </article>
      <article class="kb_cell pay f14">
        <p class="kb_cell-hd">
          <label class="kb_label">密条</label>
        </p>
        <p class="kb_cell-bd">
          <input type="number" placeholder="输入数量" class="kb_input tr  w" />
        </p>
      </article>
      <p class="dl_recharge bc mt100">
        <button class="kb_btn kb_btn-main w f18" id="weixin">购买</button>
      </p>
  </section>

<script>
    $('#weixin').on('click',function(){
      var $this = $(this),
          remark=new Array();
          remark.push($('input[name="visitor_remark[]"]').val());

      $.get("<?php echo U('ajaxControl');?>",{flag:'createAdvance',recharge_total:$('.pay .kb_input').val()},function (result) {
        console.log(result);
          if(!result){
            alert('生成订单失败');
          }else{
            showPay(result);
          }
      })
    });

    function onBridgeReady(info){
      var data = JSON.parse(info);
      console.log(data);
      WeixinJSBridge.invoke(
        'getBrandWCPayRequest',{
          "appId":data.appId,
          "timeStamp":data.timeStamp,
          "nonceStr":data.nonceStr,
          "package":data.package,
          "signType":data.signType,
          "paySign":data.paySign
        },
        function(res){     
            if(res.err_msg == "get_brand_wcpay_request:ok" ) {// 支付成功走这
              WeixinJSBridge.log(res.err_msg);
              window.location.href='http://<?php echo ($_SERVER["HTTP_HOST"]); echo U("WasteBook/myWallet");?>?companyName=<?php echo I("get.companyName");?>&tem=<?php echo I("get.tem");?>';
            }else{
              // alert(1);
              window.location.reload();
            }

            // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回ok，但并不保证它绝对可靠。 
        }
       ); 
    }

    function showPay(pay){
      if (typeof WeixinJSBridge == "undefined"){
         if( document.addEventListener ){
             document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
         }else if (document.attachEvent){
             document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
             document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
         }
      }else{
        // console.log(pay)
          onBridgeReady(pay);
      }
    }
</script>


  


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