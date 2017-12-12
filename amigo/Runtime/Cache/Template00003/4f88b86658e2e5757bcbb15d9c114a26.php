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
.tg_news-detail{
	min-height:400px;
    overflow: hidden;
	/*height:calc(100% - 109px);*/
}
.tg_news-detail img{
	max-width: 100%;
	float: left !important;
}
.kb_list-cell-title{
	font-size: 20px;
}
.f15{
	font-size:15px;
}
</style>
<?php  ?>

</head>
<body>

  <header id="Header" class="kb_header flexLayout-center ">
    <nav>
      
        <a href="javascript:;" onclick="javascript:history.go(-1)" class="icon-back w"></a>
      
    </nav>
    <h2 class="kb_header-title">
    
	动态详情

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


	<div id="Main" class="kb_main kb_notFooter">
		<?php if($newsInfo['is_video']==1): ?><div class="w h200">
			<video controls="controls"  style="background-color:#000;width:100%;height:100%" playsinline="isiPhoneShowPlaysinline" webkit-playsinline="isiPhoneShowPlaysinline"  preload="none" x-webkit-airplay=""  runat="server" poster="" >
              <source type="video/mp4" src="/Public<?php echo ($newsInfo['video']); ?>" webkit-playsinline=true>
	        </video>
		</div><?php endif; ?>
		<div class="kb_list bc  pb10 main_bg p10">
			<article class="kb_list-cell kb_list-source">
	     	<aside class="kb_list-cell-bd">
	     		<h2 class="kb_list-cell-title mb20"><?php echo ($newsInfo['news_name']); ?></h2>
	     		<!-- <p class="kb_list-cell-brief"><?php echo ($newsInfo['title']); ?></p> -->

     		</aside>
			<p class="kb_list-cell-ft main_bg">
				<time>
	 				<?php echo ($newsInfo['addtime']); ?>
	 			</time>
	 			&nbsp;
	 			<em>
	 				阅读量
	 			</em>
	 			
	 			&nbsp;|&nbsp;
	 			<em>
	 			<?php echo ($newsInfo['visit_total']? $newsInfo['visit_total']:'0'); ?>
	 			</em>
     		 </p>
	     </article>
	     <article class="tg_news-detail pt10">
			 <?php echo ($newsInfo['img_path']); ?>
		  </article>
		</div>
		<?php if(!empty($newsInfo["goods_info"])): ?><h1 class="kb_list-title main_bg mt10">相关产品链接</h1>

		<a href="<?php echo U('Goods/goodsDetail', ['id' => $newsInfo['goods_info']['id'], 'companyName' => $_GET['companyName']]);?>" class="kb_list-cell">  
		   <div class="kb_list-cell-hd">
		       <img src="/Public<?php echo ($newsInfo["goods_info"]["goods_logo"]); ?>" alt="" />
		   </div>
		   <aside class="kb_list-cell-bd">
		       <h2 class="kb_list-cell-title mb10 f15"><?php echo ($newsInfo["goods_info"]["goods_name"]); ?></h2>
		       <div class="kb_list-cell-brief">
		          <?php if(($newsInfo.goods_info.is_promotion == 1) AND ((int)$newsInfo.goods_info.sales_start_time < time()) AND ((int)$newsInfo.goods_info.sales_end_time > time())): ?><p class="tg_ft-price mb10 ">
		                 距结束：<?php echo turnDistanceTime($newsInfo.goods_info.sales_end_time);?>
		               </p>
		               
		              
		              
		               <p class="tg_ft-price mb10 f15">
		                   <b class="f16 mr10">￥<?php echo ($newsInfo["goods_info"]["promotion_price"]); ?></b><em class="tg_through">￥<?php echo ($newsInfo["goods_info"]["price"]); ?></em>
		               </p>
		           <?php else: ?>
		               <p class="tg_ft-price mb10 f15">
		                   <b class="f16 mr10">￥<?php echo ($newsInfo["goods_info"]["price"]); ?></b>
		               </p><?php endif; ?>
		           <!-- <p class="dl_bugShoping">
		              <em>销量<?php echo ($newsInfo["goods_info"]["salesTotal?$newsInfo"]["goods_info"]["salesTotal:0"]); ?></em> -->
		              <!-- <button type="button" class="kb_btn icon-bugShoping mark-bugShoping w30 h30"></button> -->
		           <!-- </p> -->
		       </div>
		   </aside>
		</a><?php endif; ?>
		<p class="kbmt_support tc mt10" style="font-size:9px"><a href="http://gdkbvip.gdallinone.com/">技术支持由旷邦科技提供</a></p>
	</div>


  


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
      wx.ready(function(){
          wx.onMenuShareAppMessage({
             title: '<?php echo ($companyInfo["company_name"]?$companyInfo["company_name"]:"阿密购商城"); ?>', // 分享标题
             desc: '<?php echo ($newsInfo['news_name']); ?>', // 分享描述
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
             desc: '<?php echo ($newsInfo['news_name']); ?>', // 分享描述
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
             desc: '<?php echo ($newsInfo['news_name']); ?>', // 分享描述
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
             desc: '<?php echo ($newsInfo['news_name']); ?>', // 分享描述
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