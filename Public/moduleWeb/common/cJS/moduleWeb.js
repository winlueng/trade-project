function localRecord(ClassIndex,callback){
	var a="."+ClassIndex;
	var strMenuKey = ClassIndex, eleLeftMenuTit = $(a).children('a');
	var funStoreDisplay = function() {
		var arrDisplay = [];
		eleLeftMenuTit.each(function(index, title) {
			console.log($(title).hasClass("selected"));
			console.log(index);
			arrDisplay[index] = $(title).hasClass("selected")==true? 1:0;	
		});	
		//存储，IE6~7 cookie 其他浏览器	HTML5本地存储
		if (window.sessionStorage) {
			sessionStorage.setItem(strMenuKey, arrDisplay);	
		} else {
			Cookie.write(strMenuKey, arrDisplay);	
		}
	};

	eleLeftMenuTit.on('click',function(){
		funStoreDisplay();
	})
	var strStoreDate = window.sessionStorage? sessionStorage.getItem(strMenuKey): Cookie.read(strMenuKey);	
	// console.log(strStoreDate);
		if (strStoreDate) {
			$.each(strStoreDate.split(","),function(index,display) {
				if (display>>>0=== 1) {
					if(eleLeftMenuTit[index]){
						callback($(eleLeftMenuTit[index]));
					}else{
						callback(false);
					}
				}
			});	
		}else{
			callback(true);
		}
}
/* function GetRequest() { 
		var url = location.search; //获取url中"?"符后的字串 
		var theRequest = new Object(); 
		if (url.indexOf("?") != -1) { 
		var str = url.substr(1); 
		strs = str.split("&"); 
		for(var i = 0; i < strs.length; i ++) { 
			theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]); 
			} 
		} 
		console.log(theRequest);
		return theRequest; 
} */