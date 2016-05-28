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
	public function checkVerify(){
        if (!IS_AJAX)
            $this->error('禁止访问！');
        $code = $_POST['verify'];
        $id = isset($_POST['id'])? $_POST['id']:'';
	    $verify = new \Think\Verify();
	    if ($verify->check($code, $id))
            echo "true";
        else
            echo "false";
	}

    // 异步验证账号是否已经存在
    // 1 表示可以注册
    // 0 表示不能注册
    public function checkAccount(){
        if (!IS_AJAX)
            $this->error("禁止访问！");

        $account = $_POST['account'];
        $account = htmlspecialchars($account);
        $where = array(
            'account' =>$account,
            );
        $count = M('user')->where($where)->count();
        if ($count)
            echo 'false';
        else
            echo 'true';
    }

    // 验证用户昵称是否已经存在
    // 已经存在返回 0
    // 未被占用返回 1
    public function checkUname(){
        if (!IS_AJAX)
            $this->error("禁止访问！");

        $uname = $_POST['uname'];
        $uname = htmlspecialchars($uname);
        $where = array(
            'uname'=>$uname,);
        $count = M('userinfo')->where($where)->count();
        if ($count)
            echo 'false';
        else
            echo 'true';
    }
}