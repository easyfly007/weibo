<?php
namespace Index\Model;
use Think\Model\ViewModel;

// tb_comment 和 tb_userinfo 关联表
// 这个视图模型是用来显示首页的评论的，看看展示一条评论需要哪些字段
class CommentViewModel extends ViewModel {
	protected $viewFields = array(
		'comment'=>array(
			'id', 'content', 'time', 'wid', 'uid',
			'_type' =>'LEFT' ),
		'userinfo' => array(
			'username', 'face50'=>'face',
			'_on'=>'comment.uid = userinfo.uid',
			),
	);
}
