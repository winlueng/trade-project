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
    
<link href="/Public/JS/module/ladingPasswordConfirm/passwordkeyboard.css" rel="stylesheet" type="text/css" ></link>
  <style>
     .goods_list img{
      height: 85px;
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
    
  确认交易

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


  <section id="Main" class="kb_main bc ">
    <a href="<?php echo U('VisitorAddress/orderAddress');?>?project_order=<?php echo ($list['project_order']); ?>&companyName=<?php echo I('get.companyName');?>&tem=<?php echo I('get.tem');?>&com=<?php echo I('get.com');?>&c_com=<?php echo I('get.c_com');?>&gid=<?php echo I('get.gid');?>" id="visitor_address" class="kb_list-cell  kb_cell-href kb_list-cell_big mb10">
    </a>
    <?php if(is_array($list["orderInfo"])): $i = 0; $__LIST__ = $list["orderInfo"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><ul class="kb_list ">
      <?php if(!$v['company_id']): ?><a class="kb_list-cell kb_list-cell_small kb_cell-href" href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>">
          <div class="kb_list-cell-hd ">
            <img src="/Public/trading/images/tr-shop.png" alt="" />
          </div>
            <aside class="kb_list-cell-bd">
              <h2 class="kb_list-cell-title"><?php echo ($pInfo['market_name']); ?></h2>
          </aside>
          <p class="kb_cell-ft">
          </p>
        </a>
      <?php else: ?>
        <a class="kb_list-cell kb_list-cell_small kb_cell-href" href="http://<?php echo ($v["company_link"]); ?>">
          <div class="kb_list-cell-hd ">
            <img src="/Public/trading/images/tr-shop.png" alt="" />
          </div>
            <aside class="kb_list-cell-bd">
              <h2 class="kb_list-cell-title"><?php echo ($v["company_name"]); ?></h2>
          </aside>
          <p class="kb_cell-ft">
          </p>
        </a><?php endif; ?>
      <?php if(is_array($v["goods_data"])): $i = 0; $__LIST__ = $v["goods_data"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="kb_list-cells">
           <a href="<?php echo ($vo["link"]); ?>" class="kb_list-cell goods_list">
              <div class="kb_list-cell-hd">
                  <img src="/Public<?php echo ($vo["attrInfo"]["attr_pic"]); ?>" alt="" />
              </div>
              <aside class="kb_list-cell-bd">
                  <h2 class="kb_list-cell-title mb10"><?php echo ($vo["goods_name"]); ?></h2>
                  <div class="kb_list-cell-brief">
                      <p class="tg_ft-default mb10">
                          <?php echo ($vo["attrInfo"]["attr_name"]); ?>: &nbsp;<?php echo ($vo["attrInfo"]["attr_val"]); ?>
                      </p>
                      <p class="tg_ft-price mb10">
                          <b class="f14 mr10">￥<?php echo ($vo["price"]); ?></b>
                           <em class="fr tg_ft-default">x<?php echo ($vo["total"]); ?></em>
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
        <label class="kb_label">留言备注</label>
      </p>
      <p class="kb_cell-bd">
        <input type="text" name="visitor_remark[]" placeholder="请输入您的留言" class="kb_input tr  w" />
      </p>
    </article>
    <article  class="kb_cell">
      <p class="kb_cell-bd">
        配送方式
      </p>
      <p class="kb_cell-ft">
        <em class="briefColor">快递</em>
        <?php if($v['express_price']): ?><em class="tg_ft-yellow">￥<?php echo ($v['express_price']); ?></em>
        <?php else: ?>
        <em class="tg_ft-yellow">免邮</em><?php endif; ?>
      </p>
    </article>

    <article  class="kb_cell">
      <p class="kb_cell-bd">
      </p>
      <p class="kb_cell-ft">
        <em class="mr10">共<?php echo ($v['piece']); ?>件</em>
        应付总额：<em class="tg_ft-price">￥<?php echo array_sum($v['total']);?></em>
      </p>
    </article><?php endforeach; endif; else: echo "" ;endif; ?>
  </section>


  <footer id="Footer" class="kb_footer ">
    <div  class="tg_cell h50 main_bg dl_orderSub">
      <article class="tg_cell-hd  h f14">
        合计：<em class="tg_ft-price">￥<?php echo ($list['express_price'] + $list['order_total']); ?></em>
      </article>
      <p class="tg_cell-bd h flexLayout-center">
        <button type="button" class="kb_btn kb_btn-main  tg_cell-bd h mark-orderSub">提交订单</button>
      </p>
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
  

<div class="sltPayClass">
  <div class="dl_cover"></div>
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
      <input type="radio" name="rd1" id="weixin" value=""  />
      <span class=" kb_choose-check">
        <b class="kb_choose-check-default kb_choose-check_default"></b>
      </span>
    </p>
  </article>
  <article class="kb_cell kb_cell-check <?php echo ($list['project_order'] ? '' : 'is-disabeld'); ?> ">
    <p class="kb_cell-hd mr10">
      <img src="/Public/trading/images/tr-Wallet-to-pay.png" alt="" class="w30 h30" />
    </p>
    <div class="kb_cell-bd">
      <h2 class="kb_list-cell-title">钱包
      </h2>
      <p class="kb_list-cell-brief"><?php echo ($userInfo['wallet']); ?>密条</p>
    </div>
    <p class="kb_cell-ft kb_choose">
      <input type="radio" name="rd1"  value="" data-isPassword="<?php echo ($userInfo['pay_pass_word'] ?'1':'0'); ?>"  class="mark-selfwallet" <?php echo ($list['project_order'] ? '' : 'disabled'); ?>  />
      <span class=" kb_choose-check">
        <b class="kb_choose-check-default kb_choose-check_default"></b>
      </span>
    </p>
  </article>
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
      <input type="hidden" id="projectOrder" data-orderinfo='{"orderNum":"<?php echo ($list["project_order"]); ?>","url":"<?php echo U("OrderForm/ajaxControl");?>","success":"http://<?php echo ($_SERVER["HTTP_HOST"]); echo U("OrderForm/payed");?>?project_order=<?php echo ($list["project_order"]); ?>&companyName=<?php echo I("get.companyName");?>","paypaw":"http://<?php echo ($_SERVER["HTTP_HOST"]); echo U("WasteBook/setPayPassWord");?>?companyName=<?php echo I("get.companyName");?>&tem=<?php echo I("get.tem");?>","flag":"balance_to_buy"}' />
  </div>
</div>
<div id="keyboardDIV"></div>
</div>
<script src="/Public/JS/module/ladingPasswordConfirm/ladingPasswordConfirm.js"></script>
<script>

window.onload=function(){
  $('.dl_cover').on('click',function(){
    $('.sltPayClass').hide();
  });

  var is_exist;
  $.get("<?php echo U('VisitorAddress/ajaxControl');?>",{flag:'get_order_pay_address'},function(res){
    $.get("<?php echo U('VisitorAddress/ajaxControl');?>",{flag:'sel_default_address',addr_id:res},function(res){
        if (res) {
          var str = '<div class="kb_list-cell-hd">'
                    +'<img src="/Public/trading/images/tr-position.png" alt="" />'
                    +'</div>'
                    +'<aside class="kb_list-cell-bd">'
                    +'<p class="f14 mb10">'+res.consignee+'<b class="ml20">'+res.phone+'</b></p>'
                    +'<p class="kb_list-cell-brief">'+ res.address_str +'</p>'
                    +'</aside>'
                    +'<footer class="kb_cell-ft"></footer>';
        }else{
          var str = '<div class="kb_list-cell-hd">'
                    +'<img src="/Public/trading/images/tr-position.png" alt="" />'
                    +'</div>'
                    +'<aside class="kb_list-cell-bd">'
                    +'<h2 class="kb_list-cell-title">请前往设置收货地址</h2>'
                    +'<p class="kb_list-cell-brief">收货地址未设置</p>'
                    +'</aside>'
                    +'<footer class="kb_cell-ft"></footer>';
        }
        is_exist = res;
        $('#visitor_address').html(str);
    });
  });


  $('.mark-orderSub').on('click',function(){
    if (!is_exist) {
        alert('请先前往添加收货地址');
    }else{
      $('.sltPayClass').show();
    }
  });

  $('#weixin').on('click',function(){
    var $this = $(this),
        remark=new Array();
        remark.push($('input[name="visitor_remark[]"]').val());

    $.get("<?php echo U('ajaxControl');?>",{flag:'createAdvance',project_order:'<?php echo ($list["project_order"]); ?>', visitor_remark:remark},function (result) {
          console.log(result);
          onBridgeReady(result)
        /*if(!result){
          alert('生成订单失败');
        }else{
          showPay(result);
        }*/
    })
  });
  $('.mark-selfwallet').on('click',function(){
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
  })
}

    function onBridgeReady(info){
      var data = JSON.parse(info);
      console.log(data);
      WeixinJSBridge.invoke(
        'getBrandWCPayRequest',{
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
              $.get("<?php echo U('ajaxControl');?>",{flag:'selOrderStatus',project_order:'<?php echo ($list["project_order"]); ?>'},function (result) {
                    if(result){
                      window.location.href='http://<?php echo ($_SERVER["HTTP_HOST"]); echo U("OrderForm/payed");?>?project_order=<?php echo ($list["project_order"]); ?>&companyName=<?php echo I("get.companyName");?>';
                    }else{
                      alert('订单支付失败!');
                    }
                });
            }else{
              // alert(1);
              window.location.href='http://<?php echo ($_SERVER["HTTP_HOST"]); echo U("OrderForm/orderList");?>?show=1&companyName=<?php echo I("get.companyName");?>&tem=<?php echo I("get.tem");?>';
            }

            // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回ok，但并不保证它绝对可靠。
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