<?php
namespace Index\Controller;
use Think\Controller;

// 账号设置控制器
class UsersettingController extends CommonController {
	    
    public function index(){
	   	$uid = session('uid');
    	$where = array('uid'=>$uid);
    	$field = 'uid, username, truename, sex, location, constellation, intro';
    	$this->loginuser = M('userinfo')->where($where)->field($field)->find();//find();
    	// 修改个人设置，默认值为原来设置
        p($this->loginuser);
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
        p($data);
        $where = array('uid'=>session('uid'));
 		if (M('userinfo')->where($where)->save($data))
	 		echo "修改成功";//$this->success("修改成功");
	 	else
	 		echo "无法修改";//$this->error("无法修改个人基本信息");
    }
}