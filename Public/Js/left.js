// 创建新的分组
$(function(){
	$('#create_group').click(function(){
		var groupLeft = ($(window).width() - $('#add-group').width())/2;
		var groupTop  = $(document).scrollTop() + 
			($(window).height() - $('#add-group').height())/2;
		var gpObj = $('#add-group').show().css({
			'left': groupLeft,
			'top':groupTop
		});
		createBg('group-bg');
		drag(gpObj, gpObj.find('.group_head'));
	});

	$('.add-group-sub').click(function(){
		var groupname = $('#gp-name').val();
		if (groupname != ''){
			$.post(addGroupUrl, {gname:groupname,}, function(data){
				if (data.status){
					// alert(data.msg);
					showTips(data.msg);
					// 创建分组成功 
					$("#add-group").hide();
					$("#group-bg").remove();
				}else
					alert(data.msg);
			}, 'json');
		}
	});

	$('.group-cancel').click(function(){

	});


});

