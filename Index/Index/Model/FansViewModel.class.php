<?php
namespace Index\Model;
use Think\Model\ViewModel;

// tb_userinfo 和 tb_follow 关联表
// 这个视图模型是用来显示那些作为粉丝的用户的信息的
class FansViewModel extends ViewModel {
	protected $viewFields = array(
		'follow'=>array(
			'follow', 'fans', 
			 '_type' =>'LEFT' ),
		'userinfo' => array(
			'username', 'face50'=>'face', 'uid','weibo',
			'_on'=>'follow.fans =userinfo.uid',),
	);

}
