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
      .dl_addrWrite{
        line-height:40px;
        text-align:center;
      }
      .dl_addrWrite:active{
        opacity:.5;
      }
     
     
      .dl_addre-wirteStatus .dl_addrOpera
      {
        display:block;
      }
      .mark-mycartRemove{
        display:none;
      }
      .dl_addre-wirteStatus + #Footer .mark-mycartRemove{
        display:block;
      }
      .dl_addre-wirteStatus + #Footer .mark-mycartSub{
        display:none;
      }
      .dl_addre-wirteStatus + #Footer .tg_cell-bd.flexLayout-center{
        opacity:0;
      }
      .mark-lower,.mark-add{
         display:none;
      }
      .dl_chang-total::before{
        display:none;
      }
      .dl_addre-wirteStatus .mark-lower,
      .dl_addre-wirteStatus .mark-add{
        display:block;
      }
      .dl_goodlist img{
        height:75px;
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
    
购物车

    </h2>
    <nav>
    
  <label class="kb_choose w h dl_addrWrite tc">
    <input type="button" value=""  />
    <b class="f14">编辑</b>
  </label>

    </nav>
  </header>


  <section id="Main" class="kb_main bc tg_myself ">
  <form id="myCartForm" action="<?php echo U('OrderForm/unpaid');?>?way=2&com=c&c_com=<?php echo I('get.c_com');?>&gid=<?php echo I('get.gid');?>" method="post">
  <?php if(is_array($info["project"])): $i = 0; $__LIST__ = $info["project"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><ul class="kb_list">
      <a class="kb_list-title kb_list-cell kb_list-cell_small kb_cell-href" href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>">
        <div class="kb_list-cell-ft flexLayout-center mr10">
          <label class="kb_choose mark-loactionAll">
            <input type="checkbox" value="" name="slta1"  />
            <span class="kb_choose-check kb_choose-check_radio w20">
              <b class="kb_choose-check-default kb_choose-check_main"></b>
            </span>
          </label>
        </div>
        <div class="kb_list-cell-hd ml10">
          <?php if($v['company_id']): ?><img src="/Public/trading/images/tr-shop.png" alt="" />
          <?php else: ?>
            <img src="/Public/trading/images/tr-Self-employed.png"  alt="" /><?php endif; ?>
        </div>
          <aside class="kb_list-cell-bd">
            <h2 class="kb_list-cell-title"><?php echo ($pInfo['market_name']); ?></h2>
        </aside>
        <p class="kb_cell-ft">
        </p>
      </a>
      <li class="kb_list-cells">
      <?php if(is_array($v)): $i = 0; $__LIST__ = $v;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><article  class="kb_list-cell dl_goodlist" >  
            <div class="kb_list-cell-ft flexLayout-center mr10">
              <label class="kb_choose">
                <input type="checkbox" value="<?php echo ($vo["id"]); ?>" name="cart_id[<?php echo ($vo["id"]); ?>]" data-price="<?php echo ($vo["true_price"]); ?>" data-total="<?php echo ($vo['total']); ?>" data-cartid="<?php echo ($vo["id"]); ?>" />
                <span class="kb_choose-check kb_choose-check_radio w20">
                  <b class="kb_choose-check-default kb_choose-check_main"></b>
                </span>
              </label>
            </div>
				    <input type="hidden" value="<?php echo ($vo['attr']['attr_price']); ?>" name="price[<?php echo ($vo["id"]); ?>]" />
            <div class="kb_list-cell-hd">
              <a href="<?php echo ($vo['link']); ?>" class="flexLayout-center h80">
                <img src="/Public<?php echo ($vo['attr']['attr_pic']); ?>" alt="" class="" />
              </a>
            </div>
            <aside class="kb_list-cell-bd">
                <h2 class="kb_list-cell-title mb10 f14"><?php echo ($vo['goodsInfo']['goods_name']); ?></h2>
                <div class="kb_list-cell-brief">
                    <p class="f13">
                        <?php echo ($vo['attr']['attr_name']); ?>: &nbsp; <?php echo ($vo['attr']['attr_val']); ?>
                    </p>
                    <div class=" dl_bugShoping">
                       <em class="tg_ft-price">￥<?php echo ($vo['true_price']); ?>元</em>
                       <p class="kb_cell dl_chang-total" data-cartid="<?php echo ($vo["id"]); ?>" >
                         <button type="button" class="kb_btn  mark-add tg_btn-default w30  ">+</button>
                         <span class="w30 tc ">x<em class="mark-goodTotal"><?php echo ($vo['total']); ?></em></span>
                         <button type="button" class="kb_btn mark-lower  tg_btn-default w30  ">-</button>
                       </p>
                    </div>
                </div>
            </aside>
         </article><?php endforeach; endif; else: echo "" ;endif; ?>
      </li>
    </ul><?php endforeach; endif; else: echo "" ;endif; ?>
  <?php if(is_array($info["company"])): $i = 0; $__LIST__ = $info["company"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><ul class="kb_list dl_goodlist">
      <a class="kb_list-title kb_list-cell kb_list-cell_small kb_cell-href" href="<?php echo ($v['link']); ?>">
        <div class="kb_list-cell-ft flexLayout-center mr10">
          <label class="kb_choose mark-loactionAll">
            <input type="checkbox" value="" name="slta1" />
            <span class="kb_choose-check kb_choose-check_radio">
              <b class="kb_choose-check-default kb_choose-check_main"></b>
            </span>
          </label>
        </div>
        <div class="kb_list-cell-hd ml10">
         <?php if($v['company_id']): ?><img src="/Public/trading/images/tr-shop.png" alt="" />
          <?php else: ?>
            <img src="/Public/trading/images/tr-Self-employed.png" alt="" /><?php endif; ?>
        </div>
          <aside class="kb_list-cell-bd">
            <h2 class="kb_list-cell-title"><?php echo ($v['name']); ?></h2>
        </aside>
        <p class="kb_cell-ft">
        </p>
      </a>
      <li class="kb_list-cells">
      <?php if(is_array($v)): foreach($v as $ki=>$vo): if(is_int($ki)): ?><article  class="kb_list-cell dl_goodslist" >  
            <div class="kb_list-cell-ft flexLayout-center mr10">
              <label class="kb_choose">
                <input type="checkbox" value="<?php echo ($vo["id"]); ?>" name="cart_id[<?php echo ($vo["id"]); ?>]" data-price="<?php echo ($vo["true_price"]); ?>" data-total="<?php echo ($vo['total']); ?>" data-cartid="<?php echo ($vo["id"]); ?>"  />
                <span class="kb_choose-check kb_choose-check_radio">
                  <b class="kb_choose-check-default kb_choose-check_main"></b>
                </span>
              </label>
            </div>
				    <input type="hidden" value="<?php echo ($vo['attr']['attr_price']); ?>" name="price[<?php echo ($vo["id"]); ?>]" />
            <div class="kb_list-cell-hd">
              <a  href="<?php echo ($vo['link']); ?>" class="flexLayout-center">
                <img src="/Public<?php echo ($vo['attr']['attr_pic']); ?>" alt="" />
              </a>
            </div>
            <aside class="kb_list-cell-bd">
                <h2 class="kb_list-cell-title mb10"><?php echo ($vo['goodsInfo']['goods_name']); ?></h2>
                <div class="kb_list-cell-brief">
                    <p class=" mb10">
                        <?php echo ($vo['attr']['attr_name']); ?>: &nbsp; <?php echo ($vo['attr']['attr_val']); ?>
                    </p>
                    <p class=" dl_bugShoping">
                       <em class="tg_ft-price">￥<?php echo ($vo['true_price']); ?>元</em>
                       <span>x<em class="mark-goodTotal"><?php echo ($vo['total']); ?></em></span>
                    </p>
                </div>
            </aside>
         </article><?php endif; endforeach; endif; ?>
      </li>
    </ul><?php endforeach; endif; else: echo "" ;endif; ?>
  </form>
  </section>


  <footer id="Footer" class="kb_footer ">
    <div class="tg_cell  h">
        <div class="tg_cell-hd flexLayout-center h">
          <label class="kb_choose ml10 mark-parentAll">
            <input type="checkbox" name="seta1" value=""  />
            <span class="kb_choose-check kb_choose-check_radio">
              <b class="kb_choose-check-default kb_choose-check_main"></b>
            </span>
          </label>
          <b class="dl_addrOpera-txt f18"> 全选</b>
        </div>
        <p class="tg_cell-bd h flexLayout-center">
          合计：￥<em class="tg_ft-price">0</em>
        </p>
        <p class="tg_cell-ft h ">
          <button type="button"  class="kb_btn tg_btn-main  w100 tg_cell-bd h mark-mycartRemove f18" >删除</button>
          <button type="button"  class="kb_btn tg_btn-main  w100 tg_cell-bd h mark-mycartSub f18" >结算</button>
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
  

<script>
  $(function(){

  
    $('.dl_addrWrite input').on('click',function(){
      var status;
        $('#Main').toggleClass('dl_addre-wirteStatus');
        status=$('#Main').hasClass('dl_addre-wirteStatus');
        if(status){
          $(this).next().text("完成");
        }else{
          $(this).next().text("编辑");
        }
        $('.kb_main  .kb_choose input').prop('checked',false);
        $('.kb_footer   .kb_choose input').prop('checked',false);
        $('.kb_footer  .tg_ft-price').text(0);
        $('.kb_footer  .mark-mycartSub').text("结算");

    })
    $('.mark-lower,.mark-add').on('click',function(){
        var $this=$(this),status,total,totalnub,cartid,prams=new Object();
        status=$this.hasClass('mark-add');
        total=$this.siblings().find('.mark-goodTotal');
        cartid=$this.parents('.dl_chang-total').attr('data-cartid').trim();
        prams={
          flag:'setTotal',
          id:cartid
        }
        if(status){
          totalnub=parseInt(total.text());
          total.text(++totalnub);
          prams.status="plus";
        }else{
          totalnub=parseInt(total.text());
          if(totalnub==1){
              total.text(1);
          }else{
            total.text(--totalnub);
          }
          prams.status="minus";
        }
        $.ajax({
          type:"GET",
          url:"<?php echo U('ShoppingCart/ajaxControl');?>",
          data:prams,
          dataType:'json',
          success:function(data){
            console.log(data);
            // if(data){
            //   oTip('操作成功');
            // }
          },
          error:function(error){
            console.log(error);
          }
        })
    })

    $('.mark-mycartSub').on('click',function(){
        if($('#myCartForm .kb_list .kb_list-cells .kb_choose input:checked').length==0){
          oTip('请先进行商品选择');
          return false;
        }
        $('#myCartForm').submit();
    });

    $('.mark-loactionAll input').on('click change ',function(){
      var $this=$(this),
          status=$this.prop('checked'),
          childInput=$this.parents('.kb_list-title').siblings('.kb_list-cells').find('.kb_list-cells .kb_choose input');  
          childInput.prop('checked',status);
         
         
    });
    $('.mark-parentAll input').on('click change ',function(){
      var $this=$(this),locationChecked,locationinput,totalPrice,totalNum,
          status=$this.prop('checked'),
          childInput=$('.kb_choose input');
          
          childInput.prop('checked',status);

         locationChecked=$('#myCartForm').find('.kb_list-cells .kb_choose input:checked');
         locationinput=$('#myCartForm').find('.kb_list-cells .kb_choose input');
        
         totalPrice=0;
         totalNum=0;

         Object.keys(locationChecked).map(function(elem,indexs){
            if(locationChecked.eq(elem).length){
              var price=Number(locationChecked.eq(elem).attr('data-price'));
              var number=Number(locationChecked.eq(elem).parents('.kb_list-cell').find('.mark-goodTotal').text().trim());
              totalPrice+=price*number;
              totalNum+=number;
            }
         })
         $('.kb_footer .tg_cell .tg_cell-bd .tg_ft-price').text(totalPrice);
         $('.kb_footer .tg_cell .tg_cell-ft .mark-mycartSub').text('结算('+totalNum+')');
    });
    //是否全选
    $('.kb_main .kb_list .kb_choose input').on('click change',function(){
     var $this,locationChecked,locationinput,inputlength,checklength,totalPrice,totalNum;
         $this=$(this);
        //是否店铺全选
         locationChecked=$('#myCartForm').find('.kb_list-cells .kb_choose input:checked');
         locationinput=$('#myCartForm').find('.kb_list-cells .kb_choose input');
        
         totalPrice=0;
         totalNum=0;

         Object.keys(locationChecked).map(function(elem,indexs){
            if(locationChecked.eq(elem).length){
              var price=Number(locationChecked.eq(elem).attr('data-price'));
              var number=Number(locationChecked.eq(elem).parents('.kb_list-cell').find('.mark-goodTotal').text().trim());
              totalPrice+=price*number;
              totalNum+=number;
            }
         })
         $('.kb_footer .tg_cell .tg_cell-bd .tg_ft-price').text(totalPrice);
         $('.kb_footer .tg_cell .tg_cell-ft .mark-mycartSub').text('结算('+totalNum+')');

         if(locationChecked.length===locationinput.length){
            $this.parents('.kb_list-cells').siblings('.kb_list-title').find('.mark-loactionAll input').prop('checked',true);
          }else{
             $this.parents('.kb_list-cells').siblings('.kb_list-title').find('.mark-loactionAll input').prop('checked',false);
          }
         
          //是否购物车全选
          inputlength=$('.kb_main .kb_list .kb_choose input').length;
          checklength=$('.kb_main .kb_list .kb_choose input:checked').length;
        

          if(inputlength===checklength){
            $('.mark-parentAll input').prop('checked',true);
          }else{
            $('.mark-parentAll input').prop('checked',false);
          }

    });
    $('.mark-mycartRemove').on('click',function(){
        var ischekced=$('.kb_main .kb_list .kb_list-cells .kb_choose input:checked'),
        isRemove=new Array(),params=new Object,
        Url="<?php echo U('ShoppingCart/ajaxControl');?>";
        Object.keys(ischekced).map(function(elem,indexs){
          if(ischekced.eq(elem).length>0){
            isRemove.push(ischekced.eq(elem).attr('data-cartid').trim());
            return false;
          }
        })
        if(isRemove.length<=0){
          oTip('请先进行商品选择');
          return false;
        }
        params={
          flag:'del',
          id:isRemove
        }
        $.ajax({
          type:"GET",
          url:Url,
          data:params,
          dataType:'json',
          success:function(data){
            console.log(data);
            if(data){
              oTip("操作成功");
              ischekced.parents('.kb_list-cell').remove();
            }else{
              oTip("操作失败");
            }
          },
          error:function(error){
            console.log(error);
          }
        })
        console.log(isRemove);
    })
  })
</script>



</body>
</html>