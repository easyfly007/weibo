<?php
namespace Admin\Model;
use Think\Model\ViewModel;


// tb_user 和 tb_userinfo 关联表
class UserViewModel extends ViewModel {
	protected $viewFields = array(
		'user'=>array(
			'id', 'registime', 'locked'),
		'userinfo' => array(
			'username', 'face50'=>'face','follow', 'fans', 'weibo',
			'_on'=>'user.id = userinfo.uid'),
	);
}