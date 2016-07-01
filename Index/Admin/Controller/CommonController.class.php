<?php
namespace Admin\Controller;
use Think\Controller;
/*
 * 后台登陆控制器 
 */
class CommonController extends Controller {
    public function _initialize(){
    	if (!session('uid') || !session('username'))
    		redirect(U('Login/index'));
	}

}