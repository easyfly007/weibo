<?php
namespace Index\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	// header("Content-Type:text/html; Charset = unicode");
    	$this->display();
    }
}