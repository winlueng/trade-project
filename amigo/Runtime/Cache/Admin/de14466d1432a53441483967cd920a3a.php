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
	
	<div id="kbVipAdmin_rightCenter" class="spAnProductClass OrderForm">
		<div class="centerTitle">
			<h1>产品分类</h1>
		</div>
		<div class="kbVipAdmin_operating spAnProductClass-operating" >
			<input class="kbVipAdmin_opt kbVipAdmin_add w80 h30" type="button" value="添加" />
		</div>
		<div class="main-contentBox  kbVipAdmin_mt24" >
			<div class="kbVipAdmin_table">
				<table>
					<thead>
						<tr>
							<th>序号</th>
							<th>分类名称</th>
							<th>简述</th>
							<th>所属商品数量</th>
							<th>分类状态</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
					<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
							<td><?php echo ($vo["id"]); ?></td>
							<td><?php echo ($vo["classify_name"]); ?></td>
							<td><!-- <img src="/Public<?php echo ($vo["classify_logo"]); ?>" width="100" style="margin-top: 3px"> --></td>
							<td><?php echo ($vo["gnum"]); ?></td>
							<td>
								<p class="kbVipAdmin_pushBtn">
									<input type="checkbox" value="" <?php echo ($vo['status'] == '0'?'checked':''); ?> title=" <?php echo ($vo['status'] == '0'?'启用':'禁用'); ?>"/>
									<label><b></b></label>
								</p>
								
							</td>
							<td class="kbVipAdmin_tdAction">
								<input class="font_57c8f2 kbVipAdminEdit" type="button" value="" title="编辑" v-on:click="classfiyUpdate" />
                <input class="font_ff6c60 kbVipAdminDel" type="button" value="" title="删除"/>
                <input class="mark-upper icon-upper" type="button" data-classifyid="<?php echo ($vo["id"]); ?>" value="" title="上移"/>
								<input class="mark-under icon-under" type="button" data-classifyid="<?php echo ($vo["id"]); ?>" value="" title="下移"/>
							</td>
						</tr><?php endforeach; endif; ?>
					</tbody>
				</table>
			</div>
			<!-- 分页位置 -->
			<div class="kbVipAdmin_page">
        <div class="pageSize">
          <?php echo ($page); ?>
        </div>
        <div class="pageJump">
        <form>  
          <input class="w60  fl" type="text" name="p" value="<?php echo I('get.p');?>" />
          <input type="submit" class="fl" value="跳转">
        </form>
        </div>
      </div>
		</div>
	</div>
    <div class="kbVipAdmin_alert spAnProductClass_alert">
    	<div class="kbVipAdmin_alertBox">
    		<button type="button" class="kbVipAdmin_alert-close "></button>
    		<form action="" method="post" enctype="multipart/form-data">
    			 <h3 class="mb10">添加产品分类</h3>
    			<p class="kbVipAdmin_enter">
            <b><i>*</i>分类名称</b>
    			  <input type="text" maxlength="6" name="classify_name"
              value=""  required="required" placeholder="请输入子分类名字"
              data-datatype="input" 
            />
    				
    			</p>
    			<div class="kbVipAdmin_enter kbVipAdmin_fileImg"><b><i>*</i>分类封面:</b>
    					
    				<input id="shopImg"  type="file" value="" name="classify_logo"  />
    				<label class="" for="shopImg" ><span style="font-size:27px">+</span><br /><span>选择一张图片作为分类封面</span></label>
    			</div>
    			<p class="kbVipAdmin_enter"><b>描述</b>
    			<textarea placeholder="请输入产品描述" name="title" maxlength="10" data-datatype="input" ></textarea>
    			</p>
    			<div class="kbVipAdmin_operating ">
    				<div class="kbVipAdmin_restsubmit"> 
    					<input  class="kbVipAdmin_button_eee w100 h40 tc" type="reset" value="取消" />
    					<input  class="kbVipAdmin_opt w100 h40 mark-submit" type="button" value="保存" />
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
    <div id="myTemplate">
      <div class="kbVipAdmin_alert spAnProductClass_alertEdit">
        <div class="kbVipAdmin_alertBox">
            <button type="button" class="kbVipAdmin_alert-close " v-on:click="closeAlert" ><img src=" " alert="X" /></button>
            <form action="" method="post" enctype="multipart/form-data">
                <h3 class="mb10">编辑产品分类</h3>
                <p class="kbVipAdmin_enter"><b><i>*</i>分类名称:</b>
                <input type="text" maxlength="6" name="classify_name"  v-bind:value="classfiyData.classify_name" placeholder="请输入子分类名字" required="required" />
                </p>
                <div class="kbVipAdmin_enter kbVipAdmin_fileImg"><b><i>*</i>分类封面:</b>
                    <div class="shopImg businessFileImgList" v-if="classfiyData.classify_logo">
                        <span class="cleraIMG" onclick="clearImg(this)"></span>
                          <img v-bind:src="'/Public'+classfiyData.classify_logo" alt="" />
                    </div>  
                    <input id="shopImg1"  type="file" value="" name="classify_logo"  />
                    <label class="" for="shopImg1" ><span style="font-size:27px">+</span><br /><span>选择一张图片作为分类封面</span></label>
                </div>
                <p class="kbVipAdmin_enter"><b>描述:</b>
                <textarea placeholder="请输入产品描述" name="title"  maxlength="10"  v-bind:value="classfiyData.title"></textarea>
                </p>
                <div class="kbVipAdmin_operating ">
                    <div class="kbVipAdmin_restsubmit"> 
                        <input  class="kbVipAdmin_button_eee w100 h40 tc" type="button" value="取消" @click="closeAlert" />
                        <input  class="kbVipAdmin_opt w100 h40" type="submit" value="保存" />
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

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/GoodsClassify/goodsClassifyAddByProject'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
<script type="text/javascript">
 $(function(){
        var bus ,app,myapp,Child,Template,myTemplate;
         //totalController
         bus=new Vue();
         //kbVipAdmin_rightCenter
         app=Vue.extend({
            mounted:function(){
                $(".spAnProductClass .spAnProductClass-operating  .kbVipAdmin_add").on('click',function(){
                    $(".spAnProductClass_alert").fadeToggle();
                    var checkData,status,formData;
                    vueMethods.maxLength();
                    checkData=new CheckData('.spAnProductClass_alert');
                    status=false;
                    $(".spAnProductClass_alert .mark-submit").on('click',function(){
                       status=checkData.verify();
                       console.log(status);
                      if (!status) return false;
                      formData=new FormData($(".spAnProductClass_alert").find('form')[0]);
                     dlLoading('数据上传中...',function(){
                        $.ajax({
                          type:"POST",
                          url:"",
                          data:formData,
                          dataType:"json",
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
                          error:function(error){
                            console.error(error);
                          }
                        });  
                     });
                    })
                });
                $('.kbVipAdmin_tdAction .kbVipAdminDel').on('click',function(){
                    var $this = $(this);
                    var ID =$this.parent().siblings('td').eq(0).text().replace(/(^\s+)|(\s+$)/g, "");
                    
                    Confirm("你确定删除该分类吗？",function(ren){

                        if(ren){
                            $.get('<?php echo U("ajaxControl");?>',{flag:'goodsClassifyDel',id:ID},function(res){
                                if(res.status == true){
                                    sTip("操作成功");
                                    $this.parent().parent().remove();
                                }else{
                                    oTip(res.err_msg)
                                }
                            });
                        };
                    });
                    
                 });
                 $('.kbVipAdmin_pushBtn input').on('click',function(){
                     var $this=$(this);
                     var ajaxUrl='<?php echo U("ajaxControl");?>';
                     var Status=$this.is(':checked')?0:1;
                     var ID = $this.parents('tr').children().eq(0).text().trim();
                     // console.log(Status);
                     $.get(ajaxUrl,{
                        flag:'changeGoodsClassifyStatus',
                        status:Status,
                        id:ID
                     },function(res){

                        if(!res.status){
                            $this.attr('checked',false)
                            oTip(res.err_msg)
                        }else{
                            sTip("操作成功");
                        }
                        console.log(res);
                     })
                });  
                vueMethods.myTitile();    
            },
            data:function(){
                return  {
                    classUpdata:{

                    }
                }
            },
            methods:{
                classfiyUpdate:function(event){
                    var $this=$(event.srcElement)?$(event.srcElement):$(event.target);
                    var ID =$this.parent().siblings('td').eq(0).text().trim();
                    bus.$emit('classfiyUpdate', ID)
                }
            },
        });

        myapp=new app().$mount('#kbVipAdmin_rightCenter');
        

      //#myTemplate
       Template=Vue.extend({
            data:function(){
                return {
                    classfiyData:{

                    }
                };
            },
            methods:{
                classfiyUpdate:function(id){
                    var ID=id;
                    $(".spAnProductClass_alertEdit").fadeToggle();
                    vueMethods.maxLength();
                    $.get('<?php echo U("ajaxControl");?>',{flag:'selClassifyInfo',id:ID},function(res){
                        myTemplate.classfiyData=res;
                    });
                    $('.spAnProductClass_alertEdit form').prop('action',"<?php echo U('goodsClassifyUpdate');?>?id="+ID);
                },
                closeAlert:function(){
                    $(".kbVipAdmin_alert").fadeOut();
                }
            },
            watch:{
                classfiyData:function () {
                  // `this` points to the vm instance
                  return myTemplate.classfiyData;
                }
            }

        })
        myTemplate=new Template().$mount('#myTemplate');
        bus.$on('classfiyUpdate', function (id) {
           myTemplate.classfiyUpdate(id);
        })

        $('.mark-upper,.mark-under').on('click',function(){
            var $this,classid,status,Url,params=new Object();
           Url="<?php echo U('GoodsClassify/ajaxControl');?>";
           $this= $(this);
           classid=$this.attr('data-classifyid');
           status=$this.hasClass('mark-upper')?'up':'down';
           params={
             flag:"goodsClassifySort",
             id:classid,
             control:status
           }
           $.ajax({
              type:"GET",
              url:Url,
              data:params,
              dataType:'json',
              success:function(data){
                console.log(data);
                if(data.status){
                    sTip('操作成功');
                    window.location.reload();
                }
              },
              error:function(error){
                console.log(error);
              }
           })

        })  
        $('.kbVipAdmin_alert .kbVipAdmin_alert-close,.kbVipAdmin_alert .kbVipAdmin_restsubmit input[type=reset]').on('click',function(){
            $('.kbVipAdmin_alert').fadeOut();
        })
})
</script>

</body>
</html>