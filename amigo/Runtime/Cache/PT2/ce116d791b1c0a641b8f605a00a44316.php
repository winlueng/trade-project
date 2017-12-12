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
        <a href="javascript:;" onclick="javascript:history.back(-1)" class="icon-back w"></a>
    </nav>
    <h2 class="kb_header-title">注册</h2>
    <nav>
        <!-- <a href="javascript:;" class="icon-navExample"></a> -->
    </nav>
</header>

  
    <section id="Main" class="kb_main bc kb_notFooter main_bg">
        <section class="dl-loginContent  bc ">
            <form action="" method="post">
                <article class="kb_cell mb10">
                    <p class="kb_cell-bd">
                        <input type="tel" name="phone" maxlength="11" placeholder="请输入手机号码" class="kb_input  w " required="required" />
                    </p>
                </article>
                <article class="kb_cell ">
                    <p class="kb_cell-bd">
                    <input type="text" name="code" placeholder="获取验证码" class="kb_input  w" required="required" />
                    </p>
                    <p class="kb_cell-ft pl5">
                        <button type="button" class="kb_btn kb_btn-main mark-vCode">获取验证码</button>
                    </p>
                </article>
                <p class="tg_ft-minor tg-tip mt10" style="display:none">
                    <i class="kb_icon-tip"></i>
                    <em class="mark-error"></em>
                </p>
                <input type="submit" value="下一步" class="kb_btn kb_btn-main w mark-registerSub" />
            </form>
        </section>
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
$(function(){
    $('.mark-vCode').on('click.mark-vCode',function(){
        var $this=$(this),
            getData=new Object,
            patrn = /^1[34578]\d{9}$/,
            phone=$this.parents('.kb_cell').siblings('.kb_cell').find('[name=phone]'),  
            time=60,
            sTime,
            now=new Date(),
            outTimestamp=now.getTime(),
            isSendCode=false;
        if(!patrn.exec(phone.val()) && !(phone.val().length===11)){
            Alert('手机号码格式不对，请重新输入',function(res){
                phone.val('');
            });
            $('.tg_ft-minor').show();
            $('.mark-error').text('手机号码格式不对，请重新输入');
            return false;
        }
       
        //查看本地该手机号码是否已经获取了验证码；
        isSendCode=localStorage.getItem(phone.val())?localStorage.getItem(phone.val()):false;
        if(isSendCode){
            //查看距离上次获取验证码时间是否已经过了60s；
            if(outTimestamp-isSendCode<60*1000){
                $('.tg_ft-minor').show();
                $('.mark-error').text('已经发送过验证码！请留意短信通知');
                $this.attr('disabled',true);
                time=outTimestamp-isSendCode/1000;
                sTime=setInterval(function(){
                    if(time>0){
                        $this.text((time--)+' s');
                    }else{
                        window.clearInterval(sTime);
                        $this.text("获取验证码");
                        $this.removeAttr('disabled');
                        localStorage.removeItem(phone.val());
                    }
                },1000);
                return false;
            }
        }

        $('.tg_ft-minor').hide();
        getData.phone=phone.val();
        getData.flag='smsToVisitorVerify';

        $.ajax({
            type:"GET",
            url:'<?php echo U("Login/ajaxControl");?>',
            data:getData,
            dataType:'json',
            success:function(data,status,xhr){
                console.log(data);
                switch(data){
                    case 1:
                        $this.attr('disabled',true);
                        localStorage.setItem(getData.phone,outTimestamp);
                        oTip('短信已经发送，请注意查收！');

                        sTime=setInterval(function(){
                            if(time>0){
                                $this.text((time--)+' s');
                            }else{
                                window.clearInterval(sTime);
                                $this.text("获取验证码");
                                $this.removeAttr('disabled');
                            }
                        },1000);
                    break;
                    case 5:
                        Alert('该号码已经被注册，请更换一个或者进行“忘记密码”操作');
                    break;
                    case 4:
                        oTip('短信已经发送，请注意查收！');
                    break;
                    default:

                    break;
                }
            },
            error:function(xhr,errorType,error){
                console.log(xhr);
                console.log(errorType);
                console.log(error);
            }
        })
    })
})
</script>

</body>
</html>