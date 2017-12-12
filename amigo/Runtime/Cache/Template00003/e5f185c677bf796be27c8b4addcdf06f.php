<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,maximum-scale=1,minimum-scale=1,user-scalable=0">
    <title>阿密购商城</title>
    <link rel="stylesheet" href="/Public/CSS/mbase.css" />
<link rel="stylesheet" href="/Public/tradchild/style/tradechild.css" /><!-- 与主门户css同步 -->
<link rel="stylesheet" href="/Public/tradchild/script/swiper/swiper.min.css" />
<script src="/Public/tradchild/script/zepto.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    
	<style>
		.goodsName em{
			color:#00bec5;
		}
		.bsSearchCare {
			width:92%;
			margin-left:auto;
			margin-right:auto;
			display:flex;
			display:-webkit-flex;
			-webkit-flex-wrap:wrap;
		}
		.bsSearchCare h2{
			text-align: left;
			-webkit-flex-basis:100%;
		}
		.bsSearchCare li{
			/*width:15%;*/
			margin-right:5%;
			padding:5px 10px;
			background-color:#eaeaea;
		    margin-bottom: 10px;
		    height: 2em;
		    line-height: 2em;
		}
		.bsSearchCare li>a{
			display:block;
			color:#999;
		}
		.kb_search{
			width: calc(100% - 35px);
		}
		.dl_goods-list img{
			height:85px;
		}
		.kb_list-cell-bd{
			width:0;
		}
	</style>

</head>
<body>

	<header id="Header" class="kb_header  ">
		<form action="<?php echo U('goSearch',['companyName' => $_GET['companyName']]);?>" >

			<article class="kb_header flexLayout-center">
			<nav class="kb_cell-hd w40 h">
				<a class="icon-back w h" href="<?php echo U('Index/index',['companyName' => $_GET['companyName']]);?>">
				</a>
			</nav>
			<h1 class="kb_header-title kb_cell-bd">
				<input class="kb_search icon-search bc" name="words" value="<?php echo ($_GET['words']); ?>"  placeholder="" />
			</h1>
			<nav class="kb_cell-ft w40 h">
				<p class="kb_choose w">
					<input  type="submit" value="搜索">
					<label class="kb_btn">搜索</label>
				</p>
			</nav>
			</article>
		</form>
	</header>


<section id="Main" class=" kb_main kb_Search kb_notFooter">
	<article class=" ">
			
			<aside class="searchContent">
			 <ul class=" bsReservationList bc mb10 dl_goods-list">
		       	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i; if(in_array($sales[$v->id]['status'], ['1','3','4']) && $v->company_id == $companyInfo['id']):?>
		       	<li class="kb_list-cells" data-goodsId="<?php echo ($vo['id']); ?>">
		       	   <a  href="<?php echo U('Goods/goodsDetail', ['companyName' => $_GET['companyName'], 'id' => $v->id]);?>" class="kb_list-cell">  
		       	      <p  class="kb_list-cell-hd">
		       	          <img src="/Public<?php echo ($v->goods_logo); ?>" alt="" />
		       	      </p>
		       	      <aside class="kb_list-cell-bd">
		       	          <h2 class="dl_goods-title mb10"><?php echo ($searchObj->highlight($v->goods_name)); ?></h2>
		       	          <div class="kb_list-cell-brief">
		       	              <!-- <p class="tg_ft-price mb10">
		       	                  距结束：6天12时30分
		       	              </p> -->
		       	                <p class="tg_ft-price mb10">
		       	                    <b class="f16 mr10">￥<?php echo ($v->price); ?></b>
		       	                </p>
		       	              
		       	              <p class="dl_bugShoping">
		       	                 <em>销量:<?php echo ($sales[$v->id]['sales']?$sales[$v->id]['sales']:0); ?></em>
		       	                 <!-- <button type="button" class="kb_btn icon-bugShoping mark-bugShoping w30 h30"></button>
 -->		       	              </p>
		       	          </div>
		       	      </aside>
		       	   </a>
		       	</li>
		     	<?php endif; endforeach; endif; else: echo "$empty" ;endif; ?>
		     </ul>
			</aside>
		</article>
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