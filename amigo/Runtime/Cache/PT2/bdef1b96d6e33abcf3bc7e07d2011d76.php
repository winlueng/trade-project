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
    
<link href="/Public/trading/style/temporarily.css" rel="stylesheet"></link>
<link href="/Public/JS/module/ladingPasswordConfirm/passwordkeyboard.css" rel="stylesheet" type="text/css"></link>
  <style>
     .kb_list img{
        height:80px;
     }
     #facusWap a{
      width:calc(100% / 5);
     }
  </style>
  <?php  ?>

</head>
<body>

  <header id="Header" class="kb_header flexLayout-center ">
    <nav>
      
  <?php if($_GET['companyName'] AND $_GET['tem']): ?><a href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/<?php echo I('get.tem');?>/VisitorInfo/myCenter?companyName=<?php echo I('get.companyName');?>" class="icon-back w"></a>
  <?php else: ?>
    <a href="<?php echo U('VisitorInfo/myCenter');?>" class="icon-back w"></a><?php endif; ?>

    </nav>
    <h2 class="kb_header-title">
    
我的订单

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


  <section id="Main" class="kb_main bc kb_notFooter  tg_orderlist">
   <header id="facusWap" class="swiper-container main_bg ">
    <nav class="kb_tabNav   swiper-wrapper f16">
      <a class="swiper-slide <?php echo ($_GET['show']?'':'selected'); ?> " href="<?php echo U('OrderForm/orderList');?>?show=0&companyName=<?php echo I('get.companyName');?>&tem=<?php echo I('get.tem');?>">全部</a>
      <a class="swiper-slide <?php echo ($_GET['show']=='1'?'selected':''); ?>" href="<?php echo U('OrderForm/orderList');?>?show=1&companyName=<?php echo I('get.companyName');?>&tem=<?php echo I('get.tem');?>">待付款</a>
      <a class="swiper-slide <?php echo ($_GET['show']=='2'?'selected':''); ?>" href="<?php echo U('OrderForm/orderList');?>?show=2&companyName=<?php echo I('get.companyName');?>&tem=<?php echo I('get.tem');?>">待发货</a>
      <a class="swiper-slide <?php echo ($_GET['show']=='3'?'selected':''); ?>" href="<?php echo U('OrderForm/orderList');?>?show=3&companyName=<?php echo I('get.companyName');?>&tem=<?php echo I('get.tem');?>">待收货</a>
      <a class="swiper-slide <?php echo ($_GET['show']=='4'?'selected':''); ?>" href="<?php echo U('OrderForm/orderList');?>?show=4&companyName=<?php echo I('get.companyName');?>&tem=<?php echo I('get.tem');?>">待评价</a>
    </nav>
   </header>
   <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><ul class="kb_list mt10">
          <?php if($v['company_id']): ?><a class="kb_list-title kb_list-cell kb_list-cell_small kb_cell-href" href="<?php echo ($v["company_link"]); ?>">
          <?php else: ?>
            <a class="kb_list-title kb_list-cell kb_list-cell_small kb_cell-href" href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>"><?php endif; ?>
        <div class="kb_list-cell-hd ">
          <!-- 自营的图片路径 /Public/trading/images/tr-Self-employed.png -->
          <?php if($v['company_id']): ?><img src="/Public/trading/images/tr-shop.png" alt="" />
          <?php else: ?>
            <img src="/Public/trading/images/tr-Self-employed.png" alt="" /><?php endif; ?>
        </div>
          <aside class="kb_list-cell-bd">
          <?php if($v['company_id']): ?><h2 class="kb_list-cell-title"><?php echo ($v["company_name"]); ?></h2>
          <?php else: ?>
            <h2 class="kb_list-cell-title"><?php echo ($pInfo['market_name']); ?></h2><?php endif; ?>
        </aside>
        <p class="kb_cell-ft">
            
        </p>
      </a>
      <li class="kb_list-cells">
      <?php if(is_array($v["goods_data"])): $i = 0; $__LIST__ = $v["goods_data"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('OrderForm/orderDetail');?>?id=<?php echo ($v["id"]); ?>&companyName=<?php echo I('get.companyName');?>&tem=<?php echo I('get.tem');?>" class="kb_list-cell">  
            <div class="kb_list-cell-hd">
                <img src="/Public<?php echo ($vo["attrInfo"]["attr_pic"]); ?>" alt="" />
            </div>
            <aside class="kb_list-cell-bd">
                <h2 class="kb_list-cell-title mb10"><?php echo ($vo["goods_name"]); ?> 
                <time class="kb_list-cell-title-time">
                <?php switch($v["status"]): case "0": if(($v['pay_status'] == 0)): if(((($v['create_time']+172800)-time()) > 0)): ?>待付款
                        <?php else: ?>
                        已关闭<?php endif; endif; break;?>
                  <?php case "1": ?>已取消<?php break;?>
                  <?php case "2": switch($v["is_send_out"]): case "0": ?>待发货<?php break;?>
                      <?php case "1": ?>待收货<?php break;?>
                      <?php case "2": ?>已收货<?php break; endswitch; break;?>
                  <?php case "3": ?>关闭交易<?php break;?>
                  <?php case "4": ?>已完成<?php break;?>
                  </case><?php endswitch;?>
                </time></h2>
                <div class="kb_list-cell-brief">
                    <p class=" mb10">
                        产品规格: <?php echo ($vo["attrInfo"]["attr_val"]); ?>
                    </p>
                    <p class=" dl_bugShoping">
                       <em class="tg_ft-price">￥<?php echo ($vo["price"]); ?>元</em>
                       <em>x<?php echo ($vo["total"]); ?></em>
                    </p>
                </div>
            </aside>
         </a><?php endforeach; endif; else: echo "" ;endif; ?>
         <p class="tr p10 fb">共<?php echo ($v["piece"]); ?>件&nbsp;&nbsp;实付金额：<em class="tg_ft-price mark-totalPrice"><?php echo ($v['total'] + $v['express_price']); ?></em></p>
         <div class="dl_orderOptraing tg_cell pb10">

          <?php switch($v["status"]): case "0": if(($v['pay_status'] == 0)): if(((($v['create_time']+172800)-time()) > 0)): ?><p class="dl_orderOptraing-bd">
                      <input type="button" value="取消订单" data-orderID="<?php echo ($v["id"]); ?>" class="kb_btn  tg_btn-default w" @click="cancelOrder" />
                    </p>
                    <p class="dl_orderOptraing-bd">
                      <input type="button" value="支付" orderID="<?php echo ($v["id"]); ?>" v-on:click="sltPay" class="kb_btn kb_btn-main w" />
                    </p><?php endif; endif; break;?>
              <?php case "2": switch($v["is_send_out"]): case "0": ?><p class="dl_orderOptraing-bd">
                        <input type="button" value="申请退款" orderID="<?php echo ($v["id"]); ?>" v-on:click="returnMoney" class="kb_btn  tg_btn-default w" />
                      </p>
                      <!-- <p class="dl_orderOptraing-bd">
                        <input type="button" value="提醒发货" class="kb_btn kb_btn-main w" />
                      </p> --><?php break;?>
                  <?php case "1": ?><!-- <a class="defineBtn  mr10  btnColorFFF" href="<?php echo U('Express/showExpressInfo', ['companyName' => $_GET['companyName'], 'id' => $v['id']]);?>" >&nbsp;&nbsp;查看物流</a> -->
                      <p class="dl_orderOptraing-bd">
                        <input type="button" data-orderID="<?php echo ($v["id"]); ?>" v-on:click="extendTimeGoods(<?php echo ($v['id']); ?>)" type="button" value="延长收货" class="kb_btn kb_btn-main w" />
                      </p>
                      <p class="dl_orderOptraing-bd ">
                        <a type="button" value="查看物流" href="<?php echo U('Express/showExpressInfo');?>?id=<?php echo ($v['id']); ?>" class="kb_btn  tg_btn-default w " >查看物流</a>
                      </p>
                      <p class="dl_orderOptraing-bd">
                        <input type="button" data-orderID="<?php echo ($v["id"]); ?>" v-on:click="affirmGoods" type="button" value="确认收货" class="kb_btn kb_btn-main w" />
                      </p><?php break;?>
                  <?php case "2": ?><p class="dl_orderOptraing-bd">
                      <a type="button" href="<?php echo U('GoodsComment/commentIns');?>?id=<?php echo ($v['id']); ?>" class="kb_btn  tg_btn-default w" >去评价</a>
                    </p><?php break; endswitch; break;?>
              <?php case "4": if(($v['goods_score'] == 0) AND ($v['express_score'] == 0)): ?><p class="dl_orderOptraing-bd">
                  <!--   <a type="button" href="<?php echo U('GoodsComment/commentIns');?>?id=<?php echo ($v['id']); ?>" class="kb_btn  tg_btn-default w" >去评价</a> -->
                  </p><?php endif; break; endswitch;?>
         </div>
      </li>
    </ul><?php endforeach; endif; else: echo "" ;endif; ?>
    <?php if(($list) AND (count($list) > 5)): ?><li is="myTemlate"  v-bind:Phrase="indexs" v-for="indexs in info" >
        </li>
      <p id="lookMore" class="lookMore tc pt10 pb10 f14"><a href="javascript:;">查看更多</a></p><?php endif; ?>
    <div class="sltPayClass">
      <div class="dl_cover" @click="closeCover" ></div>
      <div class="kb_list-cell kb_list-cell_small kb_cell-href">
        <aside class="kb_list-cell-bd">
            <h2 class="">选择付款方式</h2>
        </aside>
        <p class="kb_cell-ft">
        </p>
      </div>
      <article class="kb_cell kb_cell-check">
        <p class="kb_cell-hd mr10">
          <img src="/Public/trading/images/tr-WeChat-payment.png" alt="" class="w30 h30" />
        </p>
        <p class="kb_cell-bd">
          <h2 class="kb_list-cell-title tl w">微信支付 
      </h2>
        </p>
        <p class="kb_cell-ft kb_choose">
          <input type="radio" name="rd1" id="weixin" value="" v-bind:data-orderid="orderinfo.orderid" v-on:click="pay"  />
          <span class=" kb_choose-check">
            <b class="kb_choose-check-default kb_choose-check_default"></b>
          </span>
        </p>
      </article>
      <article class="kb_cell kb_cell-check">
        <p class="kb_cell-hd mr10">
          <img src="/Public/trading/images/tr-Wallet-to-pay.png" alt="" class="w30 h30" />
        </p>
        <div class="kb_cell-bd">
          <h2 class="kb_list-cell-title">钱包
          </h2>
          <p class="kb_list-cell-brief"><?php echo ($userInfo['wallet']); ?>密条</p>
        </div>
        <p class="kb_cell-ft kb_choose">
          <input type="radio" name="rd1"

           value="" data-isPassword="<?php echo ($userInfo['pay_pass_word'] ?'1':'0'); ?>"
          v-bind:data-orderid="orderinfo.orderid"
          v-bind:data-orderprice="orderinfo.orderprice"
          @click="walletPay"
          class="mark-selfwallet"
           />
          <span class=" kb_choose-check">
            <b class="kb_choose-check-default kb_choose-check_default"></b>
          </span>
        </p>
      </article>
    </div>
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
  

  <div class="bsAlert cancelOrderAlert">
    <div class="alertCover CoverBc999"></div>
    <div class="AlertBox" style="height:220px">
      <h2>取消订单</h2>
      <button type="button" class="alertClose" v-on:click="alertClose"></button>
      <div class="alertContent">
        <ul class="optionCard">
          <li>
            <p>
              <span class="choose chooseGoods roundChoose">
                <input type="radio" value="拍错/多拍/不想要"  name="a" />
                <label class=""></label>
              </span>
            </p>
            <p>拍错/多拍/不想要</p>
          </li>
          <li>
            <p>
              <span class="choose chooseGoods roundChoose">
                <input type="radio" value="线下交易了"  name="a" />
                <label class=""></label>
              </span>
            </p>
            <p>线下交易了</p>
          </li>
          <li class="other">
            <p>
              <span class="choose chooseGoods roundChoose">
                <input type="radio" value=""  name="a" />
                <label class=""></label>
              </span>
            </p>
            <p>其他</p>
            <p class="otherArea">
              <textarea placholder="请认真填写..."></textarea>
            </p>
          </li>
        </ul>

      </div>
      <div class="alertFooter">
        <p><input class="cancel" type="button" value="取消" /></p>
        <p><input class="determine" type="button" value="确认" /></p>
      </div>
    </div>
  </div>
  <div class="bsAlert returnMoneyAlert">
    <div class="alertCover CoverBc999"></div>
    <form action="" method="post">
    <div class="AlertBox" style="height:280px">
      <h2>退款原因</h2>
      <button type="button" class="alertClose"  v-on:click="alertClose"></button>
      <div class="alertContent">
        <ul class="optionCard">
          <li>
            <p>
              <span class="choose chooseGoods roundChoose">
                <input type="radio" name="drawback_remark" value="协商一致退款" />
                <label class=""></label>
              </span>
            </p>

            <p>协商一致退款</p>
          </li>
          <li>
            <p>
              <span class="choose chooseGoods roundChoose">
                <input type="radio" name="drawback_remark" value="拍错/多拍/不想要" />
                <label class=""></label>
              </span>
            </p>
            <p>拍错/多拍/不想要</p>
          </li>
          <li>
            <p>
              <span class="choose chooseGoods roundChoose">
                <input type="radio" name="drawback_remark" value="货物损坏了" />
                <label class=""></label>
              </span>
            </p>
            <p>货物损坏了</p>
          </li>
          <li class="other">
            <p>
              <span class="choose chooseGoods roundChoose">
                <input type="radio" name="drawback_remark" value="" />
                <label class=""></label>
              </span>
            </p>
            <p>其他</p>
            <p class="otherArea">
              <textarea placholder="请认真填写..."></textarea>
            </p>
          </li>
        </ul>
      </div>
      <div class="alertFooter">
        <p><input class="cancel" type="button" value="取消" /></p>
        <p><input class="determine" type="button" value="确认" /></p>
      </div>
    </div>
  </form>
  </div>
   <!-- 自定义支付 -->
   <div class="ftc_wzsf">
   <div class="srzfmm_box">
     <div class="qsrzfmm_bt clear_wl"> <img src="/Public/images/xx_03.jpg" class="tx close fr" > <p class="fl">请输入支付密码</p> </div>
     <div class="zfmmxx_shop">
       <div class="wxzf_price">￥<?php echo ($list['express_price'] + $list['order_total']); ?>元</div>
     </div>
      <p class="tc ml5">余额支付</p> 
     <div style="padding-top: 20px;text-align: center;">
         <form id="password" >
             <input readonly class="pass" type="password"maxlength="1"value="">
             <input readonly class="pass" type="password"maxlength="1"value="">
             <input readonly class="pass" type="password"maxlength="1"value="">
             <input readonly class="pass" type="password"maxlength="1"value="">
             <input readonly class="pass" type="password"maxlength="1"value="">
             <input readonly class="pass pass_right" type="password"maxlength="1" value="">

         </form>
         <input type="hidden" id="projectOrder" data-orderinfo='' />
     </div>
   </div>
   <div id="keyboardDIV"></div>
   </div>
  <script src="/Public/JS/module/ladingPasswordConfirm/ladingPasswordConfirm.js"></script>

  <script id="orderListTem" type="text/x-handlebars-template">
    <ul class="kb_list mt10">
      <a v-bind:href="Phrase.company_id>0?Phrase.company_link:'http://<?php echo ($_SERVER['HTTP_HOST']); ?>'" class="kb_list-title kb_list-cell kb_list-cell_small kb_cell-href">
        <div class="kb_list-cell-hd ">
          <img v-bind:src="Phrase.company_id>0?'/Public/trading/images/tr-shop.png':'/Public/trading/images/tr-Self-employed.png'" alt="" />
        </div>
          <aside class="kb_list-cell-bd">
            <h2 class="kb_list-cell-title">
              {{Phrase.company_id>0? Phrase.company_name:'<?php echo ($pInfo['market_name']); ?>'}}
            </h2>
        </aside>
        <p class="kb_cell-ft">
        </p>
      </a>
      <li class="kb_list-cells">
      <template v-for="goodsIndex in Phrase.goods_data">
        <a v-bind:href="goodsIndex.link" class="kb_list-cell">  
          <div class="kb_list-cell-hd">
              <img v-bind:src="'/Public'+goodsIndex.attrInfo.attr_pic" alt="" />
          </div>
          <aside class="kb_list-cell-bd">
              <h2 class="kb_list-cell-title mb10">{{goodsIndex.goods_name}} 
                <time class="kb_list-cell-title-time" v-if="Phrase.status==0">
                  <template v-if="Phrase.pay_status==0">
                    <template v-if="Phrase.pay_status">
                      待付款
                    </template>
                    <template v-else> 
                      已关闭
                    </template>
                  </template>
                </time>
                <time class="kb_list-cell-title-time" v-if="Phrase.status==1">
                  已取消
                </time>
                <time class="kb_list-cell-title-time" v-if="Phrase.status==2">
                  <template v-if="Phrase.is_send_out==0">
                    待发货
                  </template>
                  <template v-else-if="Phrase.is_send_out==1"> 
                      待收货
                  </template>
                  <template v-else-if="Phrase.is_send_out==2"> 
                      已收货
                  </template>
                </time>
                <time class="kb_list-cell-title-time" v-if="Phrase.status==3">
                  关闭交易
                </time>
                <time class="kb_list-cell-title-time" v-if="Phrase.status==4">
                  已完成
                </time>
              </h2>
              <div class="kb_list-cell-brief">
                  <p class=" mb10">
                      {{goodsIndex.attrInfo.attr_val}}
                  </p>
                  <p class=" dl_bugShoping">
                     <em class="tg_ft-price">￥{{goodsIndex.price}}元</em>
                     <em>x{{goodsIndex.total}}</em>
                  </p>
              </div>
          </aside>
        </a>
      </template>
         <p class="tr p10 fb">共{{Phrase.piece}}件&nbsp;&nbsp;实付金额：<em class="tg_ft-price mark-totalPrice">{{(parseInt(Phrase.total) + parseInt(Phrase.express_price)).toFixed(2)}}</em></p>
         <div
             v-if="Phrase.status==0"
            class="dl_orderOptraing tg_cell pb10" 
          >
            <template v-if="Phrase.pay_status==0">
              <template v-if="eqTime(Phrase.create_time)" >
                <p class="dl_orderOptraing-bd">
                  <input type="button" value="取消订单" class="kb_btn  tg_btn-default w"
                  v-bind:data-orderID="Phrase.id"
                  />
                </p>
                <p class="dl_orderOptraing-bd">
                  <input  class="kb_btn  kb_btn-main w pay"  type="button" value="支付"
                  v-on:click="sltPay" v-bind:orderID="Phrase.id"
                  />
                </p>
              </template>
              <template v-else>
                <p class="dl_orderOptraing-bd">
                  <input type="button" value="订单关闭" class="kb_btn  tg_btn-default w"
                  />
                </p>
              </template>
          </template>
        </div>
        <div v-else-if="Phrase.status==1" 
          class="dl_orderOptraing tg_cell pb10" >
          <p class="dl_orderOptraing-bd">
             <input type="button" value="已取消" class="kb_btn  tg_btn-default w"
                  />
          </p>
        </div>
        <div v-else-if="Phrase.status==2"
          class="dl_orderOptraing tg_cell pb10"
        >
          <template v-if="Phrase.is_send_out==0">
          <p class="dl_orderOptraing-bd">
            <input  type="button" value="申请退款"  class="kb_btn tg_btn-default returnMoney " 
            v-on:click="returnMoney" v-bind:orderID="Phrase.id"  v-bind:data-orderID="Phrase.id" 
            />
          </p>
          <!-- <p class="dl_orderOptraing-bd">
            <input class="kb_btn  tg_btn-default w" type="button" value="待发货" />
          </p>
 -->
          </template>
          <template v-else-if="Phrase.is_send_out==1">
          <p class="dl_orderOptraing-bd">
            <input  type="button" value="延长收货" class="kb_btn kb_btn-main w" 
            v-bind:data-orderID="Phrase.id" v-on:click="extendTimeGoods(Phrase.id)"
             />
          </p>
          <p class="dl_orderOptraing-bd">
            <a
            v-bind:href="jumpUrl('expressInfo',Phrase.id)"
            class="kb_btn  tg_btn-default w " >查看物流</a>
          </p>
          <p class="dl_orderOptraing-bd">
            <input
             v-bind:data-orderID="Phrase.id" v-on:click="affirmGoods" type="button" value="确认收货" class="kb_btn kb_btn-main w" />
          </p>
           <p class="dl_orderOptraing-bd">
            <input
             v-bind:data-orderID="Phrase.id"
             v-on:click="returnMoney" v-bind:orderID="Phrase.id"
             type="button" value="申请退款"
              class="kb_btn kb_btn-default w" />
          </p>
          </template>
          <template v-else-if="Phrase.is_send_out==2">
          <p class="dl_orderOptraing-bd">
            <a
            v-bind:href="jumpUrl('evaluate',Phrase.id)"
            class="kb_btn  tg_btn-default w " >去评价</a>
          </p>
          </template>
        </div>

        <div v-else-if="Phrase.status==3" v-bind:data-true="eqTime(Phrase.create_time)">
          <p class="dl_orderOptraing-bd">
            <input class="kb_btn  tg_btn-default w "  type="button" value="已关闭" />
          </p>
        </div>
       <div v-else-if="Phrase.status==4">
            <template v-if="Phrase.goods_score=0">
             <p class="dl_orderOptraing-bd">
              <a class="kb_btn  tg_btn-default w" v-bind:href="jumpUrl('evaluate',Phrase.id)" >去评价</a>
             </p>
            </template>

            <template v-else>
            <p class="dl_orderOptraing-bd">
              <input class="kb_btn  tg_btn-default w" type="button" value="已完成" />
            </p>
            </template>
          </div>
      </li>
    </ul>
  </script>
  <script>
      window.onload=function(){
          // (function(){
          //     var swiper = new Swiper('#facusWap',{
          //     });
          //     console.log(swiper);
          // })();
      }
      // function walletPay(orderId,totalPrice){
      // }
      function onBridgeReady(info,id){

      var data = JSON.parse(info);
      // console.log(data);
      // console.log(id);
        WeixinJSBridge.invoke(
           'getBrandWCPayRequest', {
              "appId":data.appId,
              "timeStamp":data.timeStamp,
              "nonceStr":data.nonceStr,
              "package":data.package,
              "signType":data.signType,
              "paySign":data.paySign
            },
            function(res){     
                if(res.err_msg == "get_brand_wcpay_request:ok" ) {// 支付成功走这
                  WeixinJSBridge.log(res.err_msg);
                  $.get("<?php echo U('ajaxControl');?>",{flag:'selOrderStatus',id:id},function (result) {
                        if(result){
                          window.location.href='http://<?php echo ($_SERVER["HTTP_HOST"]); echo U("OrderForm/payed");?>?order_id='+id+"&companyName=<?php echo I('get.companyName');?>&tem=<?php echo I('get.tem');?>";
                        }else{
                          alert('订单支付失败!');
                        }
                    });
                }else{
                  // alert(1);
                  window.location.href='http://<?php echo ($_SERVER["HTTP_HOST"]); echo U("OrderForm/orderList");?>?show=1&companyName=<?php echo I("get.companyName");?>&tem=<?php echo I("get.tem");?>';
                } 
            }
       ); 
    }

    function showPay(pay,id) {
      if (typeof WeixinJSBridge == "undefined"){
         if( document.addEventListener ){
             document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
         }else if (document.attachEvent){
             document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
             document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
         }
      }else{
        // console.log(pay)
          onBridgeReady(pay,id);
      }
    }

    $(function(){
      (function(){
        var Child={
          template:'#orderListTem',
          props: ['Phrase'],
          methods:{
            jumpUrl:function(uType,ID){
              switch(uType){
                case 'evaluate':
                  return "<?php echo U('GoodsComment/commentIns', ['companyName' => $_GET['companyName']]);?>?id="+ID;
                break;
                case 'orderDetail':
                  return "<?php echo U('orderDetail', ['companyName' => $_GET['companyName']]);?>?id="+ID;
                break;
                case 'expressInfo':
                  return "<?php echo U('Express/showExpressInfo', ['companyName' => $_GET['companyName']]);?>?id="+ID;
                break;
              }
            },
            eqTime:function(time){
              var now=new Date(),
                nowTimestamp=Date.parse(now)/1000;
                console.log(nowTimestamp)
                console.log(time)
                console.log(nowTimestamp-time>24*60*60*2)
              return nowTimestamp-time<24*60*60*2;
            },
            affirmGoods:function(event){
              app.$emit('affirmGoods',event);
            },
            returnMoney:function(event){
              app.$emit('returnMoney',event)
            },
            pay:function(event){
              app.$emit('pay',event);
            },
            cancelOrder:function(event){
              app.$emit('cancelOrder',event)
            },
            sltPay:function(event){
              console.log(event);
               app.$emit('sltPay',event);
            }
          }
        }
        var app=new Vue({
          el:"#Main",
          components:{
            'myTemlate':Child
          },
          data:{
            info:[],
            clickTotal:2,
            orderinfo:{
              id:'',
              orderprice:'',
              success: '',
              url: "<?php echo U('OrderForm/ajaxControl');?>",
              paypaw: "<?php echo U('WasteBook/setPayPassWord');?>",
              flag: 'balance_to_buy'
            }
          },
          computed:{
          },
          methods:{
            affirmGoods:function(event){
              console.log(event)
              var $this=(event.target)? $(event.target):$(event.srcElement),
                orderID=$this.attr('data-orderID').trim();
                console.log(orderID);
                Confirm("你正在进行收货操作，你确定已经收到货物了吗？",function(res){
                    if(res){
                        $.ajax({
                          type:"GET",
                          url:'<?php echo U("OrderForm/ajaxControl");?>',
                          data:{
                            flag:'receiving',
                            id:orderID,
                            companyName:"<?php echo ($_GET['companyName']); ?>"
                          },
                          dataType:"json",
                          success:function(data){
                            if(res){
                              oTip('操作成功')
                              window.location.reload();
                            }else{
                              oTip('操作失败')
                              window.location.reload();
                            }
                          },
                          error:function(error){
                            oTip('操作失败!')
                          }
                        });
                    }
                })
            },
            returnMoney:function(event){
              console.log(event);
              var url = "<?php echo U('orderForm/orderApplicationForDrawback', ['companyName' => $_GET['companyName']]);?>?id="+$(this).attr('orderID');
              $('.returnMoneyAlert form').attr('action', url);
              $('.returnMoneyAlert').show();
              var _this=(event.target)? $(event.target):$(event.srcElement),
                orderID=_this.attr('orderid').trim();
              // console.log(_this);
              $('.returnMoneyAlert .optionCard li  .roundChoose input').on('click',function(){
                var $this=$(this);
                  checkedStatus=$this.is(":checked");
                  hasOther=$this.parents('li').hasClass('other'),
                  otherArea= $this.parents('p').siblings('.otherArea').children('textarea'),
                  drawback_remark='';
                  if(hasOther){
                    otherArea.show();

                  }else{
                    otherArea.hide();
                  }
                  $('.returnMoneyAlert .determine').on('click',function(){
                    if(hasOther){
                      drawback_remark=otherArea.val();

                    }else{
                      drawback_remark=$this.val();
                    }
                    if(drawback_remark.length==0){Alert('请选择或者填写退款理由'); return false; }
                    console.log(drawback_remark);
                      $.ajax({
                        type:"GET",
                        url:'<?php echo U("OrderForm/ajaxControl");?>',
                        data:{
                            flag:'orderApplicationForDrawback',
                            id:orderID,
                            drawback_remark:drawback_remark,
                            companyName:"<?php echo ($_GET['companyName']); ?>"
                          },
                        dataType:"json",
                        success:function(data){
                          if(data){
                            oTip('操作成功')
                             window.location.reload();
                          }else{
                            oTip('操作失败')
                            window.location.reload();
                          }
                        },
                        error:function(error){
                          oTip('操作失败!')
                        }
                      });
                    $('.returnMoneyAlert').hide();
                  })
              })
            },
            sltPay:function(event){
              var $this = (event.target)? $(event.target):$(event.srcElement),
                  orderid=$this.attr('orderID').trim(),
                  totalPrice=$this.parents('.kb_list-cells').find('.mark-totalPrice').text().trim();
                  console.log($this.parents('.kb_list-cells'));
                  $('.sltPayClass').show();
                  this.$data.orderinfo.orderprice=totalPrice;
                  this.$data.orderinfo.id=orderid;

            },
            walletPay:function(event){
                var password,orderId,_this,totalPrice,$this;
                $this = (event.target)? $(event.target):$(event.srcElement);
                $('.dl_passwordAlert').show();
                $('.sltPayClass').hide();
                totalPrice=$this.attr('data-orderprice').trim();
                totalPrice="￥"+totalPrice+"元";
                // orderId=$this.attr('data-orderid').trim();
                $('.srzfmm_box .wxzf_price').text(totalPrice);
                this.orderinfo.success = 'http://<?php echo ($_SERVER["HTTP_HOST"]); echo U("OrderForm/payed");?>?order_id='+orderId+'&companyName=<?php echo I("get.companyName");?>&tem=<?php echo I("get.tem");?>'
                $('#projectOrder').data('orderinfo',JSON.stringify(this.orderinfo));
                $('.ftc_wzsf').show();
                 // $('.mubu').show();
                // $('.passwordAlert').hide();
                $('#key').show();
                $('.sltPayClass').hide();
            },
            pay:function(event){
              var $this = (event.target)? $(event.target):$(event.srcElement);
              $.get("<?php echo U('ajaxControl');?>",{flag:'createAdvance',id:$this.attr('data-orderid')},function (result) {
                if(!result){
                  alert('因库存不足或订单关闭原因, 交易已关闭');
                }else if(result == 2){
                  alert('请设置好收货地址');
                }else{
                  showPay(result, $this.attr('orderID'));
                }
              })
            },
            cancelOrder:function(event){
                $('.cancelOrderAlert').show();
                var _this=(event.target)? $(event.target):$(event.srcElement),
                  orderID=_this.attr('data-orderID').trim();
                $('.cancelOrderAlert .optionCard li  .roundChoose input').on('click',function(){
                  var $this=$(this);
                    checkedStatus=$this.is(":checked");
                    hasOther=$this.parents('li').hasClass('other'),
                    otherArea= $('.cancelOrderAlert .otherArea').children('textarea'),
                    cancel_remark='';

                    if(hasOther){
                      otherArea.show();
                    }else{
                      otherArea.hide();
                    }
                    $('.cancelOrderAlert .determine').on('click',function(){
                      if(hasOther){
                        cancel_remark=otherArea.val();
                      }else{
                        cancel_remark=$this.val();
                      }
                      if(cancel_remark.length==0){Alert('请选择或者填写取消订单理由'); return false; }
                      $.ajax({
                        type:"GET",
                        url:'<?php echo U("OrderForm/ajaxControl");?>',
                        data:{
                          flag:'orderCancel',
                          id:orderID,
                          cancel_remark:cancel_remark,
                          companyName:"<?php echo ($_GET['companyName']); ?>"
                          },
                        dataType:'json',
                        success:function(data){
                          if(data){
                            oTip('操作成功')
                            window.location.reload();
                          }else{
                            oTip('操作失败')
                            window.location.reload();
                          }
                          window.location.reload();
                        },
                        error:function(error){
                          console.log(error);
                           oTip('操作失败!')
                        }
                      })
                      $('.cancelOrderAlert').hide();
                    })
                  
                })
              
            },
            extendTimeGoods:function(id){
            Confirm("最长可延迟收货时间7天，你确定要延长吗？",function(res){
              if(res){
                $.ajax({
                  type:"GET",
                  url:"<?php echo U('OrderForm/ajaxControl');?>",
                  data:{
                    flag:"extend_the_receiving",
                    id:id
                  },
                  dataType:"json",
                  success:function(data){
                    if(data.status){
                      Alert('延长收货成功！');
                    }else{
                      if(data.err_code==2){
                        Alert('物流未送达，不需要延迟收货');
                      }
                    }
                  },
                  error:function(error){
                    console.log(error);
                    oTip("操作失败");
                  }
                });  
              }
            })
              
            },
            alertClose:function(){
              console.log("sad");
              $('.bsAlert').hide();
            },
            closeCover:function(){
              $('.sltPayClass').hide();
            }
          }
         
        });
        app.$on('affirmGoods',function(event){
          app.$methods.affirmGoods(event);
        })
        app.$on('cancelOrder',function(event){
          app.$methods.cancelOrder(event);
        })
        app.$on('pay',function(event){
          app.$methods.pay(event);
        })
        app.$on('returnMoney',function(event){
          app.$methods.returnMoney(event);
        })
         app.$on('sltPay',function(event){
          console.log(event);
          console.log(app.$methods);
          app.sltPay(event);
        })

        $("#lookMore").on('click',function(){
          var $this=$(this);
          $.ajax({
            type:"GET",
            url:"<?php echo U('OrderForm/ajaxControl');?>",
            data:{
              show:"<?php echo ($_GET['show']); ?>",
              companyName:"<?php echo ($_GET['companyName']); ?>",
              p:app.clickTotal,
              flag:'orderList'
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
        // $('.cancel').on('click',function(){
        //   $('.bsAlert ').hide();
        // })
      })();
      $('.alertClose,.cancel').on('click',function(){
        $('.bsAlert').hide();
      })
    })
  </script>

</body>
</html>