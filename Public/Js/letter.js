$(function () {

	//发送私信框
   	$('.l-reply,.send').click(function () {
    	var username = '';

	    if ($(this).attr('class') == 'l-reply') {
    	    username = $(this).parents('dd').prev().find('a').html();
    	}
	   	var letterLeft = ($(window).width() - $('#letter').width()) / 2;
		var letterTop = $(document).scrollTop() + ($(window).height() - $('#letter').height()) / 2;
		var obj = $('#letter').show().css({
	 		'left' : letterLeft,
	 		'top' : letterTop
	 	});

	    obj.find('input[name=name]').val(username);
    	obj.find('textarea').focus();
		createBg('letter-bg');
		drag(obj, obj.find('.letter_head'));
   });

   //关闭 私信框
   $('.letter-cancel').click(function () {
   		$('#letter').hide();
   		$('#letter-bg').remove();
   });

   // 删除私信
   $('.del-letter').click(function(){
   		var lid = $(this).attr('lid');
   		var obj = $(this).parents('dl');
   		var delConfirm = confirm('确实删除这条私信？');
   		if (delConfirm){
   			$.post(delLetterUrl, {lid:lid}, function(data){
   				if (data ==1){
   					obj.slideUp('slow', function(){
   						obj.remove();
   					});
   				}else
   				alert('无法删除私信');
   			}, 'json');
   		}
   });

});
