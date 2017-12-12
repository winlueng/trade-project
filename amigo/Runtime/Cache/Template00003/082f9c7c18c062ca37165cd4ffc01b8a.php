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
  .dl_sysInfo-href{
    display:block;
    padding-bottom:10px;

  }        
  .dl_sysInfo-info{
    padding-left: 60px;
    color:#8c8989;
  }
  .dl_sysInfo-href .kb_list-cell::after{
      display: none
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
    
	消息

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


  <section id="Main" class="kb_main bc  kb_notFooter tg_myself">
    <!-- <header id="facusWap" class="swiper-container main_bg">
       <nav class="kb_tabNav   swiper-wrapper">
        <a href="javascript:;" class="selected swiper-slide">个人消息</a>
        <a href="javascript:;" class="swiper-slide">系统消息</a>
       </nav>
      </header> -->
      <?php if(is_array($list)): foreach($list as $k=>$v): ?><h1 class="kb_list-title">
         <?php echo date('Y-m-d',$k);?>
        </h1>
        <?php if(is_array($v)): foreach($v as $key=>$vo): ?><a href="<?php echo ($vo['url']); ?>" class="main_bg dl_sysInfo-href mb10 <?php echo ($vo['is_read']?'kb_btn-disabled':''); ?>" onclick="readed(this)" news-id="<?php echo ($vo['id']); ?>">
            <article class="kb_list-cell kb_list-cell_small kb_cell-href ">
              <p class="kb_list-cell-hd ">
                <img src="/Public/trading/images/tr-Evaluation-reply.png" />
              </p>
              <p class="kb_list-cell-bd">
                <span class="kb_list-cell-title">
                <?php echo ($vo["title"]); ?>
                </span>
              </p>
              <p class="kb_cell-ft">
              </p>
            </article>
              <p class="dl_sysInfo-info">
                <?php echo ($vo['content']); ?>
              </p>
            <p class="tr briefColor pr10">
            <?php echo date('Y-m-d',$vo['create_time']);?>
            </p>
          </a><?php endforeach; endif; endforeach; endif; ?>
     <!-- <a href="javascript:;" class="main_bg dl_sysInfo-href mb10">
      <article class="kb_list-cell kb_list-cell_small kb_cell-href ">
        <p class="kb_list-cell-hd ">
          <img src="images/tr-Shipping-notice.png" />
        </p>
        <p class="kb_list-cell-bd">
          <span class="kb_list-cell-title">订单发货</span>
        </p>
        <p class="kb_cell-ft">
        </p>
      </article>
        <p class="dl_sysInfo-info">
          描述信息描述信息描述信息描述信息描述信息描述信息描述信息描述信息描述信息
        </p>
         <p class="tr briefColor pr10">
        2015.6.23
        </p>
      </a>
     <a href="javascript:;" class="main_bg dl_sysInfo-href mb10">
      <article class="kb_list-cell kb_list-cell_small kb_cell-href ">
        <p class="kb_list-cell-hd ">
          <img src="images/tr-Refund-notice.png" />
        </p>
        <p class="kb_list-cell-bd">
          <span class="kb_list-cell-title">订单退款</span>
        </p>
        <p class="kb_cell-ft">
        </p>
      </article>
        <p class="dl_sysInfo-info">
          描述信息描述信息描述信息描述信息描述信息描述信息描述信息描述信息描述信息
        </p>
         <p class="tr briefColor pr10">
        2015.6.23
        </p>
      </a> -->
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

<script type="text/javascript">
    function readed(obj){
      $.get('<?php echo U("ajaxControl");?>',{flag:'isRead',id:$(obj).attr('news-id'),companyName:"<?php echo ($_GET['companyName']); ?>"});
    }
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