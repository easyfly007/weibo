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

	// 上传头像照，并生成3中不同规格的缩略图 
	public function uploadFace(){
		if (!IS_POST)
			$this->error("禁止访问");
		$upload = $this->_upload('Face', '180', '180');
		echo json_encode($upload);
	}

	// 为了公用这些代码，提炼出单独的函数
	private function _upload($path, $width, $height){
		$upload = new \Think\Upload();// 实例化上传类
    	$upload->maxSize   =     C('UPLOAD_MAX_SIZE');
    	$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    	$upload->rootPath  =     C('UPLOAD_ROOT'); // './uploads/'; // 设置附件上传根目录
    	$upload->savePath  =     C('UPLOAD_FACE'); // 设置附件上传（子）目录
		$upload->uploadReplace = true;    	
    	// 上传文件 
    	$info   =   $upload->upload();
    	if(!$info) {
    		// 上传错误提示错误信息
        	$ret = array('status'=>0,'msg'=>"图片上传失败");
    	}else{
    		// 上传成功
    		$ret = $info['Filedata'];
    		$ret['fullname'] = C('UPLOAD_ROOT').$ret['savepath'].$ret['savename'];
    		// $ret['fullname'] = $ret['savepath'].$ret['savename'];
    		$ret['status'] = 1;
    	}
    	return $ret;
	}

	// 传入： orgimg，原始图图片
	// 设置：尺寸，thumbImage 文件前缀
	// 
	//
	private function _thumbImage($orgimg, $width, $height, $preifx){
	  	$image = new \Think\Image();
		$image->open($imageurl);
		// 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
		$image->thumb(150, 150)->save('./thumb.jpg');		
	}
}