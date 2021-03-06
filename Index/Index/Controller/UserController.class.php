<?php
namespace Index\Controller;
use Think\Controller;
// 用户个人页面首页

class UserController extends CommonController {
		 
	public function index(){
		$uid = I('get.uid');

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

	// 显示用户的关注或者粉丝
	public function followlist(){
		$uid = I('get.uid');
		$type = I('get.type'); // 1 关注列表， 0 粉丝列表
		$this->user = M('userinfo')->where(array('uid'=>$uid))->field('username')->find();
		if ($type ==1){
			// 关注列表
			$this->type = 'follow';
			$where = array('fans'=>$uid);
			$db = D('FollowView');
			
		}else{
			// 粉丝列表
			$this->type = 'fans';
			$where = array('follow'=>$uid);
			$db = D('FansView');
		}
		$count = $db->where($where)->count();
		$page = new \Think\Page($count, 20);
		$limit = $page->firstRow.','.$page->listRows;
		$users = $db->where($where)->limit($limit)->select();
		$this->followlist = $users;
        $this->page = $page->show();
        $this->listcount = $count;

       // 登陆用户
        $where = array('fans'=>session('uid'));
        $loginuserfollow = M('follow')->where($where)->select();
        foreach ($loginuserfollow as $key => $value) {
        	$loginuserfollow[$key] = $value['follow']; 
        }

        $where = array('follow'=>session('uid'));
        $loginuserfans = M('follow')->where($where)->select();
        foreach ($loginuserfans as $key => $value) {
        	$loginuserfans[$key] = $value['fans'];
        }

        $this->loginuserfans = $loginuserfans;
        $this->loginuserfollow = $loginuserfollow;

        $this->display();
	}

	// 显示我的收藏列表
	public function keeplist(){
		// $this->display();
		$keep = M('keep')->where(array('uid'=>session('uid')))
			->field(array('wid'))->select();
		foreach ($keep as $key => $value) {
			$keep[$key] = $value['wid'];
		}
		$where = array(
			'id'=>array('IN', $keep));
		$db = D('WeiboView');
        $count = $db->getWeiboCount($where);
        $page = new \Think\Page($count, 20);
        $limit = $page->firstRow.','.$page->listRows;

        $this->page = $page->show();
        $weibo = $db->getAllWeibo($where, $limit);
        foreach ($weibo as $key => $value) {
        	$weibo[$key]['kept'] = 1;
        }
        $this->weibo = $weibo;
		$this->display();
	}


	// 显示私信列表
	public function letterlist(){
		set_msg(session('uid'), 2, true);
		// 我收到的私信
		$letters = D('LetterView')->select();
		$where = array(
			'uto'=>session('uid'));
		$count = D('LetterView')->where($where)->count();
        $page = new \Think\Page($count, 20);
        $limit = $page->firstRow.','.$page->listRows;
        $this->page = $page->show();

		$letters = D('LetterView')->where($where)->limit($limit)
			->order('time DESC')->select();
		$this->count = $count;
		$this->letters = $letters;

		$this->display();
	}


	// 发送私信
	public function lettersend(){
		if (!IS_POST)
			$this->error("页面不存在");
		$name = I('post.name');
		$content = I('post.content');

		$where = array('username'=>$name);
		$uid = M('userinfo')->where($where)->getField('uid');
		if (!$uid){
			$this->error(" 用户不存在！");
		}

		$data = array(
			'ufrom'=>session('uid'),
			'uto'=>$uid,
			'content'=>$content,
			'time'=>time());
		
		set_msg($uid, 2);

		if ($lid = M('letter')->data($data)->add())
			$this->success('私信已经发送！', U('User/letterlist'));
		else
			$this->error("发送失败，请重试");
	}

	// 获取我写的评论，而不是写给我的评论
	public function commentlist(){
		set_msg(session('uid'), 2,true);

		$where = array('uid'=>session('uid'));
		$commentcount = D('CommentView')->where($where)->count(); 
		$page = new \Think\Page($commentcount, 20);
		$limit = $page->firstRow.','.$page->listRows;

		$comments = D('CommentView')->where($where)->limit($limit)->order('time DESC')->select();
		$this->comments = $comments;
		$this->page = $page->show();
		$this->commentcount = $commentcount;
		$this->display();
	}


	// 找到所有的at 我的微博
	public function atmelist(){
		set_msg(session('uid'),3, true);
		$where = array('uid'=>session('uid'));
		$atme = M('atme')->where($where)->select();
		foreach ($atme as $key => $value) {
			$atme[$key] = $value['wid'];
		}
		$count = count($atme);
		$where = array('id'=>array('IN', $atme));
		$page = new \Think\Page($count, 10);
        $limit = $page->firstRow.','.$page->listRows;
        $this->page = $page->show();
        $this->weibo = D('WeiboView')->getAllWeibo($where, $limit); 
        $this->display();
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