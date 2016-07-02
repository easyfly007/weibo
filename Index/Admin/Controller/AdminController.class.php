<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 后台首页控制器
 * @return   [<description>]
 */
class AdminController extends CommonController {
    public function index(){
        // 列出所有的管理员
        $db = M('admin');
        $this->admins = M('admin')->select();
        $this->display();
    }

    // 添加管理员 页面
    public function add(){
        $this->display();
    }

    public function adding(){
        $username = I('post.username');
        $password = I('post.pwd');
        $password2= I('post.pwd2');
        if ($password2 != $password)
            $this->error('两次输入的密码不一致');
        $admin = I('post.admin');

        // 确保用户名不存在
        $where = array('username'=>$username);
        if(M('admin')->where($where)->find())
            $this->error('用户名已经存在');
        $data = array(
            'username'=>$username,
            'password'=>md5($password),
            'registime'=>time(),
            'locked'=>0,
            'admin'=>$admin,);
        if (M('admin')->add($data))
            $this->success('添加管理员账户成功！', U('Admin/index'));
        $this->error('添加管理员账户失败!');
    }

    // 锁定管理员
    public function lock(){
        $id = I('get.id');
        $data = array('id'=>$id, 'locked'=>1);
        if (M('admin')->save($data))
            $this->success('锁定管理员成功', U('Admin/index'));
        else
            $this->error('锁定管理员失败');

    }

    // 解锁管理员
    public function unlock(){
        $id = I('get.id');
        $data = array('id'=>$id, 'locked'=>0);
        if (M('admin')->save($data))
            $this->success('解锁管理员成功', U('Admin/index'));
        else
            $this->error('解锁管理员失败');
    }

    //删除管理员账号
    public function delete(){
        $id = I('get.id');
        $data = array('id'=>$id);
        if (M('admin')->delete($id))
            $this->success('删除管理员账号成功', U('Admin/index'));
        else
            $this->error('删除管理员账号失败');
    }

    // 修改管理员账号的密码
    public function edit(){
        $this->display();
    }

    // 修改管理员账号的密码
    public function editting(){
        $id = session('uid');
        $oldpwd = I('post.oldpwd');
        $newpwd = I('post.newpwd');
        $newpwd2= I('post.newpwd2');
        if ($newpwd != $newpwd2)
            $this->error('两次输入的新密码不一致');
        $wher = array(
            'id'=>$id,
            'password'=>md5($oldpwd));
        $user = M('admin')->where($where)->find();
        if ($user){
            $user['password']= md5($newpwd);
            if (M('admin')->save($user)){
                $this->success('成功修改密码！', U('Admin/edit'));
            }
        }else
            $this->error('密码不正确');
        $this->error('修改密码失败');
    }



 
}