window.onload=function(){
	//按比例设定图片父元素的高度。让图片按宽高比例缩放
	//获取父元素宽除以比例，得父元素实际高度

	var dlImgAdaptive=new Object();
	dlImgAdaptive.Function=function(){
		/* 产品图 */
		dlImgAdaptive.banner =new Object();
		dlImgAdaptive.goods =new Object();

		if($('.kbMt_goodsBrief').length){
			var Parents=$('.kbMt_goodsBrief').parents('.goodsClassList-box').find('.nowShow')
			if(Parents.length){
				dlImgAdaptive.goods.height=Parents.find('.kbMt_goodsBrief').width()/1.806282723;
			}else{
				dlImgAdaptive.goods.height=$('.kbMt_goodsBrief').width()/1.806282723;
			}
			$('.kbMt_goodsBrief').css("height",dlImgAdaptive.goods.height+"px");
	  		 // console.log($('.kbMt_goodsBrief').height());
		}
		
  		/* banner图 */
  		if($('.kbMt_banner').length){
  			console.log("banner宽度"+$('.kbMt_banner').width())
  			dlImgAdaptive.banner.height=$('.kbMt_banner').width()/1.875;
  			$('.kbMt_banner').css("height",dlImgAdaptive.banner.height+"px");
  			console.log($('.kbMt_banner').height());
  		}
  		
  		
	}
	$(window).resize(function(){//当屏幕发生变化时
		 dlImgAdaptive.Function();
	});
		dlImgAdaptive.Function();



	var tlocal=function (){
		//new dlImgAdaptive.Function();
		console.log("开始记录")

		if(strStoreDate){
			$('#kbMt_center').css("visibility","hidden");
		}else{
			$('.goodsClassMenu a:eq(0)').addClass('goodsClassIndex');
			$('.goodsClassList-box ul:eq(0)').css('display','block').addClass("nowShow");
			dlImgAdaptive.Function();
		}

		var strMenuKey = "goodsClassIndex", eleLeftMenuTit = $(".goodsClassMenu a");
		var funStoreDisplay = function() {
			var arrDisplay = [];

			eleLeftMenuTit.each(function(index, title) {
				arrDisplay[index] = $(title).hasClass("goodsClassIndex")==true? 1:0;	
			});	
			//存储，IE6~7 cookie 其他浏览器	HTML5本地存储
			if (window.sessionStorage) {
				sessionStorage.setItem(strMenuKey, arrDisplay);	
			} else {
				Cookie.write(strMenuKey, arrDisplay);	
			}
		};

		var goodsClassMenu =$('.goodsClassMenu a');
		var goodsClassListBox = $('.goodsClassList-box .goodsClassList');

		eleLeftMenuTit.on("click", function() {
			var $this = $(this);
			var indexs = goodsClassMenu.index($this);
			$this.addClass('goodsClassIndex')
			$this.siblings().removeClass('goodsClassIndex');

			if (goodsClassListBox.length) {
				$(goodsClassListBox[indexs]).fadeIn().addClass('nowShow');
				$(goodsClassListBox[indexs]).siblings().fadeOut().removeClass('nowShow');
				//存储
				funStoreDisplay();
				dlImgAdaptive.Function();
			}
			// return false;
		});
		var strStoreDate = window.sessionStorage? sessionStorage.getItem(strMenuKey): Cookie.read(strMenuKey);	
		if (strStoreDate) {
			$.each(strStoreDate.split(","),function(index,display) {
				if (display>>>0=== 1) {
					if($(eleLeftMenuTit[index]).length){
						$(eleLeftMenuTit[index]).addClass('goodsClassIndex');
						$(eleLeftMenuTit[index]).siblings().removeClass('goodsClassIndex');
						$(goodsClassListBox[index]).show().addClass('nowShow');;
						$(goodsClassListBox[index]).siblings().hide().removeClass('nowShow');
						dlImgAdaptive.Function();
					}else{
						$('.goodsClassMenu a:eq(0)').addClass('goodsClassIndex');
						$('.goodsClassList-box ul:eq(0)').css('display','block').addClass("nowShow");
						dlImgAdaptive.Function();
					}
				}
			});	
			
		}
		
		
		// $("#kbMt_center").css("visibility","visible");
	}
	//if($('.goodsClassMenu a').length) tlocal();
}
