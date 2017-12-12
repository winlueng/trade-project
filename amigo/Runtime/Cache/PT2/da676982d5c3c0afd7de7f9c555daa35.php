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
<link href="/Public/JS/module/ladingPasswordConfirm/passwordkeyboard.css" rel="stylesheet" type="text/css" ></link>
  <style>
     .dl_goods-list img{
      height:85px;
     }
  </style>
  <?php  ?>

</head>
<body>

  <header id="Header" class="kb_header flexLayout-center ">
    <nav>
      
        <a href="javascript:;" onclick="javascript:history.go(-1)" class="icon-back w"></a>
      
    </nav>
    <h2 class="kb_header-title">
    
订单详情

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


  <section id="Main" class="kb_main bc "  data-orderID="<?php echo ($info["id"]); ?>">
    <?php if(($info['pay_status'] == 0) AND ($info['status'] == 0)): ?><a href="javascript:void(0);" class="kb_list-cell  kb_cell-href kb_list-cell_big mb10">
      <?php if(((($info['create_time']+172800)-time()) > 0)): ?><div class="kb_list-cell-hd">
          <img src="/Public/trading/images/tr-Order.png" alt="" />
        </div>
        <aside class="kb_list-cell-bd">
          <h2 class="kb_list-cell-title">等待买家付款</h2>
          <p class="kb_list-cell-brief"><?php echo turnDistanceTime(($info['create_time']+172800));?>后自动关闭订单</p>
        </aside>
      <?php else: ?>
          <div class="kb_list-cell-hd">
            <img src="/Public/trading/images/tr-Order.png" alt="" />
          </div>
          <aside class="kb_list-cell-bd">
            <h2 class="kb_list-cell-title">订单超时已关闭</h2>
          </aside><?php endif; ?>
    </a><?php endif; ?>
      <?php switch($info["status"]): case "1": ?><article class="kb_list-cell kb_cell-href kb_list-cell_big mb10">
          <div class="kb_list-cell-hd">
            <img src="/Public/trading/images/tr-Order.png" alt="" />
          </div>
          <aside class="kb_list-cell-bd">
            <h2 class="kb_list-cell-title">订单已取消</h2>
          </aside>
        </article><?php break;?>
         <?php case "2": if(($info['is_send_out'] == 1) AND ($info['status'] == 2)): ?><a href="javascript:void(0);" class="kb_list-cell  kb_cell-href kb_list-cell_big mb10">
                  <div class="kb_list-cell-hd">
                    <img src="/Public/trading/images/tr-Order.png" alt="" />
                  </div>
                  <aside class="kb_list-cell-bd">
                    <h2 class="kb_list-cell-title">待确认收货</h2>
                  </aside>
                </a><?php endif; ?>
              <?php if(($info['is_send_out'] == 0) AND ($info['status'] == 2)): ?><a href="javascript:void(0);" class="kb_list-cell  kb_cell-href kb_list-cell_big mb10">
                  <div class="kb_list-cell-hd">
                    <img src="/Public/trading/images/tr-Order.png" alt="" />
                  </div>
                  <aside class="kb_list-cell-bd">
                    <h2 class="kb_list-cell-title">等待买家发货</h2>
                  </aside>
              </a><?php endif; ?>

              <?php if(($info['is_send_out'] == 2) AND ($info['status'] == 2)): ?><a href="<?php echo U('Express/showExpressInfo');?>?id=<?php echo ($info['id']); ?>" class="kb_list-cell  kb_cell-href kb_list-cell_big mb10">
                    <div class="kb_list-cell-hd">
                      <img src="/Public/trading/images/tr-Order.png" alt="" />
                    </div>
                    <aside class="kb_list-cell-bd">
                      <h2 class="kb_list-cell-title">物流已签收</h2>
                    </aside>
                </a><?php endif; break;?>
        <?php case "3": ?><article class="kb_list-cell kb_cell-href kb_list-cell_big mb10">
            <div class="kb_list-cell-hd">
              <img src="/Public/trading/images/tr-Order.png" alt="" />
            </div>
            <aside class="kb_list-cell-bd">
              <h2 class="kb_list-cell-title">交易已关闭</h2>
            </aside>
            <!-- <p>您已确认收货，写下你对产品的评价吧</p> -->
           <article class="kb_list-cell kb_cell-href kb_list-cell_big mb10"><?php break;?>
        <?php case "4": ?><!--  <div class="kb_list-cell-hd">
              <img src="/Public/trading/images/tr-Order.png" alt="" />
            </div>
            <aside class="kb_list-cell-bd">
              <h2 class="kb_list-cell-title">交易已完成</h2>
            </aside> -->
            <!-- <p>您已确认收货，写下你对产品的评价吧</p> -->
          
          <!--   <div class="kb_list-cell-hd">
              <img src="/Public/trading/images/tr-Order.png" alt="" />
            </div>
            <aside class="kb_list-cell-bd">
              <h2 class="kb_list-cell-title">
                物流详情
              </h2>
              <p class="kb_list-cell-brief">
                <?php echo ($info['express']['expressLast']['AcceptStation']); ?>
              </p>
            </aside> --><?php break;?>
        <?php case "5": ?><article class="kb_list-cell kb_cell-href kb_list-cell_big mb10">
          <div class="kb_list-cell-hd">
            <img src="/Public/trading/images/tr-Order.png" alt="" />
          </div>
          <aside class="kb_list-cell-bd">
            <h2 class="kb_list-cell-title">申请退款中</h2>
            <p class="kb_list-cell-brief">我们会在3至5天内回复您的订单，请耐心等待</p>
          </aside>
          </article><?php break;?>
        <?php case "6": ?><article class="kb_list-cell kb_cell-href kb_list-cell_big mb10">
          <div class="kb_list-cell-hd">
            <img src="/Public/trading/images/tr-Order.png" alt="" />
          </div>
          <aside class="kb_list-cell-bd">
            <h2 class="kb_list-cell-title">退款已处理</h2>
          </aside>
          </article><?php break;?>
        <?php case "7": ?><article class="kb_list-cell kb_cell-href kb_list-cell_big mb10">
          <div class="kb_list-cell-hd">
            <img src="/Public/trading/images/tr-Order.png" alt="" />
          </div>
          <aside class="kb_list-cell-bd">
            <h2 class="kb_list-cell-title">退款被拒绝</h2>
          </aside>
        </article><?php break; endswitch;?>
    <a href="javascript:void(0)" class="kb_list-cell  kb_cell-href kb_list-cell_big mb10">
      <div class="kb_list-cell-hd">
          <img src="/Public/trading/images/tr-position.png" alt="" />
      </div>
      <aside class="kb_list-cell-bd">
        <h2 class="kb_list-cell-title"><?php echo ($address["consignee"]); ?></h2>
        <p class="kb_list-cell-brief"><?php echo ($address["phone"]); ?></p>
      </aside>
      <footer class="kb_cell-ft">

      </footer>
    </a>
     <?php if($info['is_send_out'] != 0): if(in_array(($info["status"]), explode(',',"2,4,5,6,7"))): ?><a href="<?php echo U('Express/showExpressInfo');?>?id=<?php echo ($info['id']); ?>" class="kb_list-cell  kb_cell-href kb_list-cell_big mb10">
          <div class="kb_list-cell-hd">
            <img src="/Public/trading/images/tr-Logistics.png" alt="" />
          </div>
          <aside class="kb_list-cell-bd">
            <h2 class="kb_list-cell-title">物流详情</h2>
             <p class="kb_list-cell-brief"><?php echo ($info['express']['expressLast']['AcceptStation']?$info['express']['expressLast']['AcceptStation']:'暂无物流信息'); ?></p>
          </aside>
        </a><?php endif; endif; ?>
    <ul class="kb_list">
          <?php if($info['company_id']): ?><a class="kb_list-cell kb_list-cell_small kb_cell-href" href="<?php echo ($info['company_link']); ?>">
          <?php else: ?>
            <a class="kb_list-cell kb_list-cell_small kb_cell-href" href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>"><?php endif; ?>
        <div class="kb_list-cell-hd ">
          <img src="/Public/trading/images/tr-shop.png" alt="" />
        </div>
          <aside class="kb_list-cell-bd">
          <?php if($info['company_id']): ?><h2 class="kb_list-cell-title"><?php echo ($info['company_name']); ?></h2>
          <?php else: ?>
            <h2 class="kb_list-cell-title"><?php echo ($pInfo['market_name']); ?></h2><?php endif; ?>
        </aside>
        <p class="kb_cell-ft">
        </p>
      </a>
      <?php if(is_array($info["goods_data"])): $i = 0; $__LIST__ = $info["goods_data"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li class="kb_list-cells">
         <a href="<?php echo ($v["link"]); ?>" class="kb_list-cell dl_goods-list">  
            <div class="kb_list-cell-hd">
                <img src="/Public<?php echo ($v["attrInfo"]["attr_pic"]); ?>" alt="" />
            </div>
            <aside class="kb_list-cell-bd">
                <h2 class="kb_list-cell-title mb10"><?php echo ($v["goods_name"]); ?></h2>
                <div class="kb_list-cell-brief">
                    <p class="tg_ft-default mb10">
                        <?php echo ($v["attrInfo"]["attr_name"]); ?>：<?php echo ($v["attrInfo"]["attr_val"]); ?>
                    </p>
                    <p class="tg_ft-price mb10">
                        <b class="f14 mr10">￥<?php echo ($v["price"]); ?></b>
                         <em class="fr tg_ft-default">x<?php echo ($v["total"]); ?></em>
                    </p>
                    <p class="dl_bugShoping">
                    </p>
                </div>
            </aside>
         </a>
      </li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
    <article class="kb_cell">
      <p class="kb_cell-hd">
        <label class="kb_label">留言</label>
      </p>
      <p class="kb_cell-bd">
        <input type="number" placeholder="<?php echo ($info["visitor_remark"]); ?>" disabled class="kb_input tr  w" />
      </p>
    </article>
    <article  class="kb_cell">
      <p class="kb_cell-bd">
        运费
      </p>
      <p class="kb_cell-ft">
        <?php if(info.express_price): ?><em class="briefColor">￥<?php echo ($info["express_price"]); ?></em>
        <?php else: ?>
          <em class="briefColor">免邮</em><?php endif; ?>
      </p>
    </article>
     <article  class="kb_cell">
      <p class="kb_cell-bd">
        商品总价
      </p>
      <p class="kb_cell-ft">
        <em class="briefColor">￥<?php echo ($info["total"]); ?></em>
      </p>
    </article>
    <article  class="kb_cell">
      <p class="kb_cell-bd">
       
      </p>
      <p class="kb_cell-ft">
        <em class="mr10">共<?php echo ($info["piece"]); ?>件</em>
        合计：<em class="tg_ft-price">￥<?php echo ($info['total'] + $info['express_price']); ?></em>
      </p>
    </article>
    <article class="main_bg mt10 p10">
      <p class="mb10">订单编号：<?php echo ($info["order_number"]); ?></p>
      <p>下单时间：<?php echo date('Y-m-d H:i:s', $info['create_time']);?></p>
    </article>
  </section>


  <footer id="Footer" class="kb_footer ">
    <div class="dl_orderOptraing tg_cell h" data-orderID="<?php echo ($info["id"]); ?>" >

      <?php switch($info["status"]): case "0": if(((($info['create_time']+172800)-time()) > 0)): ?><p class="dl_orderOptraing-bd ">
            <input type="button" value="取消订单" class="kb_btn  tg_btn-default w cancelOrder" />
          </p>
          <p class="dl_orderOptraing-bd">
            <input type="button" value="立即支付" data-isPassword="" class="kb_btn kb_btn-main w mark-paying" />
          </p><?php endif; break;?>
      <?php case "2": if($info['is_send_out'] == '0'): ?><p class="dl_orderOptraing-bd ">
            <input type="button" value="退款" class="kb_btn returnMoney tg_btn-default w" />
          </p>
        <?php elseif($info['is_send_out'] == '1'): ?>
          <p class="dl_orderOptraing-bd ">
            <input type="button" value="退款" class="kb_btn returnMoney tg_btn-default w" />
          </p>
          <p class="dl_orderOptraing-bd">
            <input type="button" value="确认收货" class="kb_btn affirmGoods kb_btn-main w" />
          </p>

        <?php elseif($info['is_send_out'] == '2'): ?>

          <p class="dl_orderOptraing-bd ">
            <input type="button" value="申请售后" class="kb_btn returnMoney tg_btn-default w" />
          </p>
          <p class="dl_orderOptraing-bd">
            <a class="kb_btn kb_btn-main w" href="<?php echo U('GoodsComment/commentIns');?>?id=<?php echo ($info['id']); ?>">去评价</a>
          </p><?php endif; break; endswitch;?>
     </div>
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
  

<!-- 自定义支付 -->
<div class="ftc_wzsf"  data-name='<?php echo I($get["companyName"]);?>'>
<div class="srzfmm_box">
  <div class="qsrzfmm_bt clear_wl"> <img src="/Public/images/xx_03.jpg" class="tx close fr" > <p class="fl">请输入支付密码</p> </div>
  <div class="zfmmxx_shop">
    <div class="wxzf_price">￥<?php echo ($info['total'] + $info['express_price']); ?>元</div>
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

      <input type="hidden" id="projectOrder" data-orderinfo='{"id":"<?php echo ($info["id"]); ?>","url":"<?php echo U("OrderForm/ajaxControl");?>","success":"http://<?php echo ($_SERVER["HTTP_HOST"]); echo U("OrderForm/payed");?>?project_order=<?php echo ($info["order_number"]); ?>","paypaw":"<?php echo U("WasteBook/setPayPassWord");?>","flag":"balance_to_buy"}' />
  </div>
</div>
<div id="keyboardDIV"></div>
</div>
<div class="sltPayClass">
  <div class="dl_cover"></div>
  <div class="kb_list-cell kb_list-cell_small kb_cell-href">
    <aside class="kb_list-cell-bd">
        <h2 class="">选择付款方式</h2>
    </aside>
    <p class="kb_cell-ft">
    </p>
  </div>
  <article class="kb_cell kb_cell-check  ">
    <p class="kb_cell-hd mr10">
      <img src="/Public/trading/images/tr-WeChat-payment.png" alt="" class="w30 h30" />
    </p>
    <p class="kb_cell-bd">
      <h2 class="kb_list-cell-title tl w">微信支付
      </h2>
    </p>
    <p class="kb_cell-ft kb_choose">
      <input type="radio" name="rd1" value="" id="pay"  />
      <span class=" kb_choose-check">
        <b class="kb_choose-check-default kb_choose-check_default"></b>
      </span>
    </p>
  </article>
  <article class="kb_cell kb_cell-check <?php echo ($info['id'] ? '' : 'is-disabeld'); ?>">
    <p class="kb_cell-hd mr10">
      <img src="/Public/trading/images/tr-Wallet-to-pay.png" alt="" class="w30 h30" />
    </p>
    <div class="kb_cell-bd">
      <h2 class="kb_list-cell-title">钱包
      </h2>
      <p class="kb_list-cell-brief"><?php echo ($userInfo['wallet']); ?>密条</p>
    </div>
    <p class="kb_cell-ft kb_choose">
      <input type="radio" name="rd1" value="" data-isPassword="<?php echo ($userInfo['pay_pass_word'] ?'1':'0'); ?>"  class="mark-walletpay"  <?php echo ($info['id'] ? '' : 'disabled'); ?> />
      <span class=" kb_choose-check">
        <b class="kb_choose-check-default kb_choose-check_default"></b>
      </span>
    </p>
  </article>
</div>
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
  <script src="/Public/JS/module/ladingPasswordConfirm/ladingPasswordConfirm.js"></script>
<script>
window.onload=function(){
  $('.dl_cover').on('click',function(){
    $('.sltPayClass').hide();
  })
 $('.mark-paying').on('click',function(){
    $('.sltPayClass').show();
  });
 $('.mark-walletpay').on('click',function(){
    var $this,status;
    $this=$(this);
    status=$this.attr('data-isPassword').trim();
    if(status==0){
      Alert('还未设置钱包支付密码，需要前往设置密码',function(){
        window.location.href="<?php echo U('WasteBook/setPayPassWord');?>";
      })
      return false;
    }
    $('.ftc_wzsf').show();
     // $('.mubu').show();
    // $('.passwordAlert').hide();
    $('#key').show();
    $('.sltPayClass').hide();
 });

}
$(function(){
      $('.refund').on('click',function(){
        $('.Popout').slideDown();
      })

      $('#pay').on('click',function(){
        var $this = $(this);
        $.get("<?php echo U('ajaxControl');?>",{
          flag:'createAdvance',
          id:'<?php echo I("get.id");?>',
          companyName:'<?php echo ($_GET["companyName"]); ?>'
        },function (result) {
          if(!result){
            Alert('因库存不足或订单关闭原因, 交易已关闭');
          }else if(result == 2){
            Alert('请设置好收货地址');
          }else{
            showPay(result);
          }
        })
      });


      // 订单退款
      $('.returnMoney').on('click',function(){
        /*var url = "<?php echo U('orderForm/orderApplicationForDrawback', ['companyName' => $_GET['companyName'], 'id' => $info['id']]);?>";
        $('.returnMoneyAlert form').attr('action', url);
        */
        $('.returnMoneyAlert').show();
        var _this=$(this),
          orderID=_this.parents('[data-orderID]').attr('data-orderID').trim();
        $('.returnMoneyAlert .optionCard li  .roundChoose input').on('click',function(){
          var $this=$(this);
            checkedStatus=$this.is(":checked");
            hasOther=$this.parents('li').hasClass('other'),
            otherArea= $('.returnMoneyAlert .otherArea').children('textarea'),
            drawback_remark='';
            console.debug(hasOther);
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
                dataType:'json',
                success:function(data){
                   if(data){
                  oTip('操作成功')
                }else{
                  oTip('操作失败')
                }
                },
                error:function(data){
                   oTip('操作失败!')
                  console.log(data);
                }
              })
              $('.returnMoneyAlert').hide();
              window.location.reload();
            })
        })
      });

      /*确认收货*/
      $('.affirmGoods').on('click',function(){
        var $this=$(this),
          orderID=$this.parents('[data-orderID]').attr('data-orderID').trim();
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
              dataType:'json',
              success:function(data){
              if(data){
                oTip('操作成功')
              }else{
                oTip('操作失败')
              }
              window.location.reload();
              },
              error:function(data){
                 oTip('操作失败!')
                console.log(data);
              }
            });
          }
        })
      });

      // 取消订单
      $('.cancelOrder').on('click',function(){
        $('.cancelOrderAlert').show();
        var _this=$(this),
          orderID=_this.parents('[data-orderID]').attr('data-orderID').trim();
        $('.cancelOrderAlert .optionCard li  .roundChoose input').on('click',function(){
          var $this=$(this);
            checkedStatus=$this.is(":checked");
            hasOther=$this.parents('li').hasClass('other'),
            otherArea= $this.parents('p').siblings('.otherArea').children('textarea'),
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
                }else{
                  oTip('操作失败')
                }
                },
                error:function(data){
                   oTip('操作失败!')
                  console.log(data);
                }
              });
              $('.cancelOrderAlert').hide();
              window.location.reload();
            })
        })
      });
      $('.alertClose,.cancel').on('click',function(){
        $('.bsAlert').hide();
      })
    });


    function onBridgeReady(info){

      var data = JSON.parse(info);

        WeixinJSBridge.invoke(
           'getBrandWCPayRequest', {
              "appId":data.appId,
              "timeStamp":data.timeStamp,
              "nonceStr":data.nonceStr,
              "package":data.package,
              "signType":data.signType,
              "paySign":data.paySign
            },function(res){     
                if(res.err_msg == "get_brand_wcpay_request:ok" ) {// 支付成功走这
                  WeixinJSBridge.log(res.err_msg);
                  $.get("<?php echo U('ajaxControl');?>",{flag:'selOrderStatus',id:'<?php echo I("get.id");?>'},function (result) {
                        if(result){
                          window.location.href='http://<?php echo ($_SERVER["HTTP_HOST"]); echo U("OrderForm/payed");?>?order_id=<?php echo I("get.id");?>';
                        }else{
                          alert('订单支付失败!');
                        }
                    });
                }else{
                  // alert(1);
                  window.location.href='http://<?php echo ($_SERVER["HTTP_HOST"]); echo U("OrderForm/orderList");?>?show=1';
                } 
            }
       ); 
    }

    function showPay(pay){
      if (typeof WeixinJSBridge == "undefined"){
         if( document.addEventListener ){
             document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
         }else if (document.attachEvent){
             document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
             document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
         }
      }else{
        // console.log(pay)
          onBridgeReady(pay);
      }
    }
</script>

</body>
</html>