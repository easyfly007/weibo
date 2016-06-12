<?php
namespace Index\Controller;
use Think\Controller;
// 用户个人页面首页

class UserController extends Controller {
		 
	public function index(){
		echo "usercontroller index function ";
	}

	/*
	空操作
	当尝试去访问一个controller 并不存在的 action 的时候，就会跳转到 _empty()方法来处理
	并把这个方法的名字传递给参数 $name
	 */
	public function _empty($name){
		echo "usercontroller _empty: ".$name."<br/>";
		$newurl = $this->_getUserUrl($name);
		redirect($this->_getUserUrl($name));
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