<?php
namespace Admin\Model;
use Think\Model\RelationModel;


// 用于一口气删除所有和这个微博有关的内容
class WeiboRelationModel extends RelationModel {
	protected $tableName = 'weibo';

	protected $_link = array(
		'picture' =>array(
			'mapping_type' => HAS_ONE,
			'foreign_key' =>'wid'),
		'comment' =>array(
			'mapping_type' =>HAS_MANY,
			'foreign_key'=>'wid'),
		'keep' => array(
			'mapping_type' => HAS_MANY,
			'foreign_key'=>'wid'),
		'atme' => array(
			'mapping_type'=>HAS_MANY,
			'foreign_key'=>'wid'),
		);
}