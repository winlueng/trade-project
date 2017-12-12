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
    
<style>
.dl_title-index{
	/*border-left:4px solid #000;*/
	margin-left:10px;
	margin-bottom:15px;
  text-indent: 5px;
  font-size:20px;
  color:#B1894B;
}
.dl_nowRecommend-content{
	width:100%;
	min-height:200px;
	padding-left:5px;
	padding-right:5px;
}
.dl_nowRecommend-content-img{
	width:100%;
	max-height: 150px;
	overflow:hidden;
}
.dl_nowRecommend-content-title{
	font-size:15px;
	/*font-weight:bold;*/
  color:#474747;
}
.dl_nowRecommend-content-brief{
	color:#a9a9a9;
	/*height: 3em;*/
    overflow: hidden;
    padding-bottom: 5px;
}
.mb10{
	margin-bottom:10px;
}
.mt15{
  margin-top:15px;
}
.dl_seconBanner,.dl_fifthBanner{
	max-height:100px;
	height:100px;
}
.firstBanner{
	/*height:290px;*/
}
.dl_saleGoods .kb_list-cells{
  width:90%;
  margin-left:auto;
  margin-right:auto;
  border:1px solid rgba(187,188,191,.3);
  margin-bottom: 10px;
}
.dl_saleGoods .dl_title-index{
  color:#679577;
}
.dl_fifthBanner,.dl_seconBanner{
  width:95%;
}
.firstBanner .dl_title-index{
  position:relative;
}
.firstBanner .dl_title-index .swiper-pagination{
    right:0;
    font-size: 12px;
    width: 50px;
    left: inherit;
    font-weight:normal;
    color:#a2a3a6;
    bottom:3px;
}
.firstBanner .dl_title-index .swiper-pagination-current{
  /*font-weight:bold;*/
  font-size:18px;
  color:#000;
}
.swiper-pagination-bullet{
  background-color:#fff;
}
.swiper-pagination-bullet.swiper-pagination-bullet-active{
    background:url('/Public/trading/style/img/pagination-bullet.png') no-repeat center;
    background-size: 15px;
}


.dl_newGoods  img{
  height:127px;
}
.dl_newGoods .dl_title-index{
  color:#849FC3;
}
.dl_newGoods h3{
  min-height:34px;
  overflow:hidden;
}
.dl_hotGoods  img,#fourthBanner img{
  height:120px;
}
.dl_hotGoods h3{
  /*height:34px;*/
  overflow:hidden;
  color:#CF7368;
}
.dl_saleGoods .kb_list  img{
  width:110px;
  height:82.5px;
}
.dl_saleGoods h3{
  height:34px;
  overflow:hidden;
}
.dl_saleGoods .kb_list{
  position: relative;
}
.dl_saleGoods .kb_list::after{
  content:'';
  display: block;
  width:90%;
  margin-right: auto;
  margin-left:auto;
  height: 1px;
  background:#e1e2e6; 
  position:absolute;
  bottom:0;
      left: 0;
    right: 0;
}
.dl_seconBanner img{
  height: 100px
}
</style>
<?php ?>

</head>
<body>

  <header id="Header" class="kb_header flexLayout-center kb_SearcHHref">
    <nav>
      
        <a href="javascript:;" class="icon-advisory w"></a>
      
    </nav>
    <h2 class="kb_header-title">
    
     <!--  <form>
          <input type="search" value="" placheholder="请输入搜索内容" class="kb_search icon-search bc" />
      </form> -->
    
    </h2>
    <nav>
    
     <a href="<?php echo U('SystemNews/newsList');?>" class="icon-mesg w <?php echo ($newsCount>0?'kb_hasTip':''); ?>">
        <?php if($newsCount > 0): ?><span class="kb_hasTip-count">
             <?php echo ($newsCount); ?>
         <span><?php endif; ?>
       </a>
    
    </nav>
  </header>


<div id="Main" class="kb_main tg_home">
  <article id="firstBanner" class="firstBanner dl_nowRecommend  main_bg mb10 swiper-container pt20">
    <h1 class="dl_title-index">今日主推 <div class="swiper-pagination">
    </div></h1>
    <ul class="swiper-wrapper ml10 ">
    <?php if(is_array($newsList)): foreach($newsList as $key=>$v): ?><li class="swiper-slide ">
    		<a href="<?php echo U('News/newsDetail',['id' => $v['id']]);?>" class="dl_nowRecommend-content fl">
    			<p class="dl_nowRecommend-content-img imgW imgH mb10">
    				<img  src="/Public/<?php echo ($v['news_logo'][0]); ?>" alt="" />
    			</p>
    			<p class="dl_nowRecommend-content-title mb10 mt15">
    				<?php echo ($v['news_name']); ?>
    			</p>
    			<p class="dl_nowRecommend-content-brief">
	    			<?php echo ($v['title']); ?>
    			</p>
    		</a>
    	</li><?php endforeach; endif; ?>
    </ul>
  </article>
  <?php if(!empty($topBanner)): ?><div class="main_bg w">
  <article id="secondBanner" class="swiper-container main_bg dl_seconBanner mb10 pb10 pt10">
  	 <ul class="swiper-wrapper ">
  	  <?php if(is_array($topBanner)): foreach($topBanner as $key=>$v): ?><li class="swiper-slide ">
    		<a href="<?php echo ($v['banner_url']); ?>" class="banner_click" banner-id="<?php echo ($v['id']); ?>">
    		<p class=" h imgW imgH  ">

				<img  src="/Public<?php echo ($v['banner_pic']); ?>" alt="" />
    		</p>
    		</a>
    	</li><?php endforeach; endif; ?>
    </ul>
    <div class="swiper-pagination">
    </div>
  </article>
  </div><?php endif; ?>
  <?php if(!empty($hot_goods)): ?><article id="thirdrBanner" class="dl_hotGoods  main_bg mb10 thirdrBanner pb10 pt10">
    <h1 class="dl_title-index">热销商品</h1>
    <ul class="swiper-wrapper ml10 ">
     <?php if(is_array($hot_goods)): foreach($hot_goods as $key=>$v): ?><li class="swiper-slide ">
    	  <a href="<?php echo ($v['link']); ?>">
    	  <p class="imgW w">
            <img src="/Public<?php echo ($v[goods_logo]); ?>" alt="" />
          </p>
          </a>
          <h3 class="mb10"><?php echo ($v[goods_name]); ?></h3>
          <p class="flexLayout-center dl_between ">
          	<?php if($v.is_promotion==1): ?><em class="tg_ft-price">￥<?php echo ($v[promotion_price]); ?></em>
            <?php else: ?>
            <em class="tg_ft-price">￥<?php echo ($v[price]); ?></em><?php endif; ?>
            <em class="tg_ft-default">销量:<?php echo ($v['salesTotal']?$v['salesTotal']:0); ?>
            </em>
          </p>
    	</li><?php endforeach; endif; ?>
    </ul>
  </article><?php endif; ?>
  <?php if(!empty($discount_goods)): ?><article class="dl_saleGoods  main_bg mb10 pt10">
    <h1 class="dl_title-index">折扣商品</h1>
    <ul class="kb_list pb20">
    <?php if(is_array($discount_goods)): foreach($discount_goods as $key=>$v): ?><li class="kb_list-cells">
         <a href="<?php echo ($v['link']); ?>" class="kb_list-cell">
            <div class="kb_list-cell-hd">
                <img src="/Public<?php echo ($v['goods_logo']); ?>" alt="" />
            </div>
            <aside class="kb_list-cell-bd">
                <h2 class="kb_list-cell-title mb10"><?php echo ($v[goods_name]); ?></h2>
                <div class="kb_list-cell-brief">
                   <?php if(($v['is_discount'] == 1) AND ((int)$v['sales_start_time'] < time()) AND ((int)$v['sales_end_time'] > time())): ?><p class="tg_ft-price mb10">
                          距结束：<?php echo turnDistanceTime($v['sales_end_time']);?>
                        </p>
                        <p class="tg_ft-price mb10">
                            <b class="f16 mr10">￥<?php echo ($v['price']*($v['discount']/10)); ?></b><em class="tg_through">￥<?php echo ($v['price']); ?></em>
                        </p>
                    <?php else: ?>
                        <p class="tg_ft-price mb10">
                            <em class="f16 mr10">￥<?php echo ($v['price']); ?></em>
                        </p><?php endif; ?>
                    <p class="dl_bugShoping">
                       <em>销量<?php echo ($v['salesTotal']?$v['salesTotal']:0); ?></em>
                       <!-- <button type="button" class="kb_btn icon-bugShoping mark-bugShoping w30 h30"></button> -->
                    </p>
                </div>
            </aside>
         </a>
      </li><?php endforeach; endif; ?>
    </ul>
  <?php if(!empty($footBanner)): ?><div class="main_bg w">
      <article id="fifthBanner" class="swiper-container main_bg dl_fifthBanner mb10 pb10 pt10">
         <ul class="swiper-wrapper ">
          <?php if(is_array($footBanner)): foreach($footBanner as $key=>$v): ?><li class="swiper-slide">
            <a href="<?php echo ($v[banner_url]); ?>" class="banner_click" banner-id="<?php echo ($v['id']); ?>">
            <p class=" h imgW imgH  ">

            <img  src="/Public<?php echo ($v[banner_pic]); ?>" alt="" />
            </p>
            </a>
          </li><?php endforeach; endif; ?>
        </ul>
        <div class="swiper-pagination">
        </div>
      </article>
    </div><?php endif; ?>
  </article><?php endif; ?>
  <?php if(!empty($new_goods)): ?><article id="fourthBanner" class="dl_newGoods  main_bg mb10 fourthBanner pb10 pt10">
    <h1 class="dl_title-index">新品区</h1>
    <ul class="swiper-wrapper ml10 ">
    <?php if(is_array($new_goods)): foreach($new_goods as $key=>$v): ?><li class="swiper-slide ">
    	  <a href="<?php echo ($v[link]); ?>">
    	  <p class="imgW w">
            <img src="/Public<?php echo ($v[goods_logo]); ?>" alt="" />
          </p>
          </a>
          <h3 class="mb10"><?php echo ($v[goods_name]); ?></h3>
          <p class="flexLayout-center dl_between ">
            <em class="tg_ft-price">￥<?php echo ($v['is_promotion']==1? $vp['promotion_price']:$v['price']); ?></em>
            <em class="tg_ft-default">销量:<?php echo ($v['salesTotal']?$v['salesTotal']:0); ?></em>
          </p>
    	</li><?php endforeach; endif; ?>
    </ul>
  </article><?php endif; ?>
  <?php if(!empty($selYouLike)): ?><article class="dl_newGoods  main_bg mb10 pt10">
    <h1 class="dl_title-index">猜你喜欢</h1>
    <ul class="tg_list-cell tg_list-cell_two p10">
    <?php if(is_array($selYouLike)): foreach($selYouLike as $key=>$v): ?><li class="tg_list-bd mb20">
      	  <a href="<?php echo ($v['link']); ?>">
          <p class="imgW w">
            <img src="/Public<?php echo ($v['goods_logo']); ?>" alt="" />
          </p>
          </a>
          <h3 class="mb15 mt15"><?php echo ($v['goods_name']); ?></h3>
          <p class="flexLayout-center dl_between ">
            <em class="tg_ft-price f14">￥<?php echo ($v['is_promotion']==1?$v['promotion_price']:$v['price']); ?></em>
            <em class="tg_ft-default f12s">销量:<?php echo ($v['sales']?$v['sales']:0); ?></em>
          </p>
      </li><?php endforeach; endif; ?>
    </ul>
  </article><?php endif; ?>
  <p class="tc pt10 pb10">粤ICP备16039183号-3</p>
</div><!--center end-->


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
  
 
  
<nav class="dl_goShopCar">
    <a class="icon-shoppCat <?php echo ($cartTotal?'dl_myself-order-point':''); ?>" href="<?php echo U('ShoppingCart/myCart');?>?c_com=i"></a>
</nav>
<script>
$(function(){
	
		(function(){
			var swiper = new Swiper('#firstBanner', {
		        autoplay:5000,//可选选项，自动滑动
		        pagination: '.swiper-pagination',
  		    	slidesPerView: 1.08,
            spaceBetween :10,
            pagination : '.swiper-pagination',
            paginationType : 'fraction',
		    });
			
			
		})();

		(function(){
			 var swiper = new Swiper('#secondBanner', {
	            autoplay:5000,//可选选项，自动滑动
	            pagination: '.swiper-pagination',
	        
	        });

		})();
		(function(){
			var swiper = new Swiper('#thirdrBanner', {
			        slidesPerView: 2.2,
			        // paginationClickable: true,
			        spaceBetween: 20,
			        // freeMode: true
	
			    });
		})();
		(function(){
			 var swiper = new Swiper('#fourthBanner', {
	            slidesPerView: 2.2,
	            spaceBetween: 20,
	        
	        });
		})();
    // fifthBanner
    (function(){
       var swiper = new Swiper('#fifthBanner', {
              autoplay:5000,//可选选项，自动滑动
              pagination: '.swiper-pagination',
          
          });

    })();
    $(function(){
    	$('.kbMt_classHref a:first-child').addClass('selected');
    })

    $('.banner_click').on('click',function(){
        $.get("<?php echo U('Index/ajaxControl');?>",{flag: 'bannerStatistics', id:$(this).attr('banner-id')});
    });
   
})
	
	
</script>

</body>
</html>