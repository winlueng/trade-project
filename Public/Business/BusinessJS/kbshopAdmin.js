$(function(){
	$('#kbShopAdmin_leftNav .special').on('click',function(){

		var $this =$(this);
		$this.siblings('ul').children('li').slideToggle();
    $this.toggleClass("meanu1");
	});
	$('.kbShopAdmin_fileImg input[type="file"]').on('change',function(){
        console.log($(this));
				if ( typeof(FileReader) === 'undefined' ){ 
					alert("抱歉，你的浏览器不支持 FileReader，推荐使用谷歌浏览器操作！"); 
					this.setAttribute( 'disabled','disabled' ); 
				} else { 
					readFile(this,this.files);
				} 
	});
	$('.kbShopAdmin_alert .kbShopAdmin_alert-close').on('click',function(){
      $('.kbShopAdmin_alert').fadeOut();
  })
  // 正则验证
  $('.kbShopAdmin_alert [required="required"]').bind('change blur',function(){
     //if(!$(this).hasClass('datainp')){
        checkData(this);
    // }
  })

  $('.kbShopAdmin_alert form .kbShopAdmin_operating input[type="submit"]').on('click',function(){
        var sStatus = false;
        var $this=$(this);
        var thisParent=$this.parents('form').parent();
        console.log(thisParent)
          checkData(thisParent,function(ren){
             sStatus=ren;
          });
          //数据正确则提交
          return sStatus;
  })
})
function companyPortal(){
  console.log("商户门户函数初始化")
}
companyPortal.prototype={
  countLength:function(_this,pleft){
    var $this=$(_this);
    
    var pleft=pleft;

    var Maxlength=$this.attr('maxlength');
    var vallength=$this.val().length;
    var Html='<p style="position:absolute;left:'+pleft
      +'px;top:'+(_this.clientHeight/2-5)
      +'px;width:10px;height:10px;color:#919191"><span class="valLength">'+vallength+"</span>/"+Maxlength
      +'</p>'
    $this.after(Html  )
   /*  console.log(pleft);
    console.debug(typeof $this.position().left);
    console.debug(typeof _this.clientWidth); */
  }
}
// 图片预览功能
function readFile(a,e){ 
	var _this=a;
	var files = e; 
	//console.log(file);
	//这里我们判断下类型如果不是图片就返回 去掉就可以上传任意文件 
	// if(!/image\/\w+/.test(file.type)){ 
	// 	alert("请确保文件为图像类型"); 
	// return false; 
	// } 
	for(var r=0;r<files.length;r++){
		
		var reader = new FileReader(); 
    	reader.readAsDataURL(files[r]); 
    
		reader.onload = function(e){ 
			var businessFileImgList=$(_this).siblings('.businessFileImgList')
			if($(_this).prop("multiple")===true){
				var closeImg = '<div class="shopImg businessFileImgList"><span class="cleraIMG" onclick="clearImg(this)"></span><img src="'+this.result+'" alt=""/></div>'
        
        $(_this).before(closeImg);
			
        if($(_this).siblings('.businessFileImgList').length==5){
          $(_this).next().hide();
        }
       
				//console.log($('.fileImgMore>div').length);
			}else if(businessFileImgList.length!=0){
				//console.log(businessFileImgList);
				businessFileImgList.find("img").remove();
				businessFileImgList.append('<img src="'+this.result+'" alt=""/>');
				businessFileImgList.append('<span class="cleraIMG" onclick="clearImg(this)"></span>');
        console.log(businessFileImgList);

			}else if(businessFileImgList.length==0){
				var closeImg = '<div class="shopImg businessFileImgList"><span class="cleraIMG" onclick="clearImg(this)"></span><img src="'+this.result+'" alt=""/></div>'
				// console.log(_this);
				$(_this).before(closeImg);
         // $(_this).next().hide();
				console.log("其他上传");
			}
		
		} 
	}
}

function clearImg(_this){
	var $this=$(_this);
	var shopImg = $this.parent().parent().children();
	var indexs=shopImg.index($this.parent());
  if($(_this).parent().siblings('input').prop('multiple')){
    if($(_this).parent().siblings('.shopImg').length<5){
      $(_this).parent().siblings('input').next().show();
    }
  }else{
     $(_this).parent().siblings('input').next().show();
  }
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


function jeDateTime(_this,status){
        var start = {
            format: 'YYYY-MM-DD hh:mm:ss',
            minDate: $.nowDate(0), //设定最小日期为当前日期
            festival:true,
            //isinitVal:true,
           // maxDate: $.nowDate(0), //最大日期
            choosefun: function(elem,datas){
               checkData(elem);
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
              start.maxDate = datas; //将结束日的初始值设定为开始日的最大日期
              checkData(elem);
          }
      };
      (status==start)? $.jeDate(_this,start):$(_this).jeDate(end);
      
 }



/*function checkData(className,callback){
   var verifyF = new Object();
   // var className=$(arguments[0]);
   verifyF.eType = new Object();
   //错误提示图
   var entError ="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAACh0lEQVRYhe2XP2gUQRTGp9h5c3hXXBMIkvl2C4uI6WJlUigEsbBIITGF/xo7kRTBStDOIo2SRkgTsLBIIdhESXFCGkHkirg7b3LIIRbBQgQPbA48i3NDvP03uxcr/eCV7/2+nX1v9q0Q/5UiC2+eQVusZcv4arUdiGbZGu1ANCOoFQu5wz69iFBbcEo0vrrDoD6DBkfigLU86/wAAU0z6GCkxiCCWnGBDzKiZ+HNF8KHp5eAF5oIQUsW8kuOgQGDPjJoKQu+D3XZgj7k1vDpu4G8mXTu0/MCeBzvO1pdHM1neHMMtetY41XCQInkgQV1wqA+eXh6E6LBoD3XfAZ1EwaMr1ZLFBgw6F04IRotITz2abtMrtVyPWGgHYhmXvNkvM9tC7VR0ngvnFKnUpvIalq0oLBkQecwmj5ZyOtZTTw0MRyj3l8w0GfQlVx4rEjTVQa1jwtuQZGFvOEEj8VT6hL76s3Yx+7T20jTYil4LON75xj0cgwDr9mvXagEj9UBnWHQswrwLQM5OxY81u8R/VZq1I5cVGOpG4gmQz2t0Hib3eMwYUCPqveAfNwKRK0ynEH3GPRzrCkAPagEt5C3GfT1GO6BHwx1tyTc+Tb8zG5fwb7zSpa1TqVEOwzqk+GEaFjIHZfJiDTN5MIN5KxxKGZBm/s+nY7zWJ84yZBPik2oXYY3lwpvCeGxlq1iuNpoCeGlPwA9dDiJvW7aZBQspMPw6X7RKzRa3uLkVv1naFpLJBZsNX0GXSuCx4pQWyhoYpNIymmknpnyzrvCD01omslp5qSBSNNi2pjZgKbLwmOFQX0ybUwjTctZrpcZtGdBHavlepVfslF1A1FjTWsMMgwymfB/Vr8A/Bj58bnXojcAAAAASUVORK5CYII="
   //正确提示图
   var entProper="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAgCAYAAAB+ZAqzAAACpUlEQVRYhc3Xz2sTURAH8Dl4EKyo2DTZeVFjKcn77qY/0KtIL6JIEQ/9B0SQInj3oBS1FMVDEQ8W/P0DRHqWohV7KHjxJhR/9FAQb4IWkzZ58wrPQ01ba5LdpGniwDvO8Jnd2Xks0X8QMRe0sfi3WTDPFlOxfJBotYli+SDBgvcscOvO85ai2KQ1C+Y3oBxbPdkyVKKg+1mQ+wclcKqoB1qCYvEvsMG3cig2uN50UMqltrPRw2yxWB6ln8VdT0dTUftchln0rbIggVMW0yw41FRU3CCrDJ5WQrFgjovBqaaiPIujnsHLKqgCC843FcUGp9niXRWUU0aPhhZSBpc8wbSyGIu5oG0zKFXUA5XWwdq+whS5/m0h3emLGxJn6sUp8YdYYKuiBHPs0u3VC7mglwWzG5M9wWOvgANRQZ2uc5cyepQFyyGoz5GWKBvcqFLkXnIprcJqxAuZg57gTgjIsWBRiT8UjrLBERZ8rTqgosc78tl4pRqe6MMseBEB5TyLa6GoFZi+Ga2gP1FuUFcuYv9jlBps9WTosK92a/2JSEUFjsV/WOZpf4+YP5dyfbsjoYiIvGJwIjoMTlmMEREpkxn8sxyj5OXiBtnIqLXOo73OdWempmZMZrBmFBFRItcVU4InNeKiHetfqQtVCuWCPhb/bYNh91M/a5irirhlPcCCLw1BGbyqa64q4lauk6VNomY9q483DFUKz2KkXpSyWGDB2YajiIjUL72XBY/qG3Y9vCWoVZyke1nwpkbY3XaX2bmlMCKi5DJOsuBTtLnSk57JYstRpfBEn2NBPgT2gS2ONQ1VCra4Wnmm8IPFP9N0FBHR/oXuPSz6Qdmv0OByS1ClSBrdzRav/0KJPx53PTtaCiMiShaDLk8wzYKcZ/2Jzf6wVIvfvPXPZoOCSwQAAAAASUVORK5CYII="
   //按表格元素不同而验证和其他方法
   verifyF={
    "Input":function(_this){
         var $this=$(_this);
         var inputType=$this.prop('type');
         //var inputEnter=$this.not($('[type="file"]'))
         var inputText=$this.val().trim();
         var ItRequired=$this.prop('required');
         var isNull=true;
         if(ItRequired){//判断是否必填
            if(inputType!="file" && inputType!="button" && inputType!="submit"){
                verifyF.notNull($this);
             }
          }
         if(typeof($($this).attr('minlength'))!='undefined'){//判断是否有最小长度限制
              var minLength=parseInt($($this).attr('minlength'));
              if(!(inputText.length>=minLength)){
                 verifyF.Disabled($this);
                 verifyF.entProper($this,"Error");
                 //verifyF.errorText($this,"min");
                 isNull=false;
              }
          }
        if(typeof($($this).attr('maxlength'))!='undefined'){//判断是否有最大长度限制,将自动截取
            var maxlengths=parseInt($($this).prop('maxlength'));
            inputText=$this.val().slice(0,maxlengths);
            $($this).val(inputText);
        }
       
        
        if(isNull){
         switch(inputType){
            case "text":
              if($($this).hasClass('accountlogin')){
                var patrn =/^(?![a-zA-Z]+$)(?!\D+$).{5,16}$/;
                (patrn.exec(inputText))? verifyF.entProper($this,"Proper"):verifyF.entProper($this,"Error");
              };
                if($($this).hasClass('goHref')){
                var isHttp= $this.val().slice(0,4)
                (isHttp=="http")? verifyF.entProper($this,"Proper"):verifyF.entProper($this,"Error");
              };
            break;
            case "file":
             
                if($($this).siblings('.businessFileImgList').length!=0){
                   verifyF.entProper($this,"Proper");
                   verifyF.remveDisabled($this);
               }else{
                   verifyF.entProper($this,"Error");
                   verifyF.Disabled($this);
               }

               if($($this).siblings('.fileImgMore').children('.businessFileImgList').length!=0){
                   verifyF.entProper($this,"Proper");
                   verifyF.remveDisabled($this);
               }else{
                  verifyF.entProper($this,"Error");
                  verifyF.Disabled($this);
               } 
            break;
            case "password":
              var patrn=/^(?=[`~!@#\$%\^&*\(\)\-_=\+\\\|\[\]\{\}:;\"\',.<>\/\?\d]*[a-zA-Z]+)(?=[a-zA-Z`~!@#\$%\^&*\(\)\-_=\+\\\|\[\]\{\}:;\"\',.<>\/\?]*\d+)[`~!@#\$%\^&*\(\)\-_=\+\\\|\[\]\{\}:;\"\',.<>\/\?\w]{5,14}$/;  
              var pawS=(patrn.exec($this.val().trim()))?  verifyF.entProper($this,"Proper"):verifyF.entProper($this,"Error")
              if($($this).hasClass("rePaw")){
                 var rePawVal =$this.val().trim();
                 var password =$this.parent().parent().find('input.Password').val().trim();
                 (rePawVal===password)? verifyF.entProper($this,"Proper"):verifyF.entProper($this,"Error");
              }
              verifyF.notNull($this);
            break;
            case "email":
              var patrn= /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
              (patrn.exec($this.val().trim()))? verifyF.entProper($this,"Proper"):verifyF.entProper($this,"Error");
            break;
            case "tel" :
              var patrn = /^1[34578]\d{9}$/;
              (patrn.exec($this.val().trim()))? verifyF.entProper($this,"Proper"):verifyF.entProper($this,"Error");
            break;
         };
        };
    },
    "Textarea":function(_this){
      var $this=$(_this);
          verifyF.notNull($this);
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
       var eStatus =(status=="Error")? entError:entProper;
       var eStatus1 =(status=="Error")? "entError":"entProper";
       $($this).siblings('b').children('img').remove();
       $($this).siblings('b').prepend("<img class='"+eStatus1+"'  style='width:20px;height:20px;margin-left:5px;vertical-align: middle;' src='"+eStatus+"' alt='' />");
    },
    "Alert":function(alertContents){//错误弹框
        Alert(alertContents,"温馨提醒");
    },

  }
    verifyF.eType=function (element){//判断元素的类型
      var element=$(element);
    
      for(e in element){
        switch(element[e].localName){
             case 'input':
               verifyF.Input(element[e]);
             break;
             case 'textarea':
                verifyF.Textarea(element[e]);
             break;
             case 'select':
                 verifyF.Select(element[e]);
             break;
        } 
      }
    }
    if(arguments.length===1){
         verifyF.eType(className)
    }
    if(arguments.length===2){//如果传入的是两个参数，则为提交验证表格数据是否正确
        var requiredElemt=$(className).find('[required="required"]');
        var cStatus=false;
        var cStatus1 = false;
        var entErrorNum=$('.entError').length;
       
        //判断是否有错误填写
        if(entErrorNum>0){
             verifyF.Alert("资料还不完善哦！请仔细检查~~");
        }else{
             verifyF.eType(requiredElemt)
        }
        var entProperNum=$('.entProper').length;
        console.info(entProperNum);
        console.info(requiredElemt.length);
        cStatus1=(entProperNum===requiredElemt.length || entProperNum>requiredElemt.length)? true : false;//如果正确图片等于required属性的个数就返回true。提交数据
         
        if(cStatus1){
               cStatus=(entErrorNum===0)? true : false;
        }
         
        callback(cStatus);//回调函数，回参是否提交
    };
}*/
var vueMethods={
  addPropertyTemp:function(event){
    var propertynum=document.getElementsByClassName('property').length
    this.lengths.push("attr"+propertynum);
  },
  myTitile:function(event){
    $("[title]").each(function(b) {//这里是控制标签
        if (this.title) {
            var c = this.title; //把title的赋给自定义属性 myTilte ，屏蔽自带提示
            var a = -16; //设置提示框相对于偏移位置，防止遮挡鼠标
            var e = 30; //设置提示框相对于偏移位置，防止遮挡鼠标
            $(this).mouseover(function(d) { //鼠标移上事件
                this.title = "";
                $("body").append('<div id="tooltip">' + c + "</div>"); //创建提示框,添加到页面中
                $("#tooltip").css({
                    left: (d.pageX) + "px",
                    top: (d.pageY+e) + "px",
                    opacity: "0.8"
                }).show(250) //设置提示框的坐标，并显示
                console.log(d.pageY+e);
            }).mouseout(function() { //鼠标移出事件
                this.title = c; //重新设置title
                $("#tooltip").remove() //移除弹出框
            }).mousemove(function(d) { //跟随鼠标移动事件
                $("#tooltip").css({
                    left: (d.pageX + a) + "px",
                    top: (d.pageY+e) + "px"
                })
            })
        }
    });
  },
  maxLength:function(){
    $('.countLength').remove();
    $('[maxlength]').each(function(index,elem){
      var $this=$(elem),
          pleft=$this.position().left+($this[0].clientWidth)+10;
      var maxlength=$this.attr('maxlength');
        countLength(this,pleft);
        $(this).on('input propertychange',function(){
          if($(this).val().length>maxlength){
            var newVal=$this.val($this.val().substring(0,maxlength-1));
          }
          $(this).siblings('.countLength').children('.valLength').text($(this).val().length);
         
        });
    });
    function countLength(_this,pleft){
      var $this=$(_this);
      var pleft=pleft;
      var Maxlength=$this.attr('maxlength');
      var vallength=$this.val().length;
      var Html='<p class="countLength" style="position:absolute;left:'+pleft
        +'px;top:'+(_this.clientHeight/2-5)
        +'px;width:10px;height:10px;color:#919191"><span class="valLength">'+vallength+"</span>/"+Maxlength
        +'</p>'

      $this.after(Html  )
    }
  },
  checkData:function(classname,callback){
    //只检查是否为空
    var $this=$(classname);
    return ($this.val().trim().length===0)? true:false;
  },
  closeAlert:function(){
   
    $(".kbVipAdmin_alert").fadeOut();
    // $(".kbVipAdmin_alert  .kbVipAdmin_operating input[type='reset']").on('click',function(){
        
    // });
  },

}/* vueMethods end */
function jsAjaxControl(_this,parameters,callback){
     
    var ID = $(_this).parents('tr').children().eq(0).text().trim();
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
    if(arr>1){
      for( def in defaults){
        if(typeof parameters[def]==="string"){
            defaults[def]=parameters[def];
        }else if (typeof parameters[def] === 'object') {
            for (var deepDef in parameters[def]) {
               /*  if (typeof defaults[def][deepDef] === 'undefined') {
                     defaults[def][deepDef]=parameters[def][deepDef];
                } */
                 defaults[def][deepDef]=parameters[def][deepDef];
            }
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
      case 'Confirm'://需要确认用的分支
       Alert('你确定要进行该操作该吗？',function(ren){
          console.log(ren);
          if(ren){

            $.get(defaults.ajaxURL,defaults.params,function(res){
                console.log(res);
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

function userAreaSltChild(_this,ajaxUrl){
    var $this = $(_this);
    var options=$this.children('option:selected');
    var optionsVal=options.val();
    var ajaxUrl=ajaxUrl;
      $('select[name=business_id]').children().not('option[value=-1]').remove();//区域选择有变动时，清除行业选择内容
      $this.siblings('select').removeAttr('name');//区域有变动时，清除区的name值
     jsAjaxControl(options,{
        ajaxURL:ajaxUrl,
        ajaxBranch:'Common',
        params:{
            id:optionsVal,
            flag:'selNextRegionInfo',
        }
    },function(res){
       $this.nextAll('select').remove();
       if(res.region.length){
          var sltText="<select required='required'><option value='-1' >请选择</option>"
          for(r in res.region ){
            var opText="<option value='"+res.region[r].id+"'>"+res.region[r].region_name+"</option>";
            sltText+=opText;
          }
          sltText+="</select>";
          $($this).after(sltText);
          $($this).next('select').on('change',function(){
            userAreaSltChild(this,ajaxUrl);
          });
       }else{
          $this.prop('name',"region_id");
          for(a in res.business){
              console.log(res.business[a]);
              $('.userTradeSlt select[name="business_id"]').append("<option value='"+res.business[a].id+"'>"+res.business[a].business_name+"</option>");
          }
          
       };
       
    });
    
}
/* 第三方组件 */
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
/*
*CheckData 数据检验函数;
*version 1.0;
*create data 20170803 16:46;
*auto dlhunter;
*e-mail:dlhunter@qq.cn
*company:kuangbang
* data-dataType= input/select;//需验证的输入框标志
* data-errmsg= "";//错误提示
* data-regexp="";//拓展验证的函数名存放处
*var checkData=new CheckData(string);//传入表单父元素，可传class、id、元素本身。但必须唯一。
*checkData.verify();//全表单验证。
*/
  function CheckData(_this){
    var self,$this;
    self=this;
    $this=$(_this);
    this.parents=$this;
    if($this.find('[data-datatype=input]').length==0 && $this.find('[data-datatype=select]').length==0){
      console.error("not found [data-datatype]");
      return false;
    }
    $this.find('[data-datatype=input]').on('blur',function(){
      self.input(this);
    });
    
    $this.find('[data-datatype=select]').on('change',function(){
      self.select(this);
    })
  };
  CheckData.prototype.isVerify={
      default:function(_this){
        var $this,isNull,isLength,Length,status;
        $this=$(_this);
        isNull= $this.prop("required");
        Length=$this.val().length;
        if(Length>0){
          if($this.attr('minlength')>Length){
            return  "minlength";
        }else if($this.attr('maxlength')<Length){
          return "maxlength";
        }else{
          return true;
        }
        }else{
          return  $this.prop("required")?'isNull':true;
        }
    }
  }
  CheckData.prototype.input=function(_this){
    var $this,status;
      $this=$(_this);
      status=this.isVerify.default($this);
    
      if(status=="maxlength"){
          $this.val(content.substring(0,$this.attr('maxlength')))
          return false;
      }else if(status=="minlength"){
          $this.attr("data-errmsg","输入的内容长度不够");
          this.errController($this,false)
          return false;
      }else if(status=="isNull"){
        $this.attr("data-errmsg","这里不能为空");
        this.errController($this,false)
        return false;
      }else{
        this.errController($this,true)
        return true;
      }
    
  }
  CheckData.prototype.select=function(_this){
    var $this,contnet;
    $this=$(_this);
    contnet=$this.val();
    if($this.prop('required')){
      if(contnet=="-1"){
        $this.attr("data-errmsg","还没进行选择");
        this.errController($this,false)
        return false;
      }else{
        this.errController($this,true)
        return true;
      }
    }else{
      this.errController($this,true)
      return true;  
    }
  }
  CheckData.prototype.errController=function(params,status){
    param=new Array();
    Array.isArray(params)?param=params:param.push(params);
    if(!status){
      param.map(function(elems,indexs){
        $(elems).attr('title',$(elems).attr('data-errmsg'));
        $(elems).css({
          outline:"10px",
          color:"red",
          "border-color":"red",
          "box-shadow":"2px 2px 20px 0 red"
        });
      });
      // vueMethods.myTitile(); 
    }else{
      param.map(function(elems,indexs){
        $(elems).removeAttr('style');
        $(elems).removeAttr('data-errmsg');
        $(elems).removeAttr('title');
      })

    }
  }
  CheckData.prototype.verify=function(){
    dlLoading('数据校验中...');
    var $this,dataType,self,verifyData,isSubmit,elem,status;
    //首先通过default检验；
    //自定义检验
    isSubmit=new Array();
    $this=$(this.parents);
    self=this;
    verifyData=$this.find('[data-dataType]');
    var r;
    for(r=0;r<=verifyData.length;r++){
      elem=verifyData.eq(r);
      if(r==verifyData.length){
        status=isSubmit.length===0?true:false;
        this.errController(isSubmit,status) ;
        loadsuccess(); 
        return status;
      }else{
        dataType=$(elem).attr('data-dataType');
        if(dataType=='input'){
          //基本验证是否必填。
          if(self.input(elem)){
            //不是必选，又有正则.则需有值；
            if($(elem).val().length>0 && $(elem).attr('data-regexp')){
              if(!self.isVerify[$(elem).attr('data-regexp')](elem)){
                isSubmit.push(elem);
              };
            };
          }else{
            isSubmit.push(elem);
          };
        }else if(dataType=='select'){
          if(!self.select(elem)){
            isSubmit.push(elem);
          };
        }
      }
    }
  }

function dlLoading(content,callback){
  var Html,lcontent,status;
  lcontent=content?content:"数据加载中...";
  console.log()
  Html='<div class="dl_loading">'+
       '<div class="dl_loading-cell">'+
       '<p class="dl_loading-icon"></p>'+
       '<p class="dl_loading-info">'+lcontent+'</p>'+
       '</div></div>';
  $('#Main').length?$('#Main').append(Html):$('body').append(Html);
  $('.dl_loading').fadeIn();
  status=callback?true:false;
  console.log(status);
  if(!status) return false;
  setTimeout(function(){
    callback();
  },500);
}
function loadsuccess(){
  $('.dl_loading').fadeOut();
  $('.dl_loading').remove();
}