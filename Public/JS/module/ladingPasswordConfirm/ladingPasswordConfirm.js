$(function(){
    var check_pass_word='';
    var passwords = $('#password').get(0);
    
    // if (!orderInfo) {
    //   Alert('获取不到订单编号，请稍候再试。如若多次出现此情况，请跟客服人员联系！');
    //   $(".ftc_wzsf").hide();
    //   $('#key').hide();
    //   return false;
    // }
    $(function(){
        var div = '\
        <div id="key" style="position:absolute;background-color:#A8A8A8;width:99.5%;bottom:0px;left:0;z-index:99;">\
            <ul id="keyboard" style="font-size:20px;margin:2px -2px 1px 2px">\
                <li class="symbol"><span class="off">1</span></li>\
                <li class="symbol"><span class="off">2</span></li>\
                <li class="symbol btn_number_"><span class="off">3</span></li>\
                <li class="tab"><span class="off">4</span></li>\
                <li class="symbol"><span class="off">5</span></li>\
                <li class="symbol btn_number_"><span class="off">6</span></li>\
                <li class="tab"><span class="off">7</span></li>\
                <li class="symbol"><span class="off">8</span></li>\
                <li class="symbol btn_number_"><span class="off">9</span></li>\
                <li class="delete lastitem">删除</li>\
                <li class="symbol"><span class="off">0</span></li>\
                <li class="cancle btn_number_">取消</li>\
            </ul>\
        </div>\
        ';
        var character,index=0;  $("input.pass").attr("disabled",true);  $("#password").attr("disabled",true);$("#keyboardDIV").html(div);
        $('#keyboard li').click(function(){
            if ($(this).hasClass('delete')) {
                console.log(index)
                index = index > 6 ? 6 : index;
                // console.log($(passwords.elements[--index%6]))
                // $(passwords.elements[--index%6]).val('');
                $(passwords.elements[--index%6]).val('');
                if($(passwords.elements[0]).val()==''){
                    index = 0;
                }
                /*for(var i= 0,len=passwords.elements.length-1;len>=i;len--){
                    if($(passwords.elements[len]).val()!=''){
                        $(passwords.elements[len]).val('');
                        break;
                    }
                }*/
                return false;
            }
            if ($(this).hasClass('cancle')) {
                passNull()
                return false;
            }
            if ($(this).hasClass('symbol') || $(this).hasClass('tab')){
                character = $(this).text();
                $(passwords.elements[index++%6]).val(character);
                if($(passwords.elements[5]).val()!=''){
                    // index = 0;
                }
                ;
            /*for(var i= 0,len=passwords.elements.length;i<len;i++){
                if($(passwords.elements[i]).val()== null ||$(passwords.elements[i]).val()==undefined||$(passwords.elements[i]).val()==''){
                    $(passwords.elements[i]).val(character);
                    break;
                }
            }*/
            if($(passwords.elements[5]).val()!='') {
                var temp_rePass_word = '';
                for (var i = 0; i < passwords.elements.length; i++) {
                    temp_rePass_word += $(passwords.elements[i]).val();
                }
                var orderInfo = $('#projectOrder').data('orderinfo');
                if (!orderInfo) {
                  Alert('订单支付失败，请稍后再试！如多次出现此情况，请联系客服人员。')
                }
                check_pass_word = temp_rePass_word;
                /*提交支付密码*/
                // alert(check_pass_word);
                // $("#key").hide();
                    var orderData = {
                        pay_pass: check_pass_word,
                        flag:orderInfo.flag
                    }
                    if (orderInfo.orderNum) {
                      orderData.project_order = orderInfo.orderNum;
                    } else if(orderInfo.id) {
                      orderData.id = orderInfo.id;
                    } else {
                      Alert('的该订单不存在，请稍后再试！如多次出现此情况，请联系客服人员。')
                    }
                    $.ajax({
                        url:orderInfo.url,
                        type:'GET',
                        data:orderData,
                        dataType:'json',
                        success:function(data){
                            if(data.status){
                              // window.parent.document.getElementsByClassName("ftc_wzsf").style.display='';
                                 // window.parent.document.getElementById("modify_ladingPassword").disabled='disabled';
                                  //window.parent.document.getElementById("oldLadingPassword").value=check_pass_word;
                              passNull();
                              Alert("支付成功!",function(){
                                window.location.href=orderInfo.success;
                              })
                            }else{
                              if(data.coed!=1){
                                passNull()
                                $(".ftc_wzsf").hide();
                                $('#key').hide();
                                Alert(data.err_msg);
                              }else{
                                Alert('还未设置钱包支付密码，需要前往设置密码',function(){
                                  window.location.href=orderInfo.paypaw;
                                });
                              }
                            }
                        },
                        error:function(data){
                          Alert('网络异常，请稍后再试！')
                        }
                    });
                }
                        }
            return false;
        });
        $(".close").on('click',function(){
          passNull()
        });
        function passNull() {
          for(var i= 0,len=passwords.elements.length-1;len>=i;len--){
              if($(passwords.elements[len]).val()!=''){
                  $(passwords.elements[len]).val('');
              }
          }
          index = 0;
          $(".ftc_wzsf").hide();
          $('#key').hide();
        }
    });
    (function () {
        function tabForward(e) {
            e = e || window.event;
            var target = e.target || e.srcElement;
            if (target.value.length === target.maxLength) {
                var form = target.form;
                for (var i = 0, len = form.elements.length-1; i < len; i++) {
                    if (form.elements[i] === target) {
                        if (form.elements[i++]) {
                            form.elements[i++].focus();
                        }
                        break;
                    }
                }
            }
        }
        var form = document.getElementById("password");
        form.addEventListener("keyup", tabForward, false);
        var set_text='\
        <span>请输入</span>\
        <span style="color: red;">提货密码</span>\
        <span>，验证本次操作</span>\
        ';
        $("#set_text").html(set_text);
    })();
})