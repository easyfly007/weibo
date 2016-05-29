<?php
namespace Index\Controller;
use Think\Controller;
class IndexController extends CommonController {
	    
    public function index(){
    	$this->display();
    }

    public function logout(){
    	session('uid', null);
    	cookie('auto',null);
    	$this->display("Index/index");
    }
}