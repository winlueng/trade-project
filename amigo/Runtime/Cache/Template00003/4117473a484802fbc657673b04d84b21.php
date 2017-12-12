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
    
<style>
.dl_title-index{
  border-left:4px solid #000;
  margin-left:10px;
  margin-bottom:15px;
  text-indent: 10px;
  font-size:20px;
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
.dl_attention{
  background:#000;
  height:80px;
}
.dl_attention .kb_cell-hd{
  width:70px;
  height:70px;
  overflow: hidden;
  border-radius: 50px
}
.kb_cell .kb_choose{
  position:relative;
}
.dl_moreShara{
  position: fixed;
  z-index: 15;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: none;
}
.dl_moreShara .kb_grid-cell{
  width: calc(100% / 4);
  height: 78px;
  border: none;
  padding:0;
}
.dl_moreShara-title{
  position:relative;
  z-index: 3
}
.dl_moreShara-title::before{
  content:'';
  display: block;
  width:80%;
  height:2px;
  background-color:#000;
  margin:auto;
  position:absolute;
  top:0;
  bottom:0;
  left:0;
  right:0;
  z-index:-1
}
.dl_moreShara-title-info{
  background-color:#fff;
  padding-right: 10px;
  padding-left: 10px;
}
.dl_morehShara-footer{
  border-top:2px solid #000;
  width:100%;
  padding:5px 10px;
}
.dl_moreShara-box{
  width: 100%;
  position: absolute;
  bottom: 0;
  left: 0;
}
.dl_moreShara  .Cover{
  width: 100%;
  height: 100%;
  position:absolute;
  top:0;
  left:0;
  background:#000;
  opacity: .5
}
</style>
<?php ?>

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


<div id="Main" class="kb_main tg_home">
  <header class="kb_cell dl_attention">
      <p class="kb_cell-hd mr20 imgW imgH">
        <img src="/Public<?php echo ($companyInfo["company_logo"]); ?>" alt="" />
      </p>
      <aside class="kb_cell-bd tg_ft-fff">
        <h1 class="kb_cell-titlle mb10">
            <?php echo ($companyInfo["company_name"]); ?>
        </h1>
        <p >
        关注人数：<em class="mark-collectTotal"><?php echo ($collect_total); ?></em>
        </p>
      </aside>
      <p class="kb_cell-ft">
        <label class="kb_choose">
          <input type="checkbox" value="" <?php echo ($is_save==1? "checked='true'":''); ?>  class="mark-attention"/>
          <span class="kb_btn kb_btn-main"> 
              <?php echo ($is_save==1?'已关注':'+关注'); ?>
          </span>
        </label>
        <!-- <button type="button"  class="kb_btn kb_btn-main"></button> -->
      </p>
    </header>
<?php if(!empty($topNews)): ?><article id="firstBanner" class="firstBanner dl_nowRecommend  main_bg mb10 swiper-container pt20">
    <h1 class="dl_title-index">今日主推 <div class="swiper-pagination">
    </div></h1>
    <ul class="swiper-wrapper ml10">
    <?php if(is_array($topNews)): foreach($topNews as $key=>$v): ?><li class="swiper-slide">
    		<a href="<?php echo U('News/newsDetail');?>?companyName=<?php echo I('companyName');?>&id=<?php echo ($v['id']); ?>" class="dl_nowRecommend-content fl">
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
  
  </article><?php endif; ?>
  <?php if(!empty($topBanner)): ?><div class="main_bg w">
  <article id="secondBanner" class="swiper-container main_bg dl_seconBanner mb10 pb10 pt10">
  	 <ul class="swiper-wrapper ">
  	  <?php if(is_array($topBanner)): foreach($topBanner as $key=>$v): ?><li class="swiper-slide">
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
  <?php if(!empty($hotGoods)): ?><article id="thirdrBanner" class="dl_hotGoods  main_bg mb10 thirdrBanner pb10 pt10">
    <h1 class="dl_title-index">热销商品</h1>
    <ul class="swiper-wrapper ml10 ">
     <?php if(is_array($hotGoods)): foreach($hotGoods as $key=>$v): ?><li class="swiper-slide ">
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
            <em class="tg_ft-default">销量:
            <?php if(empty($v["salesTotal"])): ?>0
            <?php else: ?>
            	<?php echo ($v[salesTotal]); endif; ?>
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
                   <?php if(($v['is_promotion'] == 1) AND ((int)$v['sales_start_time'] < time()) AND ((int)$v['sales_end_time'] > time())): ?><p class="tg_ft-price mb10">
                          距结束：<?php echo turnDistanceTime($v['sales_end_time']);?>
                        </p>
                        <p class="tg_ft-price mb10">
                            <b class="f16 mr10">￥<?php echo ($v['promotion_price']); ?></b><em class="tg_through">￥<?php echo ($v['price']); ?></em>
                        </p>
                    <?php else: ?>
                        <p class="tg_ft-price mb10">
                            <b class="f16 mr10">￥<?php echo ($v['price']); ?></b>
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
  <?php if(!empty($newGoods)): ?><article id="fourthBanner" class="dl_newGoods  main_bg mb10 fourthBanner pb10 pt10">
    <h1 class="dl_title-index">新品区</h1>
    <ul class="swiper-wrapper ml10 ">
    <?php if(is_array($newGoods)): foreach($newGoods as $key=>$v): ?><li class="swiper-slide ">
    	  <a href="<?php echo ($v[link]); ?>">
    	  <p class="imgW w">
            <img src="/Public<?php echo ($v[goods_logo]); ?>" alt="" />
          </p>
          </a>
          <h3 class="mb10"><?php echo ($v[goods_name]); ?></h3>
          <p class="flexLayout-center dl_between ">
            <em class="tg_ft-price">￥<?php echo ($v['is_promotion']==1? $vp['promotion_price']:$v['price']); ?></em>
            <em class="tg_ft-default">销量:<?php echo ($v['salesTotal'] ? $v['salesTotal']: 0); ?></em>
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
          <h3 class="mb15 mt20"><?php echo ($v['goods_name']); ?></h3>
          <p class="flexLayout-center dl_between ">
            <em class="tg_ft-price f14">￥<?php echo ($v['is_promotion']==1?$v['promotion_price']:$v['price']); ?></em>
            <em class="tg_ft-default f12  ">销量:<?php echo ($v['sales']?$v['sales']:0); ?></em>
          </p>
      </li><?php endforeach; endif; ?>
    </ul>
  </article><?php endif; ?>
</div><!--center end-->


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
  
<div class="dl_moreShara">
  <div class="Cover"></div>
  <div class="dl_moreShara-box main_bg ">
    <p class="tc f14 p10 dl_moreShara-title">
      <span class="dl_moreShara-title-info">分享到</span>
    </p>
    <article class="kb_grid pb10"> 
      <a href="javascript:;" class="kb_grid-cell">
        <p class="kb_grid-cell-icon">
          <img src="/Public/tradchild/images/share/tr-wechat-friends.svg" alt="">
        </p>
        <p class="kb_grid-cell-info">
          微信好友
        </p>
      </a>
      <a href="javascript:;" class="kb_grid-cell">
        <p class="kb_grid-cell-icon">
          <img src="/Public/tradchild/images/share/tr-moments.svg" alt="">
        </p>
        <p class="kb_grid-cell-info">
          朋友圈
        </p>
      </a>
      <a href="javascript:;" class="kb_grid-cell">
        <p class="kb_grid-cell-icon">
          <img src="/Public/tradchild/images/share/tr-weibo.svg" alt="">
        </p>
        <p class="kb_grid-cell-info">
            新浪微博
        </p>
      </a>
      <a href="javascript:;" class="kb_grid-cell">
        <p class="kb_grid-cell-icon">
          <img src="/Public/tradchild/images/share/tr-qq.svg" alt="">
        </p>
        <p class="kb_grid-cell-info">
            QQ好友
        </p>

      </a>
       <a href="javascript:;" class="kb_grid-cell">
        <p class="kb_grid-cell-icon">
          <img src="/Public/tradchild/images/share/tr-Qzone.svg" alt="">
        </p>
        <p class="kb_grid-cell-info">
            QQ空间
        </p>
        
      </a>
      <a href="javascript:;" class="kb_grid-cell">
        <p class="kb_grid-cell-icon">
          <img src="/Public/tradchild/images/share/tr-copy-link.svg" alt="">
        </p>
        <p class="kb_grid-cell-info">
            复制链接
        </p>
        
      </a>
    </article>
    <footer class="dl_morehShara-footer">
      <input type="button" value="取消" class="kb_btn w bcv mark-sharecancel" />
    </footer>
  </div>
</div>
<nav class="dl_goShopCar">
    <a class="icon-shoppCat <?php echo ($cartTotal?'dl_myself-order-point':''); ?>" href="<?php echo U('ShoppingCart/myCart');?>?companyName=<?php echo I('get.companyName');?>&c_com=i"></a>
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
			        spaceBetween: 20,
	
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
    $('.mark-attention').on('click',function(){
      var $this,isCheck,getData,tipTxt,collect_total;
      collect_total=$('.mark-collectTotal');
      $this=$(this);
      console.log($this.prop('checked'));
      // console.log(!$this.prop('checked'));
      isCheck= $this.prop('checked')?1:2;
      console.log(isCheck);
      getData={
        flag:"collectCompany",
        status:isCheck,
        company_id:<?php echo ($companyInfo["id"]); ?>
      }
      $.ajax({
        type:"GET",
        url:"<?php echo U('/PT2/VisitorCollect/ajaxControl');?>",
        data:getData,
        dataType:"json",
        success:function(data){
          if(data==1){
            tipTxt=isCheck==1?"收藏成功":"已取消收藏";
            $this.attr('checked',isCheck==1?'1':'0');
            $this.next('.kb_btn').text(isCheck==1?"已关注":"+关注")
            collect_total.text(isCheck==1?parseInt(collect_total.text(),10)+1:parseInt(collect_total.text(),10)-1)
            oTip(tipTxt);
          }else{
            oTip('操作失败');
          }
        },
        error:function(error){
          console.log(error);
        }
      })
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