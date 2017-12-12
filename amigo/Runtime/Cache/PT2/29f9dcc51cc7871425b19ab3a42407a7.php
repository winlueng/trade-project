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
    
<style>
    .dl_reviewCom .kb_list-cell::after{
      display:none;
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
    
发表评价

    </h2>
    <nav>
    
  <label class="kb_choose">
    <input type="button" value="" class=" w mark-sendreview" />
    <span class="kb_btn">
      发表
    </span>
  </label>

    </nav>
  </header>


  <section id="Main" class="kb_main bc  kb_notFooter tg_myself">
  <form id="sendreview" action="" method="post" enctype="multipart/form-data"> 
    <input type="hidden" name="company_id" value="<?php echo ($info["company_id"]); ?>">
    <input type="hidden" name="order_id" value="<?php echo ($info["id"]); ?>">
    <?php if(is_array($info["goods_data"])): $i = 0; $__LIST__ = $info["goods_data"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="kb_list-cells mb10">
      <article class="kb_list-cell kb_list-cell_small mt10">
        <div class="kb_list-cell-hd">
            <img src="/Public<?php echo ($v['attrInfo']['attr_pic']); ?>" alt="" />
        </div>
        <input type="hidden" name="goods_id[]" value="<?php echo ($v["goods_id"]); ?>">
          <aside class="kb_list-cell-bd">
            <h2 class=" dl_score">
              <label class="kb_choose ">
                 <input type="checkbox" value="1" 
                 	name="score[<?php echo ($v["goods_id"]); ?>]"
                  checked="checked"
                 />
                 <span class="kb_choose-check icon-isScore"></span>
              </label>
              <label class="kb_choose">
                 <input type="checkbox" checked="checked" value="2" 
                 name="score[<?php echo ($v["goods_id"]); ?>]"
                 />
                 <span class="kb_choose-check icon-isScore"></span>
              </label>
              <label class="kb_choose">
                 <input type="checkbox" checked="checked" value="3"
                 	name="score[<?php echo ($v["goods_id"]); ?>]"
                 />
                 <span class="kb_choose-check icon-isScore"></span>
              </label>
              <label class="kb_choose">
                 <input type="checkbox" checked="checked" value="4"
                 	name="score[<?php echo ($v["goods_id"]); ?>]"
                 />
                 <span class="kb_choose-check icon-isScore"></span>
              </label>
               <label class="kb_choose">
                 <input type="checkbox" checked="checked" value="5" 
                 name="score[<?php echo ($v["goods_id"]); ?>]"
                 />
                 <span class="kb_choose-check icon-isScore"></span>
              </label>  
            </h2>
          </aside>
      </article>
      <acticle class="kb_cell kb_celltextarea">
        <p class="kb_cell-bd">
          <textarea placeholder="请留下您的宝贵评价"
           name="content[<?php echo ($v["goods_id"]); ?>]" maxlength="120"
          rows="3" required="required" class="kb_textarea mark-msg"></textarea>
        </p>
        <p class="kb_cell-info tr">
          0/120
        </p>

      </acticle>
      <article class="kb_cell kb_cell-upload">
        <div class="kb_cell-bd">
          <p class="kb_fileBox-img">

          </p>
          <label class="kb_fileBox">
            <input  type="file" value=""
            name="image<?php echo ($v["goods_id"]); ?>[]"
            multiple="multiple"
            class="kb_file" />
            <span class="kb_file-btn">
            </span>
          </label>
        </div>
      </article>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>

    <div class="kb_list-cells dl_reviewCom">
      <article class="kb_list-cell kb_list-cell_small ">
        <div class="kb_list-cell-hd">
            描叙相符：
        </div>
          <aside class="kb_list-cell-bd">
            <h2 class=" dl_score">
              <label class="kb_choose ">
                 <input type="checkbox" value="1" 
                   name="goods_score" checked="true"
                 />
                 <span class="kb_choose-check icon-isScore"></span>
              </label>
              <label class="kb_choose">
                 <input type="checkbox" value="2" 
                 	name="goods_score" checked="true"
                 />
                 <span class="kb_choose-check icon-isScore"></span>
              </label>
              <label class="kb_choose">
                 <input type="checkbox" value="3" 
                 name="goods_score" checked="true"
                  />
                 <span class="kb_choose-check icon-isScore"></span>
              </label>
              <label class="kb_choose">
                 <input type="checkbox" value="4" 
                 name="goods_score" checked="true"
                  />
                 <span class="kb_choose-check icon-isScore"></span>
              </label>
               <label class="kb_choose">
                 <input type="checkbox" value="5" 
                 name="goods_score" checked="true"
                  />
                 <span class="kb_choose-check icon-isScore"></span>
              </label>  
            </h2>
          </aside>
      </article>
      <article class="kb_list-cell kb_list-cell_small ">
        <div class="kb_list-cell-hd">
            服务态度：
        </div>
          <aside class="kb_list-cell-bd">
            <h2 class=" dl_score">
              <label class="kb_choose ">
                 <input type="checkbox" checked="checked"  
                 	name="server_attitude"
                 value="1">
                 <span class="kb_choose-check icon-isScore"></span>
              </label>
              <label class="kb_choose">
                 <input type="checkbox" checked="checked"  
                 	name="server_attitude"
                 value="2">
                 <span class="kb_choose-check icon-isScore"></span>
              </label>
              <label class="kb_choose">
                 <input type="checkbox" checked="checked"  
                 	name="server_attitude"
                 value="3">
                 <span class="kb_choose-check icon-isScore"></span>
              </label>
              <label class="kb_choose">
                 <input type="checkbox" checked="checked"  
                 	name="server_attitude"
                 value="4">
                 <span class="kb_choose-check icon-isScore"></span>
              </label>
               <label class="kb_choose">
                 <input type="checkbox" checked="checked"  
                 	name="server_attitude"
                 value="5">
                 <span class="kb_choose-check icon-isScore"></span>
              </label>  
            </h2>
          </aside>
      </article>
      <article class="kb_list-cell kb_list-cell_small ">
        <div class="kb_list-cell-hd">
            物流速度：
        </div>
          <aside class="kb_list-cell-bd">
            <h2 class=" dl_score">
              <label class="kb_choose ">
                 <input type="checkbox" checked="checked"  value="1" 
                 	name="express_score"
                 />
                 <span class="kb_choose-check icon-isScore"></span>
              </label>
              <label class="kb_choose">
                 <input type="checkbox" checked="checked"  value="2" 
                 	name="express_score"
                 />
                 <span class="kb_choose-check icon-isScore"></span>
              </label>
              <label class="kb_choose">
                 <input type="checkbox" checked="checked"  value="3" 
                 	name="express_score"
                 />
                 <span class="kb_choose-check icon-isScore"></span>
              </label>
              <label class="kb_choose">
                 <input type="checkbox" checked="checked"  value="4" 
                 	name="express_score"
                 />
                 <span class="kb_choose-check icon-isScore"></span>
              </label>
               <label class="kb_choose">
                 <input type="checkbox" checked="checked"  value="5" 
                 	name="express_score"
                 />
                 <span class="kb_choose-check icon-isScore"></span>
              </label>  
            </h2>
          </aside>
      </article>
    </form>
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
  

<script>
    $(function(){
      $('.mark-sendreview').on('click',function(){
      	$('#sendreview').submit();
      })
      
      $('.fileImg #imgCover').on('change',function(){
        readFile(this,this.files);
      })
      $('.dl_score .kb_choose input').on('change',function(){
        var $this=$(this);
          score=$this.parents('.dl_score').find('.kb_choose input');
          indexs=score.index($this);
          Object.keys(score).slice(0,indexs+1).map(function(elem,indexs){
            if(score.eq(elem).length){
              score.eq(elem).prop("checked",true)
            }
          });
          Object.keys(score).slice(indexs+1,score.length).map(function(elem,indexs){
            if(score.eq(elem).length){
              score.eq(elem).prop("checked",false)
            }
          });
         
      })
      $('.mark-msg').on('input protochange',function(){
        var $this,maxlength,nowTxt;
        $this=$(this);
        maxlength=$this.attr('maxlength');
        if($this.val()<=maxlength){
          $this.val($this.val().slice(0,maxlength));
        }
        maxlegnth=$this.val().length+"/"+maxlength;
        $this.parents('.kb_cell').find('.kb_cell-info').text(maxlegnth);

      })
      $('.kb_file').on('change',function(){
        var files,$this;
        $this=$(this);
        files=this.files;
        $this.parents('.kb_fileBox').siblings('.kb_fileBox-img').html('');
        Object.keys(files).map(function(elem,indexs){
          var reader=new FileReader();
          reader.readAsDataURL(files[elem]);
          reader.onload=function(e){
          var Html="<label class='kb_fileBox imgW imgH'><img src='"+this.result+"' alt='' /></label>"
          $this.parents('.kb_fileBox').siblings('.kb_fileBox-img').append(Html)
            
          }
          //filse[elem]
        })
      })
    })
  </script>

</body>
</html>