<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 后台首页控制器
 * @return   [<description>]
 */
class IndexController extends Controller {
    public function index(){
    	$this->display();
    }

    public function copy(){
    	$this->display();

    }
}