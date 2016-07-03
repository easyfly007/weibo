<?php
namespace Admin\Controller;
use Think\Controller;
/*
 * 后台登陆控制器 
 */
class WeiboController extends Controller {
    public function index(){
        $org = I('get.org');
        if ($org == 1){
            $this->type = '原创';
            // 原创微博
            $where = array('original'=>0,);
        }else{
            $this->type = '转发';
            $where = array('original'=>array('GT', 0));
        }
        $db = D('WeiboView');
        $count = $db->count();
        $page  = new \Think\Page($count,25);
        $show  = $page->show();// 分页显示输出
        $limit = $page->firstRow.','.$page->listRows;
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $this->weibos = $db->where($where)->limit($limit)->select();
        $this->page = $page->show();

    	$this->display();
    }

    public function del(){
        $wid = I('get.id');
        $weibo = M('weibo')->find($wid);
        $where = array('uid'=>$weibo['uid']);
        M('userinfo')->where($where)->setDec('weibo');
        $where = array('wid'=>$wid);
        M('picture')->where($where)->delete();
        M('atme')->where($where)->delete();
        M('keep')->where($where)->delete();
        M('comment')->where($where)->delete();
        if (M('weibo')->delete($wid)){
            $this->success("删除成功！");
        }else{
            $this->error("无法删除微博");
        }
    }

    public function search(){
        $weibos = false;
        if (I('get.search')){
            $where = array('content'=>array('LIKE', '%'.I('get.search').'%'));
            $weibos = D('WeiboView')->where($where)->select();
        }
        $this->weibos = $weibos;
        $this->display();
    }
}