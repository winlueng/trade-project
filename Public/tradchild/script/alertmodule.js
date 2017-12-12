function oTip(content){
	// var content=JSON.stringify(content);
	var params={
		content:content
	}
	var Tip=new AlertCom(params);
		Tip.prompt();
};
function Alert(content,callback){
	if(Object.prototype.toString.call(arguments[0])=== '[object Object]'){
		console.error("首参数类型不能为对象");
	}else if(Object.prototype.toString.call(arguments[0])=== '[object Function]'){
		console.error("首参数类型不能为函数");
	}else{
	    var paramsArr=blooemParams(arguments);
	    var params=paramsArr
	}
	var newAlert=new AlertCom(params,'alert');
		newAlert.againAlert(function(res){
			(params.callback)? params.callback(res):'callback';
		});

};
function Confirm(content,callback){
	if(Object.prototype.toString.call(arguments[0])=== '[object Object]'){
		console.error("首参数类型不能为对象");
	}else if(Object.prototype.toString.call(arguments[0])=== '[object Function]'){
		console.error("首参数类型不能为函数");
	}else{
	    var paramsArr=blooemParams(arguments);
	    var params=paramsArr
	}
	var newAlert=new AlertCom(params,'Confrim');
		newAlert.againAlert(function(res){
			(params.callback)? params.callback(res):'callback';
		});
};

function blooemParams(params){
	var newparams=new Object();
	switch(params.length){
		case 1:
			return params={
				content:params[0]
			};
		break;
		case 2:
			if(Object.prototype.toString.call(params[1])=== '[object Function]'){
				params.content=params[0];
				params.callback=params[1]
			}else{
				params.content=params[0];
				params.title=params[1]
			}
		break;
		case 3:
			if(Object.prototype.toString.call(params[2])=== '[object Function]'){
				params.content=params[0];
				params.title=params[1]
				params.callback=params[2]
			}else{
				params.content=params[0];
				params.title=params[1]
				params.resultBtnTrue=params[2]
			}
		break;
		case 4:
			if(Object.prototype.toString.call(params[3])=== '[object Function]'){
				params.content=params[0];
				params.title=params[1]
				params.resultBtnTrue=params[2]
				params.callback=params[3]
			}else{
				params.content=params[0];
				params.title=params[1]
				params.resultBtnTrue=params[2]
				params.resultBtnFalse=params[3]
			}
		break;
		case 5:
			params.content=params[0];
			params.title=params[1]
			params.resultBtnTrue=params[2]
			params.resultBtnFalse=params[3]
			params.callback=params[4]
		break;
		default:
			params.content="参数错误";
			console.error("参数错误");
		break;
	}
	return newparams=params;
};

function AlertCom(params,type){
	var type=(type)?type:'alert';

	this.params={
		content:"哎呀呀~~",
		type:type,
		resultBtnTrue:"确定",
		resultBtnFalse:"取消"
	};
	for(var r in params){
		if(this.params[r]!=params[r]){
			this.params[r]=params[r];
		}
	}
};

AlertCom.prototype.prompt=function(){
	var content=this.params.content;
		if(content.length>20){
			content=content.slice(0,19)+'...';
		}else{
			content=content
		}
		var promptHTML='<div class="coverAlert"></div>'
						+'<div class="promptAlert Alert-cell">'			
							+'<p>'+content+'</p>'
						+'</div>';
	var Timestamp=new Date().getTime();
	
	var promptAlert=document.createElement('div');
			promptAlert.id='promptAlert'+Timestamp;
			promptAlert.className="Alert-cells";
	var BodyHtml=document.getElementsByTagName('body');
		BodyHtml[0].insertBefore(promptAlert,BodyHtml[0].lastElementChild);
	var prompt=document.getElementById('promptAlert'+Timestamp);
		prompt.innerHTML=promptHTML;
		prompt.style.display='block';
		prompt.style.opacity=1;
	setTimeout(function(){
		BodyHtml[0].removeChild(prompt);
	},2000)
	// console.log(document.getElementsTag('body').lastChild)
}
AlertCom.prototype.againAlert=function(callback){
	var self=this.params;
	var aTitle=(self.title)? self.title:'';
	var HTML='<div class="coverAlert coverblack"></div>'+
				'<div class="againAlert Alert-cell">'+
			  '<div class="Alert-hd">'+aTitle+'</div>'+		
			   '<div class="Alert-bd">';
					// <!-- <img src="./images/pic_160.png" alt=""> -->
		HTML+='<p class="Alert-bd-bd">'+self.content+'</p>';
		HTML+='</div>'+
			  '<div class="Alert-ft">';
		if(self.type=="Confrim"){
		    HTML+='<button type="button" class="Alert-ft-hd resultBtn resultBtn-false">'+self.resultBtnFalse+'</button>';
		}
	    HTML+='<button type="button" class="Alert-ft-hd resultBtn resultBtn-true">'+self.resultBtnTrue+'</button>'+
		      	'</div>'

	var Timestamp=new Date().getTime();
	var againAlert=document.createElement('div');
			againAlert.id='againAlert'+Timestamp;
			againAlert.className="Alert-cells";
	var BodyHtml=document.getElementsByTagName('body');
		BodyHtml[0].insertBefore(againAlert,BodyHtml[0].lastElementChild);
	var again=document.getElementById('againAlert'+Timestamp);
		again.innerHTML=HTML;
		again.style.display='block';
		again.style.opacity=1;
		// again.className+="show"
	var resultBtn=document.getElementsByClassName('resultBtn');
	
	Object.keys(resultBtn).map(function(elem){
		resultBtn[elem].addEventListener('click',function(){
			if(!event.target){ console.error("浏览器不支持event.target方法");return false;};
			var classArr=event.target.className.split(' ');
			if(classArr.indexOf('resultBtn-true')>0){
				callback(true)
			}
			if(classArr.indexOf('resultBtn-false')>0){
				callback(false);
			}
			setTimeout(function(){

				BodyHtml[0].removeChild(again);
			},800)
		})
	
	})

}