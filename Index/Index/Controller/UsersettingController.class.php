<?php
namespace Index\Controller;
use Think\Controller;

// 账号设置控制器
class UsersettingController extends CommonController {
	    
    public function index(){
	   	$uid = session('uid');
    	$where = array('uid'=>$uid);
    	$field = 'uid, username, truename, sex, location, constellation, intro';
    	$this->edituser = M('userinfo')->where($where)->field($field)->find();//find();
    	// 修改个人设置，默认值为原来设置
    	$this->display();
    }

    public function editbasic(){
    	if (!IS_POST)
    		$this->error("禁止访问！");
 
 		$data = array(
 			'username'      => I('post.nickname'),
 			'truename'      => I('post.truename'),
 			'sex'           => I('post.sex'),
 			'location'      => I('post.province').' '.I('post.city'),
 			'constellation' => I('post.constellation'),
 			'intro'         => I('post.intro')   
 			);
 		// p($data); die;
 		if (M('userinfo')->where(array('uid'=>session('uid')))->save($data))
	 		// $this->success("");
	 		$this->success("修改成功");//, $SERVER__APP__);
	 	else
	 		$this->error("无法修改个人基本信息");
    }
}