
$(function(){

	// 点击刷新 验证码
	var verifyUrl = $('#verify-img').attr('src');
	$("#verify-img").click( function() {
		$(this).attr('src', verifyUrl + '?' + Math.random());
	});

	// 表单验证，jQuery validate
	// 添加自定义验证方法，以字母开头，
	// 3-17位字母、数字、下划线为用户名
	jQuery.validator.addMethod('uservalid', function(value, element){
		var tel = /^[a-zA-Z][\w]{2,16}$/;
		return this.optional(element) || (tel.test(value));
	}, "以字母开头，3-17字母、数字或者下划线");

	$('form[name=register]').validate({
		errorElement: 'span',
		success: function(label){
			label.addClass('success');
		},
		rules:{
			account : {
				required: true,
				uservalid: true,
				remote: {
					url : checkAccount,
					type : 'post',
					dataType: 'json',
					data: {
						account: function (){
							return $('#account').val();
						}
					}
				}
			},
			uname :{
				required: true,
				remote: {
					remote :{
						url : checkUname,
						type: 'post',
						dataType: 'json',
						data: {
							uname : function (){
								return $('#uname').val();
							}
						}
					}
				}
			},
			pwd : {
				required: true,
				minlength: 6
			},
			pwded: {
				required: true,
				equalTo: "#pwd"
			},
			uname: {
				rangelength: [2, 10]
			},
			verify :{
				required: true,
				remote: {
					url : checkVerify,
					type: 'post',
					dataType: 'json',
					data: {
						verify : function (){
							return $('#verify').val();
						}
					}					
				}
			}
		},
		messages : {
			account : {
				required : "账号不能为空！",
				remote: "账号已经存在！"
			},
			pwd : {
				required : "请输入密码！",
				minlength : "密码最少为6位!"
			},
			pwded: {
				equalTo: "两次输入的密码不一致！"
			},
			uname: {
				rangelength : "用户昵称应该为2-10位"
			},
			verify:{
				required: "请输入验证码",
				remote: "输入验证码不正确，重新输入或者点击验证码刷新重试"
			}
		}
	});

});
