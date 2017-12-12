<?php if (!defined('THINK_PATH')) exit(); $navList = showCompanyNavList(); $ip = get_client_ip(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" />
	<title><?php echo ($_SESSION['companyInfo']['company_name']); ?>后台</title>
	<!-- public start -->
	<link rel="stylesheet" href="/Public/salon/css/common.css?=1"></link>
	<script type="text/javascript" src="/Public/JS/jquery-1.8.2.min.js"></script>
	<link rel="stylesheet" href="/Public/Portal/PortalCSS/mbase.special.css"></link>

	<!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
	<!-- <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->

	<!--module  start-->
	<link rel="stylesheet" href="/Public/Business/BusinessJS/alert/companyalert.css?version=1.3"></link>
	<script type="text/javascript" src="/Public/Business/BusinessJS/alert/alertNew.js?version=3.1"></script>
	<link type="text/css" rel="stylesheet" href="/Public/JS/module/jedate/skin/jedate.css">
    <script type="text/javascript" src="/Public/JS/module/jedate/jquery.jedate.min.js"></script>
	<!--module  end-->
	<!-- public end -->
	<!--defalut  -->
	<link rel="stylesheet" href="/Public/Business/BusinessCSS/kbshopAdmin.1.0.css?version=1.19"></link>
	<link rel="stylesheet" href="/Public/Business/BusinessCSS/kbshopAdmin.mend.css?version=1.18"></link>
	<script type="text/javascript" src="/Public/Business/BusinessJS/kbshopAdmin.js?version=4.11"></script>
	
	<script src="/Public/JS/module/handlebars/handlebars-base.js" type="text/javascript"></script>
	<script src="/Public/JS/module/vue/vue.js" type="text/javascript"></script>





	
    
<link rel="stylesheet" href="/Public/Business/BusinessCSS/companyInfo/companyInfo.css"></link>
<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/lang/zh-cn/zh-cn.js"></script>
<style>
.kbShopAdmin_alert{
    z-index:999;
}
.dlAlert{
    z-index:1000;
}
.dl_goodsResult,.dl_goodsResult-title{
    width:68%;
}
.kbShopAdmin_form{
    height: 78%;
}
.dl_goodsResult{
    height: 80%;
    overflow-x: hidden;
}
.kbShopAdmin_videoInfo{
  width:159px;
  height:99px;
  border:1px solid #eee;
  padding-top:30px;
  padding-bottom:30px;
}
.kbShopAdmin_radio label b, .kbShopAdmin_radio label .kbShopAdmin_radio-radio{
	width: 12px
}
</style>
<?php ?>

</head>
<body>

	<div id="kbShopAdmin_header" class="bg_main color_last">
		<h2><?php echo ($_SESSION['companyInfo']['company_name']); ?>后台管理系统</h2>
		<div class="header_Fun tr pl100 pr100 h25 lh200 fr">
			<div class="kbShop_systemInfo">
				<a href="javascript:;"><img src="/Public/Business/BusinessImages/nav_icon_mail_default.svg" alt="系统消息" />
				<?php if(array_sum($orderConut) > 0): ?><strong class="redInfoCount"><?php echo ($orderConut[0]+$orderConut[1]); ?></strong><?php endif; ?>
				</a>
				<dl>
					<dt>系统消息</dt>
					<?php if($orderConut[0] > 0): ?><dd>
							<a href="<?php echo U('OrderForm/orderList',['status' => 2]);?>">	
								您有<?php echo ($orderConut[0]); ?>张新订单待处理,请前往处理
							</a>
						</dd><?php endif; ?>
					<?php if($orderConut[4] > 0): ?><dd>
							<a href="<?php echo U('OrderForm/orderList',['status' => 5]);?>">	
								您有<?php echo ($orderConut[4]); ?>张退款订单,请前往查看
							</a>
						</dd><?php endif; ?>
				</dl>
			</div>
			
			<div class="kbShop_shopInfo ml30">
				<a href="javascript:;" ><img src="/Public/Business/BusinessImages/nav_icon_person_default.svg" alt="商户资料" /><span><?php echo ($_SESSION['companyInfo']['user_name']); ?></span></a>
					<dl>
						<dt><?php echo ($_SESSION['companyInfo']['company_name']); ?></dt>
						<!-- <dd><a href="javascript:;">商户资料</a></dd> -->
						<dd><a href="<?php echo U('Login/logout');?>">退出</a></dd>
					</dl>
				
			</div>
		</div>
	</div>
	<div id="kbShopAdmin_leftNav" class="bg_main color_last">
		<ul >
			<?php if(is_array($navList)): foreach($navList as $key=>$v): ?><li>
				<?php if($v['rules']): ?><a href="javascript:;" class="special"><?php echo ($v["parent_name"]["alias"]); ?></a>
				<!-- 子菜单 -->
					<ul>
					<?php if(is_array($v["rules"])): foreach($v["rules"] as $key=>$vo): ?><li>
							<a  href="<?php echo U($vo['name']);?>">
							<?php if((in_array($vo['name'],$showNumberArr)) AND (checkIsControl($vo['name'], $companyID))): ?><strong class="redInfoCount"><?php echo checkIsControl($vo['name'], $companyID);?></strong><?php endif; ?>
							<?php echo ($vo["alias"]); ?></a>
						</li><?php endforeach; endif; ?>
					</ul>
				<?php else: ?>
					<a  href="<?php echo U($v['parent_name']['name']);?>"><!-- <strong class="redInfoCount">99</strong> --><?php echo ($v["parent_name"]["alias"]); ?></a><?php endif; ?>
			</li><?php endforeach; endif; ?>
		</ul>
	</div>


	<div id="kbShopAdmin_rightCenter" class="spAnDynamic OrderForm">
		<div class="centerTitle">
			<h1>动态列表</h1>
		</div>
		<div class="kbShopAdmin_operating spAnDynamic-operating filter-operating" >
			<form action="" method="get" style="display:inline-block">
					<select class="kbShopAdmin_slt w200 h30" name="news_classify_id" title="可选择分类查找相关商品">
						<option value="">全部类型</option>
						<?php if(is_array($classify)): foreach($classify as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php echo ($v['id'] == $_GET['news_classify_id']?'selected':''); ?>><?php echo ($v["news_type_name"]); ?></option><?php endforeach; endif; ?>
					</select>
				<input type="submit" class="kbShopAdmin_opt w80 h30" value="确认查找">
			</form>
			<form>
				<div class="filter-searchDate mr10">
						<input type="search" name="order_number" value="" placeholder="请输入想要查找的内容">
						<input class="kbShopAdmin_opt w80 h30 fr" type="submit" value="确定">
				</div>
				
			</form>
			<!-- <a href="#/addnews" class="kbShopAdmin_opt w80 h30 kbShopAdmin_add fr">添加</a> -->
			<input class="kbShopAdmin_opt w80 h30 kbShopAdmin_add fr" type="button" value="添加" onclick="window.location.href='#/addnews'" />
		</div>
		<div class="main-contentBox kbShopAdmin_mt24" >
			<div class="kbShopAdmin_table">
				<table>
					<thead>
						<tr>
							<th>序号</th>
							<th>动态分类</th>
							<th width="15%">动态标题</th>
							<th width="20%">动态简述</th>
							<th>添加时间</th>
							<th>浏览人数</th>
							<th>状态</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
					<?php if(empty($list)): ?><tr ><td colspan="8"><span style="color:#F209CA;font-size:20px">暂无动态数据</span></td></tr>
					<?php else: ?>
					<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
							<td><?php echo ($v["id"]); ?></td>
							<td><?php echo ($v["classify_name"]); ?></td>
							<td width="15%"><?php echo ($v["news_name"]); ?></td>
							<td width="20%"><?php echo ($v["title"]); ?></td>
							<td><?php echo date('Y-m-d', $v['addtime']);?></td>
							<td><?php echo ($v['visit_total']?$v['visit_total']:0); ?></td>
							<td>
								
								<p class="kbShopAdmin_checkbox kbShopAdmin_checkboxTop">
									<input  type="checkbox" name="status1" <?php echo ($v['is_top'] == '1'?'checked':''); ?> />
									<label class="font_6ccac9">
										<b class="kbShopAdmin_buttonMr"></b>
										置顶
									</label>
								</p>
								<p class="kbShopAdmin_checkbox kbShopAdmin_checkboxdisabled">
									<input type="checkbox"  name="status" <?php echo ($v['status'] == '1'?'checked':''); ?> />
									<label class="font_ff6c60">
										<b class="kbShopAdmin_buttonMr">
										</b>
										禁用
									</label>
								</p>
								
							</td>
							<td class="kbShopAdmin_tdAction">
								<a class="font_57c8f2 kbShopAdminSea w30 h20 copyButton-default" href="<?php echo U('preview', ['id' => $v['id']]);?>" target="view_window" tittle="预览"></a>
								<input class="font_57c8f2 kbShopAdminEdit" type="button" value="" onclick="window.location.href='#/updatenews?id=<?php echo ($v['id']); ?>'" tittle="编辑" />
								<input class="font_ff6c60 kbShopAdminDel" type="button" value="" tittle="删除" />
							</td>
						</tr><?php endforeach; endif; endif; ?>
					</tbody>
				</table>
			</div>
			<div class="kbShopAdmin_page mb10">
					<div class="pageSize">
						<?php echo ($page); ?>
						<script type="text/javascript">
							$('.pageSize a:first-child').addClass('prevPage');
							$('.pageSize a:last-child').addClass('nextPage');
						</script>
					</div>
					<div class="pageJump">	
					<form >
						<input class="w60  fl" type="text" name="p" placeholder="<?php echo I('get.p');?>" />
						<input type="submit" class="fl" name="" value="跳转">
					</form>	
					</div>
				</div>
		</div>
		<div id="kbShopAdmin-edit" class="spAnDynamic-edit" >
			<div class="centerTitle">
				<h1>添加动态</h1>
			</div>
			<form class="" action="" method="post" enctype="multipart/form-data">
				 <p class="kbShopAdmin_enter"><b><i>*</i>标题：</b>
                <input type="text" value="" name="news_name" placeholder="请输入文章标题" maxlength="40" 
                data-datatype="input"  required="required" 
                />
                <strong class="kbShopAdmin_tip">必填项。文章标题输入的字符不可以超过40个</strong>
                </p>
                <p class="kbShopAdmin_enter">
                    <b>文章作者：</b>
                    <input type="text" value="" name="news_author" placeholder="请输入文章作者" maxlength="8" data-datatype="input" />
                    <strong class="kbShopAdmin_tip">选填项。文章作者输入字符不可超过8个</strong>
                </p>
                <!-- <p class="kbShopAdmin_enter">
                    <b>原文出处：</b>
                    <input class="goHref" type="text" value="" name="news_link" placeholder="请输入原文网址"  data-datatype="input"

                    />
                    <strong class="kbShopAdmin_tip">选填项。动态原文出处的跳转页面链接，必须以https或者http开头的页面链接</strong>
                </p> -->

                <p class="kbShopAdmin_enter"><b><i>*</i>简述：</b>
                <textarea type="text" value="" maxlength="20" name="title" placeholder="请输入文章简述" required="required" 
                data-datatype="input"
                ></textarea>
                <strong class="kbShopAdmin_tip">必填项。动态简述输入字符不可超过20个</strong>
                </p>
                <div class="kbShopAdmin_enter mark-changeFile" >
                <b>上传类型</b>
                  <p class="kbShopAdmin_radio">
                    <input type="radio" name="is_video" value="0" checked v-on:click="changeFile" requred="required"/>
                     <label><em class="kbShopAdmin_radio-radio"></em></label>
                   
                  </p>
                  <span>图片</span>
                   <p class="kbShopAdmin_radio">
                    <input type="radio" name="is_video" value="1" v-on:click="changeFile" required="required" />
                     <label><em class="kbShopAdmin_radio-radio"></em></label>
                   
                  </p>
                  <span>视频</span>
                </div>
                <div class="kbShopAdmin_enter  " v-if="isChangeFile==0"><b><i>*</i>动态封面:</b>
                <!-- name="news_logo[]" -->
                  <div class="fileImgMore">
                    <input id="shopImg"  type="file" value=""  multiple="multiple" required="required" />
                    <label class="" for="shopImg" ><span style="font-size:27px">+</span><br /><span>最多可选择三张图片作为动态封面</span></label>
                  </div>
                    <strong class="kbShopAdmin_tip">必填项。上传格式为jpg或png的图片，大小不超过40k，可上传三张图片</strong>
                </div>
                <div class="kbShopAdmin_enter kbShopAdmin_fileVideo" v-if="isChangeFile==1"><b><i>*</i>动态视频:</b>
                 <!-- name="video" -->
                  <div class="fileImgMore">
                    <div class="kbShopAdmin_videoInfo shopImg businessFileImgList">
                        <p class="tc">还没视频信息哦~~</p>
                    </div>
                    <input id="shopImg2"  type="file" value=""   required="required" v-on:click="shopVideo" />
                    <label class="" for="shopImg2" ><span style="font-size:27px">+</span><br /><span>最多可一个视频上传</span></label>
                  </div>
                </div>
                <p class="kbShopAdmin_enter">
                    <b><i>*</i>动态分类：</b>
                    <select class="kbShopAdmin_slt kbShopAdmin_sltblack" name="news_classify_id" required="required" 
                      data-datatype="select"  
                    >
                        <option value="-1">请选择分类</option>
                        <?php if(is_array($classify)): foreach($classify as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["news_type_name"]); ?></option><?php endforeach; endif; ?>
                    </select>
                    <strong class="kbShopAdmin_tip">必填项。请选择动态的分类</strong>
                </p>
                 <p class="kbShopAdmin_enter">
                    <b>相关产品：</b>
                    <input type="text" value="请选择" readonly class="mark-sltGoods"  />
                    <input type="hidden" value="" name="goods_id" />
                </p>
                <div class="kbShopAdmin_enter">
                    <b>详细内容:</b>
                    <div id="myEditor" class="myEditor">
                        <script id="container" name="img_path" type="text/plain">
                        请填写动态详情
                        </script>
                    </div>
                </div>
                <div class="kbShopAdmin_operating ">
                    <div class="kbShopAdmin_restsubmit"> 
                        <input  class="kbShopAdmin_button_eee w100 h40 tc" type="reset" value="取消" />
                        <input  class="kbShopAdmin_opt w100 h40 mark-submitForm" type="button" value="保存"  />
                    </div>
                </div>
			</form>
		</div>
		<div id="kbShopAdmin-update" class="spAnDynamic-edit" >
			<div class="centerTitle">
				<h1>修改动态</h1>
			</div>
			<form class="" action="<?php echo U('companyNewsUpdate');?>" method="post" enctype="multipart/form-data">
				<div id="kbShopAdmin-updateForm">
				 <p class="kbShopAdmin_enter"><b><i>*</i>标题：</b>
                <input type="text" v-bind:value="newsDetail.news_name" name="news_name" placeholder="请输入文章标题" maxlength="40" 
                data-datatype="input"  required="required" 
                />
                <strong class="kbShopAdmin_tip">必填项。文章标题输入的字符不可以超过40个</strong>
                </p>
                <p class="kbShopAdmin_enter">
                    <b>文章作者：</b>
                    <input type="text" v-bind:value="newsDetail.news_author" name="news_author" placeholder="请输入文章作者" maxlength="8" data-datatype="input" />
                    <strong class="kbShopAdmin_tip">选填项。文章作者输入字符不可超过8个</strong>
                </p>
                <!-- <p class="kbShopAdmin_enter">
                    <b>原文出处：</b>
                    <input class="goHref" type="text" value="" name="news_link" placeholder="请输入原文网址"  data-datatype="input"

                    />
                    <strong class="kbShopAdmin_tip">选填项。动态原文出处的跳转页面链接，必须以https或者http开头的页面链接</strong>
                </p> -->

                <p class="kbShopAdmin_enter"><b><i>*</i>简述：</b>
                <textarea type="text" v-bind:value="newsDetail.title" maxlength="20" name="title" placeholder="请输入文章简述" required="required" 
                data-datatype="input"
                ></textarea>
                <strong class="kbShopAdmin_tip">必填项。动态简述输入字符不可超过20个</strong>
                </p>
                <div class="kbShopAdmin_enter mark-changeFile" >
                <b>上传类型</b>
                  <p class="kbShopAdmin_radio">
                    <input type="radio" name="is_video" value="0"  v-bind:checked="newsDetail.is_video==0?1:0"  v-on:click="changeFile" requred="required"/>
                     <label><em class="kbShopAdmin_radio-radio"></em></label>
                   
                  </p>
                  <span>图片</span>
                   <p class="kbShopAdmin_radio">
                    <input type="radio" name="is_video"  v-bind:checked="newsDetail.is_video==1?1:0" value="1" v-on:click="changeFile" required="required" />
                     <label><em class="kbShopAdmin_radio-radio"></em></label>
                   
                  </p>
                  <span>视频</span>
                </div>
                <div class="kbShopAdmin_enter  " v-if="isChangeFile==0"><b><i>*</i>动态封面:</b>
                <!-- name="news_logo[]" -->
                  <div class="fileImgMore">
                  	<div class="shopImg businessFileImgList" v-for="indexs in newsDetail.news_logo">
                        <span class="cleraIMG" onclick="clearImg(this)"></span>
                        <img v-bind:src="'/Public'+indexs" alt="">
                    </div>
                    <input id="shopImg4"  type="file" value="" name="news_logo[]"  multiple="multiple" required="required" />
                    <label class="" for="shopImg4" ><span style="font-size:27px">+</span><br /><span>最多可选择三张图片作为动态封面</span></label>
                  </div>
                    <strong class="kbShopAdmin_tip">必填项。上传格式为jpg或png的图片，大小不超过40k，可上传三张图片</strong>
                </div>
                <div class="kbShopAdmin_enter kbShopAdmin_fileVideo" v-if="isChangeFile==1"><b><i>*</i>动态视频:</b>
                 <!-- name="video" -->
                  <div class="fileImgMore">
                     <div class="shopImg businessFileImgList kbShopAdmin_videoInfo">
                         <video controls="controls"  width="100%" height="100%" poster="20170214143451.png"  runat="server" 
                            id="VideoShow">
                            <source type="video/mp4" v-bind:src="'/Public'+newsDetail.video" >
                        </video>
                    </div>
                    <input id="shopImg3"  type="file" value=""  name="video"  required="required" v-on:click="shopVideo" />
                    <label class="" for="shopImg3" ><span style="font-size:27px">+</span><br /><span>最多可一个视频上传</span></label>
                  </div>
                </div>
                <p class="kbShopAdmin_enter">
                    <b><i>*</i>动态分类：</b>
                    <select class="kbShopAdmin_slt kbShopAdmin_sltblack" name="news_classify_id" required="required" v-model='newsDetail.news_classify_id' 
                      data-datatype="select"  
                    >
                        <option value="-1">请选择分类</option>
                        <?php if(is_array($classify)): foreach($classify as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["news_type_name"]); ?></option><?php endforeach; endif; ?>
                    </select>
                    <strong class="kbShopAdmin_tip">必填项。请选择动态的分类</strong>
                </p>
                 <p class="kbShopAdmin_enter">
                    <b>相关产品：</b>
                    <input type="text" value="请选择" readonly class="mark-sltGoods"  />
                    <input type="hidden" v-bind:value="newsDetail.goods_id" name="goods_id" />
                </p>
                

                </div>
                <div class="kbShopAdmin_enter">
                    <b>详细内容:</b>
                    <div id="myEditor" class="myEditor">
                        <script id="container2" name="img_path" type="text/plain">
                        
                        </script>
                    </div>
                </div>
                <div class="kbShopAdmin_operating ">
                    <div class="kbShopAdmin_restsubmit"> 
                        <input  class="kbShopAdmin_button_eee w100 h40 tc" type="reset" value="取消" />
                        <input  class="kbShopAdmin_opt w100 h40 mark-submitForm" type="button" value="保存"  />
                    </div>
                </div>
			</form>
		</div>
	</div>
	</div>


 <p class="tc mt20 f14">技术支持由<a href="http://gdkbvip168.gdallinone.com/Company/Index/index">广州旷邦科技有限责任公司提供</a></p>

<div class="kbShopAdmin_alert aboutGoods_alert">
        <div id="aboutGoods_alert" class="kbShopAdmin_alertBox">
            <button type="button" class="kbShopAdmin_alert-close "></button>
            <h3 class="mb10">相关商品</h3>
            <div class="kbShopAdmin_form">
                <div class="kbShopAdmin_enter pb10" style="border-bottom:1px solid #eee">
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
            <div class="kbShopAdmin_operating ">
                <div class="kbShopAdmin_restsubmit"> 
                    <input  class="kbShopAdmin_button_eee w100 h40 tc" type="reset" value="取消" />
                    <input  class="kbShopAdmin_opt w100 h40 mark-aboutGoodsSub" type="button" value="保存" />
                </div>
            </div>
    
        </div> 
    </div>
<script>
$(function(){
	$('.spAnDynamic-operating .kbShopAdmin_add').on('click',function(){
			// $("#kbShopAdmin-edit").siblings().fadeOut();
			// $("#kbShopAdmin-edit").fadeIn();
	 	// 	vueMethods.maxLength();
	});


	(function(){
	  var app=new Vue({
	    el:"#kbShopAdmin-edit",
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
	          $this.siblings('.kbShopAdmin_videoInfo').html(Html);
	        });
	      }
	    },
	    mounted:function(){
	      var formData,checkData,shopImg,shopImg2;
	      checkData=this.checkdata('#kbShopAdmin-edit');
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
	      
	      $('.mark-submitForm').on('click',function(){
	         if(!checkData.verify()) return false;
	         dlLoading('数据上传中...',function(){
	          formData=new FormData($('#kbShopAdmin-edit form')[0]);
	           shopImg=document.getElementById('shopImg');
	           shopImg2=document.getElementById('shopImg2');
	           if(shopImg){
	             Object.keys(shopImg.files).map(function(elem){
	                if(elem<3){
	                 formData.append('news_logo[]',shopImg.files[elem]);
	                }
	             })
	           }
	           if(shopImg2){
	             formData.append('video',shopImg2.files[0]);
	           }

	           $.ajax({
	                type:'POST',
	                url:"",
	                data:formData,
	                dataType:'json',
	                enctype: 'multipart/form-data',
	                async: false,  
	                cache: false,  
	                contentType: false,  
	                processData: false,
	                success:function(data){
	                  // loadsuccess();
	                  if(data.status==1){
	                     sTip('操作成功');
	                     setTimeout(function(){
	                      // window.location.reload();
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
	  	console.log($('.aboutGoods_alert'))
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
	          $('.aboutGoods_alert').fadeOut();

	      }else{
	          eTip('请先选择商品！');
	      }
	  })
	})();

	// $('.kbShopAdmin_alert .kbShopAdmin_alert-close,.kbShopAdmin_alert input[type=reset]').on('click',function(){
	//     $('.kbShopAdmin_alert').fadeOut();
	// })

})
	
</script>
<script type="text/javascript">
     $(function(){
     	(function(){
     		var ue = UE.getEditor('container',{
     				'initialFrameHeight':360,
     				// 'initialContent':'在这里你可以布置好你商品详情的资料'
     		});
     	})();
     	(function(){
     		var ue = UE.getEditor('container2',{
     				'initialFrameHeight':360,
     				// 'initialContent':'在这里你可以布置好你商品详情的资料'
     		});
     	})();
     	var app=new Vue({
     			el:"#kbShopAdmin-updateForm",
     			data:{
     				newsDetail:{},
     				isChangeFile:0,
     				sltOption:{}
     			},
			    watch:{
			    	sltOption:function(event,id){
			    		console.log(id);
			    	}
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
     			    $('#shopImg3').on("change",function(){
     			      var Html,$this;
     			       $this=$(this);
     			      files=this.files;
     			      if(!/video\/\w+/.test(files[0].type)){ 
     			            alert("请确保文件为视频类型"); 
     			            return false; 
     			      }
     			      Html="<p class='tc mb10'>视频名字："+files[0].name+"</p>"+
     			           "<p class='tc'>视频大小："+files[0].size/1000/1000+"M"+"</p>";
     			      $this.siblings('.kbShopAdmin_videoInfo').html(Html);
     			    });
     			  },
     			  getNewsDetail:function(id){
     			  	$.ajax({
     			  		type:"GET",
     			  		url:'<?php echo U("News/ajaxControl");?>',
     			  		data:{
     			  			flag:"selNewsInfo",
     			  			id:id
     			  		},
     			  		dataType:'json',
     			  		success:function(data){
     			  			console.log(data);
     			  			app.$data.newsDetail=data;
     			  			app.$data.isChangeFile=data.is_video;
     			  			$('#kbShopAdmin-update').find('form').attr('action','<?php echo U("companyNewsUpdate");?>?id='+data.id);
     			  			UE.getEditor('container2').setContent(data.img_path);
     			  		},
     			  		error:function(error){
     			  			console.log(error);
     			  		}
     			  	})
     			  }
     			},
     			mounted:function(){
     			  var formData,checkData,shopImg,shopImg2,url;
     			  checkData=this.checkdata('#kbShopAdmin-update');
     			  $('#shopImg4').on("change",function(){
     			    var $this,files;
     			    $this=$(this);
     			    files=this.files;
     			    $this.siblings('.businessFileImgList').remove();
     			    if(files.length>3) {Alert("只可以上传三张图片，请重新选择上传");return false;}
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
     			  
     			  $('.mark-submitForm').on('click',function(){
     			     if(!checkData.verify()) return false;
     			     dlLoading('数据上传中...',function(){
     			      formData=new FormData($('#kbShopAdmin-update form')[0]);
     			       shopImg=document.getElementById('shopImg4');
     			       shopImg2=document.getElementById('shopImg3');

     			       url=$('#kbShopAdmin-update form').attr('action');
     			       if(shopImg && shopImg.files.length>0){
     			         Object.keys(shopImg.files).map(function(elem){
     			            if(elem<3){
     			             formData.append('news_logo[]',shopImg.files[elem]);
     			            }
     			         })
     			       }
     			       if(shopImg2 && shopImg2.files.length>0){
     			         formData.append('video',shopImg2.files[0]);
     			       }


     			       $.ajax({
     			            type:'POST',
     			            url:url,
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
     			                   window.history.go(-1);
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
     			    });
 			   		 $('.mark-sltGoods').on('click',function(){
 				  		console.log($('.aboutGoods_alert'))
 				    	$('.aboutGoods_alert').fadeIn();
 				    	 $('.kbShopAdmin_alert .kbShopAdmin_alert-close,.kbShopAdmin_alert input[type=reset]').on('click',function(){
 				 	     $('.kbShopAdmin_alert').fadeOut();
 				 	 });
 				 	 });

     			}
     		});

     	
   		/* 商户后台置顶*/
   		$('.kbShopAdmin_checkboxTop input').on('change',function(){
   			var $this=$(this);
   			var  Status=($this.is(":checked")===true)? 1:0;
   			var ajaxUrl='<?php echo U("News/ajaxControl");?>';
   			if(!$this.prop('disabled')){
   			jsAjaxControl($this,{
					ajaxURL:ajaxUrl,
			        params:{//这是ajax需要提交的集合
			        	flag:"changeNewsTop",
			        	is_top:Status,
			        }
				},function(res){

					oTip(res);
					if(res=="操作成功"){
						$this.parent().siblings('.kbShopAdmin_checkboxChosen').fadeToggle();
					}
					
			})
	   		}
	   	})
	   	
   		$('.kbShopAdmin_checkboxdisabled input').on('change',function(){
   			var $this=$(this);
   			var  Status=($this.is(":checked")===true)? 1:0;
   			var ajaxUrl='<?php echo U("News/ajaxControl");?>';
   			if(!$this.prop('disabled')){
   			jsAjaxControl($this,{
					ajaxURL:ajaxUrl,
			        ajaxBranch:'Common',
			        params:{//这是ajax需要提交的集合
			        	flag:"changeNewsStatus",
			        	status:Status,
			        }
				},function(res){
					if(res!=1){
	   		 	 		// $this.attr('checked',false)
	   		 	 		eTip('操作失败')
	   		 	 	}else{
	   		 	 		sTip('操作成功')
	   		 	 	}
			})
			}
   		})

		
	    /* 删除 */
   		$(".kbShopAdminDel").on('click',function(){
   			var $this=$(this);
   			var ajaxUrl='<?php echo U("News/ajaxControl");?>';
   			jsAjaxControl($this,{
					ajaxURL:ajaxUrl,
			        ajaxBranch:'Confirm',
			        params:{//这是ajax需要提交的集合
			        	flag:"newsDel",
			        }
				},function(res){
					
					if(res==1) {
						$this.parents('tr').remove()
						sTip("操作成功");
					}else{
						eTip("操作失败");
					};
			})
   		})
   		$('.spAnDynamic-edit .kbShopAdmin_operating input[type=reset]').on('click',function(){
   			window.history.go(-1);
   		})
   		 $('.mark-sltGoods').on('click',function(){
	  		console.log($('.aboutGoods_alert'))
	    	$('.aboutGoods_alert').fadeIn();
	 	 });

	 	(function(e){
     		function Router(){
     		  this.routes = {};
     		  this.curUrl = '';

     		  this.route = function(path, callback){
     		    this.routes[path] = callback || function(){};
     		  };

     		  this.refresh = function(){
     		  	var hash,indexs;
     		  	hash=window.location.hash;
     		  	indexs=hash.indexOf('?')!=-1?hash.indexOf('?'):hash.length;
     		    this.curUrl = hash.slice(1,indexs) || '/';
     		    this.routes[this.curUrl]();
     		  };

     		  this.init = function(){
     		    window.addEventListener('load', this.refresh.bind(this), false);
     		    window.addEventListener('hashchange', this.refresh.bind(this), false);
     		  }

     		}
     		var R = new Router();
     		R.init();
     		var res = $(e);
     		R.route('/',function(){
     			res.find('.main-contentBox').nextAll().hide();
     			res.find('.main-contentBox').prevAll().show();
     			res.find('.main-contentBox').show();
     		});
     		R.route('/addnews',function(){
				$("#kbShopAdmin-edit").siblings().fadeOut();
				$("#kbShopAdmin-edit").fadeIn();
		 		vueMethods.maxLength();
     		});
     		R.route('/updatenews',function(){
		 		var hash,id,indexs;
		 		hash=window.location.hash;
		 		indexs=hash.indexOf('?id=');
		 		if(indexs<0){alert('获取动态id值失败，请稍后再试');return false;}
		 		id=hash.slice(indexs+4)
				$("#kbShopAdmin-update").siblings().fadeOut();
				$("#kbShopAdmin-update").show();
		 		app.getNewsDetail(id);
		 		vueMethods.maxLength();

     		});
     	})('#kbShopAdmin_rightCenter');

     	$('.kbShopAdmin_alert .kbShopAdmin_alert-close,.kbShopAdmin_alert input[type=reset]').on('click',function(){
     	    $('.kbShopAdmin_alert').fadeOut();
     	});
	 })/* function end */
	</script>

	<script type="text/javascript">
	$(function(){
		$('.kbShop_shopInfo>a,.kbShop_systemInfo>a').on('click',function(){
			var $this=$(this);
			$this.next().slideToggle();
		});
		(function(){
			var nav_a = $('#kbShopAdmin_leftNav a');
			for(var i = 0;i < nav_a.length;i ++)
			{
				if(nav_a[i].href == 'http://'+"<?php echo $_SERVER['HTTP_HOST'].'/Admin/News/companyNewsAdd.html';?>")
				{
					console.log($(nav_a[i]));
					$(nav_a[i]).addClass('selected');
					$(nav_a[i]).parent().parent().addClass('selectedPar') ;
					$(nav_a[i]).parent().parent().parent().addClass('selected') ;
				}
			}
		})();
	});

	
	</script>
</body>
</html>