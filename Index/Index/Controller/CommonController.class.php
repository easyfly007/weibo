<?php
namespace Index\Controller;
use Think\Controller;
class CommonController extends Controller {
	// 登录检查
	public function _initialize(){
		// 检查 cookie，是否保自动登录
		if (cookie('auto') && !session('uid'))
		{
			$cookie = encryption(explode('|', $cookie), 1);
			// cookie[0] = uid, cookie[1] = ip, cookie[2] = expire_time
			if ($cookie[1] == get_client_ip() && time() <= $cookie[2])
			{
				$uname = $cookie[0];
				$user = M('user')->where(array('account'=>$uname))->find();
				if ($user)
				{
					if (!$user['locked'])
						$this->error('自动登录账号被锁定');
					session('uid', $user['account']);
				}
			}
		}

		if (!session('uid'))
			redirect(U('Login/index'));
		$this->loginuser = M('userinfo')->where(array('uid'=>session('uid')))->find();
	}
}