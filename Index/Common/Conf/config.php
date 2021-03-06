<?php
return array(
	//'配置项'=>'配置值'
	/* 数据库设置 */
    'DB_TYPE'               =>  'MySQL',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'db_weibo',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '',          // 密码
    'DB_PORT'               =>  '',        // 端口
    'DB_PREFIX'             =>  'tb_',    // 数据库表前缀
    'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8



    "ENCRYPTION_KEY"        =>  "myweibo.com", // for encryption key
    "AUTO_LOGIN_TIME"       =>   time() + 7*24*60*60, // cookie 的信息保存1个星期有效  

    // 自定义标签
    'TAGLIB_LOAD'           => true, //加载自定义标签库
    // 'APP_AUTOLOAD_PATH'     => '@.TagLib',// 自动加载文件路径
    // 'TAGLIB_PRE_LOAD'       =>"Index\TagLib\Wbtags",
    'TAGLIB_BUILD_IN'       =>'Cx,Wbtags', //把自定义标签加入到系统标签库 

    // 缓存设置
    // 'DATA_CACHE_SUBDIR' => true, //开启以hash形式生成缓存目录
    // 'DATA_PATH_LEVEL'   => 2, // 目录层次
    'DATA_CACHE_TYPE'   => 'Memcache',
    'MEMCACHE_HOST'     => '127.0.0.1',
    'MEMCACHE_PORT'     => 11211,
    'LOAD_EXT_CONFIG'   => 'system',

    'REGIST_ON'         => true,


);