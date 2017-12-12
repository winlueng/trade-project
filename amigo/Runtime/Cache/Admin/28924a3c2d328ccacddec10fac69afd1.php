<?php if (!defined('THINK_PATH')) exit(); $moduleList = showModuleList(); $navList = showNavList(); $ip = get_client_ip(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" />
	<title>管理后台</title>
	<!-- default end -->
<link rel="stylesheet" href="/Public/CSS/common.css">

<link rel="stylesheet" href="/Public/Portal/PortalJS/alert/companyalert.css?version=4">

<link rel="stylesheet" href="/Public/JS/module/jedate/skin/jedate.css"></link>
<link rel="stylesheet" href="/Public/Portal/PortalCSS/mbase.special.css"></link>
<link rel="stylesheet" href="/Public/Portal/PortalCSS/Portal.css">


<script type="text/javascript" src="/Public/JS/jquery-1.8.2.min.js"></script>


	
<style>
.kbVipAdmin_alert{
    z-index:999;
}
.dlAlert{
    z-index:1000;
}
.dl_goodsResult,.dl_goodsResult-title{
    width:68%;
}
.kbVipAdmin_form{
    height: 78%;
}
.dl_goodsResult{
    height: 80%;
    overflow-x: hidden;
}
.kbVipAdmin_videoInfo{
  width:159px;
  height:99px;
  border:1px solid #eee;
  padding-top:30px;
  padding-bottom:30px;
}
</style>
<?php  ?>

</head>
<body>
	<div id="kbVipAdmin_header" class="bg_main color_last kbVipAdmin_header">
		<h2>
			<span class="kbVipAdmin_logo mr10  imgH100">
				
			</span>
			<?php echo ($userInfo['market_name']); ?>后台管理系统
		</h2>
		<nav class="kbVipAdmin_header_nav ft">
		<?php if(is_array($moduleList)): foreach($moduleList as $key=>$v): ?><a class="<?php echo ($_GET['module']==$v['id']?'selected':''); ?>" href="<?php echo U('', ['module' => $v['id']]);?>"><?php echo ($v["module_name"]); ?></a><?php endforeach; endif; ?>
		</nav>
		<div class="header_Fun tr   h25 lh200 fr">
			<div class="kbVipAdmin_systemInfo">
				<a href="javascript:;"><img src="/Public/Business/BusinessImages/nav_icon_mail_default.svg" alt="系统消息" />
				<?php if(array_sum($orderConut) > 0): ?><strong class="redInfoCount"><?php echo array_sum($orderConut);?></strong><?php endif; ?>
				</a>
				<dl>
					<dt>系统消息</dt>
					<?php if($orderConut[0] > 0): ?><dd>
							<a href="<?php echo U('OrderForm/projectOrderList',['status' => 2,'module' => 5]);?>">	
								您有<?php echo ($orderConut[0]); ?>张新订单待处理,请前往处理
							</a>
						</dd><?php endif; ?>
					<?php if($orderConut[1] > 0): ?><dd>
							<a href="<?php echo U('SubscribeOrderForm/orderList',['status' => 1,'module' => 5]);?>">	
								您有<?php echo ($orderConut[1]); ?>张新预约订单待处理,请前往处理
							</a>
						</dd><?php endif; ?>
					<?php if($orderConut[2] > 0): ?><dd>
							<a href="<?php echo U('WechatRefund/orderListByProject',['status' => 1,'module' => 5]);?>">	
								您有<?php echo ($orderConut[2]); ?>张自营退款待处理,请前往处理
							</a>
						</dd><?php endif; ?>
					<?php if($orderConut[3] > 0): ?><dd>
							<a href="<?php echo U('WechatRefund/companyOrderListByProject',['status' => 1,'module' => 5]);?>">	
								您有<?php echo ($orderConut[3]); ?>张商盟退款待处理,请前往处理
							</a>
						</dd><?php endif; ?>
				</dl>
			</div>


			<div class="kbVipAdmin_shopInfo ml30">
				<a href="javascript:;" ><img src="/Public/Business/BusinessImages/nav_icon_person_default.svg" alt="商户资料" /><span><?php echo ($_SESSION['marketInfo']['user_name']); ?></span></a>
					<dl>
						<dt><?php echo ($_SESSION['marketInfo']['user_name']); echo ($_SESSION['adminInfo']['user_name']); ?></dt>
						<!-- <dd><a href="javascript:;">商户资料</a></dd> -->
						<dd><a href="<?php echo U('Login/logout');?>">退出</a></dd>
					</dl>
				
			</div>
		</div>

		
	</div>
	<nav id="kbVipAdmin_leftNav" class="bg_main color_last">
		<ul >
			<?php if(is_array($navList)): foreach($navList as $key=>$v): ?><li>
				<?php if($v['rules']): ?><a href="javascript:;" class="special"><?php echo ($v["parent_name"]["alias"]); ?></a>
				<!-- 子菜单 -->
					<ul>
					<?php if(is_array($v["rules"])): foreach($v["rules"] as $key=>$vo): ?><li>
							<a active="<?php echo U($vo['name']);?>" href="<?php echo U($vo['name'],[module=>$_GET['module']]);?>"><?php echo ($vo["alias"]); ?></a>
						</li><?php endforeach; endif; ?>
					</ul>
				<?php else: ?>
					<a active="<?php echo U($v['parent_name']['name']);?>" href="<?php echo U($v['parent_name']['name'],[module=>$_GET['module']]);?>"><?php echo ($v["parent_name"]["alias"]); ?></a><?php endif; ?>
			</li><?php endforeach; endif; ?>	
		</ul>
	</nav>
	
<div id="kbVipAdmin_rightCenter" class="spAnDynamic OrderForm">
    <div class="centerTitle">
        <h1>添加动态</h1>
    </div>
  <div id="kbVipAdmin-edit" class="spAnDynamic-edit" >
            <form class="" action="?module=<?php echo I('get.module');?>" method="post" enctype="multipart/form-data">
                <p class="kbVipAdmin_enter"><b><i>*</i>标题：</b>
                <input type="text" value="" name="news_name" placeholder="请输入文章标题" maxlength="40" 
                data-datatype="input"  required="required" 
                />
                <strong class="kbVipAdmin_tip">必填项。文章标题输入的字符不可以超过40个</strong>
                </p>
                <p class="kbVipAdmin_enter">
                    <b>文章作者：</b>
                    <input type="text" value="" name="news_author" placeholder="请输入文章作者" maxlength="8" data-datatype="input" />
                    <strong class="kbVipAdmin_tip">选填项。文章作者输入字符不可超过8个</strong>
                </p>
                <!-- <p class="kbVipAdmin_enter">
                    <b>原文出处：</b>
                    <input class="goHref" type="text" value="" name="news_link" placeholder="请输入原文网址"  data-datatype="input"

                    />
                    <strong class="kbVipAdmin_tip">选填项。动态原文出处的跳转页面链接，必须以https或者http开头的页面链接</strong>
                </p> -->

                <p class="kbVipAdmin_enter"><b><i>*</i>简述：</b>
                <textarea type="text" value="" maxlength="20" name="title" placeholder="请输入文章简述" required="required" 
                data-datatype="input"
                ></textarea>
                <strong class="kbVipAdmin_tip">必填项。动态简述输入字符不可超过20个</strong>
                </p>
                <p class="kbVipAdmin_enter mark-changeFile" >
                <b>上传类型</b>
                  <label class="kb_choose">
                    <input type="radio" name="is_video" value="0" checked v-on:click="changeFile" requred="required"/>
                    <span class="kb_choose-check kb_choose-check_radio h20">
                      <em class="kb_choose-check-default kb_choose-check_main h"></em>
                    </span>
                  </label>
                  <span>图片</span>
                   <label class="kb_choose">
                    <input type="radio" name="is_video" value="1" v-on:click="changeFile" required="required" />
                    <span class="kb_choose-check kb_choose-check_radio h20">
                      <em class="kb_choose-check-default kb_choose-check_main h"></em>
                    </span>
                  </label>
                  <span>视频</span>
                </p>
                <div class="kbVipAdmin_enter  " v-if="isChangeFile==0"><b><i>*</i>动态封面:</b>
                <!-- name="news_logo[]" -->
                  <div class="fileImgMore">
                    <input id="shopImg"  type="file" value=""  multiple="multiple" required="required" />
                    <label class="" for="shopImg" ><span style="font-size:27px">+</span><br /><span>最多可选择三张图片作为动态封面</span></label>
                  </div>
                    <strong class="kbVipAdmin_tip">必填项。上传格式为jpg或png的图片，大小不超过40k，可上传三张图片</strong>
                </div>
                <div class="kbVipAdmin_enter kbVipAdmin_fileVideo" v-if="isChangeFile==1"><b><i>*</i>动态视频:</b>
                 <!-- name="video" -->
                  <div class="fileImgMore">
                    <div class="kbVipAdmin_videoInfo shopImg businessFileImgList">
                        <p class="tc">还没视频信息哦~~</p>
                    </div>
                    <input id="shopImg2"  type="file" value=""   required="required" v-on:click="shopVideo" />
                    <label class="" for="shopImg2" ><span style="font-size:27px">+</span><br /><span>最多可一个视频上传</span></label>
                  </div>
                </div>
                <p class="kbVipAdmin_enter">
                    <b><i>*</i>动态分类：</b>
                    <select class="kbVipAdmin_slt kbVipAdmin_sltblack" name="news_classify_id" required="required" 
                      data-datatype="select"  
                    >
                        <option value="-1">请选择分类</option>
                        <?php if(is_array($classify)): foreach($classify as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["news_type_name"]); ?></option><?php endforeach; endif; ?>
                    </select>
                    <strong class="kbVipAdmin_tip">必填项。请选择动态的分类</strong>
                </p>
                 <p class="kbVipAdmin_enter">
                    <b>相关产品：</b>
                    <input type="text" value="请选择" readonly class="mark-sltGoods"  />
                    <input type="hidden" value="" name="goods_id" />

                    <button type="button" class="kb_btn kb_btnMini kb_btn-main mark-delAboutGoods" disabled="disabled">删除</button>
                </p>
                <div class="kbVipAdmin_enter">
                    <b>详细内容:</b>
                    <div id="myEditor" class="myEditor">
                        <script id="container" name="img_path" type="text/plain">
                        请填写动态详情
                        </script>
                    </div>
                </div>
                <div class="kbVipAdmin_operating ">
                    <div class="kbVipAdmin_restsubmit"> 
                        <input  class="kbVipAdmin_button_eee w100 h40 tc" type="reset" value="取消" />
                        <input  class="kbVipAdmin_opt w100 h40 mark-submitForm" type="button" value="保存"  />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


	<script type="text/javascript" src="/Public/Portal/PortalJS/alert/alertNew.js?version=3.1"></script>
<script src="/Public/JS/module/handlebars/handlebars-base.js" type="text/javascript"></script>
<script src="/Public/JS/module/vue/vue.js" type="text/javascript"></script>

<script type="text/javascript" src="/Public/JS/module/jedate/jquery.jedate.min.js"></script>

<script type="text/javascript" src="/Public/Portal/PortalJS/portal.js?version=9.7"></script>

	
	<script type="text/javascript">
		$(function(){
			$('.kbVipAdmin_shopInfo>a,.kbVipAdmin_systemInfo>a').on('click',function(){
				var $this=$(this);
				$this.next().slideToggle();
			})

		});
		var nav_a = $('.left_nav a');
		for(var i = 0;i < nav_a.length;i ++)
		{

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/News/newsAddByProject'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
    <div class="kbVipAdmin_alert aboutGoods_alert">
        <div id="aboutGoods_alert" class="kbVipAdmin_alertBox">
            <button type="button" class="kbVipAdmin_alert-close "></button>
            <h3 class="mb10">相关商品</h3>
            <div class="kbVipAdmin_form">
                <div class="kbVipAdmin_enter pb10" style="border-bottom:1px solid #eee">
                    <b>产品分类:</b>
                    <select>
                        <option value="-1">请选择相关分类</option>
                        <?php if(is_array($goods_classify)): foreach($goods_classify as $key=>$v): ?><option value="<?php echo ($v['id']); ?>"><?php echo ($v['classify_name']); ?></option><?php endforeach; endif; ?>
                    </select>
                    <button type="button" class="kb_btn kb_btnMini kb_btn-main mark-sltGddosResult">查询</button>
                  
                </div>
              <h2 class="f14 dl_goodsResult-title bc">请选择商品</h2>
              <ul class="kb_list-cells dl_goodsResult bc" >
                <template  v-for="(goods,indexs) in goodsData">
                  <li class="kb_cell kb_cell-check" >
                    <p class="kb_cell-bd">
                        {{goods.goods_name}}
                    </p>
                    <p class="kb_cell-ft kb_choose">
                        <input type="radio" name="rd1" v-bind:value="goods.id" v-bind:checked="indexs==0? true : false" />
                        <span class=" kb_choose-check">
                            <b class="kb_choose-check-default kb_choose-check_default"></b>
                        </span>
                    </p>
                  </li>
                </template>
                </ul>
            </div>
            <div class="kbVipAdmin_operating ">
                <div class="kbVipAdmin_restsubmit"> 
                    <input  class="kbVipAdmin_button_eee w100 h40 tc" type="reset" value="取消" />
                    <input  class="kbVipAdmin_opt w100 h40 mark-aboutGoodsSub" type="button" value="保存" />
                </div>
            </div>
    
        </div> 
    </div>
    <script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/lang/zh-cn/zh-cn.js"></script>
<script>
$(function(){

  (function(){
    var ue = UE.getEditor('container',{
            'initialFrameHeight':360,
    });
  })();
  
  (function(){
    var app=new Vue({
      el:"#kbVipAdmin-edit",
      data:{
         isChangeFile:0
      },
      methods:{
        changeFile:function(event){
          var $this,is_video;
          $this=$(event.srcElement)?$(event.srcElement):$(eventget);
          this.$data.isChangeFile=$this.val();

        },
        checkdata:function(e){
          var checkData;
          checkData = new CheckData(e);
          return checkData;
        },
        shopVideo:function(){
          $('#shopImg2').on("change",function(){
            var Html,$this;
             $this=$(this);
            files=this.files;
            if(!/video\/\w+/.test(files[0].type)){ 
                  alert("请确保文件为视频类型"); 
                  return false; 
            }
            Html="<p class='tc mb10'>视频名字："+files[0].name+"</p>"+
                 "<p class='tc'>视频大小："+files[0].size/1000/1000+"M"+"</p>";
            $this.siblings('.kbVipAdmin_videoInfo').html(Html);
          });
        }
      },
      mounted:function(){
        var formData,checkData,shopImg;
        checkData=this.checkdata('#kbVipAdmin-edit');
        
        $('#shopImg').on("change",function(){
          var $this,files;
          $this=$(this);
          files=this.files;
          $this.siblings('.businessFileImgList').remove();
          if(files.length>3) {Alert("只可以上传三张图片，请重新选择上传");return false;}
          console.log(files)
          Object.keys(files).map(function(elem){
              if(elem>3){return false};
              if(!/image\/\w+/.test(files[elem].type)){ 
                Alert("请确保文件为图像类型"); 
                return false; 
              }
              var reader=new FileReader();
              reader.readAsDataURL(files[elem]);
              reader.onload=function(e){
                console.log("aaa");
                var closeImg = '<div class="shopImg businessFileImgList"><span class="cleraIMG" onclick="clearImg(this)"></span><img src="'+this.result+'" alt=""/></div>'
                $this.before(closeImg);
              } 
              if($this.siblings('.businessFileImgList').length==5){
                $this.next().hide();
              }
           });
        });
        

        vueMethods.maxLength();
        $('.mark-submitForm').on('click',function(){
           if(!checkData.verify()) return false;
           dlLoading('数据上传中...',function(){
            formData=new FormData($('#kbVipAdmin-edit form')[0]);
             shopImg=document.getElementById('shopImg');
             shopImg2=document.getElementById('shopImg2');
             if(shopImg){
               Object.keys(shopImg.files).map(function(elem){
                  if(elem<3){
                   formData.append('news_logo',shopImg.files[elem]);
                  }
               })
             }
             if(shopImg2){
               formData.append('video',shopImg2.files[0]);
             }

             $.ajax({
                  type:'POST',
                  url:"?module=<?php echo I('get.module');?>",
                  data:formData,
                  dataType:'json',
                  enctype: 'multipart/form-data',
                  async: false,  
                  cache: false,  
                  contentType: false,  
                  processData: false,
                  success:function(data){
                    loadsuccess();
                    if(data.status==1){
                       sTip('操作成功');
                       setTimeout(function(){
                         window.location.reload();
                       },2000)
                    }else{
                       oTip(data.info);
                    }
                  },
                  error:function(xhr, errorType, error){
                      console.log("xhr"+xhr);
                      console.log("errorType"+errorType);
                      console.log("error"+error);
                  }
              })
            })
          })
           
      }
    })
  })();
    $('.mark-sltGoods').on('click',function(){
      $('.aboutGoods_alert').fadeIn();
    });
 
  (function(){
    var app=new Vue({
        el:'#aboutGoods_alert',
        data:{
            goodsData:[],
            test:1
        }
    });
    $('.mark-sltGddosResult').on('click',function(){
      var $this=$(this),goodsClass,Url,params;  
      goodsClass=$this.siblings('select').val();

      if(goodsClass==-1){
          eTip('请先选择产品分类')
      }else{
          // flag:getGoodsList 
          // classify_id: 商品分类id 
          Url="<?php echo U('News/ajaxControl');?>";
          params={
              flag:'getGoodsList',
              classify_id:goodsClass
          }
        $.ajax({
          type:"GET",
          url:Url,
          data:params,
          dataType:'json',
          success:function(data){
            console.log(data);
            app.$data.goodsData=data;
            console.log(app.$data.goodsData);
          },
          error:function(error){
            console.log(error)
          }
        })
      }
      
    })
    $('.aboutGoods_alert .mark-aboutGoodsSub').on('click',function(){
        var goods,goodsName;
        goods=$('#aboutGoods_alert .dl_goodsResult input:checked');
        if(goods.length){
            goodsName=goods.parent().prev().text().trim();
            $('.mark-sltGoods').val(goodsName);
            $('.mark-sltGoods').siblings('input[type=hidden]').val(goods.val());
            sTip('操作成功');
            $('.mark-delAboutGoods').prop('disabled',false);
            $('.aboutGoods_alert').fadeOut();
        }else{
            eTip('请先选择商品！');
        }
    })
  })();

  $('.kbVipAdmin_alert .kbVipAdmin_alert-close,.kbVipAdmin_alert input[type=reset]').on('click',function(){
      $('.kbVipAdmin_alert').fadeOut();
  })
  $('.mark-delAboutGoods').on('click',function(){
    $('.mark-sltGoods').val('');
    $('.mark-sltGoods').next('input').val('');
    $(this).prop('disabled',true);
  })
  
})
</script>

</body>
</html>