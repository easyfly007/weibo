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
        p($_GET);
    }

    public function lock(){
        p($_GET);
    }
}