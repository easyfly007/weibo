<?php
namespace Index\Model;
use Think\Model\ViewModel;

// tb_weibo 和 tb_picture 关联表
// 这个视图模型是用来显示首页的微博列表的，看看展示微博首页需要哪些字段
class WeiboViewModel extends ViewModel {
	protected $viewFields = array(
		'weibo'=>array(
			'id', 'content', 'time', 'forward', 'original',
			'keep', 'comment', 'uid', '_type' =>'LEFT' ),
		'userinfo' => array(
			'username', 'face50'=>'face',
			'_on'=>'weibo.uid = userinfo.uid',
			'_type' =>'LEFT'),
		'picture'=>array(
			'mini', 'medium', 'max',
			'_on'=>'weibo.id = picture.wid'
			),
	);

	// 查询所有的微博记录
	public function getAllWeibo($where){
		$result = $this->where($where)->order('time DESC')->select();

		// 为了那些转发的微博找到原微博
		if ($result){
			foreach ($result as $key => $value) {
				if ($value['original']>0){
					// $where = array('id'=>$v['forward']);
					$result[$key]['original'] = $this->find($value['original']); 
				}
			}
		}
		return $result;

	}
}
