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
    
<link href="/Public/JS/module/LArea/LArea.css?t=1.2" rel="stylesheet" />

  <style>
      .dl_addrWrite{
          line-height:40px;
          text-align:center;
        }
        .dl_addrWrite:active{
          opacity:.5;
        }
        .kb_cell{
        font-size: 14px;
      }
  </style>

</head>
<body>

  <header id="Header" class="kb_header flexLayout-center ">
    <nav>
      
        <a href="javascript:;" onclick="javascript:history.go(-1)" class="icon-back w"></a>
      
    </nav>
    <h2 class="kb_header-title">
    
  增加地址

    </h2>
    <nav>
    
  <label class="kb_choose w h dl_addrWrite">
    <input type="button" value=""  />
    <en class="f15">保存</en>
  </label>

    </nav>
  </header>


  <section id="Main" class="kb_main bc   kb_notFooter">
    <form id="addAddressForm" action="<?php echo U('addressAdd');?>" method="post" >
      <article class="kb_cell">
        <p class="kb_cell-hd">
          <label class="kb_label">收货姓名：</label>
        </p>
        <p class="kb_cell-bd">
          <input type="text" name="consignee" data-datatype="input" required="required" placeholder="请输入收货姓名" class="kb_input  w" />
        </p>
      </article>
      <article class="kb_cell">
        <p class="kb_cell-hd">
          <label class="kb_label">手机号码：</label>
        </p>
        <p class="kb_cell-bd">
          <input type="tel" name="phone" data-datatype="input" maxlength="11" minlength="11" data-regexp="verifyTel" required="required" placeholder="请输入" class="kb_input  w" />
        </p>
      </article>
      <article class="kb_cell">
        <p class="kb_cell-hd">
          <label class="kb_label">所在地区：</label>
        </p>
        <p class="kb_cell-bd">
          <input id="nowCity" type="text"  name="city" data-datatype="input" readonly placeholder="请输入" class="kb_input  w" required="required" />
           <input id="nowCityhide" type="hidden" value="" placeholder="" />
        </p>
      </article>
      <article class="kb_cell">
        <p class="kb_cell-hd">
          <label class="kb_label">详细地址：</label>
        </p>
        <p class="kb_cell-bd">
          <input type="text" name="address_str" data-datatype="input" placeholder="请输入" class="kb_input  w" required="required" />
        </p>
      </article>
      <article class="kb_cell  kb_cell-check ">
        <p class="kb_cell-bd">
          设为默认
        </p>
        <p class="kb_cell-ft ">
          <label class="kb_choose">
            <input type="checkbox" name="status" class="mark-setDefault"  value="1" title="是" />
            <span class="kb_choose-pushBtn">
              <b class="kb_choose-pushBtn-radio"></b>
            </span>
          </label>
        </p>
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
  

<script src="/Public/JS/module/LArea/LArea.js"></script>
<script src="/Public/trading/script/tradeing.js"></script>
<script>
  $(function(){
   
       (function(){
            var area1 = new LArea();
            // var Address=new Array();
              $.get("<?php echo U('VisitorInfo/ajaxControl');?>",{
                flag:'getAddress',
                companyName:"<?php echo ($_GET['companyName']); ?>"
              }, function(data) {
                var Address = JSON.parse(data)
                area1.init({
                   'trigger': '#nowCity', //触发选择控件的文本框，同时选择完毕后name属性输出到该位置
                   'valueTo': '#nowCityhide', //选择完毕后id属性输出到该位置
                   'keys': {
                       id: 'district_id',
                       name: 'name'
                   }, //绑定数据源相关字段 id对应valueTo的value属性输出 name对应trigger的value属性输出
                   'type': 1, //数据源类型
                   'data': Address //数据源
                  
               });
               // console.log(LAreaData);
               area1.value=[1,13,3];//控制初始位置，注意：该方法并不会影响到input的value
              });
           
          })()
  })
</script>
<script>
$(function(){
  (function(){
    var checkdata=new CheckData('#addAddressForm');
      checkdata.isVerify.verifyTel=function(_this){
        var $this,patrn;
        $this=$(_this);
        patrn = /^1[34578]\d{9}$/;
        console.log(patrn.test($this.val().trim()))
        if(!patrn.test($this.val().trim())){
          checkdata.errController($this,false) ;
          Alert("手机号码格式不对，请重新输入！",function(){
            $this.val('');
          });
        }else{
          return true;
        };
      }
    $('[data-regexp=verifyTel]').on('blur',function(){
      checkdata.isVerify.verifyTel(this);
    })
    $('.dl_addrWrite').on('click',function(){
      var Url;
          Url=$('#addAddressForm').attr('action');
          
          if(checkdata.verify()){
            $.ajax({
                type:"POST",
                url:Url,
                data:$('#addAddressForm').serialize(),
                dataType:'json',
                success:function(data){
                    if(data.status == 'true'){
                        Alert('添加成功');
                        var url = "<?php echo ($_SERVER['HTTP_REFERER']); ?>";
                        setTimeout("window.location.href='"+url+"'",2000);
                        // window.location.href='http://<?php echo ($_SERVER["HTTP_HOST"]); echo U("WasteBook/myWallet");?>';
                    }else{
                        Alert(data.err_msg);
                        setTimeout("window.location.reload()",2000);
                    }
                },
                error:function(error){

                }
            })
          };
    });
  })();
 

})

</script>

</body>
</html>