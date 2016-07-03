<?php
namespace Admin\Controller;
use Think\Controller;
/*
 * 后台评论控制器 
 */
class SystemController extends Controller {
    // 显示所有系统设置
    public function index(){
        // 列出所有的系统设置
        $config = array();
        $config['regist_on']= C('REGIST_ON');
        $config['copy'] = C('COPY');
        $config['webname'] = C('WEBNAME');
        $this->config = $config;
        $this->display();
    }

    // 设置关键词过滤
    public function filter(){
        $this->filters = M('filter')->select();
        $this->display();
    }

    // 添加或者修改过滤词
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