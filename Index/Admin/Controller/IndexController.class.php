<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 后台首页控制器
 * @return   [<description>]
 */
class IndexController extends CommonController {
    public function index(){
    	$this->display();
    }

    public function copy(){
        $this->usercnt = M('user')->count();
        $this->lockedcnt = M('user')->where(array('locked'=>1,))->count();
        // 原创
        $where = array('original'=>0);
        $this->orgweibocnt = M('weibo')->where($where)->count();
        // 转发
        $this->fwdweibocnt = M('weibo')->count() - $this->orgweibocnt; 
        // 评论
        $this->commentcnt = M('comment')->count();
    	$this->display();
    }

    public function logout(){
    	session_unset();
    	session_destroy();
    	redirect(U('Login/index'));
    }
}