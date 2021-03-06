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
					$logintime = time();
					$user['logintime'] = $logintime;
					if (!M('user')->save($user))
						$this->error("无法更新登录时间");
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
		$path = C('UPLOAD_FACE');
		$upload = $this->_upload($path, '180', '180');
		echo json_encode($upload);
	}
	
	// 上传微博图片
	public function uploadPic(){
		if (!IS_POST)
			$this->error("禁止访问");
		$path = C('UPLOAD_PIC');
		// 800*800, 380*380, 120*120 大中小三种尺寸
		$upload = $this->_upload($path, '800,380,120', '800,380,120');
		echo json_encode($upload);
	}

	// 异步调用，添加新的分组，从 left.js 中调用
	public function addGroup(){
		if (!IS_AJAX)
			$this->error("页面不存在");
		$uid = session('uid');
		$groupname = I('post.gname');
		$data = array(
			'uid'=>$uid,
			'name'=>$groupname);
		if (M('group')->add($data))
			echo json_encode(array('status'=>1, "msg"=>"分组创建成功"));
		else
			echo json_encode(array('status'=>0, "msg"=>"分组创建失败"));
	}

	public function addFollow(){
		if (!IS_AJAX)
			$this->error("页面不存在");
		$data = array(
			'follow'=>I('post.follow'),
			'gid'=>I('post.gid'),
			'fans'=>session('uid'));
		if (M('follow')->data($data)->add())
		{
			$where = array(
				'uid'=>session('uid'),);
			M('userinfo')->where($where)->setInc('follow');
			$where = array(
				'uid'=>I('post.follow'),);
			M('userinfo')->where($where)->setInc('fans');
			echo json_encode(array('status'=>1, 'msg'=>"添加关注成功！"));
		}
		else
			echo json_encode(array('status'=>0, 'msg'=>"无法添加关注！"));
	}

	//异步调用移除关注关系
	public function delFollow(){
		if (!IS_AJAX)
			$this->error('页面不存在');
		$uid = I('post.uid');
		$type = I('post.type');
		if ($type == 'follow'){
			$where = array('follow'=>$uid, 'fans'=>session('uid'));
			if (M('follow')->where($where)->delete()){
				M('userinfo')->where(array('uid'=>session('uid')))->setDec('follow');
				M('userinfo')->where(array('uid'=>$uid))->setDec('fans');
				echo 1;
			}else
				echo 0;
		}else{
			$where = array('follow'=>session('uid'), 'fans'=>$uid);
			if (M('follow')->where($where)->delete()){
				M('userinfo')->where(array('uid'=>$uid))->setDec('follow');
				M('userinfo')->where(array('uid'=>session('uid')))->setDec('fans');
				echo 1;
			}else
				echo 0;
		}
	}

	// 修改微博模板样式
	public function editStyle(){
		if (!IS_AJAX)
			$this->error('页面不存在');
		$style = I('post.style');
		// 修改自己的样式
		$where = array('uid'=>session('uid'));
		$data = array('style'=>$style);
		if (M('userinfo')->where($where)->save($data)){
			echo 1;
		}else{
			echo 0;
		}
	}

	// 异步轮询检查数据
	public function getMsg(){
		if (!IS_AJAX)
			$this->error('页面不存在');
		$uid = session('uid');
		$msg = S('usermsg'.$uid);
		if ($msg){
			if ($msg['comment']['status']){
				$msg['comment']['status']=0;
				S('usermsg'.$uid, $msg, 0);
				echo json_encode(array(
					'status'=>1,
					'total'=>$msg['comment']['total'],
					'type'=>1));
				exit();
			}
			if ($msg['letter']['status']){
				$msg['letter']['status']=0;
				S('usermsg'.$uid, $msg, 0);
				echo json_encode(array(
					'status'=>1,
					'total'=>$msg['letter']['total'],
					'type'=>2));
				exit();
			}
			if ($msg['atme']['status']){
				$msg['atme']['status']=0;
				S('usermsg'.$uid, $msg, 0);
				echo json_encode(array(
					'status'=>1,
					'total'=>$msg['atme']['total'],
					'type'=>3));
				exit();
			}

		}
		echo json_encode(array('status'=>0));
	}


	// 为了公用这些代码，提炼出单独的函数
	private function _upload($path, $width, $height){
		$upload = new \Think\Upload();// 实例化上传类
    	$upload->maxSize   =     C('UPLOAD_MAX_SIZE');
    	$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    	$upload->rootPath  =     C('UPLOAD_ROOT'); // './uploads/'; // 设置附件上传根目录
    	$upload->savePath  =     $path; //C('UPLOAD_FACE'); // 设置附件上传（子）目录
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