<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 后台首页控制器
 * @return   [<description>]
 */
class UserController extends CommonController {
    public function index(){
        // 列出所有的微博用户
        $db = D('UserView');
        $count = $db->count();
        $page  = new \Think\Page($count,25);
        $show  = $page->show();// 分页显示输出
        $limit = $page->firstRow.','.$page->listRows;
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $this->users = $db->limit($limit)->select();
        $this->page = $page->show();
    	$this->display();
    }

    public function unlock(){
        $id = I('get.uid');
        $data = array(
            'id'=>I('get.uid'),
            'locked'=>0);
        if (M('user')->save($data))
            $this->success('锁定用户成功', U('User/index'));
        else
            $this->error('锁定用户失败');
    }


    public function lock(){
        $id = I('get.uid');
        $data = array(
            'id'=>I('get.uid'),
            'locked'=>1);
        if (M('user')->save($data))
            $this->success('解锁用户成功', I('server.http_referer'));
        else
            $this->error('解锁用户失败');
    }

    // 查找微博用户
    public function search(){
        $users = false;
        if (I('get.search')){
            if (I('get.type') ==0){
                $where = array('username'=>array('LIKE', '%'.I('get.search').'%'));
            }else{
                $where = array('id'=>I('get.search'));
            }
            $users = D('UserView')->where($where)->select();
        }
        $this->users = $users;
        $this->display();

    }
}