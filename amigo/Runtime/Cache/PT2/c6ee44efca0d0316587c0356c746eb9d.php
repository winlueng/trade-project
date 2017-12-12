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
    .mark-writer{
      line-height:40px;
    }
   
    .tg_colllected + .kb_footer,
    .tg_colllected .kb_list-cell .kb_choose{
      display:none;
    }
    .dl_status-writer .kb_list-cell .kb_choose,
    .dl_status-writer + .kb_footer{
      display:block;
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
    
 收藏列表

    </h2>
    <nav>
    
 <label class="kb_choose">
  <input type="checkbox" value="完成" class=" w mark-writer" />
  <span class="kb_btn">
    编辑
  </span>
 </label>

    </nav>
  </header>


  <section id="Main" class="kb_main bc   tg_colllected ">
    <ul class="kb_list mb10">
    <?php if(is_array($list)): foreach($list as $key=>$v): ?><li class="kb_list-cells">
         <a href="<?php echo ($v['link']); ?>" class="kb_list-cell">  
            <div class="kb_list-cell-ft flexLayout-center mr10">
              <label class="kb_choose">
                <input type="checkbox" value="<?php echo ($v['id']); ?>" name="slta1"  />
                <span class="kb_choose-check kb_choose-check_radio">
                  <b class="kb_choose-check-default kb_choose-check_main"></b>
                </span>
              </label>
            </div>
            <div class="kb_list-cell-hd">
                <img src="/Public<?php echo ($v['goods_logo']); ?>" alt="" />
            </div>
            <aside class="kb_list-cell-bd">
                <h2 class="kb_list-cell-title mb10"><?php echo ($v['goods_name']); ?>  </h2>
                <div class="kb_list-cell-brief">
                    
                    <p class=" dl_bugShoping">
                       <em class="tg_ft-price">￥<?php echo ($v['price']); ?>元</em>
                    </p>
                    <p class=" mb10">
                        销量：<?php echo ($v['salesTotal']); ?>
                    </p>
                </div>
            </aside>
         </a>
      </li><?php endforeach; endif; ?>
    </ul>
  </section>


  <footer id="Footer" class="kb_footer">
    <div class="tg_cell  h">
        <div class="tg_cell-hd flexLayout-center h">
          <label class="kb_choose ml10 mark-parentAll">
            <input type="checkbox" name="seta1" value="" class="mark-checkAll-collect"  />
            <span class="kb_choose-check kb_choose-check_radio">
              <b class="kb_choose-check-default kb_choose-check_main"></b>
            </span>
          </label>
          <b class="dl_addrOpera-txt "> 全选</b>
        </div>
        <p class="tg_cell-bd h flexLayout-center">
         
        </p>
        <p class="tg_cell-ft h ">
         
          <button type="button"  class="kb_btn tg_btn-main  w100 tg_cell-bd h mark-isCollect" >删除</button>
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
   $('.mark-writer').on('click',function(){
     var $this,status,nowTxt;
     $this=$(this);
     status=$this.prop('checked');
     status?$('.kb_main').addClass('dl_status-writer'):$('.kb_main').removeClass('dl_status-writer');
     nowTxt=status?'完成':'编辑';
     $this.next().text(nowTxt);

     $('.dl_status-writer .kb_list-cell .kb_choose input').on('click',function(){
       var ischildCheck,allCheck,childCheck;
       
       childCheck=$('.dl_status-writer .kb_list-cell .kb_choose input');
       ischildCheck=$('.dl_status-writer .kb_list-cell .kb_choose input:checked');
       allCheck=$('.kb_footer .mark-checkAll-collect');
       status=childCheck.length===ischildCheck.length? true:false;
       console.log(status);
       allCheck.prop('checked',status);
     })//是否全选
   });
   $('.mark-isCollect').on('click',function(){
     var checked,goodsId;
     checked=$('.dl_status-writer .kb_list-cell .kb_choose input:checked');
     Object.keys(checked).map(function(elem,index){
     	if(checked.eq(elem).length){
     		goodsId=checked.eq(elem).val();
     		$.ajax({
     			type:"GET",
     			url:"<?php echo U('Goods/ajaxControl');?>",
     			data:{
     				flag: 'collectGoods',
     				goods_id: goodsId,
     				status:2,
     			},
     			dataType:"json",
     			success:function(data){
     				// checked.parents('.kb_list-cells').remove();
     				console.log(data);
     			},
     			error:function(error){

     			}
     		})
     	}
     })

     checked.parents('.kb_list-cells').remove();
     oTip('操作成功');
   });//是否移除收藏
   $('.mark-checkAll-collect').on('click',function(){
     var $this,status,childCheck;
     $this=$(this);
     status=$this.prop('checked');
     childCheck=$('.dl_status-writer .kb_list-cell .kb_choose input');
     childCheck.prop('checked',status);
   })//全选操作

  })
</script>

</body>
</html>