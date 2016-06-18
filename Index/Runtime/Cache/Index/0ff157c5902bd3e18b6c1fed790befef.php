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
	<title>用户设置首页</title>
	<link rel="stylesheet" type="text/css" href="/weibo/Public/Uploadify/uploadify.css" />
	<script type="text/javascript" src="/weibo/Public/Uploadify/jquery.uploadify.min.js"></script>
	<script type="text/javascript" src="/weibo/Public/Js/jquery.validate.min.js"></script>

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
    	var ROOT = '/weibo';
    	var checkPwd = "<?php echo U('checkPwd');?>";
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
						<ul class='hidden' >
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
	<div style = "height:60px; opcity:10"></div>
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
			<?php
 $groups = M('group')->where(array('uid'=>session('uid')))->select(); ?>
			<li><a href = "<?php echo U(Index/idnex);?>"> <i class = 'icon icon-group'></i>&nbsp;全部</a></li>
			<?php if(is_array($groups)): foreach($groups as $key=>$v): ?><li><a href="<?php echo U('Index/index', array('gid'=>$v['id']));?>">
					<i class = 'icon icon-group'></i>&nbsp;<?php echo ($v['name']); ?></a>
				</li><?php endforeach; endif; ?>
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
				<form action ="<?php echo U('Usersetting/editface');?>" method = "post">
					<div class = 'edit-face'>
						<?php if($loginuser['face180']): ?><img src="/weibo/<?php echo ($loginuser['face180']); ?>" width = '180' height = '180' id = 'face-image'>
						<?php else: ?>
							<img src="/weibo/Public/Images/noface.gif" width = '180' height = '180' id = 'face-image'>
							<img src=""><?php endif; ?>
						<p>
							<input type = 'file' name = 'face' id = 'face'/>
						</p>
						<p>
							<input type = 'hidden' name = 'face180' value = '1'>
							<input type = 'hidden' name = 'face80'  value = '2'>
							<input type = 'hidden' name = 'face50'  value = '3'>
							<input type = 'submit' value = '保存修改' class = 'edit-sub' />
						</p>
					</div>
				</form>
			</div>

			<div class = 'form hidden'>
				<form action = "<?php echo U('editpwd');?>" method = "post" name  = 'changepwd'>
					<p class= 'account' > 登录邮箱：<span>admin@admin.com</span></p>
					<p>
						<label for = ""> <span class = "red">*</span> 旧密码</label>
						<input type = 'password' name = 'oldpwd' id = 'oldpwd'>
					</p>
					<p>
						<label for = ""> <span class = 'red'>*</span> 新的密码</label>
						<input type = 'password' name = 'newpwd' id = 'newpwd'>
					</p>
					<p>
						<label for = ""> <span class = 'red'>*</span> 再输入一遍</label>
						<input type = 'password' name = 'newpwd2' id = 'newpwd2'>
					</p>
					<p>
						<input type = 'submit' value ="确认修改" class = 'edit-sub'>
					</p>
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
		<form method = 'post' action = "<?php echo U('Index/turn');?>" name = 'turn'>
			<p></p>
			<div class = 'turn_prompt'>
				你还可以输入<span>140</span> 个字
			</div>
			<textarea name = 'content' sign = 'turn'></textarea>
			<ul>
				<li class = 'phiz fleft' sign='turn'></li>
				<li class = 'turn_comment fleft'>
					<label>
						<input type='checkbox' name='becomment' /> 同时评论给<span class= 'turn_cname'></span>
					</label>
				</li>
				<li class = 'turn_btn fright'>
					<input type = 'hidden' name = 'id' value = '/'>
					<input type = 'hidden' name = 'orgid' value = '' />
					<input type = 'submit' value = '转发' class = 'turn_btn' />
				</li>
			</ul>
		</form>
	</div>
</div>


<!-- 表情选择框 -->
<div id = 'phiz' class = 'hidden'>
	<div>
		<p>常用表情</p>
		<span class = 'close fright'></span>
	</div>
	<ul>
		<li><img src="/weibo/Public/Images/phiz/hehe.gif" alt='呵呵' title ='呵呵'></li>
		<li><img src="/weibo/Public/Images/phiz/xixi.gif" alt='嘻嘻' title ='嘻嘻'></li>
		<li><img src="/weibo/Public/Images/phiz/haha.gif" alt='哈哈' title ='哈哈'></li>
		<li><img src="/weibo/Public/Images/phiz/keai.gif" alt='可爱' title ='可爱'></li>
		<li><img src="/weibo/Public/Images/phiz/kelian.gif" alt='可怜' title ='可怜'></li>
		<li><img src="/weibo/Public/Images/phiz/wabisi.gif" alt='挖鼻屎' title ='挖鼻屎'></li>
		<li><img src="/weibo/Public/Images/phiz/chijing.gif" alt='吃惊' title ='吃惊'></li>
		<li><img src="/weibo/Public/Images/phiz/haixiu.gif" alt='害羞' title ='害羞'></li>
		<li><img src="/weibo/Public/Images/phiz/jiyan.gif" alt='挤眼' title ='挤眼'></li>
		<li><img src="/weibo/Public/Images/phiz/bizui.gif" alt='闭嘴' title ='闭嘴'></li>
		<li><img src="/weibo/Public/Images/phiz/bishi.gif" alt='鄙视' title ='鄙视'></li>
		<li><img src="/weibo/Public/Images/phiz/aini.gif" alt='爱你' title ='爱你'></li>
		<li><img src="/weibo/Public/Images/phiz/lei.gif" alt='累' title ='类'></li>
		<li><img src="/weibo/Public/Images/phiz/touxiao.gif" alt='偷笑' title ='偷笑'></li>
		<li><img src="/weibo/Public/Images/phiz/shengbing.gif" alt='生病' title ='生病'></li>
		<li><img src="/weibo/Public/Images/phiz/taikaixin.gif" alt='太开心' title ='太开心'></li>
		<li><img src="/weibo/Public/Images/phiz/qinqin.gif" alt='亲亲' title ='亲亲'></li>
		<li><img src="/weibo/Public/Images/phiz/landelini.gif" alt='懒得理你' title ='懒得理你'></li>
		<li><img src="/weibo/Public/Images/phiz/zuohengheng.gif" alt='' title ='左哼哼'></li>
		<li><img src="/weibo/Public/Images/phiz/youhengheng.gif" alt='右哼哼' title ='右哼哼'></li>
		<li><img src="/weibo/Public/Images/phiz/xu.gif" alt='嘘' title ='嘘'></li>
		<li><img src="/weibo/Public/Images/phiz/shuai.gif" alt='衰' title ='衰'></li>
		<li><img src="/weibo/Public/Images/phiz/weiqu.gif" alt='委屈' title ='委屈'></li>
		<li><img src="/weibo/Public/Images/phiz/tu.gif" alt='吐' title ='吐'></li>
		<li><img src="/weibo/Public/Images/phiz/dahaqian.gif" alt='打哈欠' title ='打哈欠'></li>
		<li><img src="/weibo/Public/Images/phiz/baobao.gif" alt='抱抱' title ='抱抱'></li>
		<li><img src="/weibo/Public/Images/phiz/nu.gif" alt='怒' title ='怒'></li>
		<li><img src="/weibo/Public/Images/phiz/yiwen.gif" alt='疑问' title ='疑问'></li>
		<li><img src="/weibo/Public/Images/phiz/chanzui.gif" alt='馋嘴' title ='馋嘴'></li>
		<li><img src="/weibo/Public/Images/phiz/baibai.gif" alt='拜拜' title ='拜拜'></li>
		<li><img src="/weibo/Public/Images/phiz/sikao.gif" alt='思考' title ='思考'></li>
		<li><img src="/weibo/Public/Images/phiz/han.gif" alt='汗' title ='汗'></li>
		<li><img src="/weibo/Public/Images/phiz/kun.gif" alt='困' title ='困'></li>
		<li><img src="/weibo/Public/Images/phiz/shuijiao.gif" alt='睡觉' title ='睡觉'></li>
		<li><img src="/weibo/Public/Images/phiz/qian.gif" alt='钱' title ='钱'></li>
		<li><img src="/weibo/Public/Images/phiz/shiwang.gif" alt='失望' title ='失望'></li>
		<li><img src="/weibo/Public/Images/phiz/ku.gif" alt='哭' title ='哭'></li>
		<li><img src="/weibo/Public/Images/phiz/huaxin.gif" alt='花心' title ='花心'></li>
		<li><img src="/weibo/Public/Images/phiz/heng.gif" alt='哼' title ='哼'></li>
		<li><img src="/weibo/Public/Images/phiz/guzhang.gif" alt='鼓掌' title ='鼓掌'></li>
		<li><img src="/weibo/Public/Images/phiz/yun.gif" alt='晕' title ='晕'></li>
		<li><img src="/weibo/Public/Images/phiz/beishang.gif" alt='悲伤' title ='悲伤'></li>
		<li><img src="/weibo/Public/Images/phiz/zhuakuang.gif" alt='抓狂' title ='抓狂'></li>
		<li><img src="/weibo/Public/Images/phiz/heixian.gif" alt='黑线' title ='黑线'></li>
		<li><img src="/weibo/Public/Images/phiz/yinxian.gif" alt='阴险' title ='阴险'></li>
		<li><img src="/weibo/Public/Images/phiz/numa.gif" alt='怒骂' title ='怒骂'></li>
		<li><img src="/weibo/Public/Images/phiz/xin.gif" alt='心' title ='心'></li>
		<li><img src="/weibo/Public/Images/phiz/shangxin.gif" alt='伤心' title ='伤心'></li>

	</ul>
</div>
</body>
</html>