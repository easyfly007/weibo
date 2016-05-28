<?php
namespace Index\Controller;
use Think\Controller;
class CommonController extends Controller {
	// 登录检查
	public function _initialize(){
		if (session('uid'))
			redirect(U('Login/index'));
	}
}