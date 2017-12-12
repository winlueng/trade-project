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
  .kb_list-cell img{
  	height: 64px;
  	width: 64px;
  }
  .sltAttertionAlert{
  	position: absolute;
  	bottom: 0;
  	width: 100%;
  	overflow: hidden;
  }
 
  .sltAttertionAlert .kb_cell{
  	width: 100%;
  	z-index: 41;
  	text-align: center;
  }
  .kb_cell:not(:last-child){
  	margin-bottom: 10px;
  }
</style>
<?php ?>

</head>
<body>

  <header id="Header" class="kb_header flexLayout-center ">
    <nav>
      
        <a href="javascript:;" onclick="javascript:history.go(-1)" class="icon-back w"></a>
      
    </nav>
    <h2 class="kb_header-title">
    
        
          
            <!-- <p>
              <a href="javascript:;">
                <span class="icon-MoreShare"></span>
                <b>分享</b>
              </a>
            </p> -->

          </div>
        </div>
    
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


  <section id="Main" class="kb_main bc   tg_colllected kb_notFooter">
    <ul class="kb_list">
    <?php if(empty($list)): ?><p class="tc mt50 p10">还没有店铺收藏哦，快到处看看吧</p>
    <?php else: ?>
    <?php if(is_array($list)): foreach($list as $key=>$v): ?><li class="kb_cells">
	     <article class="kb_list-cell" data-id="<?php echo ($v["id"]); ?>">  
	     	<a href="http://<?php echo ($v["link"]); ?>" class="kb_list-cell-hd">
	     		<img src="/Public<?php echo ($v["company_logo"]); ?>" alt="" class="w100 h100" />
	     	</a>
	     	<a href="http://<?php echo ($v["link"]); ?>" class="kb_list-cell-bd ml10">
	     		<h2 class="kb_list-cell-title mb10"><?php echo ($v["company_name"]); ?></h2>
	     		<p class="kb_list-cell-brief"><?php echo ($v["address_info"]); ?></p>
     		</a>
     		<footer class="kb_list-cell-ft">
     		  <button typeo="button" class="kb_btn icon-MoreMenu mark-attertion w20 h50"></button>
     		</footer>
	     </article>
	  </li><?php endforeach; endif; endif; ?>

    
	</ul>
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
  

<div class="sltAttertionAlert" style="display: none;">
  <div class="coverAlert coverblack"></div>
  <article class="kb_cell ">
    <p class="kb_cell-bd">
      取消关注
    </p>
  </article>
  <article class="kb_cell">
    <p class="kb_cell-bd">
      取消
    </p>
</div>
<script>
$(function(){
	$('.mark-attertion').on('click',function(){
		var $this,id,attertion;
		$this=$(this);
		id=$this.parents('[data-id]').attr("data-id").trim();
		attertion=$('.sltAttertionAlert');
		attertion.show();
		attertion.children('.kb_cell').eq(0).on('click',function(){
			$.ajax({
				type:"GET",
				url:"<?php echo U('/PT2/VisitorCollect/ajaxControl');?>",
				data:{
					flag:"collectCompany",
					status:2,
					company_id:id
				},
				datatype:"json",
				success:function(data){
					console.log(data);
					if(data==1){
						oTip("操作成功");
						$this.parents('.kb_cells').remove();
					}else{
						oTip("操作失败");
					}
					attertion.hide();
				},
				error:function(error){
					console.log(error)
				}

			})
		})
		attertion.children('.kb_cell').eq(1).on('click',function(){
			attertion.hide();
		})
	})
})
</script>

</body>
</html>