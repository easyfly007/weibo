<?php
	// 将时间戳转化为输出格式
	function time_format($time){
		$now = time();
		$today000000 = strtotime(date('y-m-d', $now));
		echo date('Y-m-d Y:i:s', $today000000);
	}

?>