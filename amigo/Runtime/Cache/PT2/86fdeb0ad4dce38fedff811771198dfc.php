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


  <section id="Main" class="kb_main bc  kb_notFooter tg_myself">
    <!-- <header id="facusWap" class="swiper-container main_bg">
       <nav class="kb_tabNav   swiper-wrapper">
        <a href="javascript:;" class="selected swiper-slide">个人消息</a>
        <a href="javascript:;" class="swiper-slide">系统消息</a>
       </nav>
      </header> -->
      <?php if(is_array($list)): foreach($list as $k=>$v): ?><h1 class="kb_list-title">
       	<?php echo ($k); ?>
        </h1>
        <?php if(is_array($v)): foreach($v as $key=>$vo): ?><a href="<?php echo ($vo['url']); ?>" class="main_bg dl_sysInfo-href mb10 <?php echo ($vo['is_read']==1?'kb_btn-disabled':''); ?>" onclick="readed(this)" news-id="<?php echo ($vo['id']); ?>">
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
      <?php if(($list) AND (count($list) > 10)): ?><myTemlate   v-bind:Phrase="indexs" v-for="indexs in info" >
        </myTemlate>
       <p id="lookMore" class="lookMore tc pt10 pb10 f14"><a href="javascript:;">查看更多</a></p><?php endif; ?>
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
  

<script id="newListTempl" type="text/html">
<a href="javascript:;" class="main_bg dl_sysInfo-href mb10">
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
</script>
<script type="text/javascript">
    function readed(obj){
      $.get('<?php echo U("ajaxControl");?>',{flag:'isRead',id:$(obj).attr('news-id')});
    }
    $(function(){
      (function(){
        var Child={
          template:"#newListTempl",
          props:['Phrase'],
        }
        var app=new Vue({
          el:"#Main",
          components:{
            'myTemlate':Child
          },
          data:{
            info:[],
            clickTotal:2
          }
        })
        $("#lookMore").on('click',function(){
          var $this=$(this);
          $.ajax({
            type:"GET",
            url:"<?php echo U('ajaxControl');?>",
            data:{
              show:"<?php echo ($_GET['show']); ?>",
              companyName:"<?php echo ($_GET['companyName']); ?>",
              p:app.clickTotal,
              flag:'newsList'
            },
            dataType:"json",
            success:function(data){
              if(data){
                app.info=app.info.concat(data);
                app.clickTotal+=1;
                console.log(app.info);
              }else{
                $this.hide();
                oTip("没有更多了")
              }
            },
            error:function(error){

            }
          })

        })
      })();
    })
</script>

</body>
</html>