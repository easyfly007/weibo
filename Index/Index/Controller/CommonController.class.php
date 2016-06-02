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

	public function uploadFace(){
		if (!IS_POST)
			$this->error("禁止访问");
		$upload = new \Think\Upload();// 实例化上传类
    	$upload->maxSize   =     C('UPLOAD_MAX_SIZE');
    	//3145728 ;// 设置附件上传大小
    	
    	$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    	$upload->rootPath  =     C('UPLOAD_ROOT'); // './uploads/'; // 设置附件上传根目录
    	$upload->savePath  =     C('UPLOAD_FACE'); // 设置附件上传（子）目录
		$upload->uploadReplace = true;    	
    	// 上传文件 
    	$info   =   $upload->upload();
    	if(!$info) {
    		return 0;
    		// 上传错误提示错误信息
        	return $ret = array('status'=>0,);
    	}else{
    		return 1;
    		$ret = '';
    	    foreach($info as $file){
    	    	$ret += $file['savepath'].$file['savename'];
    	    }	
    	}
    	echo $ret;
    	return $ret;

	  	// $image = new \Think\Image(); 
		// $image->open('./1.jpg');
		// // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
		// $image->thumb(150, 150)->save('./thumb.jpg');
	}
}