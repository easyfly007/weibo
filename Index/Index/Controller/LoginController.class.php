<?php
namespace Index\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
        $this->display();
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
        $config = array('reset' => false,); // 验证成功后是否重置，这里才是有效的。
	    $verify = new \Think\Verify($config);
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

    // 后台注册用户
    public function runRegister(){
        if (!IS_POST)
            $this->error("禁止访问！");
        // 后台验证
        $account = I('post.account');
        $username = I('post.uname');
        $pwd =  I('post.pwd');
        $pwd2 = I('post.pwded');

        // 验证码
        $code = I('post.verify');
        $verify = new \Think\Verify();
        if (!$verify->check($code, ''))
            $this->error("验证码错误！");

        if ($pwd != $pwd2)
            $this->error("输入的密码不一致！");
        $pwd = md5($pwd);
        $data = array(
            'account' => $account,
            'password' =>$pwd,
            'registime' =>time(),
            'userinfo' =>array(
                'username' => $username,
                ),
            // 'registime' => I('server.REQUEST_TIME'), 
            );
        if ($id = D('UserRelation')->insert($data))
        {
            session('uid', $id);
            header("Content-Type:text/html; Charset = UTF-8");
            redirect(__APP__, 3, "注册成功，正在为您跳转到首页...");
        }
        else
            $this->error("无法注册用户");
    }

    public function login(){
        if (!IS_POST)
            $this->error("页面不存在");
        $account = I('post.account');
        $pwd = I('post.pwd');
        $where = array('account'=>$account, "password" =>md5($pwd));
        $user = M('user')->where($where)->find();
        if (!$user)
            $this->error("请输入正确的用户名密码");

        if ($user['locked'])
            $this->error("用户账号被锁定");

        session('uid', $uid);
        if (I('post.auto'))
        {
            $cookie = $user['account']."|".get_client_ip()."|".time();
            $cookie = encryption($cookie);
            setcookie('auto', $cookie, C('AUTO_LOGIN_TIME'), '/'); // 写入到cookie
        }
        $this->success("登录成功，正在为您跳转到首页", __APP__);
    }
}