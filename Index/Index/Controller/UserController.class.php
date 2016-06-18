<?php
namespace Index\Controller;
use Think\Controller;
// 用户个人页面首页

class UserController extends CommonController {
		 
	public function index(){
		$uid = I('get.id');

		// 用户个人信息
		$field = array('uid', 'face180'=>'face', 'username', 'truename', 'sex', 'location', 
			'constellation', 'intro','follow', 'fans', 'weibo');
		$userinfo = M('userinfo')->where(array('uid'=>$uid))->field($field)->find();
		if (!$userinfo)
			$this->error("用户不存在");
		$this->userinfo = $userinfo;

		// 用户微博
		$db = D('WeiboView');
		$where = array('uid'=>$uid,);
		$count = D('WeiboView')->where($where)->count();
        $count = $db->getWeiboCount($where);
        $page = new \Think\Page($count, 10);
        $limit = $page->firstRow.','.$page->listRows;

        $this->page = $page->show();
        $this->weibo = $db->getAllWeibo($where, $limit); 

        // 用户关注的
        if (S('follow_'.$uid)){
        	$follow = S('follow_'.$uid);
        }else{
	        $limit = 8;
	        $where = array('fans'=>$uid);
	        $field = array('uid','username', 'face');
	        $follow = D('FollowView')->where($where)->field($field)->limit($limit)->select();
			S('follow_'.$uid, $follow, 3600);
		}
		$this->follow = $follow;
        
        // 用户的粉丝
        if (S('fans_'.$uid)){
        	$fans = S('fans_'.$uid);
        }else{
	        $where = array('follow'=>$uid);
	        $field = array('uid','username', 'face');
	        $limit = 8;
	        $fans = D('FansView')->where($where)->field($field)->limit($limit)->select();
       		S('fans_'.$uid, $fans, 3600);
        }
        $this->fans = $fans;

		$this->display();
	}

	/*
	空操作
	当尝试去访问一个controller 并不存在的 action 的时候，就会跳转到 _empty()方法来处理
	并把这个方法的名字传递给参数 $name
	 */
	public function _empty($name){
		echo "usercontroller _empty: ".$name."<br/>";
		$newurl = $this->_getUserUrl($name);
		// redirect($this->_getUserUrl($name));
		// redirect $this->_getUserUrl($name);
	}

	private function _getUserUrl($username){
		$username = htmlspecialchars($username);
		$uid = M('userinfo')->where(array('username'=>$username))->getField('uid');
		if (!$uid)
			return U('Index/index');
		else
			return U('User/index', array('id'=>$uid));
	}
}