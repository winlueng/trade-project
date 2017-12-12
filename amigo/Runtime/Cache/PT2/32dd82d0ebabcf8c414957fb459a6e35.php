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
        .dl-loginContent{
            width:76%;
            height:100%;
            padding-top:50px;
        }
        .dl-registered{
            display:flex;
            display:-webkit-flex;
            justify-content:space-between;
            -webkit-justify-content:space-between;
            align-items:center;
            -webkit-align-items:center;
            padding:10px 0;
            text-indent: 10px;
            display:none;
        }
        .dl-loginContent .mark-registerSub{
            margin-top:120px;
            height: 44px;
            font-size: 18px;
        }
        .kb_main{
            overflow:hidden;
        }
        .kb_cell-bd{
            padding-left:0;
            padding-right:0;
            font-size:15px;
        }
        .dl-gift{
            display: flex;
        }
        .mark-vCode{
            width:80px;
            height:35px;
        }
    </style>

</head>
<body>

<header id="Header" class="kb_header flexLayout-center">
    <nav>
        <a href="javascript:;" onclick="javascript:history.back(-1)" class="icon-back"></a>
    </nav>
    <h2 class="kb_header-title">设置支付密码</h2>
    <nav>
        <!-- <a href="javascript:;" class="icon-navExample"></a> -->
    </nav>
</header>


    <section id="Main" class="kb_main bc kb_notFooter main_bg">
        <section class="dl-loginContent  bc ">
            <form action="" method="post">
                <article class="kb_cell mb10">
                    <p class="kb_cell-hd">
                        <label class="kb_label">设置密码</label>
                    </p>
                    <p class="kb_cell-bd">
                        <input type="password" placeholder="请输入6位纯数字密码" name="password" class="kb_input  w" />
                    </p>
                </article>
                <article class="kb_cell ">
                    <p class="kb_cell-hd">
                        <label class="kb_label">重复密码</label>
                    </p>
                    <p class="kb_cell-bd">
                        <input type="password" placeholder="请再次输入6位纯数字密码" name="repass" class="kb_input  w" />
                    </p>
                </article>
                <!-- <p class="tg_ft-minor tg-tip mt10">
                    <i class="kb_icon-tip"></i>
                    密码不一致
                </p> -->
                <input type="button" value="确定设置" class="kb_btn kb_btn-main w mark-registerSub" />
            </form>
        </section>
    </section>
    <script>
        $('[name=password],[name=repass]').on('input protochange',function(){
           var $this = $(this),
           patt=new RegExp('^[0-9]*','g'),
           newVal=patt.exec($this.val());
           $this.val(newVal)
        })
        $('.mark-registerSub').on('click',function(){
        var Url;
        Url="<?php echo U('WasteBook/setPayPassWord');?>";
        $.ajax({
            type:"POST",
            url:Url,
            data:$('#Main form').serialize(),
            dataType:'json',
            success:function(data){
                if(data.status == 'true'){
                    Alert('修改成功');
                    var url = 'http://<?php echo ($_SERVER["HTTP_HOST"]); echo U("WasteBook/myWallet");?>?companyName=<?php echo I("get.companyName");?>&tem=<?php echo I("get.tem");?>';
                    setTimeout("window.location.href='"+url+"'",3000);
                    // window.location.href='http://<?php echo ($_SERVER["HTTP_HOST"]); echo U("WasteBook/myWallet");?>';
                }else{
                    Alert(data.err_msg);
                    var url = 'http://<?php echo ($_SERVER["HTTP_HOST"]); echo U("WasteBook/setPayPassWord");?>?companyName=<?php echo I("get.companyName");?>&tem=<?php echo I("get.tem");?>';
                    setTimeout("window.location.href='"+url+"'",3000);
                }
            },
            error:function(error){

            }
        })
      })
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