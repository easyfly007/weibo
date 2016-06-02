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
		// formData: {'session_id': sid},
		// 上传成功后的回调函数
		onUploadSuccess: function (file, data, response){
			if (data == 0)
				alert(0);
			else
				alert(1);
			// alert('the file ' + file.name + "uploaded successfully");
			// alert('the final file in the server is: ' + data);
			// eval('var data = ' + data);
			// alert(1);
		}
	});

});