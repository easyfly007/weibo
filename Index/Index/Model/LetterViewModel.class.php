<?php
namespace Index\Model;
use Think\Model\ViewModel;


// tb_letter 和 tb_userinfo 关联表
// 这个视图模型是用来显示首页的微博列表的，看看展示私信需要哪些东西？
// 收到信的那个人视图模型
class LetterViewModel extends ViewModel {
	protected $viewFields = array(
		'letter'=>array(
			'id'=>'lid', 'ufrom', 'uto', 'content', 'time',
			'_type' =>'LEFT' ),
		'userinfo' => array(
			'username', 'face50'=>'face',
			'_on'=>'letter.ufrom = userinfo.uid',
			'_type' =>'LEFT'),
	);
}
