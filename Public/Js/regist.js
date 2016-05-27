
$(function(){

	// 点击刷新 验证码
	var verifyUrl = $('#verify-img').attr('src');
	$("#verify-img").click( function() {
		$(this).attr('src', verifyUrl + '?' + Math.random());
	});

	// 表单验证，jQuery validate
	$('.form[name=register]').validate({
		rules:{
			account: {
				required: true,
				rangelength: [3, 20]
			}
		},
		messages:{
			account: {
				required: "账号不能为空！",
				rangelength:"账号应该为3到20位"
			}
		}
	});


});
