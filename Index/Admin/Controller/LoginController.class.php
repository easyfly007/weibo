<?php
namespace Admin\Controller;
use Think\Controller;
/*
 * 后台登陆控制器 
 */
class LoginController extends Controller {
    public function index(){
    	echo "admin login";
    	$this->display();
    }

    // 获取验证码
    public function verify(){
        ob_end_clean();
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

}