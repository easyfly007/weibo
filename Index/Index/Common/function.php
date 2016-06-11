<?php
	// 将时间戳转化为输出格式
	function time_format($time){
		$now = time();
		$today000000 = strtotime(date('y-m-d', $now));
		$diff = $now - $time;
		$str = '';
		if ($diff < 60)
			$str = $diff.'秒前';
		else if ($diff < 60*60)
			$str = floor($diff/60).'分钟前';
		else if ($diff < 60*60*8)
			$str = floor($diff/60/60).'小时之前';
		else if ($time > $today000000)
			$str = "今天 ".date('H:i', $time);
		else
			$str = date('Y-m-d H:i:s', $time);

		return $str;
	}
?>

<?php

/**
 * 替换微博中的 输入 表情符文字，@
 * @param  [type] 带有 [] 和 @ 的微博正文
 * @return [type] 返回带有相应 url 转换的字符串
 */
	function replace_weibo($content){

		// 替换 url TODO: www. 考虑下
		$pattern = "/http:\/\/([\w.]+[\w\/]*[\w.]*[\w\/]*\??[\w=\&\+\%]*)/is";
		$content = preg_replace($pattern,
			"<a href ='http://\\1' target = '_blank' >\\1</a>", $content);
		
		// 给 @用户带上超链接
		$pattern = "/@(\S+)\s/is";
		$content = preg_replace($pattern, 
			'<a href = "'.__APP__.'/User/\\1">\\1</a>', $content);

		// 匹配表情符号
		$pattern ='/\[\S+\]/is';
		preg_match_all($pattern, $content, $matches);
		// 表情包 函数组
		$phiz = include "./Public/Data/phiz.php";
		if (!empty($matches[1])){
			foreach ($matches as $key => $value) {
				$name = array_search($value, $phiz);
				if ($name){
					$content = str_replace($matches[0][$key],
						"<img src = '".__ROOT__."/Public/Images/phiz/".$name.".gif' title = '".$value."' />", $content);
				}
			}
		}


		return $content;
	}

?>