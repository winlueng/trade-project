<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,maximum-scale=1,minimum-scale=1,user-scalable=0">
    <title>阿密购商城</title>
    <link rel="shortcut icon" href="/Public/trading/images/favicon.ico">
<link rel="stylesheet" href="/Public/CSS/mbase.css" />
<link rel="stylesheet" href="/Public/trading/style/trading.css" />
<link rel="stylesheet" href="/Public/trading/script/swiper/swiper.min.css" />
<script src="/Public/trading/script/zepto.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    
<link href="/Public/trading/style/temporarily.css" rel="stylesheet"></link>
  <style>
    .kb_list-cell img{
      height: 86px;
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
    
退款订单

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
   <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><ul class="kb_list mt10">
          <?php if($v['company_id']): ?><a class="kb_list-title kb_list-cell kb_list-cell_small kb_cell-href" href="http://<?php echo ($v["company_link"]); ?>">
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
      <?php if(is_array($v["goods_data"])): $i = 0; $__LIST__ = $v["goods_data"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('OrderForm/orderDetail');?>?id=<?php echo ($v["id"]); ?>" class="kb_list-cell">  
            <div class="kb_list-cell-hd">
                <img src="/Public<?php echo ($vo["attrInfo"]["attr_pic"]); ?>" alt="" />
            </div>
            <aside class="kb_list-cell-bd">
                <h2 class="kb_list-cell-title mb10"><?php echo ($vo["goods_name"]); ?> 
                <time class="kb_list-cell-title-time">
                <?php switch($v["status"]): case "5": ?>待处理<?php break;?>
                  <?php case "6": ?>已处理<?php break;?>
                  <?php case "7": ?>已拒绝<?php break; endswitch;?>
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
         <p class="tr p10 fb">共<?php echo ($v["piece"]); ?>件&nbsp;&nbsp;实付金额：<em class="tg_ft-price"><?php echo ($v['total'] + $v['express_price']); ?></em></p>
         <div class="dl_orderOptraing tg_cell pb10">

          <?php switch($v["status"]): case "0": if(($v['pay_status'] == 0)): if(((($v['create_time']+172800)-time()) > 0)): ?><p class="dl_orderOptraing-bd">
                      <input type="button" value="取消订单" data-orderID="<?php echo ($v["id"]); ?>" class="kb_btn  tg_btn-default w" @click="cancelOrder" />
                    </p>
                    <p class="dl_orderOptraing-bd">
                      <input type="button" value="支付" orderID="<?php echo ($v["id"]); ?>" v-on:click="pay" class="kb_btn kb_btn-main w" />
                    </p><?php endif; endif; break;?>
              <?php case "2": switch($v["is_send_out"]): case "0": ?><p class="dl_orderOptraing-bd">
                        <input type="button" value="申请退款" orderID="<?php echo ($v["id"]); ?>" v-on:click="returnMoney" class="kb_btn  tg_btn-default w" />
                      </p>
                      <p class="dl_orderOptraing-bd">
                        <input type="button" value="提醒发货" class="kb_btn kb_btn-main w" />
                      </p><?php break;?>
                  <?php case "1": ?><!-- <a class="defineBtn  mr10  btnColorFFF" href="<?php echo U('Express/showExpressInfo', ['companyName' => $_GET['companyName'], 'id' => $v['id']]);?>" >&nbsp;&nbsp;查看物流</a> -->
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
                    <a type="button" href="<?php echo U('GoodsComment/commentIns');?>?id=<?php echo ($v['id']); ?>" class="kb_btn  tg_btn-default w" >去评价</a>
                  </p><?php endif; break; endswitch;?>
         </div>
      </li>
        
    </ul><?php endforeach; endif; else: echo "" ;endif; ?>
    <?php if(($list) AND (count($list) > 5)): ?><li is="myTemlate"  v-bind:Phrase="indexs" v-for="indexs in info" >
            </li>
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
  

  <script id="orderListTem" type="text/x-handlebars-template">
    <ul class="kb_list mt10">
      <a v-bind:href="Phrase.company_id>0?'http://'+Phrase.company_link:'http://<?php echo ($_SERVER['HTTP_HOST']); ?>'" class="kb_list-title kb_list-cell kb_list-cell_small kb_cell-href">
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
                
                <time class="kb_list-cell-title-time" >
                 {{Phrase.refund_remark}}  
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
                          window.location.href='http://<?php echo ($_SERVER["HTTP_HOST"]); echo U("OrderForm/payed");?>?order_id='+id;
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
                case 'refundListDetail':
                  return "<?php echo U('refundListDetail', ['companyName' => $_GET['companyName']]);?>?id="+ID+"&refund=1";
                break;
                case 'orderDetail':
                  return "<?php echo U('orderDetail', ['companyName' => $_GET['companyName']]);?>?id="+ID;
                break;
              
              }
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
            clickTotal:2
          },
          computed:{
            
          },
          methods:{

          }

        })
        $("#lookMore").on('click',function(){
          var $this=$(this);
          $.get("<?php echo U('ajaxControl');?>",{
            show:"<?php echo ($_GET['show']); ?>",
            companyName:"<?php echo ($_GET['companyName']); ?>",
            p:app.clickTotal,
            flag:'orderList'
          },function(res){
            console.log(res);
            if(res){
              app.info=app.info.concat(res);
              app.clickTotal+=1;
              console.log(app.info);
            }else{
              $this.hide();
              oTip("没有更多了")
            }
          })
        })
      })();
      $('.addShopCarBtn').on('click',function(){
        $('.Popout').slideDown();
      });
      
      $('.pay').on('click',function(){
        var $this = $(this);
        $.get("<?php echo U('ajaxControl');?>",{flag:'createAdvance',id:$this.attr('orderID'),companyName:'<?php echo ($_GET["companyName"]); ?>'},function (result) {
          if(!result){
            alert('因库存不足或订单关闭原因, 交易已关闭');
          }else if(result == 2){
            alert('请设置好收货地址');
          }else{
            showPay(result);
          }
        })
      });
    })
  </script>

</body>
</html>