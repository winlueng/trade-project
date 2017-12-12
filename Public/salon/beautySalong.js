$(function(){
	$('.bsAlert .alertClose,.bsAlert .cancel').on('click',function(){
		$('.bsAlert').fadeOut();
	})
})

/* readFile(this,this.files); */
function readFile(a,e){ 
	var _this=a;
	var files = e; 
	//console.log(file);
	//这里我们判断下类型如果不是图片就返回 去掉就可以上传任意文件 
	// if(!/image\/\w+/.test(file.type)){ 
	// 	alert("请确保文件为图像类型"); 
	// return false; 
	// } 
	console.log(files);
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