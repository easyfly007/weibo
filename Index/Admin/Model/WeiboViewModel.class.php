<?php
namespace Admin\Model;
use Think\Model\ViewModel;


// tb_user 和 tb_userinfo 关联表
class WeiboViewModel extends ViewModel {
	protected $viewFields = array(
		'weibo'=>array(
			'id'=>'wid', 'content','time','original', 'forward','keep','comment','original',
			'_type'=>'LEFT'),
		'picture'=> array(
			'max'=>'pic',
			'_type'=>'LEFT',
			'_on'=>'picture.wid = weibo.id'
			),
		'userinfo' => array(
			'uid','username',
			'_on'=>'weibo.uid = userinfo.uid'),
	);
}