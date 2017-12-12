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
      .kb_header{
        background-color: #E9CDA2;
      }
    </style>
    
  <?php  ?>
  <style>
    .dl_btnPlain-default{
      border:1px solid #CF7368;
      color:#CF7368;
      background-color:#fff;
      border-radius: 0
    }
  </style>

</head>
<body>

<header id="Header" class="kb_header flexLayout-center dl_selfHeader">
<nav>
  <a href="javascript:;" class="icon-setting w"></a>
</nav>
<h2 class="kb_header-title"></h2>
<nav>
  <a href="<?php echo U('SystemNews/newsList');?>" class="icon-mesg w <?php echo ($newsCount>0?'kb_hasTip':''); ?>">
    <span class="kb_hasTip-count">
        <?php echo ($newsCount); ?>
    <span>
  </a>
</nav>
</header>


    <section id="Main" class="kb_main bc   tg_myself">
   <header class="dl_mysel-header pb10  pt10">
       <a href="<?php echo U('VisitorInfo/myCenterUpdate');?>" class=" kb_cell    kb_cell-href">
        <p class="kb_cell-hd">
          <?php if(empty($userInfo["head_portrait"])): ?><img src="/Public/trading/images/1.jpg" alt="use header" class="dl_mysel-header-userInfo-image" />
          <?php else: ?>
            <img src="<?php echo ($userInfo[head_portrait]); ?>" alt="use header" class="dl_mysel-header-userInfo-image" /><?php endif; ?>
        </p>
        <p class="ml20 kb_cell-bd">
            <?php if(empty($userInfo["nick_name"])): ?>请完善资料先
             <?php else: ?>
                <?php echo ($userInfo[nick_name]); endif; ?>
            <button type="button" class="kb_btn mt10 dl_btnPlain-default">查看个人资料</button>
        </p>
        <p class="kb_cell-ft">
        </p>
       </a>
       <?php if(empty($userInfo)): ?><p class="w100 bc ">
        <a  href="<?php echo U('Login/defaultLogin');?>" class="kb_btn kb_btn-main">登陆/注册</a>
       </p><?php endif; ?>
   </header>
   <article class="kb_list-cell dl_navlist mb10 f13 ">
        <!-- <?php echo U('VisitorCollect/goodsCollect');?> -->
        <a href="<?php echo U('VisitorCollect/goodsCollect');?>" class="kb_list-cell-bd">
            <p class="tc "><?php echo ($data['goodsCollect']); ?></p>
            <p class="tc">收藏</p>
        </a>
        <!-- <?php echo U('VisitorCollect/companyCollect');?> -->
        <a href="<?php echo U('VisitorCollect/companyCollect');?>" class="kb_list-cell-bd">
            <p class="tc "><?php echo ($data['companyCollect']); ?></p>
            <p class="tc">关注</p>
        </a>
        <a href="<?php echo U('ShoppingCart/myCart');?>?c_com=c" class="kb_list-cell-bd">
            <p class="tc "><?php echo ($data['cartTotal']); ?></p>
            <p class="tc">购物车</p>
        </a>
   </article>
   <a href="<?php echo U('OrderForm/orderList');?>?show=0" class="kb_cell kb_cell-href f16">
        <p class="kb_cell-bd">
            我的订单
        </p>
        <p class="kb_cell-ft f14">
            <em>查看全部订单</em>
        </p>
    </a>
    <article class="kb_list-cell dl_navlist mb10 dl-myself-order f13">
        <a href="<?php echo U('OrderForm/orderList');?>?show=1" class="kb_list-cell-bd <?php echo ($orderCount[1]?'dl_myself-order-point':''); ?>">
            <p class="icon-pendingPay h20"></p>
            <p class="tc">待付款</p>
        </a>
        <a href="<?php echo U('OrderForm/orderList');?>?show=2" class="kb_list-cell-bd <?php echo ($orderCount[2]?'dl_myself-order-point':''); ?>">
            <p class="icon-delivered h20"></p>
            <p class="tc">待发货</p>
        </a>
        <a href="<?php echo U('OrderForm/orderList');?>?show=3" class="kb_list-cell-bd <?php echo ($orderCount[3]?'dl_myself-order-point':''); ?>">
            <p class="icon-received h20"></p>
            <p class="tc">待收货</p>
        </a>
        <a href="<?php echo U('OrderForm/orderList');?>?show=4" class="kb_list-cell-bd <?php echo ($orderCount[4]?'dl_myself-order-point':''); ?>">
            <p class="icon-evaluated h20"></p>
            <p class="tc">待评价</p>
        </a>
        <a href="<?php echo U('OrderForm/refundList');?>?show=5" class="kb_list-cell-bd <?php echo ($orderCount[5]?'dl_myself-order-point':''); ?>">
            <p class="icon-refunds h20"></p>
            <p class="tc">退款/售后</p>
        </a>
   </article>
   <article class="kb_grid dl_myself-grid main_bg f14">
        <a  href="<?php echo U('VisitorTrack/myTrack');?>"class="kb_grid-cell">
            <p class="kb_grid-cell-icon">
                <img src="/Public/trading/images/grid/tr-footprints.svg" alt="">
            </p>
            <p class="kb_grid-cell-info">
                足迹
            </p>
        </a>
        <a  href="<?php echo U('VisitorInfo/selYouLike');?>"class="kb_grid-cell">
            <p class="kb_grid-cell-icon">
                <img src="/Public/trading/images/grid/tr-like.svg" alt="">
            </p>
            <p class="kb_grid-cell-info">
                猜你喜欢
            </p>
        </a>
        <a href="<?php echo U('WasteBook/myWallet');?>" class="kb_grid-cell">
            <p class="kb_grid-cell-icon">
                <img src="/Public/trading/images/grid/tr-wallet.svg" alt="">
            </p>
            <p class="kb_grid-cell-info">
                钱包
            </p>
        </a>
      <!--   <a  href="javascript:;"class="kb_grid-cell">
            <p class="kb_grid-cell-icon">
                <img src="/Public/trading/images/grid/tr-love.svg" alt="">
            </p>
            <p class="kb_grid-cell-info">
                爱心捐赠
            </p>
        </a> -->
        <a href="<?php echo U('Discount/privilegeList');?>" class="kb_grid-cell">
            <p class="kb_grid-cell-icon">
                <img src="/Public/trading/images/grid/tr-offer.svg" alt="">
            </p>
            <p class="kb_grid-cell-info">
                优惠
            </p>
        </a>
        <a href="<?php echo U('VisitorAddress/addressList');?>" class="kb_grid-cell">
            <p class="kb_grid-cell-icon">
                <img src="/Public/trading/images/grid/tr-address.svg" alt="">
            </p>
            <p class="kb_grid-cell-info">
                收货地址
            </p>
        </a>
        <a  href="<?php echo U('WriteInfo/about_us');?>"class="kb_grid-cell">
            <p class="kb_grid-cell-icon">
                <img src="/Public/trading/images/grid/tr-about.svg" alt="">
            </p>
            <p class="kb_grid-cell-info">
                关于
            </p>
        </a>
        <a  href="<?php echo U('Email/sendEmail');?>"class="kb_grid-cell">
            <p class="kb_grid-cell-icon">
                <img src="/Public/trading/images/grid/tr-feedback.svg" alt="">
            </p>
            <p class="kb_grid-cell-info">
                建议与反馈
            </p>
        </a>
        <!-- <a href="<?php echo U('Job/jobList');?>" class="kb_grid-cell">
            <p class="kb_grid-cell-icon">
                <img src="/Public/trading/images/grid/tr-recruitment.svg" alt="">
            </p>
            <p class="kb_grid-cell-info">
                招聘
            </p>
        </a> -->
   </article>
  </section>


  <footer id="Footer" class="kb_footer ">
    <ul class="firstNav flexLayout-center ">
      <li>
        <a href="<?php echo U('Index/index');?>" button-type="1">
          <em class="icon-menu-home"></em>
            <b>首页</b>
        </a>
      </li>
      <li>
        <a href="<?php echo U('Goods/goodsList');?>" button-type="2">
          <em class="icon-menu-classification"></em>
            <b>分类</b>
        </a>
      </li>
      <li>
          <a href="<?php echo U('News/newsList');?>" button-type="3">
            <em class="icon-menu-magazine"></em>
            <b>杂志</b>
          </a>
      </li>
    <!--   <li>
        <a href="<?php echo U('AllianceShops/companyList');?>" button-type="4">
          <em class="icon-menu-experience"></em>
          <b>体验店</b>
        </a>
      </li> -->
      <li>
        <a href="<?php echo U('VisitorInfo/myCenter');?>" button-type="5">
          <em class="icon-menu-myself"></em>
          <b>我的</b>
        </a>
      </li>
    </ul>
  </footer>
  <script>
    $('#Footer a').on('click',function(){
      $.get("<?php echo U('Index/ajaxControl');?>", {flag: 'indexButtonClickStatistics', buttonType:$(this).attr('button-type')});
    })
    $(function(){
      $('.kb_header.kb_SearcHHref  .kb_search').on('click',function(){
        window.location.href='<?php echo U("Search/showSearch", ["companyName" => $_GET["companyName"]]);?>';//搜索跳转
      });
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