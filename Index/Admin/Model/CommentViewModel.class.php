<?php
namespace Admin\Model;
use Think\Model\ViewModel;


// tb_user 和 tb_userinfo 关联表
class CommentViewModel extends ViewModel {
	protected $viewFields = array(
		'comment'=>array(
			'id'=>'cid', 'content','time',
			'_type'=>'LEFT'),
		'userinfo' => array(
			'uid','username',
			'_on'=>'comment.uid = userinfo.uid'),
	);
}