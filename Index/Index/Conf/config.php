<?php
return array(
	//'配置项'=>'配置值'

	// 图片上传大小（个人头像等）
	'UPLOAD_MAX_SIZE' => 200000000,

	// 文件上传地址
	'UPLOAD_ROOT' =>'Uploads/',
	'UPLOAD_FACE' =>'face/',
	'UPLOAD_PIC'  =>'pic/',
	// URL 路由功能
	'URL_ROUTER_ON' => true, // 开启路由
	'URL_ROUTE_RULES' => array(
		':id\d'=> 'User/index'
	),
);