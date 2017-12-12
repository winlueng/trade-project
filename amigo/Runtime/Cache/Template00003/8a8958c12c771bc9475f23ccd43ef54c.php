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


  <section id="Main" class="kb_main bc tg_classification">
    <header id="facusWap" class="swiper-container main_bg">
     <nav class="kb_tabNav   swiper-wrapper f16">
     <?php if(is_array($classifyList)): foreach($classifyList as $k=>$v): ?><a href="<?php echo U('goodsList',['companyName' => $_GET['companyName'],'classify_id' => $v['id']]);?>" class=" swiper-slide" data-goodId="<?php echo ($v["id"]); ?>" ><?php echo ($v['classify_name']); ?></a><?php endforeach; endif; ?>
     </nav>
    </header>
	<ul class="kb_list dl_goodsList">
   <?php if(is_array($list)): foreach($list as $key=>$vo): ?><li class="kb_list-cells" data-goodsid="<?php echo ($vo['id']); ?>">
       <a  href="<?php echo U('goodsDetail', ['id' => $vo['id'], 'companyName' => $_GET['companyName']]);?>" class="kb_list-cell">  
          <p  class="kb_list-cell-hd">
              <img src="/Public<?php echo ($vo['goods_logo']); ?>" alt="" />
          </p>
          <aside class="kb_list-cell-bd">
              <h2 class="kb_list-cell-title dl_goods-title mb10"><?php echo ($vo["goods_name"]); ?></h2>
              <div class="kb_list-cell-brief">
                  <!-- <p class="tg_ft-price mb10">
                      距结束：6天12时30分
                  </p> -->
                  <?php if(($vo['is_promotion'] == 1) AND ((int)$vo['sales_start_time'] < time()) AND ((int)$vo['sales_end_time'] > time())): ?><p class="tg_ft-price mb10">
                      距结束：<?php echo turnDistanceTime($vo['sales_end_time']);?>
                    </p>
                    <p class="tg_ft-price mb10">
                        <b class="f16 mr10">￥<?php echo ($vo['price'] * ($vo['discount']/10)); ?></b><em class="tg_through">￥<?php echo ($vo['price']); ?></em>
                    </p>
                <?php else: ?>
                    <p class="tg_ft-price mb10">
                        <b class="f16 mr10">￥<?php echo ($vo['price']); ?></b>
                    </p><?php endif; ?>
                  <p class="dl_bugShoping">
                     <em>销量<?php echo ($vo['salesTotal']?$vo['salesTotal']:0); ?></em>
                     <button type="button" class="kb_btn icon-bugShoping mark-bugShoping w30 h30"></button>
                  </p>
              </div>
          </aside>
       </a>
    </li><?php endforeach; endif; ?>
  </ul>
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
  
<nav class="dl_goShopCar">
    <a class="icon-shoppCat <?php echo ($cartTotal?'dl_myself-order-point':''); ?>" href="<?php echo U('ShoppingCart/myCart',['companyName' => $_GET['companyName']]);?>"></a>
</nav>
<div class="sltShopBuy pt20" id="sltShopBuy" v-bind:data-goodid="goodsData.id">
 <form id="sltShopBuyForm" action="<?php echo U('ShoppingCart/insertCart');?>" method="post">
  <input type="hidden" name="goods_id" v-bind:value="goodsData.id" />
  <button type="button" class="kb_btn w20 h20 sltShopClose"></button>
  <article class="kb_list-cell pt20">
    <div class="kb_list-cell-hd">
      <img v-bind:src="'/Public'+goodsData.goods_logo" alt="" />
    </div>
    <aside class="kb_list-cell-bd pr20">
      <h2 class="kb_list-cell-title mb10">
      {{goodsData.goods_name}}
      </h2>
      <p class="kb_list-cell-brief ">
        <b class="tg_ft-price">￥
        {{goodsData.price}}
        </b>
        <em>库存{{goodsData.inventory_total ? goodsData.inventory_total:0}}</em>
      </p>
    </aside>
  </article>
  <article class="main_bg p10">
  <p>属性选择</p>
  <p class="sltShopBuy-attr pt10">
    <label class="kb_choose mr10" v-for="(attrName , indexs) in attrData">
      <input type="radio" name="attribute_id"
       v-bind:value="attrName.id"
       v-bind:data-image="attrName.attr_pic"
       v-bind:data-attr_val="attrName.attr_val" 
       v-bind:data-inventory_total="attrName.inventory_total" 
       v-bind:data-attr_price="attrName.attr_price" 
       v-on:click="changeattr"
      />
      <span class=" kb_choose-check kb_choose-check_radio">
        {{attrName.attr_val}}
      </span>
    </label>
  </p>
  </article>
  <article class="kb_cell ">
    <p class="kb_cell-bd">
      数量选择
    </p>
    <p class="kb_cell-ft sltShopBuy-update">
      <input type="button" value="-" class="kb_btn w30" @click="lower" />
      <input type="number" v-bind:value="goodsNum" name="total" readonly class="sltShopBuy-update-number tc w30" />
      <input type="button" value="+" class="kb_btn w30" @click="add" />
    </p>
  </article>
  <p class="main_bg">
  <button type="button" class="kb_btn kb_btn-main w h50 f18  mark-sltShopSub">确定</button>
  </p>
  </form>
</div>

<script type="text/javascript">
window.onload=function(){
    (function(){
        var swiper = new Swiper('#facusWap',{
            slidesPerView: 3.5,
            paginationClickable: true,
            freeMode: true
        });
    })();
    (function(){
        var app=new Vue({
            el:'#sltShopBuy',
            data:{
                goodsData:{},
                attrData:[],
                goodsNum:1
            },
            methods:{
                changeattr:function(event){
                   var $this=$(event.srcElement)?$(event.srcElement):$(event.target);
                   app.$data.goodsData.goods_logo=$this.attr('data-image');
                   // app.$data.goodsData.attr_val=$this.attr('data-attr_val');
                   app.$data.goodsData.price=$this.attr('data-attr_price');
                   app.$data.goodsData.inventory_total=$this.attr('data-inventory_total');
                },
                lower:function(){
                   if(app.$data.goodsNum==1){
                    app.$data.goodsNum==1;
                   }else{
                      app.$data.goodsNum--;
                   }
                },
                add:function(){
                  app.$data.goodsNum++
                }
            }
        });

        $('.mark-bugShoping').on('click',function(e){
          var $this,ID,data;
          $this=$(this);
          ID=$this.parents('[data-goodsid]').attr('data-goodsid').trim();
          data={
            flag:'getAttr',
            id:ID ,
            companyName:"<?php echo ($_GET['companyName']); ?>"
          };
          $.ajax({
            type: "GET",
            url: "<?php echo U('ajaxControl');?>",
            data: data,
            dataType: "json",
            success: function(res) {
                app.goodsData=res.Info;
                app.attrData=res.goodsAttr;
                app.goodsNum=1;
                $('.sltShopBuy-attr input').prop('checked',false);
            },
            error: function(res) {
                console.log(res);
            }
          });


          $('.sltShopBuy').show();
          return false;
        });

        // .mark-sltShopSub
        $('.sltShopClose').on('click',function(){
          $('.sltShopBuy').hide();
        });
        $('.mark-sltShopSub').on('click',function(){
            /* attribute_id: 商品属性id 
             * goods_id: 商品id 
             */
            var attributeid,goodsid,goodsNum,
                $this=$(this),
                formdata=new FormData($('#sltShopBuyForm')[0]);
            attributeid=$this.parents('[data-goodid]').attr('data-goodid').trim();
            // formdata.append('goods_id',attributeid);
            goodsid=$this.parents('#sltShopBuy').find('.sltShopBuy-attr input:checked').val();
            goodsNum=$this.parents('#sltShopBuy').find('.sltShopBuy-update input[name=total]').val();
            goodsNum=(goodsNum>0)?goodsNum:1;
            if(!goodsid){
                oTip('请先选择属性');
                return false;
            }
            $.ajax({
                type:'POST',
                url:"<?php echo U('PT2/ShoppingCart/insertCart');?>",
                data:formdata,
                dataType:'json',
                enctype: 'multipart/form-data',
                async: false,  
                cache: false,
                contentType: false,
                processData: false,
                success:function(res){
                  if(res){
                    oTip("加入购物车成功");
                     $('.sltShopBuy').hide();
                  }

                },
                error:function(xhr, errorType, error){
                    console.log("xhr"+xhr);
                    console.log("errorType"+errorType);
                    console.log("error"+error);
                }
            })


        })
    })()
}
$(function(){
    var url=document.URL,
        news_classify_id="classify_id"
        indexs=url.indexOf('classify_id'),
        newURL=url.substring(indexs+news_classify_id.length+1,url.length),
        urlID=newURL.substring(0,newURL.indexOf('.'));
        // 滑动位置从0开始，每个元素滑动距离为屏幕宽度/每屏显示的元素个数+屏幕宽度*第N屏-屏幕宽度*n屏
        // n屏为tabNav的a元素长度/每屏放置3.5个元素得出

        var tabNav = $('.kb_tabNav a');
        var mWidth = $('body').width();
        var group = Math.ceil(tabNav.length/3.5)
        tabNav.each(function(indexs,elem){
            var dataUrlID=$(elem).attr('data-goodId').trim();
                if(dataUrlID==urlID){
                  var nowGroup = Math.ceil(indexs/3.5) || 1;
                  // debugger;
                    $(elem).addClass('selected');
                    $(elem).parent().css({
                        'transition-duration': '0ms',
                         'transform': 'translate3d(-'+(mWidth*group-(group-nowGroup+1)*mWidth+mWidth/4*(indexs-(nowGroup*4-1)+3)) +'px, 0px, 0px)'
                    })
                }
        })
        if(indexs=="-1"){
            $('.kb_tabNav a').eq(0).addClass('selected');
        }
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