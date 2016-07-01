<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 后台首页控制器
 * @return   [<description>]
 */
class IndexController extends CommonController {
    public function index(){
    	$this->display();
    }

    public function copy(){
    	$this->display();
    }

    public function logout(){
    	session_unset();
    	session_destroy();
    	redirect(U('Login/index'));
    }
}