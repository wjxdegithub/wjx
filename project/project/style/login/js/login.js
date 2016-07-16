// JavaScript Document
//支持Enter键登录
		document.onkeydown = function(e){
			if($(".bac").length==0)
			{
				if(!e) e = window.event;
				if((e.keyCode || e.which) == 13){
					var obtnLogin=document.getElementById("submit_btn")
					obtnLogin.focus();
				}
			}
		}

    	$(function(){
			//提交表单
			$('#submit_btn').click(function(){
				show_loading();
				var myReg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/; //邮件正则
				if($('#email').val() == ''){
					show_err_msg('用户名还没填呢！');
					$('#email').focus();
				}else if($('#password').val() == ''){
					show_err_msg('密码还没填呢！');
					$('#password').focus();
				}else{
                    //获取跳转地址
                    var url=$('form').attr('action');
                    //获取账号密码
                    var username = $(":input[name='username']").val();
                    var password = $(":input[name='password']").val();
                    $.post(url,{username:username,password:password},function(msg) {
                        if (msg) {
                            //ajax提交表单，#login_form为表单的ID。 如：$('#login_form').ajaxSubmit(function(data) { ... });
                            show_msg('登录成功咯！  正在为您跳转...','index.php?r=backstage/index');
                        }else{
                            show_err_msg('账号密码错咯！');
                        }
                    })
				}
			});
		});