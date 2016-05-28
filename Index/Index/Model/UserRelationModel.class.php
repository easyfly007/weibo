<?php
namespace Index\Model;
use Think\Model\RelationModel;

// tb_user 和 tb_userinfo 关联表

class UserRelationModel extends RelationModel {
	protected $tableName = 'user';

	protected $_link = array(
		'userinfo' =>array(
			'mapping_type' => self::HAS_ONE, // 1 对 1 的关系
			'foreign_key' =>'uid',
			),
		);

	// 定义插入数据的方法 用以外部调用
	public function insert($data= NULL){
		// 无参数是默认从POST 中取
		$data = is_null($data)? $_POST:$data;
		 // 创建数据对象，并插入
		return $this->relation(true)->add($data);
	}
}
