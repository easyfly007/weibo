<?php
namespace Index\Controller;
use Think\Controller;

// 账号设置控制器
class UsersettingController extends CommonController {
	    
    public function index(){
	   	$uid = session('uid');
    	$where = array('uid'=>$uid);
    	$field = 'uid, username, truename, sex, location, constellation, intro, face180';
    	$this->loginuser = M('userinfo')->where($where)->field($field)->find();//find();
    	// 修改个人设置，默认值为原来设置
    	$this->display();
    }

    public function editbasic(){
    	if (!IS_POST)
    		$this->error("禁止访问！");
        header('Content-Type:text/html;Charset=UTF-8');
 		$data = array(
 			'username'      => I('post.nickname'),
 			'truename'      => I('post.truename'),
 			'sex'           => I('post.sex'),
 			'location'      => I('post.province').' '.I('post.city'),
 			'constellation' => I('post.constellation'),
 			'intro'         => I('post.intro')   
 			);
        $where = array('uid'=>session('uid'));
 		if (M('userinfo')->where($where)->save($data))
	 		// echo "修改成功";
            $this->success("修改成功");
	 	else
	 		// echo "无法修改";
            $this->error("无法修改个人基本信息");
    }

    public function editface(){
        $uid = session('uid');
        $where = array('uid'=>$uid);
        $oldface = M('userinfo')->where($where)->find();
        if (M('userinfo')->where($where)->save($_POST))
        {
            if (!empty($oldface['face180'])){
                @unlink($oldface['face180']);
            }
            if (!empty($oldface['face80'])){
                @unlink($oldface['face80']);
            }
            if (!empty($oldface['face50'])){
                @unlink($oldface['face50']);
            }
            $this->success('修改成功', U('index'));
        }
        else
            $this->error('修改失败，请重试...');
    }

    // 异步验证密码是否正确，用于 用户密码修改时的 Ajax 前端异步提交验证
    public function checkpwd(){
        if (!IS_AJAX)
            $this->error("禁止访问！");
        $id = I('session.uid');
        $pwd = md5($_POST['pwd']);
        $where = array(
            'id'=>$id,
            'password'=>$pwd,);
        $count = M('user')->where($where)->count();
        if ($count)
            echo 'true';
        else
            echo 'false';
    }

    public function editpwd(){
        if (!IS_POST)
            $this->error("禁止访问!");
        p($_POST);
        $where = array(
            'id'=>session('uid'),
            'password'=>md5(I('post.oldpwd')));
        $user = M('user')->where($where)->find();
        if (!$user)
            $this->error("密码输入错误！");

        if (I('post.newpwd') != I('post.newpwd2'))
            $this->error("两次输入的新密码不一致");
        
        if (I('post.oldpwd') == I('post.newpwd'))
            $this->error("新密码与旧密码相同");

        $data = array(
            'id'=>session('uid'),
            'password'=>md5(I('post.newpwd')));

        if (M('user')->save($data))
            $this->success("新密码设置成功！", U('index'));
        else
            $this->error("无法修改密码！");
        //I('server.HTTP_REFERER'));
    }
}