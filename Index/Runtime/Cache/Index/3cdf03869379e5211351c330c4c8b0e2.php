<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html xmlns = "http://www.w3.org/1999/xhtml" xml:lang='en' >
<head>
	<META http-equiv= "Content-Type" content = "text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="/weibo/Public/Css/nav.css" />
	<link rel="stylesheet" type="text/css" href="/weibo/Public/Css/left.css" />
	<link rel="stylesheet" type="text/css" href="/weibo/Public/Css/middle.css" />
	<link rel="stylesheet" type="text/css" href="/weibo/Public/Css/right.css" />
	<link rel="stylesheet" type="text/css" href="/weibo/Public/Css/letter.css" />
	<link rel="stylesheet" type="text/css" href="/weibo/Public/Css/bottom.css" />

	<script type="text/javascript" src="/weibo/Public/Js/jquery-2.2.3.min.js"></script>
	<script type="text/javascript" src="/weibo/Public/Js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="/weibo/Public/Js/nav.js"></script>
	<script type="text/javascript" src="/weibo/Public/Js/left.js"></script>
	<title>微博首页</title>
	<link rel="stylesheet" type="text/css" href="/weibo/Public/Uploadify/uploadify.css" />
    <link rel="stylesheet" type="text/css" href="/weibo/Public/Css/index.css" />

	<script type="text/javascript" src="/weibo/Public/Uploadify/jquery.uploadify.min.js"></script>
    <script type="text/javascript" src="/weibo/Public/Js/index.js"></script>
    <script type="text/javascript">
    	var uploadUrl = "<?php echo U('Common/uploadPic');?>";
    	var PUBLIC = "/weibo/Public";
    	var ROOT = "/weibo";
    	var sid = "<?php echo session('uid');?>";
    </script>

</header>

<body>
	<!-- 顶部导航栏 -->
		<!-- // 顶部固定导航条 -->
	<div id= 'top_wrap'>
		<div id = 'top'>
			<div class = 'top_wrap'>
				<div class = "logo fleft"></div>
				<ul class = 'top_left fleft'>
					<li class='cur_bg'><a href="/weibo/index.php">首页</a></li>
					<li><a href="">私信</a></li>
					<li><a href="">评论</a></li>
					<li><a href="">@我的</a></li>
				</ul>
				<div id = 'search' class = 'fleft'>
					<form action = "<?php echo U('Search/searchuser');?>" method = 'get'>
						<input type = 'text' name = 'keyword' id = 'sech_text' class = 'fleft' placeholder = '搜索微博、找人' />
						<input type = 'submit' value = '' id = 'sech_sub' class = 'fleft' /> 
					</form>
				</div>
				<div class = 'user fleft'> 
					<a href=""><?php echo ($loginuser["username"]); ?></a>
				</div>
				<ul class = 'top_right fleft'>
					<li title = '快速发微博' class = 'fast_send'><i class = 'icon icon-write'></i></li>
					<li class = 'selector'><i class = 'icon icon-msg'></i>
						<ul class = 'hidden'>
							<li><a href="">查看评论</a></li>
							<li><a href="">查看私信</a></li>
							<li><a href="">查看收藏</a></li>
							<li><a href="">查看@我</a></li>
						</ul>
					</li>
					<li class ='selector'><i class = 'icon icon-setup'></i>
						<ul  >
							<li><a href="<?php echo U('Usersetting/Index');?>">账号设置</a></li>
							<li><a href="">模板设置</a></li>
							<li><a href="<?php echo U('Index/logout');?>">退出登录</a></li>
						</ul>
					</li>
					<!-- 消息推送 -->
					<li id = 'news' class = 'hidden'>
						<i class ='icon icon-news'></i>
						<ul>
							<li class = 'news_comment hidden'>
								<a href=""></a>
							</li>
							<li class = 'news_letter hidden'>
								<a href=""></a>
							</li>
							<li class = 'news_atme hidden'>
								<a href=""></a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>


	<?php
 $where = array('uid'=>session('uid')); $loginusergroups = M('group')->where($where)->select(); $loginusergroups[]=array('id'=>0,'name'=>"默认分组") ?>
	<script type="text/javascript">
		var addFollowUrl = "<?php echo U('Common/addFollow');?>";
	</script>
	<!-- 	加关注弹出框
		因为很多个页面都要用到，所以放到了这个页面包含在所有的网页中 -->
	<div id = 'follow'>
		<div class = 'follow_head'>
			<span class = 'follow_text fleft'>关注好友</span>
		</div>
		<div class = 'sel-group'>
			<span>好友分组</span>
			<select name = 'gid'>
				<!-- <option value = '0'>默认分组</option> -->
				<?php if(is_array($loginusergroups)): foreach($loginusergroups as $key=>$v): ?><option value = "<?php echo ($v['id']); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
			</select>
		</div>
		<div class = 'fl-btn-wrap'>
			<input type ='hidden' name = 'follow' />
			<span class = 'add-follow-sub'>关注</span>
			<span class = 'follow-cancel'>取消</span>
		</div>
	</div>

	<div style = 'height:60px; opcity:10'></div>
	<div class = 'main'>
		<!-- 左侧边栏 -->
		<div id = 'left' class = 'fleft'>
	<ul class = 'left_nav'>
		<li><a href="/weibo/index.php"><i class = 'icon icon-home'></i>&nbsp;首页</a></li>
		<li><a href=""><i></i>提到我的</a></li>
		<li><a href=""><i></i>评论</a></li>
		<li><a href=""><i></i>私信</a></li>
		<li><a href=""><i></i>收藏</a></li>
	</ul>
	<div class = 'group'>
		<fieldset><legend>分组</legend></fieldset>
		<ul>
			<li><a href=""><i></i>微博网友</a></li>
			<li><a href=""><i></i>分组1</a></li>
			<li><a href=""><i></i>分组2</a></li>
			<li><a href=""><i></i>分组2</a></li>
		</ul>
		<span id = 'create_group'>创建新的分组</span>
	</div>
</div>

<!-- 创建新的分组弹出对话框 -->
<script type="text/javascript">
	var addGroupUrl = "<?php echo U('Common/addGroup');?>";
</script>
<div id = 'add-group'>
	<div class = 'group_head'>
		<span class = 'group_text fleft'> 创建好友分组</span>
	</div>
	<div class = 'group-name'>
		<span>分组名称</span>
		<input type = 'text' name = 'name' id= 'gp-name'>
	</div>
	<div class = 'gp-btn-wrap'>
		<span class = 'add-group-sub'>添加</span>
		<span class = 'group-cancel'>取消</span>
	</div>
</div>
		<!-- 中部 -->
		<div id = 'middle' class = 'fleft'>
			<div class = 'send_wrap'>
				<div class = 'send_title fleft'></div>
				<div class = 'send_prompt fright'>
					<span>你还可以输入<span id = 'send_num'>150</span>个字</span>
				</div>
				<div class = 'send_write'>
					<form action = "<?php echo U('sendweibo');?>" method = 'post' name = 'weibo'>
						<textarea sign = 'weibo' name = 'content'></textarea>
						<div class = 'send_tool'>
							<ul class = 'fleft'>
								<li title = '表情'>
									<i class = 'icon icon-phiz phiz' sign = 'weibo' ></i>
								</li>
								<li title = '图片'>
									<i class = 'icon icon-picture'></i>
									<!-- 图片上传框 -->
									<div id = 'upload_img' class = 'hidden'>
										<div class = 'upload-title'>
											<p>本地上传</p>
											<span class = 'close'></span>
										</div>
										<div class = 'upload-btn'>
											<input type ='hidden' name = 'max' value = ''>
											<input type ='hidden' name = 'medium' value = ''>
											<input type ='hidden' name = 'mini' value = ''>
											<input type= 'file' name = 'picture' id='picture'>
										</div>
									</div>
									<!-- 图片上传框 -->
									<div id = 'pic-show' class = 'hidden'>
										<img src="" alt = '' />
									</div>
								</li>
							</ul>
							<input type = 'submit' value = '' class = 'send_btn fright' title = '发布微博' />
						</div>
					</form>
				</div>
			</div>

			<!-- 微博发布框 -->
			<div class = 'view_line'>
				<strong>微博</strong>
			</div>

			<!-- 普通微博样式 -->
			<div class = 'weibo'>
				<!-- 头像 -->
				<div class = 'face'>
					<a href="">
						<img src="" width = '50' height = '50'>
					</a>
				</div>
				<div class = 'wb_cons'>

				</div>
			</div>
		</div>
	</div>

	<div id = 'bottom'>
	<div class = 'link'>
		<dl>
			<dt>xx 论坛</dt>
			<dd><a href="">a</a></dd>
			<dd><a href="">a</a></dd>
			<dd><a href="">a</a></dd>
		</dl>
		<dl>
			<dt>xx 论坛2</dt>
			<dd><a href="">b</a></dd>
			<dd><a href="">b</a></dd>
			<dd><a href="">b</a></dd>
		</dl>
	</div>

	<div id = 'copy'>
		<div>
			<p>版权所有 ICP 备案</p>
		</div>
	</div>
</div>

<!-- 自定义模板 -->
<div id = 'model' class = 'hidden'>
	<div class = 'model_head'>
		<span class = 'model_text'>个性化设置</span>
		<span class = 'close fright'></span>
	</div>
	<ul>
		<li class  = 'style1'></li>
		<li class  = 'style1'></li>
		<li class  = 'style1'></li>
	</ul>
	<div class = 'model_operat'>
		<span class = 'model_save'>保存</span>
		<span class = 'model_cancel'>取消</span>
	</div>
</div>

<!-- 转发输入框 -->
<div id = 'turn' class = 'hidden'>
	<div class = 'turn_head'>
		<span class = 'turn_text fleft'>转发微博</span>
		<span class = 'close fright'></span>
	</div>
	<div class = 'turn_main'>
		<form method = '' action = '' name = 'turn'>
			<p></p>
			<div class = 'turn_prompt'>
				你还可以输入<span>140</span> 个字
			</div>
			<textarea name = 'content' sign = 'turn'></textarea>
			<ul>
				<li></li>
				<li>
					<label>
						<input> 同时评论给user02
					</label>
				</li>
			</ul>
		</form>
	</div>
</div>

<!-- 表情选择框 -->
<div id = '' class = 'hidden'>
	<div>
		<p>常用表情</p>
		<span class = 'close fright'></span>
	</div>
	<ul>
		<li><img src=""></li>
		<li><img src=""></li>
		<li><img src=""></li>
		<li><img src=""></li>
		<li><img src=""></li>
		<li><img src=""></li>
		<li><img src=""></li>
		<li><img src=""></li>
	</ul>
</div>
</body>
</html>