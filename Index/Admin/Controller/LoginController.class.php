<?php
namespace Admin\Controller;
use Think\Controller;
/*
 * 后台登陆控制器 
 */
class LoginController extends Controller {
    public function index(){
    	$this->display();
    }

    // 提交登陆表单处理
    public function login(){
    	if (!IS_POST)
    		$this->error('页面不存在');
    	$code = I('post.verify');
    	$config = array('reset'=>false,);
    	$verify = new \Think\Verify($config);
    	if (!$verify->check($code, ''))
    		$this->error('验证码不正确');

   //  	if (!(I('post.submit')===''))
			// return false;
		$username = I('post.uname');
		$password = md5(I('post.pwd'));
		$where = array('username'=>$username, 'password'=>$password);

		$admin = M('admin')->where($where)->find();
		if (!$admin)
			$this->error("请输入正确的管理员用户名和密码");
		if ($admin['locked'])
			$this->error("账号被锁定");

		$data = array(
			'id'=>$admin['id'],
			'logintime'=>time(),
			'loginip'=>get_client_ip());
		M('admin')->save($data);

		session('uid', $admin['id']);
		session('username', $admin['username']);
		session('logintime', date('Y-m-d H:i',$admin['logintime']));
		session('now', date('Y-m-d H:i', time()));
		session('loginip', $admin['loginip']);
        session('admin', $admin['admin']);

		$this->success('正在登陆', __APP__);
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