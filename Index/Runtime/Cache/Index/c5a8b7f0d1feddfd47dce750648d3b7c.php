<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html xmlns = "http://www.w3.org/1999/xhtml" xml:lang='en'>
<header>
	<META http-equiv= "COntent-Type" content = "text/html; charset=UTF-8">
	<title>微博登录</title>
	<link rel="stylesheet" type="text/css" href="/weibo/Public/Css/login.css" />
	<script type="text/javascript" src="/weibo/Public/Js/jquery-2.2.3.min.js"></script>
	<script type="text/javascript" src="/weibo/Public/Js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="/weibo/Public/Js/login.js"></script>
	<script type="text/javascript">
		var checkAccount = "<?php echo U('Login/checkAccount');?>";
		// var checkUname = "<?php echo U('Login/checkUname');?>";
		// var checkVerify = "<?php echo U('Login/checkVerify');?>";
		// checkAccount 变量会在regist.js 里面用到
	</script>

</header>

<body>
	<div id = 'top-bg'>
	</div>
	<div id = 'login-form'>
		<div id = 'login-wrap'>
			<p>还没有微博账号？<a href="<?php echo U('register');?>"> 立即注册</a></p>
			<form action = "<?php echo U('login/login');?>" method = "post" name = 'login'>
				<fieldset>
					<legend>用户登录</legend>
					<p>
						<label for = "account">登录账号：</label>
						<input type ='text' name = "account" value = "" class = 'input'>
					</p>
					<p>
						<label for = "pwd">密码</label>
						<input type = 'password' name = "pwd" value = "" class = "input">
					</p>
					<p>
						<input type = 'checkbox' name = 'auto' checked = '1' id = 'auto'>
						<label for = 'auto'> 下次自动登录</label>
					</p>
					<p>
						<input type = 'submit' name = '' value = '马上登录' id ='login'>
					</p>
				</fieldset>

			</form>
		</div>
	</div>
</body>

</thml>