<?php
namespace Index\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
    	echo 1;
    }

    public function register(){
    	$this->display();
    }

    // 获取验证码
    public function verify(){
    	$Verify = new \Think\Verify();
		$Verify->entry();
    }

    // 检测输入的验证码是否正确，$code为用户输入的验证码字符串
	public function check_verify($code, $id = ''){
	    $verify = new \Think\verify();
	    return $verify->check($code, $id);
	}
}