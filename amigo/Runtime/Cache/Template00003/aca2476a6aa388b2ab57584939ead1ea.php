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
      .kb_hasTip-count{
        top:7px;
        right: 14px;
      }
    </style>
    
<!-- <link href="/Public/salon/css/beautySalons.css" rel="stylesheet"></link> -->
    <style>
        .bsClassHref{
            /*overflow-x:scroll;*/
        }
        .kb_search {
            background-size: 18px;
            background-position: 10px center;
        }
        #Main .bsGoodsBrief:nth-child(2){
            margin-top:40px;
        }
        .dl_news-videoContent .kb_cell::before{
            display:none;
        }
        .dl_news-videoContent{
          border-bottom:1px solid #eee;
        }
        .dl_news-videoContent img{
          height:72px;
        }
        .dl_news-default img{
          height:72px;
        }
    </style>
    <?php  ?>

</head>
<body>

  <header id="Header" class="kb_header kb_SearcHHref flexLayout-center ">
    <nav>
      
        <a href="javascript:;" class="icon-advisory w"></a>
      
    </nav>
    <h2 class="kb_header-title">
    
      <!-- <form>
          <input type="search" value="" placheholder="请输入搜索内容" class="kb_search icon-search bc" />
      </form> -->
    
    </h2>
    <nav>
    
     <a class="icon-MoreMenu w" href="javascript:;" >
        </a>
        <div class="moreMenu">
          <div class="Cover h"></div>
          <div class="moreMenu-box">
            <!-- <p>
              <a href="<?php echo U('PT2/Index/index');?>?companyName=<?php echo I('get.companyName');?>">
                <span class="icon-MoreIndex"></span>
                <b>首页</b>
              </a>
            </p> -->
            <p>
              <a href="<?php echo U('SystemNews/newsList');?>?companyName=<?php echo I('get.companyName');?>">
                <span class="icon-MoreMessage <?php echo ($newsCount>0?'kb_hasTip':''); ?>">
                <?php if($newsCount > 0): ?><span class="kb_hasTip-count">
                       <?php echo ($newsCount); ?>
                   </span><?php endif; ?>
                </span>
                <b>消息</b>
              </a>
            </p>
           <!--  <p>
             <a href="javascript:;" class="mark-moreShare">
               <span class="icon-MoreShare"></span>
               <b>分享</b>
             </a>
           </p> -->
          </div>
        </div>
    
    </nav>
  </header>


    <section id="Main" class="kb_main tg_magazine">
        <header id="facusWap" class="swiper-container  mb10  main_bg">
            <nav class="kb_tabNav swiper-wrapper">
                <?php if(is_array($classify)): $i = 0; $__LIST__ = $classify;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><a style="width:107px" class="swiper-slide <?php echo ($v['id'] == $_GET['news_classify_id']?'selected':''); ?> <?=(empty($_GET['news_classify_id']) && $key == 0)?'selected':''?>" href="<?php echo U('newsList', ['news_classify_id' => $v['id'], 'companyName' => $_GET['companyName']]);?>" data-urlID="<?php echo ($v['id']); ?>"><?php echo ($v["news_type_name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
            </nav>
            
        </header>
        <?php if(is_array($list )): $i = 0; $__LIST__ = $list ;if( count($__LIST__)==0 ) : echo "这分类还没发布动态哦" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i; switch($v["is_video"]): case "0": if($v['visit_total'] < 100): if(count($v['news_logo']) > 1): ?><div class="main_bg pt10 pb10 dl_news-videoContent" >
                     <a href="<?php echo U('News/newsDetail');?>?id=<?php echo ($v['id']); ?>&companyName=<?php echo I('get.companyName');?>" class="kb_cell">
                      <?php if(is_array($v["news_logo"])): $i = 0; $__LIST__ = $v["news_logo"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><p class="kb_cell-bd imgW mr10">
                           <img src="/Public<?php echo ($vo); ?>">
                         </p><?php endforeach; endif; else: echo "这分类还没发布动态哦" ;endif; ?>
                     </a>
                     <h1 class="p10 kb_list-cell-title"><?php echo ($v['news_name']); ?></h1>
                     <p class="p10 tg_ft-default">阅读量：<?php echo ($v['visit_total']); ?></p>
                   </div>
               <?php else: ?>
                 <a href="<?php echo U('News/newsDetail');?>?id=<?php echo ($v['id']); ?>&companyName=<?php echo I('get.companyName');?>" class="kb_list-cell dl_news-default">  
                  <aside class="kb_list-cell-bd">
                    <h1 class="kb_list-cell-title mb10">
                     <?php echo ($v['news_name']); ?>
                    </h1>
                   <!--  <p class="kb_list-cell-brief">
                     <?php echo ($v['title']); ?>
                    </p> -->
                    <p class="tg_ft-default">阅读量:<?php echo ($v['visit_total']); ?></p>
                  </aside>
                  <div class="kb_list-cell-ft " >

                    <img src="/Public<?php echo ($v['news_logo'][0]); ?>" alt="" />
                  </div>
                 </a><?php endif; ?>
              <?php else: ?>
               <div class="main_bg pt10 pb10 dl_news-videoContent">
                 <a href="<?php echo U('News/newsDetail');?>?id=<?php echo ($v['id']); ?>&companyName=<?php echo I('get.companyName');?>" class="kb_cell">
                     <p class="kb_cell-bd imgW mr10">
                       <img src="/Public<?php echo ($v['news_logo'][0]); ?>">
                       </p>
                 </a>
                 <h1 class="p10 mb10"> <?php echo ($v['title']); ?></h1>
                 <p class="p10 tg_ft-default">阅读量：<?php echo ($v['visit_total']); ?></p>
               </div><?php endif; break;?>
          <?php case "1": ?><div class="main_bg pt10 pb10 dl_news-videoContent">
                <a href="<?php echo U('News/newsDetail');?>?id=<?php echo ($v['id']); ?>&companyName=<?php echo I('get.companyName');?>" >
                  <article class="kb_cell">
                    <p class="kb_cell-bd imgW mr10">
                       <video controls="controls"  style="background-color:#000;width:100%;height:100%" playsinline="isiPhoneShowPlaysinline" webkit-playsinline="isiPhoneShowPlaysinline"  preload="none" x-webkit-airplay=""  runat="server" poster="" >
                              <source type="video/mp4" src="/Public<?php echo ($v['video']); ?>" webkit-playsinline=true>
                      </video>
                    </p>
                  </article>
                <h1 class="p10 mb10"> <?php echo ($v['title']); ?></h1>
                <p class="p10 tg_ft-default">阅读量：<?php echo ($v['visit_total']); ?></p>
              </div>
             </a><?php break; endswitch; endforeach; endif; else: echo "" ;endif; ?>
          
    </section>


  <footer id="Footer" class="kb_footer ">
    <ul class="firstNav flexLayout-center ">
      <li>
        <a href="<?php echo U('Index/index');?>?companyName=<?php echo ($_GET['companyName']); ?>" button-type="1">
          <em class="icon-menu-home"></em>
            <b>首页</b>
        </a>
      </li>
      <li>
        <a href="<?php echo U('Goods/goodsList');?>?companyName=<?php echo ($_GET['companyName']); ?>" button-type="2">
          <em class="icon-menu-classification"></em>
            <b>分类</b>
        </a>
      </li>
      <li>
          <a href="<?php echo U('News/newsList');?>?companyName=<?php echo ($_GET['companyName']); ?>" button-type="3">
            <em class="icon-menu-magazine"></em>
            <b>杂志</b>
          </a>
      </li>
      <!-- <li>
        <a href="javascript:;" button-type="4">
          <em class="icon-menu-experience"></em>
          <b>体验店</b>
        </a>
      </li> -->
      <li>
        <a href="<?php echo U('VisitorInfo/myCenter');?>?companyName=<?php echo ($_GET['companyName']); ?>" button-type="5">
          <em class="icon-menu-myself"></em>
          <b>我的</b>
        </a>
      </li>
    </ul>
  </footer>
  <script>
    $('#Footer a').on('click',function(){
      $.get("<?php echo U('Template00002/Index/ajaxControl');?>?companyName=<?php echo I('get.companyName');?>", {flag: 'indexButtonClickStatistics', button:$(this).attr('button-type')});
    })
  </script>

  
  
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
        $('.icon-MoreMenu').on('click',function(){
          $('.moreMenu').show();
          $('.moreMenu .Cover').on('click',function(){
            $('.moreMenu').hide();
           })
        })
        $('.mark-moreShare').on('click',function(){
            $('.moreMenu').hide();
            $('.dl_moreShara').show();
            $('.dl_moreShara .Cover,.mark-sharecancel').on('click',function(){
            $('.dl_moreShara').hide();

           })
        })
      })
      $(function(){
        $('.kb_header.kb_SearcHHref  .kb_search').on('click',function(){
          window.location.href='<?php echo U("Search/showSearch", ["companyName" => $_GET["companyName"]]);?>';//搜索跳转
        });
      })
    </script>
  
    <script>
        $(function(){
            (function(){
              var swiper = new Swiper('#facusWap',{
                  slidesPerView: 3.5,
                  paginationClickable: true,
                  freeMode: true
              });
            })();
                  

            (function(){
              var url=window.location.href,
                  news_classify_id="news_classify_id",
                  index=url.indexOf('news_classify_id'),
                  newURL=url.substring(index+news_classify_id.length+1,url.length),
                  urlID=newURL.substring(0,newURL.indexOf('.')),
                  wWidth=window.innerWidth,
                  evenWidth=wWidth/3.5,
                  bsClassHref=$('.kb_tabNav a');
                
                  Object.keys(bsClassHref).map(function(elem,indexs){
                      if(bsClassHref.eq(elem).length>0){
                        var dataUrlID=bsClassHref.eq(elem).attr('data-urlID').trim();
                        console.log(dataUrlID);
                        console.log(urlID);
                        if(dataUrlID==urlID){
                            console.log(bsClassHref.eq(elem));
                            bsClassHref.eq(elem).addClass('selected');
                            bsClassHref.eq(elem).parent().css(
                                 'transform', 'translate3d(-'+bsClassHref.eq(elem).width()*(indexs-1)+'px, 0px, 0px)'
                            ).css('transition-duration', '0ms')
                        }
                        if(index=="-1"){
                            bsClassHref.eq(0).addClass('selected');
                            return false;
                        }
                      }else{
                        return false;
                      }
                  });
                  
              })();
            
            
           
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