/*crate date:20170113
*version:2.1;
*author:dlhunter;
*插件制作时引用的jquery 1.8.0版本的；
**若要修改背景模板的透明度，请修改dlalert.css里面的#dlAlert::before下opacity
*/
var dlhunter={};
dlhunter.Function={};
/*the animation definition*/
//动画版
//出现
 function animationAlert (params,callback){
 	var className,condition;
	 var defaults={
	 		//此对象成员值为默认值
			headline:"温馨提醒",//标题
			alertContent:"信息因为网速太快出了车祸。请您稍后再试一次~~",//正文
			alertHide:"alertHide",//隐藏取消按钮的class,显示值为：alertShow
			act:"",//动画zoom、slide、rotate、bounce，默认为空，没有效果
			alertHref:undefined,//确定跳转的按钮链接
			determineClass:".determine",//确定跳转的按钮的Class,默认为第一个.determine。
			alertHref2:undefined,//取消按钮链接
			cancelClass:".cancel",//若绑定取消按钮，则为.cancel
			determineName:"确定",//第一个按钮的内容
			cancelName:"取消",//第二个按钮的内容
			alertBoxCanel:"alertShow",//隐藏的右上角取消按钮则值为alertHide,默认显示
			// new add 可提交表单和简易反馈
			alertTip:false,//简易反馈为true

			alertButton:false,//需提交表单则为true，并传入表单的id
			alertButtonID:"fromSubmit",//表单的id
			atnFunction:"a",

	}
	dlhunter.params = params || {};
	//console.log(dlhunter.params);
	for( def in defaults){
		if (typeof dlhunter.params[def] === 'undefined') {
		//将params 与 defaults通过对比。defaults对象里面才有的数值补充到params对象里面
        dlhunter.params[def] = defaults[def];
    }
    else if (typeof dlhunter.params[def] === 'object') {
        for (var deepDef in defaults[def]) {
            if (typeof dlhunter.params[def][deepDef] === 'undefined') {
                dlhunter.params[def][deepDef] = defaults[def][deepDef];
            }
        }
    }
	}
	//alert的Html
	//if($('#dlAlert').length===0){
		var timestamp = (new Date()).valueOf();
		var alertHTML='<div id="dlAlert'+timestamp+'" class="dlAlert">\
							<div class="dlAlert-box">\
								<span class="dlAlert-box-cancel'+' '+dlhunter.params.alertBoxCanel+'"></span>\
								<h1>'+dlhunter.params.headline+'</h1>\
								<div class="dlAlert-box-txt txtCenter">'+dlhunter.params.alertContent+'</div>'
								
		var alertInputCenter='<p class="dlAlert-box-input txtCenter">';
		var alertButton='<a  href="javascript:;" class="determine" >'+dlhunter.params.determineName+'</a>'
		if(dlhunter.params.alertButton){//当为true时重置为提交按钮
			alertButton='<input  onclick="$(\'#'+dlhunter.params.alertButtonID+'\').submit();" class="determine" type="submit" value="'+dlhunter.params.determineName+'"/>';
		}
		alertButton+='<a  href="javascript:;" class="cancel '+dlhunter.params.alertHide+'">'+dlhunter.params.cancelName+'</a></p>'
		alertInputCenter+=alertButton;
		if(!dlhunter.params.alertTip){
			alertHTML+=	alertInputCenter;
		}
		alertHTML+='</div></div>';

		$('body').append(alertHTML);
	//}

	dlhunter.dlAlert= $("#dlAlert"+timestamp);
	dlhunter.dlAlertBox=$(".dlAlert-box");
	dlhunter.dlAlertBoxInput=$(".dlAlert-box-input");

	

	className=dlhunter.params.determineClass;//第一个按钮的css名字
 	condition=dlhunter.params.alertHref;//第一个按钮的要绑定的链接
 	className2=dlhunter.params.cancelClass;//第二个按钮的css名字
 	condition2=dlhunter.params.alertHref2;//第二个按钮的要绑定的链接

 	//简易反馈弹框
	if(dlhunter.params.alertTip){
		$('.dlAlert-box-input').hide();
		dlhunter.dlAlert.fadeIn(1000,function(){
			dlhunter.dlAlertBox.removeClass(dlhunter.params.act+" "+"animated");
		})
		setTimeout(function(){
			animationAlertOut(dlhunter.params.act,timestamp);
		},2000);//简易提示消失的时间
		
	}
	
	//判断是否动画效果
	if(dlhunter.params.act!==''){
		dlhunter.dlAlertBox.addClass(dlhunter.params.act+"In"+" "+"animated");

		dlhunter.dlAlert.fadeIn(1000,function(){//1000，动画总共运行1秒
			dlhunter.dlAlertBox.removeClass(dlhunter.params.act+" "+"animated");
		});
		//绑定确定按钮效果
		dlhunter.dlAlertBoxInput.find(dlhunter.params.determineClass).on('click',function(){
			animationAlertOut(dlhunter.params.act,timestamp);

		})
		//绑定取消按钮消失效果
		dlhunter.dlAlertBoxInput.find(dlhunter.params.cancelClass).on('click',function(){
			animationAlertOut(dlhunter.params.act,timestamp);
		})
		//绑定消失效果
		$(".dlAlert-box-cancel").on('click',function(){
			animationAlertOut(dlhunter.params.act,timestamp);
		})
		//绑定跳转链接
		bhref(condition,className,condition2,className2,function(res){
			console.log(res)
		});

	}else{
		//基本效果
		dlalert(className,condition,timestamp);
	}
	if(arguments.length==2){
		$('.determine').on('click',function(){
			callback(true);
		})
		$('.cancel').on('click',function(){
			callback(false);
		})
	}

}
//简单反馈
// function operatingTip(){

// }
/* function aa(d,e,f){
	var d=d;
	var e=e;
	var f=f;
	console.log(e+d+f);
} */

// console.log(dlhunter.Function.atnFunction)
//基本确定

//带取消的弹窗

/* var a=new aa(1,2,3);
console.log(typeof a);
var g=new aa(4,5,6);
console.log(typeof g);
var n=new aa(7,8,9);
console.log(typeof n); */
//动画效果消失
function animationAlertOut(act,timestamp){
	var act=act;
	var timestamp=timestamp;
	dlhunter.dlAlertBox.addClass(dlhunter.params.act+"Out"+" "+"animated");
	dlhunter.dlAlert.fadeOut(500,function(){//500，动画总共运行0.5秒
		dlhunter.dlAlertBox.removeClass(dlhunter.params.act+"Out"+" "+"animated");
		setTimeout(function(){
				$("#dlAlert"+timestamp).remove();
		},1000);
		
	});
}
//基本版
function dlalert(className,condition,timestamp){
		dlhunter.dlAlert.fadeIn();
		var condition=condition;
		var className=className;
		var timestamp=timestamp;
		dlhunter.dlAlertBoxInput.find("a").on('click',function(){
			dlhunter.dlAlert.fadeOut();
			setTimeout(function(){
				$("#dlAlert"+timestamp).remove();
			},1000);
			
		})
		$(".dlAlert-box-cancel").on('click',function(){
			dlhunter.dlAlert.fadeOut();
			$("#dlAlert"+timestamp).remove();
		})
		bhref(condition,className,condition2,className2);
}


//绑定跳转链接的按钮
function bhref(condition,className,condition2,className2){
	var className=className;
	var condition=condition;
	var className2=className2;
	var condition2=condition2;
	var returnData;
	if(condition!==undefined){
		dlhunter.dlAlert.find(className).on('click',function(){
			goJump(this,condition);
		})
	}else{
		returnData=0;
	}
	if(condition2!==undefined){
		dlhunter.dlAlert.find(className2).on('click',function(){
			goJump(this,condition2);
		})
	}else{
		 returnData=1;
	}
	return returnData;
}
//跳转链接
function goJump(athis,condition1){
	var _this = $(athis);
	if(condition1!==""){
		_this.attr("href",condition1)//动画总共运行1秒后再确定跳转网页，
	}
	
	//window.location.href=condition1;
}

