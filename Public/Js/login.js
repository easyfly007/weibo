
$(function(){

	// 表单验证，jQuery validate
	// 添加自定义验证方法，以字母开头，
	// 3-17位字母、数字、下划线为用户名
	jQuery.validator.addMethod('uservalid', function(value, element){
		var tel = /^[a-zA-Z][\w]{2,16}$/;
		return this.optional(element) || (tel.test(value));
	}, " ");

	$('form[name=login]').validate({
		errorElement: 'span',
		success: function(label){
			label.addClass('success');
		},
		rules:{
			account : {
				required: true,
				uservalid: true
			},
			pwd : {
				required: true,
				minlength: 6
			},
		},
		messages : {
			account : {
				required : " "
			},
			pwd : {
				required : " ",
				minlength : " "
			},
		}
	});

});
