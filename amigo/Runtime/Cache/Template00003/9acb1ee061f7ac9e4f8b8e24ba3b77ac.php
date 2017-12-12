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
    
<script src="/Public/tradchild/script/module/mobiscroll/mobiscroll.2.13.2.js"></script>
<link href="/Public/tradchild/script/module/mobiscroll/mobiscroll.2.13.2.css?t=1" rel="stylesheet" />
<link href="/Public/JS/module/LArea/LArea.css?t=1.2" rel="stylesheet" />


<style>
.kb_cell-href{
    flex-wrap:nowrap;
    -webkit-flex-wrap:nowrap;
}
.kb_cell-bd{
    min-width:100px;
}
.kb_fileBox{
    position:static;
    border-radius:50%;
}
.dl_updateImg .kb_cell{
    position:relative;
    overflow:hidden;
}
.dl_selfmain-alone,.mark-selfSub,.dl_selfmain-city,.dl_service{
  display:none;
}

.dl-loginContent{
    width:76%;
    height:100%;
    padding-top:50px;
    display:none;
}
.dl-registered{
    display:flex;
    display:-webkit-flex;
    justify-content:space-between;
    -webkit-justify-content:space-between;
    align-items:center;
    -webkit-align-items:center;
    padding:10px 0;
    text-indent: 10px;
    display:none;
}
.dl-loginContent .mark-registerSub{
    margin-top:120px;
    height: 44px;
    font-size: 18px;
}
/*.kb_main{
    overflow:hidden;
}
.kb_cell-bd{
    padding-left:0;
    padding-right:0;
    font-size:15px;
}*/
.dl-gift{
    display: flex;
}
.mark-vCode{
    width:80px;
    height:35px;
}
.sltSexAlert{
  width:100%;
  background-color:#fff;
  position:absolute;
  bottom:0;
  z-index: 12;
  display:none;
}
.sltSexAlert .coverAlert {
  z-index:-1;

}
#yearmd{
  position: absolute;
  width: 93%;
  opacity: 0;
  z-index:2;
}
.kb_cell .kb_choose.pr{
  position: relative;
}
.dl_service{
  position: fixed;
  top: 0;
  z-index: 99;
  height: 100%;
  overflow-x: hidden;
  background-color: #fff;
}
.dl_service img{
  display: block;
  width:96%;
  margin-left: auto;
  margin-right: auto;
}
.mark-closeService{
  display: block;
  position: absolute;
}
</style>

</head>
<body>

  <header id="Header" class="kb_header flexLayout-center ">
    <nav>
      
        <a href="javascript:;" onclick="javascript:history.go(-1)" class="icon-back w"></a>
      
    </nav>
    <h2 class="kb_header-title">
    
注册

    </h2>
    <nav>
    
	 <button type="button" class="kb_btn  w  mark-selfSub " >保存</button>

    </nav>
  </header>

 
<section id="Main" class="kb_main bc">
<div class="dl_selfmain-content">
  <article class="mb10 dl_updateImg">
    <a href="javascript:;" class="kb_cell kb_cell-href">
     <p class="kb_cell-bd">
      <label class="kb_fileBox imgW imgH">
        <input id="mark-changeImg" type="file" value="" class="kb_file" />
        <?php if(empty($_SESSION["visitorInfo"]["head_portrait"])): ?><img src="/Public/oneselfCore/oneselfCoreImages/01login_img_user_default.png">
        <?php else: ?>
        <img src="<?php echo ($_SESSION['visitorInfo']['head_portrait']); ?>"><?php endif; ?>
      </label>
     </p>
     <p class="kb_cell-ft">
         <em>修改头像</em>
     </p>
    </a>
  </article>
  <actricle class="kb_cells">
   <a href="#/nickName" class="kb_cell kb_cell-href">
    <p class="kb_cell-bd">
        店铺名称<em class="tg_ft-yellow">*</em>
    </p>
    <p class="kb_cell-ft">
        <em><?php echo ($visitorInfo["nick_name"]); ?></em>
    </p>
   </a>
   <a href="#/realName" class="kb_cell kb_cell-href">
    <p class="kb_cell-bd">
        姓名
    </p>
    <p class="kb_cell-ft">
        <em><?php echo ($visitorInfo[real_name]); ?></em>
    </p>
   </a>
   <a href="javascript:;" class="kb_cell kb_cell-href mark-sltSex">
    <p class="kb_cell-bd">
        性别
    </p>
    <p class="kb_cell-ft">
        <em><?php echo ($visitorInfo[sex]==1?'男':女); ?></em>
    </p>
   </a>
   <a href="javascript:;" class="kb_cell kb_cell-href">
    <input type="text" value="" id="yearmd" readonly />
    <p class="kb_cell-bd">
        生日<em class="tg_ft-yellow">*</em>
    </p>
    <p class="kb_cell-ft">
        <em><?php echo date('Y-m-d', $visitorInfo['visitor_birthday']);?></em>
    </p>
   </a>
    <a href="#/nowcity" class="kb_cell kb_cell-href">
     <p class="kb_cell-bd">
        所在地<em class="tg_ft-yellow">*</em>
     </p>
     <p class="kb_cell-ft">
        <em><?php echo ($visitorInfo[address]); ?></em>
     </p>
   </a>
    <a href="#/verifytel" class="kb_cell kb_cell-href">
    <p class="kb_cell-bd">
        注册手机号<em class="tg_ft-yellow">*</em>
    </p>
    <p class="kb_cell-ft">
        <em><?php echo ($visitorInfo[phone]); ?></em>
    </p>
   </a>
   <!--  <a href="javascript:;" class="kb_cell kb_cell-href">
    <p class="kb_cell-bd">
        个性签名
    </p>
    <p class="kb_cell-ft">
        <em>详细信息详细信息详细信息详细信息详细信息详细信息详细信息详细信息详细信息</em>
    </p>
   </a> -->
  </actricle>
  <!-- <a href="javascript:;" class="kb_btn kb_btn-main mt50">退出登录</a> -->
  </div>
  <div class="dl_selfmain-alone">
    <article class="kb_cell">
        <p class="kb_cell-bd">
          <input type="text" placeholder="请在此输入..." autofocus="true" class="kb_input  w mark-userData" />
        </p>
    </article>

    <!-- <button class="kb_btn tg_btn-main w  mark-selfSub">保存</button> -->
  </div>
  <div class="dl_selfmain-city">
     <!-- <input id="nowCity" type="text" value="" placeholder="请输入你现居的城市" readonly required="required" />
     <input id="nowCityhide" type="hidden" value="" name="city" placeholder="" /> -->
    <article class="kb_cell">
        <p class="kb_cell-bd">
          <input id="nowCity" type="text" placeholder="请在此输入..." autofocus="true" readonly class="kb_input  w mark-userData" />
          <input id="nowCityhide" type="hidden" value="" name="city" placeholder="" />
        </p>
    </article>

    <!-- <button class="kb_btn tg_btn-main w  mark-selfSub">保存</button> -->
  </div>
  <section class="dl-loginContent  bc ">
      <form action="<?php echo U('Login/visitorSignIn');?>" method="post">
          <article class="kb_cell mb10">
              <p class="kb_cell-bd">
                  <input type="tel" name="phone" maxlength="11" placeholder="请输入手机号码" class="kb_input  w " />
              </p>
          </article>
          <article class="kb_cell ">
              <p class="kb_cell-bd">
              <input type="text" name="code" placeholder="获取验证码" class="kb_input  w" />
              </p>
              <p class="kb_cell-ft pl5">
                  <button type="button" class="kb_btn kb_btn-main mark-vCode" >获取验证码</button>
              </p>
          </article>
          <article class="kb_cell kb_cell_small">
            <div class="kb_cell-hd ">
              <label class="kb_choose ml10 pr">
                <input type="checkbox" value="" checked="" class="mark-isService" />
                <span class=" kb_choose-check">
                  <b class="kb_choose-check-default kb_choose-check_default"></b>
                </span>
              </label>
            </div>
              <aside class="kb_cell-bd ml10 ">
                <a href="javascript:;" class="kb_cell-title kb_cell-hrefMore mark-isReadService">我阅读并同意服务协议</a>
            </aside>
            <p class="kb_cell-ft">
            </p>
          </article>
          <p class="tg_ft-minor tg-tip mt10" style="display:none">
              <i class="kb_icon-tip"></i>
              <em class="mark-error"></em>
          </p>
          <input type="submit" value="确定" class="kb_btn kb_btn-main w mark-registerSub" />
      </form>
  </section>
  <section class="dl_service bc">
    <p>
      <a href="javascript:;" class="w50 h50 mark-closeService"></a>
      <img src="/Public/images/serviceNote.jpg" alt="服务协议" />
      <button type="button" class="kb_btn kb_btn-main w h50 fb f16 mark-readedservice">已阅读</button>
    </p>
  </section>
</section>


  


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
 
<div class="sltSexAlert">
  <div class="coverAlert coverblack"></div>
  <a href="javascript:;" class="kb_cell  mt10">
    <p class="kb_cell-bd briefColor">
      请选择性别
    </p>
    <p class="kb_cell-ft">
      <button type="button" class=" kb_btn mark-sltSexSub">确定</button>
    </p>
  </a>
  <article class="kb_cell kb_cell-check">
    <p class="kb_cell-bd">
      男
    </p>
    <p class="kb_cell-ft kb_choose">
      <input type="radio" name="sex" value="1" <?php echo ($visitorInfo[sex]==1?'checked':''); ?> />
      <span class=" kb_choose-check">
        <b class="kb_choose-check-default kb_choose-check_default"></b>
      </span>
    </p>
  </article>
  <article class="kb_cell kb_cell-check">
    <p class="kb_cell-bd">
      女
    </p>
    <p class="kb_cell-ft kb_choose">
      <input type="radio" name="sex" value="2" <?php echo ($visitorInfo[sex]==2?'checked':''); ?> />
      <span class=" kb_choose-check">
        <b class="kb_choose-check-default kb_choose-check_default"></b>
      </span>
    </p>
  </article>
</div>
<script src="/Public/JS/module/LArea/LArea.js"></script>
<script>
$(function(){
  function Router(){
    this.routes = {};
    this.curUrl = '';

    this.route = function(path, callback){
      this.routes[path] = callback || function(){};
    };

    this.refresh = function(){
      this.curUrl = location.hash.slice(1) || '/';
      this.routes[this.curUrl]();
    };

    this.init = function(){
      window.addEventListener('load', this.refresh.bind(this), false);
      window.addEventListener('hashchange', this.refresh.bind(this), false);
    }

  }
  var R = new Router();
  R.init();
  var res = $('#Main');

   R.route('/', function() {
    res.find('.dl_selfmain-content').show();
    res.find('.dl_selfmain-alone').hide();
    res.find('.dl_selfmain-city').hide();
    res.find('.dl-loginContent').hide();
     res.removeClass('main_bg')
    $('.mark-selfSub').hide();
    $('.kb_header-title').text('注册')
    $('.mark-userData').val('');
   });

   R.route('/nickName', function() {
      res.find('.dl_selfmain-content').hide();
      res.find('.dl_selfmain-alone').show();
      $('.mark-selfSub').show();
      $('.kb_header-title').text('店铺名称');
      $('.mark-userData').val('<?php echo ($visitorInfo[nick_name]); ?>');
      inputControl('nickName',5);//限制字数

      $('.mark-selfSub').on('click',function(){
        var userData=$('.mark-userData');
        if(userData.val().length==0){
            oTip("这里不能为空，请按要求输入内容");
            $(this).attr('disabled',true);
        }else{
          updateSelfInfo({
            field:'nick_name',
            data:userData.val().trim()
          });
        }
      });
   });
   R.route('/realName', function() {
      res.find('.dl_selfmain-content').hide();
      res.find('.dl_selfmain-alone').show();
      $('.mark-selfSub').show();
      $('.kb_header-title').text('姓名');
      $('.mark-userData').val('<?php echo ($visitorInfo[real_name]); ?>');
      inputControl('nickName',5);
      $('.mark-selfSub').on('click',function(){
        var userData=$('.mark-userData');
        if(userData.val().length==0){
            oTip("这里不能为空，请按要求输入内容");
            $(this).attr('disabled',true);
        }else{
          updateSelfInfo({
            field:'real_name',
            data:userData.val().trim()
          });
        }
      });

   });

    R.route('/nowcity', function() {
      res.find('.dl_selfmain-content').hide();
      res.find('.dl_selfmain-city').show();
      $('.mark-selfSub').show();
      $('.kb_header-title').text('所在地');
      $('.mark-userData').val('<?php echo ($visitorInfo[address]); ?>');

      $('.mark-selfSub').on('click',function(){
        var userData=$('.mark-userData');
        if(userData.val().length==0){
            oTip("这里不能为空，请按要求输入内容");
            $(this).attr('disabled',true);
        }else{
          if($('#nowCityhide').val().trim().length>0){
            updateSelfInfo({
              field:'city',
              data:$('#nowCityhide').val().trim()
            });
          }else{
            window.location.href="javascript:history.go(-1)"
          }
          
        }
      });

   });
     R.route('/verifytel', function() {
      res.find('.dl_selfmain-content').hide();
      res.find('.dl-loginContent').show();
      // $('.mark-selfSub').show();
      $('.kb_header-title').text('注册手机号');
      res.addClass('main_bg')
      $('.mark-isService').on('change', function() {
        var $this = $(this),
        status = $this.is(':checked');
        $('.mark-registerSub').prop('disabled', !status)
      })
      $('.mark-isReadService').on('click', function() {
        $('.dl_service').show();
        $('.mark-closeService, .mark-readedservice').on('click',function() {
          $('.dl_service').hide();
        })
      })
     /*  $('.mark-userData').val('<?php echo ($visitorInfo[address]); ?>');
      $('.mark-selfSub').on('click',function(){
        var userData=$('.mark-userData');
        if(userData.val().length==0){
            oTip("这里不能为空，请按要求输入内容");
            $(this).attr('disabled',true);
        }else{
          if($('#nowCityhide').val().trim().length>0){
            updateSelfInfo({
              field:'city',
              data:$('#nowCityhide').val().trim()
            });
          }else{
            window.location.href="javascript:history.go(-1)"
          }
          
        }
      }); */

   });
    
  function updateSelfInfo(params){
    var Url,postData=new Object(),formData;

    formData=new FormData();
    postData=params;
    Object.keys(postData).map(function(elem,indexs){
        formData.append(elem,postData[elem]);
    })

    Url="<?php echo U('VisitorInfo/ajaxControl');?>?flag=infoUpdate";
    $.ajax({
        type:"POST",
        url:Url,
        data:formData,
        dataType:'json',
        async:false,
        cache:false,
        contentType:false,
        processData:false,
        success:function(data){
            if(data.status){
              oTip('操作成功');
              setTimeout(function(){
                window.location.href="<?php echo U('VisitorInfo/myCenterUpdate');?>";
              },2000)
            }
        },
        error:function(xhr, errorType, error){
            console.log("xhr："+xhr);
           console.log("errorType："+errorType);
           console.log("error："+error);
        }

    })
  }
  function inputControl(type,maxlength){
    var userData,maxLength;
    maxLength=maxlength;
    userData=$('.mark-userData');
    userData.on('input propertychange',function(){
        if($(this).val().length>maxLength){
           $(this).val($(this).val().slice(0,maxLength));
        }
       $('.mark-selfSub').removeAttr('disabled',false);
    });
    
  }
     
  
   function telCode(self){
    var $this=$(self),
        getData=new Object,
        patrn = /^1[34578]\d{9}$/,
        phone=$this.parents('.kb_cell').siblings('.kb_cell').find('[name=phone]'),  
        time=60,
        sTime,
        now=new Date(),
        outTimestamp=now.getTime(),
        isSendCode=false;
    if(!patrn.exec(phone.val()) && !(phone.val().length===11)){
        Alert('手机号码格式不对，请重新输入',function(res){
            phone.val('');
        });
        $('.tg_ft-minor').show();
        $('.mark-error').text('手机号码格式不对，请重新输入');
        return false;
    }
    
    //查看本地该手机号码是否已经获取了验证码；
    isSendCode=localStorage.getItem(phone.val())?localStorage.getItem(phone.val()):false;
    if(isSendCode){
        //查看距离上次获取验证码时间是否已经过了60s；
        if(outTimestamp-isSendCode<60*1000){
            $('.tg_ft-minor').show();
            $('.mark-error').text('已经发送过验证码！请留意短信通知');
            $this.attr('disabled',true);
            time=outTimestamp-isSendCode/1000;
            sTime=setInterval(function(){
                if(time>0){
                    $this.text((time--)+' s');
                }else{
                    window.clearInterval(sTime);
                    $this.text("获取验证码");
                    $this.removeAttr('disabled');
                    localStorage.removeItem(phone.val());
                }
            },1000);
            return false;
        }
    }

    $('.tg_ft-minor').hide();
    getData.phone=phone.val();
    getData.flag='smsToVisitorVerify';

    $.ajax({
        type:"GET",
        url:'<?php echo U("Login/ajaxControl");?>',
        data:getData,
        dataType:'json',
        success:function(data,status,xhr){
            console.log(data);
            switch(data){
                case 1:
                    $this.attr('disabled',true);
                    localStorage.setItem(getData.phone,outTimestamp);
                    oTip('短信已经发送，请注意查收！');

                    sTime=setInterval(function(){
                        if(time>0){
                            $this.text((time--)+' s');
                        }else{
                            window.clearInterval(sTime);
                            $this.text("获取验证码");
                            $this.removeAttr('disabled');
                        }
                    },1000);
                break;
                case 5:
                    Alert('该号码已经被注册，请更换一个或者进行“忘记密码”操作');
                break;
                case 4:
                    oTip('短信已经发送，请注意查收！');
                break;
                default:

                break;
            }
        },
        error:function(xhr,errorType,error){
            console.log(xhr);
            console.log(errorType);
            console.log(error);
        }
    })
  }
  //mark-vCode
  $('.mark-vCode').on('click',function(){
    telCode(this);
  })
  $('.mark-registerSub').on('click',function(){
    var $this,phone;
    $this=$(this);
    phone=$this.parents('.dl-loginContent').find('.kb_input[name=phone]').val();
    if(phone.length!=11){
        Alert("请输入11位的手机号码");
        return false;
    }
    if($('.mark-vCode').parents('.kb_cell').find('.kb_input[name=code]').val().length<4){
        Alert("您输入的验证码位数不对哦！");
        return false;
    }
  })
  //选择性别
  $('.mark-sltSex').on('click',function(){
    $('.sltSexAlert').show();
    $('.sltSexAlert .coverAlert ').on('click',function(){
        $('.sltSexAlert').hide();
    });
    $('.sltSexAlert .mark-sltSexSub').on('click',function(){
      var $this=$('.sltSexAlert .kb_choose input:checked'),
          params=new Object();
     
      params={
        field:$this.attr('name'),
        data:$this.val()
      }
      updateSelfInfo(params);
    })
  })
  //上传头像
  $('#mark-changeImg').on('change',function(){
    var $this=$(this),
        formData=new FormData(),
        Url="<?php echo U('VisitorInfo/ajaxControl');?>?flag=headPortraitUpload",imgType=false;
        switch(this.files[0].type.toLowerCase()){
          case 'image/jpeg':
            imgType=true;
          break;
          case 'image/png':
            imgType=true;
          break;
          case 'image/jpg':
            imgType=true;
          break;
          default:
            imgType=false;
          break
        }
        if(!imgType){
          Alert('请选择jpg、png、jpg的格式图片上传！')
           return false;
        }

        formData.append('head_portrait',this.files[0]);
        $.ajax({
          type:"POST",
          url:Url,
          data:formData,
          dataType:'json',
          enctype: 'multipart/form-data',
          async: false,  
          cache: false,  
          contentType: false,  
          processData: false,
          success:function(data,status,xhr){
            if(data.status){
              $this.siblings('img').attr('src',data.headUrl);
            }
            console.log(data);
          },
          error:function(xhr,errorType,error){
            console.log(xhr);
            console.log(errorType);
            console.log(error);
          }
        })
  });
  //选择生日
  (function(){
        //var curr = new Date().getFullYear();
        var opt = {  
          'default': {
            theme: 'default',
            mode: 'scroller',
            display: 'modal',
            animate: 'fade'
                  },
          'dateYMD': {
                    preset: 'date',
            dateFormat: 'yyMMdd',
            defaultValue: new Date(new Date()),
            maxDate: new Date(),
            // invalid: { daysOfWeek: [0, 6], daysOfMonth: ['5/1', '12/24', '12/25'] }
                  },
                  'select': {
                      preset: 'select'
                  },
                  'select-opt': {
                      preset: 'select',
                      group: true,
                      width: 50
                  }
         }
      $('#yearmd').scroller($.extend(opt['dateYMD'],opt['default']));

      $('#yearmd').on('change',function(){
        console.log($(this).val());
        var $this=$(this),birthday,params=new Object()
            year=$this.val().slice(0,4);
            month=$this.val().slice(4,6);
            day=$this.val().slice(6,8);
            $this.val(year+"-"+month+"-"+day+" 0:0:0");
            birthday=new Date($this.val()).getTime()/1000;

            params={
              field:'visitor_birthday',
              data:birthday
            }
            updateSelfInfo(params);
      })
  })();
  (function(){
    var area1 = new LArea();
    // var Address=new Array();
      $.get("<?php echo U('VisitorInfo/ajaxControl');?>",{flag:'getAddress',companyName:"<?php echo ($_GET['companyName']); ?>"}, function(data) {
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
    $('#nowCityhide').on('change',function(){
       $(this).val();
    })
  })()
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