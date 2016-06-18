<?php
namespace Index\Controller;
use Think\Controller;
// 搜索控制器
class SearchController extends CommonController {   
    public function index(){
    	$this->display();
    }

    public function searchuser(){
    	$keyword = I('get.keyword');
    	// TODO: 考虑用空格分隔的多个关键词检索
    	if ($keyword){
    		// 利用%检索数据库，但是要排除自己
    		$where = array(
    			'username'=>array('LIKE', '%'.$keyword.'%'),
    			'uid'=>array('NEQ', session('uid')),);
    		$fields = array('uid', 'username', 'sex', 'location',
    		 'intro', 'follow','face80', 'fan', 'weibo',);

    		$count = M('userinfo')->where($where)->count();
    		$page = new \Think\Page($count, 10);
    		$limit = $page->firstRow.','.$page->listRows;
    		$this->page = $page->show();
    		$searchusers = M('userinfo')->where($where)
    			->limit($limit)->select();
    		$this->searchusers = $this->_getFollowRelation($searchusers);
    		$this->keyword = $keyword;
    		$this->count = $count;
    	}
    	else{
    		$this->searchusers= null;
    		$this->page = null;
    		$this->keyword = null;
    	}
    	$this->display();
    }

    	/// 用来判断 user 和  登录用户的关注关系
    	/// 0 表示互相没有关注
    	/// 1 表示已经关注，但是对方没有关注你
    	/// 2 表示互相已经关注
    private function _getFollowRelation($users){
    	if (!$users || count($users)==0)
    		return false;
    	$db = M('follow');
    	foreach ($users as $key=>$val) {
    		// 我是否关注了他
    		$where = array(
    			'follow'=>$val['uid'],
    			'fans' =>session('uid'));
    		$ifollowyou = $db->where($where)->count();
			
			// 他是否关注了我
    		$where = array(
    			'follow'=>session('uid'),
    			'fans'=>$val['uid']);
    		$youfollowme = $db->where($where)->count();
    		
    		$users[$key]['ifollowyou'] = $ifollowyou;
    		$users[$key]['youfollowme'] = $youfollowme;
    	}
    	return $users;
    }


}
