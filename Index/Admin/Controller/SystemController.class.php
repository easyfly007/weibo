<?php
namespace Admin\Controller;
use Think\Controller;
/*
 * 后台评论控制器 
 */
class SystemController extends Controller {
    // 显示所有系统设置
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

    // 设置关键词过滤
    public function filter(){
        $comments = false;
        if (I('get.search')){
            $where = array('content'=>array('LIKE', '%'.I('get.search').'%'));
            $comments = D('CommentView')->where($where)->select();
        }
        $this->comments = $comments;
        $this->display();
    }

    public function add(){
        $word = I('post.word');
        $replacement = I('post.replacement');
        if ($word && $replacement){
            $where = array('word'=>$word);
            $filter = M('filter')->where($where)->find();
            if ($filter){
                $filter['replacement'] = $replacement;
                if (M('filter')->save($filter)){
                    $this->success('修改过滤词规则成功！', I('server.http_referer'));
                }
            }else{
                $filter = array('word'=>$word, 'replacement'=>$replacement);
                if (M('filter')->add($filter)){
                    $this->success('添加新的过滤词成功！', I('server.http_referer'));
                }
            }
            $this->error('无法添加或者更改过滤词！');
        }

        $this->filters = M('filter')->select();
        $this->display();
    }

    public function del(){
        $id = I('get.id');
        if (M('filter')->delete($id)){
            $this->success('删除成功', I('server.http_referer'));
        }else{
            $this->error('无法删除');
        }
    }

}