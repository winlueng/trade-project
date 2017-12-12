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
      .dl_addrWrite{
        line-height:40px;
        text-align:center;
      }
      .dl_addrWrite:active{
        opacity:.5;
      }
      .dl_addrOpera{
        display:none;
      }
      .kb_cell-href .kb_cell-ft::after{
        display:none;
      }
      .dl_addre-wirteStatus .dl_addrOpera,
      .dl_addre-wirteStatus .kb_cell-href .kb_cell-ft::after{
        display:block;
      }
      .dl_addre-wirteStatus .kb_cell-ft .kb_choose{
        display:none;
      }
  </style>

</head>
<body>

  <header id="Header" class="kb_header flexLayout-center ">
    <nav>
      
  <?php if($_GET['companyName'] AND $_GET['tem']): ?><a href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/<?php echo I('get.tem');?>/VisitorInfo/myCenter?companyName=<?php echo I('get.companyName');?>" class="icon-back w"></a>
  <?php else: ?>
    <a href="<?php echo U('VisitorInfo/myCenter');?>" class="icon-back w"></a><?php endif; ?>

    </nav>
    <h2 class="kb_header-title">
    
  地址管理

    </h2>
    <nav>
    
 <!--  <label class="kb_choose w h dl_addrWrite tc">
    <input type="checkbox" value=""  />
    <b>编辑</b>
  </label> -->

    </nav>
  </header>


    <section id="Main" class="kb_main bc tg_addrList dl_addre-wirteStatus ">
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><article class="dl_addre-cell main_bg   mb20">
        <a href="<?php echo U('VisitorAddress/addressInfo');?>?addr_id=<?php echo ($v['id']); ?>" class="kb_list-cell kb_cell-href  kb_list-cell_big mb10">
          <div class="kb_list-cell-hd">
              <img src="/Public/trading/images/tr-position.png" alt="" class="w20 h20" />
          </div>
          <aside class="kb_list-cell-bd">
            <p class="mb10 f18">
                <?php if($v['status']): ?><em class="tg_btn-status-main">默认</em><?php endif; ?>
                  <em class="mr30"><?php echo ($v["consignee"]); ?></em>
                  <em><?php echo ($v["phone"]); ?></em>
            </p>
            <p class="kb_list-cell-brief"><?php echo ($v["address_str"]); ?></p>
          </aside>
          <footer class="kb_cell-ft">
            <label class="kb_choose ml10 mt10">
              <input type="radio" value="" name="slta1" <?php echo ($v['status']?'checked':''); ?> />
              <span class="kb_choose-check kb_choose-check_radio">
                <b class="kb_choose-check-default kb_choose-check_main"></b>
              </span>
            </label>
          </footer>
        </a>
        <p class="dl_addrOpera pb10"> 
            <label class="kb_choose ml15">
              <input type="radio" name="status" value="<?php echo ($v['id']); ?>" <?php echo ($v['status']?'checked':''); ?> />
              <span class="kb_choose-check kb_choose-check_radio">
                <b class="kb_choose-check-default kb_choose-check_main"></b>
              </span>
            </label>
            <em class="dl_addrOpera-txt f15">默认地址</em>
          </p>
      </article><?php endforeach; endif; else: echo "" ;endif; ?>
    </section>


  <footer id="Footer" class="kb_footer ">
    <a href="<?php echo U('VisitorAddress/addressAdd');?>" class="kb_btn kb_btn-main fb dl_addre-add  "><em style="font-weight: none">+</em>&nbsp;新增地址</a>
  </footer>


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
  // $('.dl_addrWrite input').on('click',function(){
  //     var $this=$(this);
  //     $('.kb_main').toggleClass('dl_addre-wirteStatus');

  // })
  // $('.kb_list-cell').on('click',function(){
  //       return  $('.dl_addrWrite input').prop('checked');
  // })
  $('input[name="status"]').on('click', function(){
    $.get('<?php echo U("ajaxControl");?>',{flag:'saveDefault', id:$(this).val()},function(res){
      if (res) {
        alert('设置成功');
        window.location.reload();
      }else{
        alert('设置失败')
      }
    })
  });
</script>

</body>
</html>