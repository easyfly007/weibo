$(function(){
	// 修改资料选项卡
	$('#sel-edit li').click(function(){
		var index = $(this).index();
		$(this).addClass('edit-cur').siblings().removeClass('edit-cur');
		$('.form').hide().eq(index).show();
	});

	// // 城市选择
	var province = '';
	$.each(city, function(i,k){
		province += '<option value="'+ k.name + '" index = "' +i + '">' + k.name + '</option>'; 
	});
	$('select[name=province]').append(province).change(function() {
		var option ='';
		if ($(this).val() == ''){
			option += '<option value ="">请选择</option>';
		}else{
			var index =$(':selected', this).attr('index');
			var data = city[index].child;
			for (var i =0; i < data.length; i++){
				option += '<option value ="' + data[i] + '">' + data[i] +'</option>';
			}
		}
		$('select[name=city]').html(option);
	});

	// 城市所在地默认选项
	thelocation = thelocation.split(' ');
	$('select[name=province]').val(thelocation[0]);
	$.each(city, function(i, k){
		if (k.name == thelocation[0]){
			var str = '';
			for (var j in k.child){
				if (k.child[j] == thelocation[1])
					str += "<option value = '" + k.child[j] + "' selected = 'selected' >"; 
				else
					str += "<option value = '" + k.child[j] + "' >"
				str += k.child[j] + "</option>";
			}
			$('select[name=city]').html(str);
		}
	});

	// 星座默认选项
	$('select[name=constellation]').val(constellation);

	// 头像上传
	$('#face').uploadify({
		swf: PUBLIC + '/Uploadify/uploadify.swf', // Uploadify 核心Flash文件
		uploader: uploadUrl, // php 处理脚本地址
		width : 120,   				  		// 上传按钮宽度
		height: 38,     				    // 上传按钮高度
		buttonImage:  PUBLIC + '/Uploadify/upload_btn.jpg', // 按钮背景图
		fileTypeDesc: "Image File", //上传图片的类型提示文字
		fileTypeExts: "*.jpg; *.gif; *.jpeg; *.png", // 允许选择的文件后缀类型
		// 上传成功后的回调函数
		// data 是 uploader 后台处理中 echo 的内容
		onUploadSuccess: function (file, data, response){
			eval('var data=' + data);
			if (data.status == 1){
				var facename = data.fullname;
				var faceurl = ROOT + '/' + data.fullname;

				$('#face-image').attr('src', faceurl);
				$('input[name=face180]').val(facename);
				$('input[name=face80]').val(facename);
				$('input[name=face50]').val(facename);
			}else{
				alert(data.msg);
			}
		}
	});



	// 修改密码，表单验证
	$('form[name=changepwd]').validate({
		errorElement: 'span',
		success: function(label){
			label.addClass('success');
		},
		rules:{
			oldpwd : {
				required: true,
				remote :{
					url : checkPwd,
					type: 'post',
					dataType: 'json',
					data: {
						pwd : function (){
							return $('#oldpwd').val();
						}
					}
				}
			},
			newpwd : {
				required: true,
				minlength: 6
			},
			newpwd2: {
				required: true,
				equalTo: '#newpwd'
			},
		},

				

		messages : {
			oldpwd : {
				required : "请输入原密码",
				remote: "密码不正确"
			},
			newpwd : {
				required : "请输入新密码",
				minlength : "密码至少6位长"
			},
			newpwd2:{
				equalTo: "两次输入的密码不一致",
			}
		}
	});



});