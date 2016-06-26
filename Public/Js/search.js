
$(function(){
	$('.sech-type').click(function(){
		$('.cur').removeClass('cur');
		$(this).addClass('cur');
		$('form[name=search]').attr('action', $(this).attr('url'));
	});

});
