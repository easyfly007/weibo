$(function () {
	 //点击回复
   	$('.c-reply').click(function () {
   		if($(this).parent().next().is(":hidden")) 
		{   
			var name =$(this).parents('dl').find('dd a').html();
			var str = '回复@'+ name.replace(/: $/, ' ')+':';
	   		$(this).parent().next().show().find('textarea').val(str);
   		}else{
   			$(this).parent().next().hide();
   		}
    });

    // 表情处理，点击添加表情符号
    var phiz = $('.phiz');
    for (var i =0; i< phiz.length; i++){
        phiz[i].onclick = function(){
           // 定位表情框到对应位置
            $('#phiz').show().css({
                'left': $(this).offset().left,
                'top':$(this).offset().top + $(this).height() + 5
            });
            // 为每个表情图片添加事件
            var phizImg = $('#phiz img');
            var sign = this.getAttribute('sign');
            for (var j =0; j < phizImg.length; j++){
                phizImg[j].onclick = function(){
                    var content = $('textarea[sign='+sign+']');
                    content.val(content.val() + '[' + $(this).attr('title') + ']');
                    $('#phiz').hide();
                };
            }     
        };
    }

    // 关闭表情框
    $('.close').hover(function(){
        $(this).css('backgroundPosition', '-100px -200px');
    }, function(){
        $(this).css('backgroundPosition', '-75px -200px');
    }).click(function(){
        $(this).parent().parent().hide();
        $('#phiz').hide();
        if ($('turn').css('display')=='none'){
            $('#opcity_bg').remove();
        };
    });

    // 这一段代码在index.js 里面已经有了
    // //回复按钮
    // $('.comment_btn').click(function(){
    //     var data = {
    //         wid : $(this).attr('wid'),
    //         content : $(this).parent('ul').prev().val(),
    //     };
    //     $.post(postCommentUrl, data, function(data){
    //         alert(1);
    //     }, 'json');
    // });
    
    // 删除我发出的评论
    $('.del-comment').click(function(){
        var confirmDel = confirm('确定删除评论？');
        if (confirmDel){
            var data = {
                cid: $(this).attr('cid'),
            }
            var obj = $(this).parents('dl');
            $.post(delCommentUrl, data, function(data){
                if (data){
                    obj.slideUp('slow', function(){
                        obj.remove();
                    });
                }else
                    alert('删除失败');
            });
        }
    });

});