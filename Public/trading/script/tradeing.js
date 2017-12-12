 /*
*CheckData 数据检验函数;
*version 1.0;
*create data 20170803 16:46;
*auto dlhunter;
*e-mail:dlhunter@qq.cn
*company:kuangbang
* data-datatype= input/select;//需验证的输入框标志
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