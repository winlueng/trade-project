/*crate date:20170405
*version:3.3;
*author:dlhunter;
*插件制作时引用的jquery 1.8.0版本的；
**若要修改背景模板的透明度，请修改dlalert.css里面的#dlAlert::before下opacity
*/ 
function Alert(){
	var argumentsDate=arguments;
	var defaultsCom=dateCom('alert',argumentsDate);
	dlalert(defaultsCom.defaults,function(res){
	 	if($.isFunction(defaultsCom.callback)) defaultsCom.callback(res);
	})

}
/*
 *Confirm(内容)
 *Confirm(内容，callback)，
 *Confirm(标题，内容，callback)，
 *Confirm(标题，内容，第一按钮内容，callback)
 *Confirm(标题，内容，按钮内容，第二按钮内容，callback)
 */

function Confirm(){
	var argumentsDate=arguments;
	var defaultsCom=dateCom('confirm',argumentsDate);
	return dlalert(defaultsCom.defaults,function(res){
		if($.isFunction(defaultsCom.callback)) defaultsCom.callback(res);
	});
	console.log(a);
}
/* 提示 */
function oTip(){
	var headLine,Content,oTip,oTipShow;
	switch(arguments.length){
		case 1:
			Content=arguments[0];
		break;
		case 2:
			Content=arguments[0];
			headLine=arguments[1];
		break;
		case 3:
			Content=arguments[0];
			headLine=arguments[1];
			console.log(typeof arguments[2]=== 'number');
			(typeof arguments[2] === 'number')?oTip= arguments[2] : oTipShow = arguments[2];
			
		break;
		default:
			console.error("参数错误");
			return;
	}
	var defaults={
 		//此对象成员值为默认值
		headLine:headLine,//标题
		Content:Content,//正文
		oTip:oTip,//正文
		oTipShow:oTipShow,//正文
	}
	dlalert(defaults);
}
/* 提示成功 */
function sTip(Content){
	var Content=(Content)? Content:'操作成功';
	var defaults={
 		//此对象成员值为默认值
		Content:Content,//正文
		//oTip:oTip,//正文
		Act:'',
		oTip:2000,
		oTipShow:false,//正文
		backResult:true,
		tipType:'success',
	}
	// console.log(defaults);
	dlalert(defaults);
}
/* 提示失败 */
function eTip(Content){
	var Content=(Content)? Content:'操作失败';
	var defaults={
 		//此对象成员值为默认值
		Content:Content,//正文
		Act:'',
		oTip:2000,
		oTipShow:false,//正文
		backResult:true,
		tipType:'error',
	}
	// console.log(defaults);
	dlalert(defaults);
}
function dateCom(Type,Data){
	var headLine,Content,oneBtnVal,twoBtnVal,callback;
	// console.log(Data.length);
	if(Type=='confirm') twoBtnVal="取消";
	switch(Data.length){
		case 1:
			Content=Data[0];
		break;
		case 2:
			Content=Data[0];
			($.isFunction(Data[1]))? callback=Data[1] : headLine=Data[1];
		break;
		case 3:
			Content=Data[0];
			headLine=Data[1];
			callback=Data[2];
		break;
		case 4:
			Content=Data[0];
			headLine=Data[1];
			oneBtnVal=Data[2];
			callback=Data[3];
		break;
		case 5:
			Content=Data[0];
			headLine=Data[1];
			oneBtnVal=Data[2];
			twoBtnVal=Data[3];
			callback=Data[4];
		break;
		default:
			console.error("参数错误");
			return;
	}

	var defaults={
 		//此对象成员值为默认值
		headLine:headLine,//标题
		Content:Content,//正文
		boxBtn:true,
		oneBtnVal:oneBtnVal,
		twoBtnVal:twoBtnVal,
	}
	var defaultsCom={
		defaults:defaults,
		callback:callback
	}
	return defaultsCom;
}

function dlalert (params,callback){
	// console.log(defaults);
	this.dlhunter=params;
 	var Alert=new Object();
	var defaults={
	 		//此对象成员值为默认值
			headLine:"温馨提醒",//标题
			Content:"信息因为网速太快出了车祸。请您稍后再试一次~~",//正文
			Animation:true,////
			Act:"bounce",//动画zoom、slide、rotate、bounce，为空，没有效果
			boxBtn:false,//是否有按钮。默认没有
			oneBtnVal:"确定",
			twoBtnVal:"",
			oneHref:"javascript:;",
			twoHref:"javascript:;",
			oTip:4000,//自动关闭的时间
			oTipShow:false,//是不自动关闭？默认自动关闭
			backResult:false,//简单提示结果
			tipType:'success',//简单提示结果类型 ，默认为成功
	}
	for( def in defaults){
		if (typeof this.dlhunter === 'undefined') {
			//将params 与 defaults通过对比。defaults对象里面才有的数值补充到params对象里面
			
       		this.dlhunter = defaults;
       		console.log(this.dlhunter);
       		// return;
   		}else{
	            if (typeof this.dlhunter[def] === 'undefined') {
	               this.dlhunter[def] = defaults[def];
            	}
    	}
	}
	//alert的Html
	// console.log(this.dlhunter.Content)
	var timestamp = (new Date()).valueOf();
	var alertHTML='<div id="dlAlert'+timestamp+'" class="dlAlert">';
		alertHTML+='<div class="dlAlert-bg"></div>';

		alertHTML+='<div class="dlAlert-box">';
		alertHTML+='<span class="dlAlert-box-cancel"></span>';
		alertHTML+='<h1>'+this.dlhunter.headLine+'</h1>'
		alertHTML+='<div class="dlAlert-box-txt txtCenter">'+this.dlhunter.Content+'</div>';
	if(this.dlhunter.boxBtn){
		var alertBTN='<p class="dlAlert-box-input txtCenter"><a href="'+this.dlhunter.oneHref+'" class="determine">'+this.dlhunter.oneBtnVal+'</a>';
		if(this.dlhunter.twoBtnVal.length){
			alertBTN+='<a href="'+this.dlhunter.twoHref+'" class="cancel">'+this.dlhunter.twoBtnVal+'</a>';
		}
		alertBTN+='</p>';	
		alertHTML+=alertBTN;
	}
	alertHTML+='</div>';

	alertHTML+='</div>';

	var ResultHtml='<div id="dlAlert'+timestamp+'" class="dlAlert">\
				  <div class="tip-result ">\
				 <div class="tip-line-'+this.dlhunter.tipType+'">\
				  <span></span><span></span></div>\
				  <p class="bc" style="width:88%;text-indent:54.5px;white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">'+this.dlhunter.Content+'</p></div></div>';

	this.dlhunter.html=(this.dlhunter.backResult) ? ResultHtml:alertHTML;

	$('body').append(this.dlhunter.html,function(){
		
	});

	
	Alert.ID= $("#dlAlert"+timestamp);
	if(this.dlhunter.backResult){
		setTimeout(function(){
				Alert.ID.find('.tip-result').addClass('is_active');
		},200)
	};
	Alert.dlAlertBox=$(".dlAlert-box");
	//判断是否动画效果
	Alert.Animation=this.dlhunter.Animation;
	Alert.Act=this.dlhunter.Act;

	if(Alert.Animation) Alert.dlAlertBox.addClass(Alert.Act+"In"+" "+"animated");
	Alert.ID.fadeIn(1000);


	$('.dlAlert-box-cancel').on('click',function(){alertHide()});

	// 判断是否需要confirm
	if(this.dlhunter.boxBtn){

		$('.determine').on('click',function(){
			alertHide();
			// return return true
			(typeof callback=='function')?  callback(true): 'callback';

		});
		$('.cancel').on('click',function(){
			alertHide();
			(typeof callback=='function')? callback(false) : 'callback';
		});
		
	}
	function alertHide(){
		if(this.dlhunter.Animation){
				Alert.dlAlertBox.removeClass(this.dlhunter.Act+"In");
				Alert.dlAlertBox.addClass(this.dlhunter.Act+"Out");
		}

		Alert.ID.fadeOut(500,function(){//500，动画总共运行0.5秒
			setTimeout(function(){
					Alert.ID.remove();
			},1000);
		});
	}
	if(!this.dlhunter.boxBtn){ 
		if(!this.dlhunter.oTipShow) setTimeout(function(){alertHide()},this.dlhunter.oTip);
	}
	
}
