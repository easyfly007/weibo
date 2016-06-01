<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html xmlns = "http://www.w3.org/1999/xhtml" xml:lang='en'>
<header>
	<META http-equiv= "Content-Type" content = "text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="/weibo/Public/Css/nav.css" />
	<link rel="stylesheet" type="text/css" href="/weibo/Public/Css/bottom.css" />
	<script type="text/javascript" src="/weibo/Public/Js/jquery-2.2.3.min.js"></script>
	<script type="text/javascript" src="/weibo/Public/Js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="/weibo/Public/Js/nav.js"></script>

	<title>用户设置首页</title>
	<link rel="stylesheet" type="text/css" href="/weibo/Public/Uploadify/uploadify.css" />
	<script type="text/javascript" src="/weibo/Public/Uploadify/jquery.uploadify.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/weibo/Public/Css/nav.css" />
	<link rel="stylesheet" type="text/css" href="/weibo/Public/Css/bottom.css" />

	<link rel="stylesheet" type="text/css" href="/weibo/Public/Css/edit.css" />
	<script type="text/javascript" src="/weibo/Public/Js/city.js"></script>
	<script type="text/javascript" src="/weibo/Public/Js/useredit.js"></script>

    <script type="text/javascript">
    // for useredit.js
    	var constellation = "<?php echo ($loginuser["constellation"]); ?>";
    	var thelocation = "<?php echo ($loginuser["location"]); ?>";
    	var PUBLIC = "/weibo/Public";
    	var uploadUrl = "<?php echo U('Common/uploadFace');?>";
    	var sid = "<?php echo session_id();?>";
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
					<li class='cur_bg'>首页</li>
					<li><a href="">私信</a></li>
					<li><a href="">评论</a></li>
					<li><a href="">@我的</a></li>
				</ul>
				<div id = 'search' class = 'fleft'>
					<form action = '' method = 'get'>
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
	<div style = "height:60px; opcity:10"></div>
	<div class = 'main'>
		<!-- 左侧边栏 -->
		<div id = 'left' class = 'fleft'>
	<ul class = 'left_nav'>
		<li><a href=""><i class = 'icon icon-home'></i>&nbsp;首页</a></li>
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
		<span id = 'create_group'><a href="">创建新的分组</a></span>
	</div>
</div>
		<div id = 'right'>
			<ul id = 'sel-edit'>
				<li class = 'edit-cur'> 基本信息</li>
				<li>修改头像</li>
				<li>修改密码</li>
			</ul>
			<div class = 'form'>
				<form action ="<?php echo U('Usersetting/editbasic');?>" method = 'post'>
					<p>
						<label for='nickname'><span class = 'red'>*</span>昵称：</label>
						<input type = 'text' name = 'nickname' class = 'input' value = "<?php echo ($loginuser['username']); ?>" class = 'input'>
					</p>
					<p>
						<label for='truename'>真实姓名</label>
						<input type = 'text' name = 'truename' class = 'input' value = "<?php echo ($loginuser['truename']); ?>" >
					</p>
					<p>
						<label for='sex'><span class = 'red'>*</span>性别</label>
						<?php if($loginuser["sex"] == 'm'): ?><input type = 'radio' name = 'sex' value = 'm' checked = 'true' >
						<?php else: ?>
							<input type = 'radio' name = 'sex' value = 'm' ><?php endif; ?>
						 &nbsp;男&nbsp;&nbsp;
						<?php if($loginuser["sex"] == 'f'): ?><input type = 'radio' name = 'sex' value = 'f' checked = 'true' >
						<?php else: ?>
							<input type = 'radio' name = 'sex' value = 'f' ><?php endif; ?>
						 &nbsp;女&nbsp;
					</p>
					<p>
						<label>所在地</label>
						<select name = 'province'>
							<option value = ''>请选择</option>
						</select>
						&nbsp;&nbsp;
						<select name = 'city'>
							<option value =''> 请选择</option>
						</select>
					</p>
					<p>
						<label for ='constellation'>星座</label>
						<select name = 'constellation'>
							<option value = ''>请选择</option>
							<option value = "摩羯座">摩羯座</option>
							<option value = "水瓶座">水瓶座</option>
							<option value = "双鱼座">双鱼座</option>
							<option value = "白羊座">白羊座</option>
							<option value = "金牛座">金牛座</option>
							<option value = "双子座">双子座</option>
							<option value = "巨蟹座">巨蟹座</option>
							<option value = "狮子座">狮子座</option>
							<option value = "处女座">处女座</option>
							<option value = "天秤座">天秤座</option>
							<option value = "天蝎座">天蝎座</option>
							<option value = "射手座">射手座</option>
						</select>
					</p>
					<p>
						<label for = 'intro' class = 'intro'>一句话介绍自己</label>
						<textarea name = 'intro' value = '<?php echo ($loginuser["intro"]); ?>'></textarea>
					</p>
					<p>
						<input type = 'submit' value = '保存修改' class = 'edit-sub'>
					</p>
				</form>
			</div>

			<div class = 'form hidden'>
				<form action ="" action = "">
					<div class = 'edit-face'>
						<img src="/weibo/Public/Images/noface.gif" width = '180' height = '180'>
						<p>
							<input type = 'file' name = 'face' id = 'face'/>
						</p>
						<p>
							<input type = 'submit' value = '保存修改' class = 'edit-sub' />
						</p>
					</div>
				</form>
			</div>

			<div class = 'form hidden'>
				<form action = "" method = "">
					<p class= 'account' > 登录邮箱：<span>admin@admin.com</span></p>
					<p>
						<label for = ""> <span class = "red">*</span> 旧密码</label>
						<input type = 'password' name = 'oldpwd'>
					</p>
					<p>
						<label for = ""> <span class = 'red'>*</span> 新的密码</label>
						<input type = 'password' name = 'newpwd'>
					</p>
					<p>
						<label for = ""> <span class = 'red'>*</span> 再输入一遍</label>
						<input type = 'password' name = 'newpwd'>
					</p>
					<p>
						<input type = 'submit' value ="确认修改" class = 'edit-sub'>
				</form>
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