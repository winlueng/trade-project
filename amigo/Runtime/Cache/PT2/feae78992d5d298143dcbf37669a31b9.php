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
    

	<!-- gaoCode -->
	<!-- <link rel="stylesheet" href="http://cache.amap.com/lbs/static/AMap.PlaceSearchRender1120.css"/>
	<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=a2414330232c1ba563ad05237561e9d9&plugin=AMap.Autocomplete,AMap.PlaceSearch,AMap.Geocoder"></script>
	<script type="text/javascript" src="http://cache.amap.com/lbs/static/PlaceSearchRender.js"></script>
	<script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js"></script>
 -->
	<style>
	
	</style>
	<?php  ?>

</head>
<body>

  <header id="Header" class="kb_header flexLayout-center ">
    <nav>
      
        <a href="javascript:;" onclick="javascript:history.go(-1)" class="icon-back w"></a>
      
    </nav>
    <h2 class="kb_header-title">
    
	优惠

    </h2>
    <nav>
    
     <a class="icon-MoreMenu w mark-moreMenu" href="javascript:;" >
        </a>
        <div class="moreMenu">
          <div class="Cover"></div>
          <div class="moreMenu-box">
          <?php if($_GET['companyName']): ?><p>
              <a href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/<?php echo ($_GET['companyName']); ?>">
                <span class="icon-MoreIndex"></span>
                <b>首页</b>
              </a>
            </p>
          <?php else: ?>
            <p>
              <a href="<?php echo U('Index/index');?>">
                <span class="icon-MoreIndex"></span>
                <b>首页</b>
              </a>
            </p><?php endif; ?>
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


	<section id="Main" class="kb_main bc kb_notFooter   ">
	<?php if(empty($list)): ?><p class="tc pt50">商家暂无优惠活动哦！</p>
	<?php else: ?>
		<ul class="kb_list-cells bc mb10">
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li class="kb_list-cell">
			    <div class="preferential-veryNew-box" cardID="<?php echo ($v["id"]); ?>">
			        <?php switch($v["card_type"]): case "GROUPON": ?><p class="kb_list-cell-hd">
			            <img src="/Public/images/groupBuyCard.png" alt="团购券" />
			            </p><?php break;?>
			          <?php case "DISCOUNT": ?><p class="kb_list-cell-hd">
			            <img src="/Public/images/rebateCard.png" alt="折扣券" />
			          </p><?php break;?>
			          <?php case "GIFT": ?><p class="kb_list-cell-hd">
			            <img src="/Public/images/exchangeCard.png" alt="礼品券" />
			          </p><?php break;?>
			          <?php case "CASH": ?><p class="kb_list-cell-hd">
			            <img src="/Public/images/likeMoneyCard.png" alt="代金券" />
			          </p><?php break;?>
			          <?php case "GENERAL_COUPON": ?><p class="kb_list-cell-hd">
			            <img src="/Public/images/preferentialCard.png" alt="优惠券" />
			          </p><?php break;?>
			          <?php default: ?>  <p class="kb_list-cell-hd">未知错误</p><?php endswitch;?>
			        
			      
			      <div class="kb_list-cell-bd">
			        <!-- <p class="kbMt_fontCr-000 fb kbMt_font14">
			          <?php switch($v["card_type"]): case "GROUPON": ?>团购券<?php break;?>
			            <?php case "DISCOUNT": ?>折扣券<?php break;?>
			            <?php case "GIFT": ?>礼品券<?php break;?>
			            <?php case "CASH": ?>代金券<?php break;?>
			            <?php case "GENERAL_COUPON": ?>优惠券<?php break; endswitch;?>
			        </p> -->
			        <p class=" fb ft14"><?php echo ($v["title"]); ?></p>
			        <!-- <p class="kbMt_fontCr-000 fb kbMt_font14"><?php echo ($v["notice"]); ?></p> -->
			        <p class="">
			          <?php switch($v["date_info"]["type"]): case "DATE_TYPE_FIX_TIME_RANGE": ?>使用时间: <?php echo date('Y年m月d日', $v['date_info']['begin_timestamp']);?>- <?php echo date('Y年m月d日', $v['date_info']['end_timestamp']); break;?>
			            <?php case "DATE_TYPE_FIX_TERM": if($v['date_info']['fixed_begin_term']): ?>使用时间: 自领取后<?php echo ($v['date_info']['fixed_begin_term']); ?>天开始生效, 生效后有效期<?php echo ($v['date_info']['fixed_term']); ?>天
			              <?php else: ?>
			                <?php if($v['date_info']['fixed_term']): ?>使用时间: 自领取后<?php echo ($v['date_info']['fixed_term']); ?>天内有效
			                <?php else: ?>
			                使用时间: 自领取后当天内有效<?php endif; endif; break; endswitch;?>
			        </p>
			        <p class="">剩余<?php echo ($v['sku']['quantity']); ?>张, 已有<?php echo ($v['sku']['total_quantity'] - $v['sku']['quantity']); ?>人领取</p>
			      </div>
			    </div>
			  </li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul><?php endif; ?>
	</section>
	<script type="text/javascript">
		wx.config({
            debug: false,//调试模式
            appId: '<?php echo ($wechat["appId"]); ?>',//公众号ID
            timestamp: '<?php echo ($wechat["timestamp"]); ?>',//时间戳
            nonceStr: '<?php echo ($wechat["nonceStr"]); ?>',//随机字符串
            signature: '<?php echo ($wechat["signature"]); ?>',//JSSDK接口签名
            jsApiList: [
              // 所有要调用的 API 都要加到这个列表中
              'addCard'
        ]});

       /* $(".mb10 li .redBagAnimated").on("click", function(){
            // $.get("<?php echo U('ajaxControl');?>", {flag:'clickAdd', cardip:$(this).attr('cardcid')});
            console.log(1);
            wx.addCard({
                cardList:[{
                    cardId: $(this).attr('cardid'),
                    cardExt: '{"code": "", "openid": "", "timestamp": "'+ $(this).attr('timestamp') +'", "nonce_str": "'+ $(this).attr('nonce') +'", "signature": "'+ $(this).attr('signature') +'"}',
                }],
                success: function (res) {
                    $.get("<?php echo U('ajaxControl');?>", {flag:'getAdd', cardip:$(this).attr('cardcid')});
                        alert("领取成功");
                },
            });
        });*/

        function youhui(obj) 
        {
        	wx.addCard({
                cardList:[{
                    cardId: $(obj).attr('cardid'),
                    cardExt: '{"code": "", "openid": "", "timestamp": "'+ $(obj).attr('timestamp') +'", "nonce_str": "'+ $(obj).attr('nonce') +'", "signature": "'+ $(obj).attr('signature') +'"}',
                }],
                success: function (res) {
                    $.get("<?php echo U('ajaxControl');?>", {flag:'getAdd', cardip:$(obj).attr('cardcid')});
                        alert("领取成功");
                },
                /* cancel: function (res) {
                    alert("取消了。。。。");
                }, */
                /* fail: function (res) {
                    alert("接口调用失败");
                } */
            });
        }
	</script>
	<script type="text/javascript">
		// // 113.286602,23.119968
	 //    var map, geolocation;
	 //    //加载地图，调用浏览器定位服务
	 //    map = new AMap.Map('geoCoder', {
	 //        resizeEnable: true
	 //    });
	 //    map.plugin('AMap.Geolocation', function() {
	 //        geolocation = new AMap.Geolocation({
	 //            enableHighAccuracy: true,//是否使用高精度定位，默认:true
	 //            timeout: 10000,          //超过10秒后停止定位，默认：无穷大
	 //            buttonOffset: new AMap.Pixel(10, 20),//定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
	 //            zoomToAccuracy: true,      //定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：false
	 //            buttonPosition:'RB'
	 //        });
	 //        map.addControl(geolocation);
	 //        geolocation.getCurrentPosition();
	 //        AMap.event.addListener(geolocation, 'complete', onComplete);//返回定位信息
	 //        AMap.event.addListener(geolocation, 'error', onError);      //返回定位出错信息
	 //    });
	 //    //解析定位结果
	 //    function onComplete(data) {

	 //     	var mapPosition= $('.mapPosition');
		//    for(var i=0;i<mapPosition.length;i++){
		//     var shopPosition= $(mapPosition[i]).val().trim().split(",");
		//     // var mapDistance=parsetInt(data.position.distance(shopPosition));
		//    	var mapDistance=(data.position.distance(shopPosition).toFixed(0));

		//    	// alert(mapDistance);
		//    	if(mapDistance.length>5){
		//    		mapDistance="&gt;&nbsp;"+99+"公里"
		//    	}else if(mapDistance.length>3){
		//    		mapDistance="&gt;&nbsp;"+(mapDistance/1000).toFixed(2)+"公里"
		//    	}
		//    	else{
		//    		mapDistance="&lt;&nbsp;"+mapDistance+"米"
		//    	}
	 //    	$(mapPosition[i]).siblings('.positionDistance').html(mapDistance);
		//     }
	 //    }
	   
	 //    //解析定位错误信息
	 //    function onError(data) {
	 //        // document.getElementById('tip').innerHTML = '定位失败';
	 //         animationAlert({alertContent:"定位失败",alertTip:false,});
	 //    }
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