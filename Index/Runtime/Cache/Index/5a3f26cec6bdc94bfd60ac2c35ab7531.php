<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html xmlns = 'http://www.w3.org/1999/xhtml' xml:lang = 'en'>
<head>
	<META http-equiv="Content-Type" content = "text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="/weibo/Public/Css/regis.css" />
	<script type="text/javascript" src="/weibo/Public/Js/jquery-2.2.3.min.js"></script>
	<script type="text/javascript" src="/weibo/Public/Js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="/weibo/Public/Js/regist.js"></script>

	<title>
		微博-注册
	</title>
</head>

<body>
	<div id = 'logo'></div>
	<div id = 'reg-wrap'>
		<form action ="" method = 'get' name='register'>
			<fieldset>
				<legend> 用户注册</legend>
				<p>
					<label for="account">登录账号</label>
					<input type = 'text' name = 'account' id = 'account' class = 'input'>
				</p>
				<p>
					<label for = 'pwd'>登录密码</label>
					<input type = 'password' name = 'pwd' id = 'pwd' class = 'input'>
				</p>
				<p>
					<label for = 'pwded'>确认密码</label>
					<input type = 'password' name = 'pwded' id = 'pwded' class = 'input'>
				</p>
				<p>
					<label for = 'uname'> 昵称</label>
					<input type = 'text' name = 'uname' id = 'uname' class = 'input'>
				</p>
				<p>
					<label for = 'verify'> 验证码</label>
					<input type = 'text' name = 'verify' class = 'input' >
					<img src="<?php echo U('verify');?>" width = '150' height = '40' id = 'verify-img' />
				</p>
				<p class = 'run'>
					<input type = 'submit' value = '马上注册' id = 'regis'>
				</p>
			</fieldset>
		</form>
	</div>
</body>

</html>