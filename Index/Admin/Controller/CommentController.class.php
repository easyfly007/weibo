<?php
namespace Admin\Controller;
use Think\Controller;
/*
 * 后台评论控制器 
 */
class CommentController extends Controller {
    public function index(){
        // 列出所有的评论
        $db = D('CommentView');
        $count = $db->count();
        $page  = new \Think\Page($count,25);
        $show  = $page->show();// 分页显示输出
        $limit = $page->firstRow.','.$page->listRows;
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $this->comments = $db->where($where)->limit($limit)->select();
        $this->page = $page->show();
    	$this->display();
    }

    public function search(){
        $comments = false;
        if (I('get.search')){
            $where = array('content'=>array('LIKE', '%'.I('get.search').'%'));
            $comments = D('CommentView')->where($where)->select();
        }
        $this->comments = $comments;
        $this->display();
    }

    public function del(){
        $cid = I('get.cid');
        if ($cid){
            $comment = M('comment')->find($cid);
            if ($comment){
                M('comment')->delete($cid);
                M('weibo')->where(array('id'=>$comment['wid']))->setDec('comment');
                $this->success('删除评论成功', I('server.http_referer'));
            }
        }
        $this->error('无法删除评论');
    }

}