<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,maximum-scale=1,minimum-scale=1,user-scalable=0">
    <title>阿密购商城</title>
    <link rel="shortcut icon" href="/Public/trading/images/favicon.ico">
<link rel="stylesheet" href="/Public/CSS/mbase.css" />
<link rel="stylesheet" href="/Public/tradchild/style/tradechild.css" /><!-- 与主门户css同步 -->
<link rel="stylesheet" href="/Public/tradchild/script/swiper/swiper.min.css" />
<script src="/Public/tradchild/script/zepto.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    
<style>
   
</style>
<?php ?>

</head>
<body>

  <header id="Header" class="kb_header flexLayout-center ">
    <nav>
      
        <a href="javascript:;" onclick="javascript:history.go(-1)" class="icon-back w"></a>
      
    </nav>
    <h2 class="kb_header-title">
    
 足迹

    </h2>
    <nav>
    
     <a class="icon-MoreMenu w" href="javascript:;" >
        </a>
        <div class="moreMenu">
          <div class="Cover"></div>
          <div class="moreMenu-box">
            <p>
              <a href="<?php echo U('Index/index');?>?companyName=<?php echo I('get.companyName');?>">
                <span class="icon-MoreIndex"></span>
                <b>首页</b>
              </a>
            </p>
           <!--  <p>
              <a href="<?php echo U('SystemNews/newsList',['companyName' => $_GET['companyName']]);?>">
                <span class="icon-MoreMessage"></span>
                <b>消息</b>
              </a>
            </p> -->
          </div>
        </div>
    
    </nav>
  </header>


 <section id="Main" class="kb_main bc   tg_colllected ">
  <?php if(empty($track)): ?><p class="tc pt50">
    暂无足迹，去别处看看吧~~
    </p>  
  <?php else: ?>
  <?php if(is_array($track)): $i = 0; $__LIST__ = $track;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><h1 class="kb_list-title"><?php echo date('Y-m-d',$v['visit_date']);?></h1>
    <ul class="kb_list ">
      <?php if(is_array($v["list"])): $i = 0; $__LIST__ = $v["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="kb_list-cells">
         <a href="<?php echo ($vo['link']); ?>" class="kb_list-cell">  
            <div class="kb_list-cell-ft flexLayout-center mr10">
            </div>
            <div class="kb_list-cell-hd">
                <img src="/Public<?php echo ($vo['info']['goods_logo']); ?>" alt="" />
            </div>
            <aside class="kb_list-cell-bd">
                  <h2 class="kb_list-cell-title mb10">
                    <?php echo ($vo['info']['goods_name']); ?>
                 </h2>
                <div class="kb_list-cell-brief">
                    <p class=" dl_bugShoping">
                       <em class="tg_ft-price">￥<?php echo ($vo['info']['price']); ?>元</em>
                    </p>
                    <p class=" mb10">
                        销量：<?php echo ($vo['sales']); ?>
                    </p>
                </div>
            </aside>
         </a>
      </li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul><?php endforeach; endif; else: echo "" ;endif; endif; ?>
  </section>


  


<script src="/Public/tradchild/script/vue.js"></script>
<script src="/Public/tradchild/script/alertmodule.js"></script>
<script src="/Public/tradchild/script/swiper/swiper-3.4.2.jquery.min.js"></script>
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
      $('.icon-MoreMenu,.Cover').on('click',function(){
        $('.moreMenu').show();
      })
    })
  </script>

<script>
 
</script>


  <script>
    wx.ready(function(){
        wx.onMenuShareAppMessage({
           title: '<?php echo ($companyInfo["company_name"]?$companyInfo["company_name"]:"阿密购商城"); ?>', // 分享标题
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
           title: '<?php echo ($companyInfo["company_name"]?$companyInfo["company_name"]:"阿密购商城"); ?>', // 分享标题
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
           title: '<?php echo ($companyInfo["company_name"]?$companyInfo["company_name"]:"阿密购商城"); ?>', // 分享标题
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
              title: '<?php echo ($companyInfo["company_name"]?$companyInfo["company_name"]:"阿密购商城"); ?>', // 分享标题
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
              title: '<?php echo ($companyInfo["company_name"]?$companyInfo["company_name"]:"阿密购商城"); ?>', // 分享标题
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