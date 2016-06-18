<?php
namespace Index\Model;
use Think\Model\ViewModel;

// tb_userinfo 和 tb_follow 关联表
// 这个视图模型是用来显示那些被关注的人的信息
class FollowViewModel extends ViewModel {
	protected $viewFields = array(
		'follow'=>array(
			'follow', 'fans', 
			 '_type' =>'LEFT' ),
		'userinfo' => array(
			'username', 'face50'=>'face', 'uid',
			'_on'=>'follow.follow =userinfo.uid',),
	);

}
