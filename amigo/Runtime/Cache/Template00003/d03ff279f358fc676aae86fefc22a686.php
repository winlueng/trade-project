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
    
  <?php  ?>
  <style>
    .icon-collect{
      height: 100%;
      width: 100%;
    }
    .kb_choose-icon{
      width: 30px;
      height: 30px;
    }
    #showImg img{
      width: 100%;
      float:left !important;
    }
    /* .dl_class-recommend .tg_list-bd{
      -webkit-margin-bottom:100px;
      margin-bottom:10px;
    }*/
    .kb_list-cell_small .kb_list-cell-title{
      font-size:16px;
    }
    #showImg{
      overflow: hidden
    }
    .h10{
      height: 10px
    }
  </style>

</head>
<body>

  <header id="Header" class="kb_header flexLayout-center ">
    <nav>
      
        <a href="javascript:;" onclick="javascript:history.go(-1)" class="icon-back w"></a>
      
    </nav>
    <h2 class="kb_header-title">
    
  商品详情

    </h2>
    <nav>
    
 <label class="kb_choose  kb_choose-icon">
    <input type="checkbox" value="" <?php echo ($goodsInfo['is_collect']?'checked':''); ?> data-goodsid="<?php echo ($goodsInfo['id']); ?>" class="mark-isCollect" />
    <span class="kb_choose-check icon-collect ">
     
    </span>
  </label>

    </nav>
  </header>


  <section id="Main" class="kb_main bc tg_classification dl_classDetail">
    <header id="focusWap" class="swiper-container focusWap main_bg">
      <ul class="swiper-wrapper">
        <?php if(is_array($goodsInfo["goods_picture"])): foreach($goodsInfo["goods_picture"] as $key=>$v): ?><li class="swiper-slide bc mb10 dl_banner">
          <a href="javascript:;">
            <img src="/Public<?php echo ($v); ?>" alt="大图" />
          </a>
        </li><?php endforeach; endif; ?>
      </ul>
      <div class="swiper-pagination banner-pagination mb10"></div>
    </header>
    <article class="kb_list-cell kb_list-cell_small mt10 dl_classDetail-name ">
      <aside class="kb_list-cell-bd">
        <h2 class="kb_list-cell-title f16"><?php echo ($goodsInfo['goods_name']); ?></h2>
      </aside>
    </article>
    <article class="main_bg p10 mb10">
      
      <p class="tg_ft-price mb10">
      <?php if(($goodsInfo['is_promotion'] == '1') AND ($goodsInfo['sales_start_time'] < time()) AND ($goodsInfo['sales_end_time'] > time())): ?><em class="f16 mr10">￥<?php echo ($goodsInfo['price']*($goodsInfo['discount']/10)); ?>元</em>
        <em class="tg_through mr10 tg_ft-default">￥<?php echo ($goodsInfo['price']); ?></em>
        <time class="tg_ft-price mb10">
          距结束：<?php echo turnDistanceTime($goodsInfo['sales_end_time']);?>
        </time>
        <?php else: ?>
           <em class="f16 mr10">￥<?php echo ($goodsInfo['price']); ?>元</em><?php endif; ?>
      </p>
      <p class="flexLayout-center dl_between tg_ft-default">
        <em>快递:<?php echo ($goodsInfo['express_price']); ?></em>
        <em>月销:<?php echo ($goodsInfo['sales_total']?$goodsInfo['sales_total']:0); ?>笔</em>
        <!-- <em>广东佛山</em> -->
      </p>
    </article>
    <article class="kb_list-cell kb_list-cell_small mt10">
      <div class="kb_list-cell-hd">
          <img src="/Public/trading/images/tr-Order.png" alt="" />
      </div>
      <aside class="kb_list-cell-bd">
        <h2 class="kb_list-cell-title">商品详情</h2>
      </aside>
    </article>
    <article class="p10 main_bg mb10" id="showImg">
      <!-- <h2 clas="f14">标题标题标题标题</h2>
      <p>我无法否认自己的存在，因为当我否认、怀疑时，我就已经存在！”因为我在思考在怀疑的时候，肯定有一个执行“思考”的“思考者”，这个作为主体的“我”是不容怀疑的，这个我并非广延的肉体的“我”，而是思维者的我。所以，否认自己的存在是自相矛盾的</p> -->
      <?php echo ($goodsInfo['goods_title']); ?>
    </article>
    

    <article class="dl_class-recommend p10 main_bg  mb10">
      <h2 class="f16 tc mb10">为您推荐</h2>
      <ul class="tg_list-cell tg_list-cell_two">
      <?php if(is_array($goodsLike)): $i = 0; $__LIST__ = $goodsLike;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li class="tg_list-bd mb10">
            <a href="<?php echo U('goodsDetail', ['id' => $v['id'], 'companyName' => $_GET['companyName']]);?>" class="imgW w">
              <img src="/Public<?php echo ($v["goods_logo"]); ?>" alt="" />
            </a>
            <h3 class="mb10 mt10"><?php echo ($v["goods_name"]); ?></h3>
            <p class="flexLayout-center dl_between ">
              <em class="tg_ft-price f14">￥<?php echo ($v['price']); ?></em>
              <em class="tg_ft-default">销量:<?php echo ($v["salesTotal"]); ?></em>
            </p>
        </li><?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
    </article>
  </section>
  


  <footer id="Footer" class="kb_footer ">
      <div class="tg_cell dl_classOpera h">
          <div class="tg_cell-hd flexLayout-center h">
          
            <a href="<?php echo U('Index/index',['companyName' => $_GET['companyName']]);?>" class="tg_cell-bd h">
                <p class="icon-gohone h20 mt5  w"></p>
                <p class="tc mt5">店铺</p>
            </a>
            <a href="javascript:;" class="tg_cell-bd h">
                <p class="kb_choose mt5  w h20">
                  <input type="checkbox" value="" <?php echo ($is_save==1? "checked='true'":''); ?> class="mark-attention" />
                  <span class="icon-isAttention kb_btn h10 "></span>
                </p>
                <p class="tc "> <?php echo ($is_save==1?'已关注':'未关注'); ?></p>
            </a>
            <a href="<?php echo U('ShoppingCart/myCart');?>?companyName=<?php echo I('get.companyName');?>&c_com=g&gid=<?php echo I('get.id');?>" class="tg_cell-bd h">
                <p class="icon-addShop h20 mt5 <?php echo ($cartTotal?'dl_myself-order-point':''); ?> w"></p>
                <p class="tc mt5">购物车</p>
            </a>
          </div>
          <p class="tg_cell-bd h flexLayout-center">
            <button type="button" data-goodsid="<?php echo ($goodsInfo['id']); ?>" class="kb_btn dl_classDetail-btn kb_btn-main tg_cell-bd  h  mark-addCar f18">加入购物车</button>
            <button type="button" data-goodsid="<?php echo ($goodsInfo['id']); ?>"  class="kb_btn kb_btn-main   tg_cell-bd h mark-bugShoping f18" >立即购买</button>
          </p>
      </div>
  </footer>


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

  <div class="sltShopBuy pt20" id="sltShopBuy" v-bind:data-goodid="goodsData.id">
 <form id="sltShopBuyForm" action="<?php echo U('PT2/ShoppingCart/insertCart');?>" method="post">
  <input type="hidden" name="goods_id" v-bind:value="goodsData.id" /> 
  <input type="hidden" name="price" v-bind:value="goodsData.attr_price" /> 
  <button type="button" class="kb_btn w20 h20 sltShopClose"></button>
  <article class="kb_list-cell pt20">  
    <div class="kb_list-cell-hd">
      <img v-bind:src="'/Public'+goodsData.goods_logo" alt="" />
    </div>
    <aside class="kb_list-cell-bd pr20">
      <h2 class="kb_list-cell-title mb10 f15">
      {{goodsData.goods_name}}
      </h2>
      <p class="kb_list-cell-brief ">
        <b class="tg_ft-price f16">￥
        {{goodsData.price}}
        </b>
        <em>库存{{goodsData.inventory_total ? goodsData.inventory_total:0}}</em>
      </p>
    </aside>
  
  </article>
  <article class="main_bg p10">
  <p >属性选择</p>
  <p class="sltShopBuy-attr pt10">
    <label class="kb_choose mr10" v-for="(attrName , indexs) in attrData">
      <input type="radio" name="attribute_id"
       v-bind:value="attrName.id"
       v-bind:data-image="attrName.attr_pic"
       v-bind:data-attr_val="attrName.attr_val" 
       v-bind:data-inventory_total="attrName.inventory_total"  v-bind:data-attr_price="attrName.attr_price" 
       v-bind:data-price="attrName.price" 
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
      <input type="button" value="-" class="kb_btn w30 f14" @click="lower" />
      <input type="number" v-bind:value="goodsNum" name="total" readonly class="sltShopBuy-update-number tc w30 f15" />
      <input type="button" value="+" class="kb_btn w30 f14"  @click="add" />
    </p>
  </article>
  <p class="main_bg">
  <button type="button" class="kb_btn kb_btn-main w h50 f18 fb mark-sltShopSub">确定</button>
  </p>
  </form>
</div>
<script>
  window.onload=function(){
      var u = navigator.userAgent;
       var device =""; //当前设备信息
       if (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1) {//安卓手机
           $('.dl_class-recommend li').addClass("mb100")
           $('.dl_class-recommend').addClass("mt50")
           device = "Android";
       } else if (u.indexOf('iPhone') > -1) {//苹果手机
           d = "iPhone";
       } else if (u.indexOf('Windows Phone') > -1) {//winphone手机
           device = "Windows Phone";
       }

      (function(){
         var swiper = new Swiper('#focusWap', {
                         autoplay:5000,//可选选项，自动滑动
                         pagination: '.swiper-pagination',
                     });
      })();
      $('.kb_footer .tg_cell-bd button').on('click',function(){
        $('.sltShopBuy').show();
      });
      $('.sltShopClose,.mark-sltShopSub').on('click',function(){
        $('.sltShopBuy').hide();

      });
      (function(){
        var way;
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
                   app.$data.goodsData.attr_price=$this.attr('data-price');
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

        $('.mark-bugShoping,.mark-addCar').on('click',function(e){
          var $this,ID,data;
          $this=$(this);
          ID=$this.attr('data-goodsid').trim();
          if($this.hasClass('mark-bugShoping')){
            way=1;
          }else{
            way=null;
          }
          data={
            flag:'getAttr',
            id:ID,
            companyName:"<?php echo ($_GET['companyName']); ?>"
          };
          $.ajax({
            type: "GET",
            url: "<?php echo U('ajaxControl');?>",
            data: data,
            dataType: "json",
            success: function(res) {
            	console.log(res);
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
                formdata=new FormData($('#sltShopBuyForm')[0]),
                url="<?php echo U('PT2/ShoppingCart/insertCart');?>";
            goodsid=$this.parents('#sltShopBuy').find('.sltShopBuy-attr input:checked').val();
            goodsNum=(goodsNum>0)?goodsNum:1;
            if(!goodsid){
                oTip('请先选择属性');
                return false;
            }
            if(way==1){
             
              $('#sltShopBuyForm').attr('action',"<?php echo U('PT2/OrderForm/unpaid');?>?way=1&companyName=<?php echo ($_GET['companyName']); ?>");
              $('#sltShopBuyForm').submit();
              return false;
            }
            $.ajax({
                type:'POST',
                url:url,
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
    $('.mark-isCollect').on('click',function(){
      var $this=$(this),
          status=$this.prop('checked')?1:2,
          getData=new Object,
          goodsid=$this.attr('data-goodsid').trim(),
          tipTxt;
          getData={
            flag: 'collectGoods',
            goods_id: goodsid ,
            status:status,

          }
          $.ajax({
            type:"GET",
            url:"<?php echo U('PT2/Goods/ajaxControl');?>",
            data:getData,
            dataType:'json',
            success:function(data){
              tipTxt=status==1? '收藏成功':'取消收藏'
              if(data){
                oTip(tipTxt);
              }else{
                oTip('操作失败');
              }
            },
            error:function(error){
              console.log(error)
            }
          })
    })
     $('.mark-attention').on('click',function(){
      var $this,isCheck,getData,tipTxt;
      $this=$(this);
      isCheck= $this.prop('checked')===true?1:2;
     
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
             $this.parents('.kb_choose').next().text(isCheck==1?"已关注":"未关注")
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
  }
</script>


 <script>
      wx.ready(function(){
          wx.onMenuShareAppMessage({
             title: '<?php echo ($companyInfo["company_name"]?$companyInfo["company_name"]:"阿密购商城"); ?>', // 分享标题
             desc: '<?php echo ($goodsInfo['goods_name']); ?>', // 分享描述
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
             desc: '<?php echo ($goodsInfo['goods_name']); ?>', // 分享描述
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
             desc: '<?php echo ($goodsInfo['goods_name']); ?>', // 分享描述
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
             desc: '<?php echo ($goodsInfo['goods_name']); ?>', // 分享描述
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