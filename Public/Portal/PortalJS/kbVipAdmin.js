$(function(){
  //用户管理，权限列表
  $('.kbVipAdmin_center_nav .special').on('click',function(){
    var $this =$(this);
    $this.siblings('ul').children('li').slideToggle();
  })
  // 弹出框的显示隐藏
  //关闭弹出框
  $('.kbVipAdmin_alert-close').on('click',function(){
    $('.kbVipAdmin_alert').fadeOut();
  })

  // 切换选项卡
    $('.kbVipAdmin_tableHead-tab li a').on('click',function(){
    var $this = $(this);
    var tableHeadTab = $('.kbVipAdmin_tableHead-tab li a');
    var tabIndex = tableHeadTab.index($this);
    var roleListArry = $('.roleListDiv');
    $(roleListArry[tabIndex]).fadeIn();
    
    $(roleListArry[tabIndex]).siblings('.roleListDiv').hide();

    $($this).addClass('selected');

    $($this).parent().siblings().children().removeClass('selected');
    
    // console.log($(tableHeadTab[0]));
    // console.log($(tableHeadTab[0]).siblings());
  })

  // 角色页面
  //弹框权限多选 父级选择后子级选择全选
  $('.userAdmin_Form>li>p>input').on('click',function(){
    var $this=$(this);  //获取已被选取的父级选择框
    if($this.is(":checked")){
      $this.parent().siblings('ul').find('input').prop('checked',true);
    }else{
      $this.parent().siblings('ul').find('input').prop('checked',false);
    }
  })
  // 一级选择
  $('.userAdmin_Form-first input').on('click',function(){
    var $this=$(this);  //获取已被选取的一级选择框
    if($this.is(":checked")){
      $this.parent().siblings('li').find('input').prop('checked',true);
      $this.parents('li').children('input').prop('checked',true);

    }else{
      $this.parent().siblings('li').find('input').prop('checked',false);
      $this.parents('li').children('input').prop('checked',false);
    }
  })
  //弹框权限多选 子选择选择后父级呈现被选择
  $('.userAdmin_Form li ul li>input').on('click',function(){
    var $this=$(this);  //获取已被选取的选择框
    $this.parents('li').eq(1).children('input').prop('checked',true);
    $this.parents('li').eq(1).find('.userAdmin_Form-first').children('input').prop('checked',true);
    if($('.userAdmin_Form li ul li>input:checked').length===0){
      $this.parents('li').eq(1).children('input').prop('checked',false);
      $this.parents('li').eq(1).find('.userAdmin_Form-first').children('input').prop('checked',false);
    }

  })

})
// 图片预览功能
function readFile(a,e){ 
  var _this=a;
  var file = e; 
  //这里我们判断下类型如果不是图片就返回 去掉就可以上传任意文件 
  if(!/image\/\w+/.test(file.type)){ 
    alert("请确保文件为图像类型"); 
  return false; 
  } 

  var reader = new FileReader(); 
  reader.readAsDataURL(file); 
  reader.onload = function(e){ 
  var businessFileImgList=$(_this).siblings('.businessFileImgList')
  console.log(businessFileImgList);
  if(businessFileImgList.length!=0){
    businessFileImgList.find("img").remove();
    businessFileImgList.append('<img src="'+this.result+'" alt=""/>');
  }else{
    console.log(businessFileImgList);
    var closeImg = '<div class="businessFileImgList"><span class="cleraIMG" onclick="clearImg(this)"></span><img src="'+this.result+'" alt=""/></div>'
    $(_this).parent().append(closeImg)
  }
  
  } 
}
function clearImg(_this){
  $(_this).parent().remove();
}
/*
 * 和PHP一样的时间戳格式化函数 
 * @param {string} format 格式 
 * @param {int} timestamp 要格式化的时间 默认为当前时间 
 * @return {string}   格式化的时间字符串 
 *date('Y-m-d','1350052653');//很方便的将时间戳转换成了2012-10-11 
 *date('Y-m-d H:i:s','1350052653');//得到的结果是2012-10-12 22:37:33
 */
function date(format, timestamp){ 
 var a, jsdate=((timestamp) ? new Date(timestamp*1000) : new Date()); 
 var pad = function(n, c){ 
  if((n = n + "").length < c){ 
   return new Array(++c - n.length).join("0") + n; 
  } else { 
   return n; 
  } 
 }; 
 var txt_weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]; 
 var txt_ordin = {1:"st", 2:"nd", 3:"rd", 21:"st", 22:"nd", 23:"rd", 31:"st"}; 
 var txt_months = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]; 
 var f = { 
  // Day 
  d: function(){return pad(f.j(), 2)}, 
  D: function(){return f.l().substr(0,3)}, 
  j: function(){return jsdate.getDate()}, 
  l: function(){return txt_weekdays[f.w()]}, 
  N: function(){return f.w() + 1}, 
  S: function(){return txt_ordin[f.j()] ? txt_ordin[f.j()] : 'th'}, 
  w: function(){return jsdate.getDay()}, 
  z: function(){return (jsdate - new Date(jsdate.getFullYear() + "/1/1")) / 864e5 >> 0}, 
   
  // Week 
  W: function(){ 
   var a = f.z(), b = 364 + f.L() - a; 
   var nd2, nd = (new Date(jsdate.getFullYear() + "/1/1").getDay() || 7) - 1; 
   if(b <= 2 && ((jsdate.getDay() || 7) - 1) <= 2 - b){ 
    return 1; 
   } else{ 
    if(a <= 2 && nd >= 4 && a >= (6 - nd)){ 
     nd2 = new Date(jsdate.getFullYear() - 1 + "/12/31"); 
     return date("W", Math.round(nd2.getTime()/1000)); 
    } else{ 
     return (1 + (nd <= 3 ? ((a + nd) / 7) : (a - (7 - nd)) / 7) >> 0); 
    } 
   } 
  }, 
   
  // Month 
  F: function(){return txt_months[f.n()]}, 
  m: function(){return pad(f.n(), 2)}, 
  M: function(){return f.F().substr(0,3)}, 
  n: function(){return jsdate.getMonth() + 1}, 
  t: function(){ 
   var n; 
   if( (n = jsdate.getMonth() + 1) == 2 ){ 
    return 28 + f.L(); 
   } else{ 
    if( n & 1 && n < 8 || !(n & 1) && n > 7 ){ 
     return 31; 
    } else{ 
     return 30; 
    } 
   } 
  }, 
   
  // Year 
  L: function(){var y = f.Y();return (!(y & 3) && (y % 1e2 || !(y % 4e2))) ? 1 : 0}, 
  //o not supported yet 
  Y: function(){return jsdate.getFullYear()}, 
  y: function(){return (jsdate.getFullYear() + "").slice(2)}, 
   
  // Time 
  a: function(){return jsdate.getHours() > 11 ? "pm" : "am"}, 
  A: function(){return f.a().toUpperCase()}, 
  B: function(){ 
   // peter paul koch: 
   var off = (jsdate.getTimezoneOffset() + 60)*60; 
   var theSeconds = (jsdate.getHours() * 3600) + (jsdate.getMinutes() * 60) + jsdate.getSeconds() + off; 
   var beat = Math.floor(theSeconds/86.4); 
   if (beat > 1000) beat -= 1000; 
   if (beat < 0) beat += 1000; 
   if ((String(beat)).length == 1) beat = "00"+beat; 
   if ((String(beat)).length == 2) beat = "0"+beat; 
   return beat; 
  }, 
  g: function(){return jsdate.getHours() % 12 || 12}, 
  G: function(){return jsdate.getHours()}, 
  h: function(){return pad(f.g(), 2)}, 
  H: function(){return pad(jsdate.getHours(), 2)}, 
  i: function(){return pad(jsdate.getMinutes(), 2)}, 
  s: function(){return pad(jsdate.getSeconds(), 2)}, 
  //u not supported yet 
   
  // Timezone 
  //e not supported yet 
  //I not supported yet 
  O: function(){ 
   var t = pad(Math.abs(jsdate.getTimezoneOffset()/60*100), 4); 
   if (jsdate.getTimezoneOffset() > 0) t = "-" + t; else t = "+" + t; 
   return t; 
  }, 
  P: function(){var O = f.O();return (O.substr(0, 3) + ":" + O.substr(3, 2))}, 
  //T not supported yet 
  //Z not supported yet 
   
  // Full Date/Time 
  c: function(){return f.Y() + "-" + f.m() + "-" + f.d() + "T" + f.h() + ":" + f.i() + ":" + f.s() + f.P()}, 
  //r not supported yet 
  U: function(){return Math.round(jsdate.getTime()/1000)} 
 }; 
   
 return format.replace(/[\\]?([a-zA-Z])/g, function(t, s){ 
  if( t!=s ){ 
   // escaped 
   ret = s; 
  } else if( f[s] ){ 
   // a date function exists 
   ret = f[s](); 
  } else{ 
   // nothing special 
   ret = s; 
  } 
  return ret; 
 }); 
}
function jeDateTime(_this,status){
      console.log((status=="start"));
        var start = {
            format: 'YYYY-MM-DD hh:mm:ss',
            minDate: '2016-01-01 00:00:00', //设定最小日期为当前日期
            festival:true,
            //isinitVal:true,
           // maxDate: $.nowDate(0), //最大日期
            choosefun: function(elem,datas){
                end.minDate = datas; //开始日选好后，重置结束日的最小日期
            },
            okfun:function(elem, val) {
                // checkData(elem);
            }
        };
      var end = {
          format: 'YYYY-MM-DD hh:mm:ss',
          minDate: $.nowDate(0), //设定最小日期为当前日期
          festival:true,
          //isinitVal:true,
          //maxDate: '2099-06-16 23:59:59', //最大日期
          choosefun: function(elem,datas){
              //start.maxDate = datas; //将结束日的初始值设定为开始日的最大日期
          }
      };
      (status=="start")? $.jeDate(_this,start):$(_this).jeDate(end);
 }


/*弹框 */
function operatingTip (alretTip){
    console.log(alretTip);
    // var alretTip = (alretTip==true)?"Good!  这次操作很成功哦":"真是抱歉！操作失败了呢，请稍候操作~~"
    animationAlert({//需引入dlalert插件才能进行的方法
          headline:"操作结果",//标题
          alertContent:alretTip,//正文
          act:"zoom",
          alertTip:true,//不出现确定或者取消按钮。简易的提示。三秒钟后消失
    })
}

function checkData(className,callback){
   var verifyF = new Object();
   var className=$(arguments[0]);
   console.log(className);
   //错误提示图
   var entError ="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAACh0lEQVRYhe2XP2gUQRTGp9h5c3hXXBMIkvl2C4uI6WJlUigEsbBIITGF/xo7kRTBStDOIo2SRkgTsLBIIdhESXFCGkHkirg7b3LIIRbBQgQPbA48i3NDvP03uxcr/eCV7/2+nX1v9q0Q/5UiC2+eQVusZcv4arUdiGbZGu1ANCOoFQu5wz69iFBbcEo0vrrDoD6DBkfigLU86/wAAU0z6GCkxiCCWnGBDzKiZ+HNF8KHp5eAF5oIQUsW8kuOgQGDPjJoKQu+D3XZgj7k1vDpu4G8mXTu0/MCeBzvO1pdHM1neHMMtetY41XCQInkgQV1wqA+eXh6E6LBoD3XfAZ1EwaMr1ZLFBgw6F04IRotITz2abtMrtVyPWGgHYhmXvNkvM9tC7VR0ngvnFKnUpvIalq0oLBkQecwmj5ZyOtZTTw0MRyj3l8w0GfQlVx4rEjTVQa1jwtuQZGFvOEEj8VT6hL76s3Yx+7T20jTYil4LON75xj0cgwDr9mvXagEj9UBnWHQswrwLQM5OxY81u8R/VZq1I5cVGOpG4gmQz2t0Hib3eMwYUCPqveAfNwKRK0ynEH3GPRzrCkAPagEt5C3GfT1GO6BHwx1tyTc+Tb8zG5fwb7zSpa1TqVEOwzqk+GEaFjIHZfJiDTN5MIN5KxxKGZBm/s+nY7zWJ84yZBPik2oXYY3lwpvCeGxlq1iuNpoCeGlPwA9dDiJvW7aZBQspMPw6X7RKzRa3uLkVv1naFpLJBZsNX0GXSuCx4pQWyhoYpNIymmknpnyzrvCD01omslp5qSBSNNi2pjZgKbLwmOFQX0ybUwjTctZrpcZtGdBHavlepVfslF1A1FjTWsMMgwymfB/Vr8A/Bj58bnXojcAAAAASUVORK5CYII="
   //正确提示图
   var entProper="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAgCAYAAAB+ZAqzAAACpUlEQVRYhc3Xz2sTURAH8Dl4EKyo2DTZeVFjKcn77qY/0KtIL6JIEQ/9B0SQInj3oBS1FMVDEQ8W/P0DRHqWohV7KHjxJhR/9FAQb4IWkzZ58wrPQ01ba5LdpGniwDvO8Jnd2Xks0X8QMRe0sfi3WTDPFlOxfJBotYli+SDBgvcscOvO85ai2KQ1C+Y3oBxbPdkyVKKg+1mQ+wclcKqoB1qCYvEvsMG3cig2uN50UMqltrPRw2yxWB6ln8VdT0dTUftchln0rbIggVMW0yw41FRU3CCrDJ5WQrFgjovBqaaiPIujnsHLKqgCC843FcUGp9niXRWUU0aPhhZSBpc8wbSyGIu5oG0zKFXUA5XWwdq+whS5/m0h3emLGxJn6sUp8YdYYKuiBHPs0u3VC7mglwWzG5M9wWOvgANRQZ2uc5cyepQFyyGoz5GWKBvcqFLkXnIprcJqxAuZg57gTgjIsWBRiT8UjrLBERZ8rTqgosc78tl4pRqe6MMseBEB5TyLa6GoFZi+Ga2gP1FuUFcuYv9jlBps9WTosK92a/2JSEUFjsV/WOZpf4+YP5dyfbsjoYiIvGJwIjoMTlmMEREpkxn8sxyj5OXiBtnIqLXOo73OdWempmZMZrBmFBFRItcVU4InNeKiHetfqQtVCuWCPhb/bYNh91M/a5irirhlPcCCLw1BGbyqa64q4lauk6VNomY9q483DFUKz2KkXpSyWGDB2YajiIjUL72XBY/qG3Y9vCWoVZyke1nwpkbY3XaX2bmlMCKi5DJOsuBTtLnSk57JYstRpfBEn2NBPgT2gS2ONQ1VCra4Wnmm8IPFP9N0FBHR/oXuPSz6Qdmv0OByS1ClSBrdzRav/0KJPx53PTtaCiMiShaDLk8wzYKcZ/2Jzf6wVIvfvPXPZoOCSwQAAAAASUVORK5CYII="
   //按表格元素不同而验证和其他方法
  verifyF={
    "Input":function(_this){
         var $this=$(_this);
         var inputArry=[];
         var inputType=$this.prop('type');
         //var inputEnter=$this.not($('[type="checkbox"],input[type="radio"],input[type="file"]'))
         var inputText=$this.val().trim();;
         if(inputType!="file" && inputType!="button" && inputType!="submit"){
            verifyF.notNull($this);
         }
         switch(inputType){
            case "text":
             /* if($($this).prop('minlength')!=''){
                console.log("ss");
                  verifyF.Disabled($this);
                  verifyF.entProper($this,"Error");
              }*/
              // if($($this).prop('maxlength')!=''){
              //   var maxlengths=parseInt($($this).prop('maxlength'));
              //   inputText=$this.val().slice(0,maxlengths);
              //   $($this).val(inputText);
              // }
              if($($this).hasClass('accountlogin')){
                var patrn =/^(?![a-zA-Z]+$)(?!\D+$).{5,16}$/;
               (patrn.exec(inputText))? verifyF.entProper($this,"Proper"):verifyF.entProper($this,"Error");
              }
            break;
            case "file":
               //var FileImgList =()
               if($($this).siblings('.businessFileImgList').length!=0){
                 console.log($($this));
                   verifyF.entProper($this,"Proper");
                   verifyF.remveDisabled($this);
               }
               if($($this).siblings('.fileImgMore').children('.businessFileImgList').length!=0){
                 console.log($($this));
                   verifyF.entProper($this,"Proper");
                   verifyF.remveDisabled($this);
               }
            case "password":
              //^(?=[`~!@#\$%\^&*\(\)\-_=\+\\\|\[\]\{\}:;\"\',.<>\/\?\d]*[a-zA-Z]+)(?=[a-zA-Z`~!@#\$%\^&*\(\)\-_=\+\\\|\[\]\{\}:;\"\',.<>\/\?]*\d+)[`~!@#\$%\^&*\(\)\-_=\+\\\|\[\]\{\}:;\"\',.<>\/\?\w]{10,16}$
              
              var patrn=/^(?=[`~!@#\$%\^&*\(\)\-_=\+\\\|\[\]\{\}:;\"\',.<>\/\?\d]*[a-zA-Z]+)(?=[a-zA-Z`~!@#\$%\^&*\(\)\-_=\+\\\|\[\]\{\}:;\"\',.<>\/\?]*\d+)[`~!@#\$%\^&*\(\)\-_=\+\\\|\[\]\{\}:;\"\',.<>\/\?\w]{5,14}$/;  
              //console.log($this.val().trim())
              var pawS=(patrn.exec($this.val().trim()))?  verifyF.entProper($this,"Proper"):verifyF.entProper($this,"Error")
              //var rePaw = $($this).hasClass("rePaw");
              verifyF.notNull($this);
              if($($this).hasClass("rePaw")){

                 var rePawVal =$this.val().trim();
                 var password =$this.parent().parent().find('input.Password').val().trim();
                 if(rePawVal==""){
                    verifyF.notNull($this);
                 }else{
                 (rePawVal===password)? verifyF.entProper($this,"Proper")  : verifyF.entProper($this,"Error") ;
                 }
                 // console.log()
                 // if(rePawVal===password){
                   
                 // }else{
                   
                 // }
              }
              
            break;
            case "email":
              var patrn= /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
              (patrn.exec($this.val().trim()))? verifyF.entProper($this,"Proper"):verifyF.entProper($this,"Error");
            break;
            case "tel" :
              var patrn = /^1[34578]\d{9}$/;
              console.log(patrn.test(inputText));
              (patrn.exec($this.val().trim()))? verifyF.entProper($this,"Proper"):verifyF.entProper($this,"Error");
            break;
         }
         
        console.log($this);
    },
    "Textarea":function(_this){
      var $this=$(_this);
      $($this).blur(function(){
            verifyF.notNull($this);
      })
      console.log($this);
    },
    "Select":function(_this){
       var $this=$(_this);
       var sltOption=$this.find("option:selected").val()
       //var _thisparent = $this.parent();
       if(sltOption=="-1"){
          //verifyF.Alert("您还没有选择产品分类！！！");
          verifyF.entProper( $this,"Error");
          verifyF.Disabled( $this);
       }else{
          verifyF.entProper( $this,"Proper");
          verifyF.remveDisabled( $this);
       }
      
       
    },
    "notNull":function(_this){
      var $this = _this;
      var tipInfo = ($this.val()=="")? "Error":"Proper";
      verifyF.entProper($this,tipInfo);
      if(tipInfo=="Error"){
          verifyF.Disabled($this);
      }else{
        verifyF.remveDisabled($this);
      }
      
    },
    "Disabled":function(_this){
      $(_this).parents("form").find("input[type='submit']").prop("disabled",true).addClass('kbShopAdmin_dashed');
    },
    "remveDisabled":function(_this){
      $(_this).parents("form").find("input[type='submit']").prop("disabled",false).removeClass('kbShopAdmin_dashed');
    },
    "entProper":function($this,status){
       console.log(status);
       var eStatus =(status=="Error")? entError:entProper;
       var eStatus1 =(status=="Error")? "entError":"entProper";
       $($this).siblings('span').children('img').remove();
       $($this).siblings('span').prepend("<img class='"+eStatus1+"'  style='width:20px;height:20px;margin-left:5px;vertical-align: middle;' src='"+eStatus+"' alt='' />");
    },
    "Alert":function(alertContents){//错误弹框
        animationAlert({//如没有引入指定的弹窗插件，这个发法需注释掉
          headline:"温馨提醒",//标题
          alertContent:alertContents,//正文
          act:"bounce",
          alertHide:"alertHide",
          cancelName:"确定",//第二个按钮的内容，返回值为false
        });
    },

  }
   /* 如果传入得是一个参数则验证单个数据输入是否正确 */ 
    if(arguments.length===1){
       for(r in className){
             switch(className[r].localName){
             case 'input':
               verifyF.Input(className[r]);
                
             break;
             case 'textarea':
                verifyF.Textarea(className[r]);
               
             break;
             case 'select':
                 verifyF.Select(className[r]);
             break;
            }
          }
    }else if(arguments.length===2){//如果传入的是两个参数，则为提交验证表格数据是否正确
        var requiredElemt=className.find('[required="required"]');
        var cStatus=false;
        var cStatus1 = false;
          if(cStatus1){
               cStatus=(entErrorNum===0)? true : false;
          }
          if(!cStatus1){
              for(e in requiredElemt){
               switch(requiredElemt[e].localName){
                 case 'input':
                    if(requiredElemt[e].type!='file'){
                      console.log(requiredElemt[e]);
                      verifyF.Input(requiredElemt[e]);
                    }
                    //verifyF.Input(requiredElemt[e]);
                 break;
                 case 'textarea':
                      verifyF.Textarea(requiredElemt[e]);

                 break;
                 case 'select':
                    verifyF.Select(requiredElemt[e]);
                   /*  if($(requiredElemt[e]).find("option:selected").val()=="-1"){
                      
                    } */
                 break;
                }
              } 
            verifyF.Alert("资料还不完善哦！请查看相关提示");
          }
        var entProperNum=$('.entProper').length;
        var entErrorNum=$('.entError').length;
        cStatus1=(entProperNum===requiredElemt.length || entProperNum>requiredElemt.length)? true : false;//如果正确图片等于required属性的个数就返回true。提交数据
        if(cStatus1){
               cStatus=(entErrorNum===0)? true : false;
              
        }
        callback(cStatus);
    };
}
function jsAjaxControl(_this,parameters,callback){
     // console.log(ajaxBranch);
    var ID = $(_this).parent().parent().siblings().eq(0).text().trim();
     /*
      1.传入input本身与Object()。Object()为defaults格式的
      2.比较为defaults下标值。如果下标值相等着把parameters的元素补充进去。不相等则推入
     */
    var defaults= new Object();
    //默认的必有的参数，如果不能多，也不你少。否则就报错
    defaults={
        ajaxURL:"ajaxUrl",
        ajaxBranch:'Common',
        params:{//这是ajax需要提交的集合
         id:ID,
        }
    }  
    var arr = Object.keys(parameters).length//获取对象的长度\
    if(arr===3){
      for( def in defaults){
        if(typeof parameters[def]==="string"){
            defaults[def]=parameters[def];
        }else if (typeof parameters[def] === 'object') {
            for (var deepDef in parameters[def]) {
                if (typeof defaults[def][deepDef] === 'undefined') {
                     defaults[def][deepDef]=parameters[def][deepDef];
                }
            }
        }else{
         console.log("对象类型不正确");
        }

      }
    }else{
      console.log("参数传入错误")
    }
    console.log(defaults);
    switch(defaults.ajaxBranch){
      case 'Common':
        $.get(defaults.ajaxURL,defaults.params,function(res){
            callback(res);
        })
      break;
      case 'Confirm':
        animationAlert({
            alertContent:'你确定要进行该操作该吗？',
            alertHide:'alertShow'
        },function(ren){
          console.log(ren);
          if(ren){
            $.get(defaults.ajaxURL,defaults.params,function(res){
              callback(res);
            })
          }
        })
      break;
      default:
        console.log("没有相应的方法");
      break
    }
    
}

