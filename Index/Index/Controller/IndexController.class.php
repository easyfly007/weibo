<?php
namespace Index\Controller;
use Think\Controller;
class IndexController extends CommonController {
	    
    public function index(){
        // $content = replace_weibo($content);
        $db = D('WeiboView');

        // 获取我关注的 用户id列表 +我自己的id
        $uid = array(session('uid'),);
        $where = array('fans'=>session('uid'),);
        $result = M('follow')->field('follow')->where($where)->select();
        
        if ($result){
            foreach ($result as $v){
                $uid[] = $v['follow'];
            }
        }

        // $uid 包含了我自己的应该出现在我的timeline 上面的微博用户
        // 获取这些人的微博
        $where = array(
            'uid'=>array('IN', $uid),);

        $count = $db->getWeiboCount($where);

        $page = new \Think\Page($count, 20);
        $limit = $page->firstRow.','.$page->listRows;

        $this->page = $page->show();
        $this->weibo = $db->getAllWeibo($where, $limit);
        $this->display();
    }

    public function logout(){
    	session('uid', null);
    	cookie('auto',null);
    	redirect(U("Index/index"), 3, "成功注销账号...");
    }

    // 发微博
    public function sendweibo(){
        if (!IS_POST)
            $this->error("页面不存在");
        $content = I('post.content');
        $data = array(
            'content' =>$content,
            'time'=>time(),
            'original'=>0, // 原创微博，该微博的原微博为0，没有原微博
            'uid'=> session('uid'));
        if ($wid = M('weibo')->data($data)->add())
        {
            $where = array('uid'=>session('uid'),);
            M('userinfo')->where($where)->setInc('weibo');
            if (!empty(I('post.medium')))
            {
                $img = array(
                    'max' => I('post.max'),
                    'medium' => I('post.medium'),
                    'mini'=>I('post.mini'),
                    'wid'=>$wid);
                if (M('picture')->data($img)->add())
                    $this->success('微博发布成功', U('index'));
                else
                    $this->error("微博发布成功，图片上传失败");
           }else{
                $this->success("微博发送成功");
           }
        }
        else
            $this->error("微博发送失败，请重试！");
    }

    // 异步调用获取对某个微博的评论
    public function getComment(){
        if (!IS_AJAX)
            $this->error("页面不存在");
    }

    public function postComment(){
        // 提交针对某个微博的评论
        if (!IS_AJAX)
            $this->error('页面不存在');

        $data = array(
            'wid' => I('post.wid'),
            'uid' => session('uid'),
            'content' => I('post.content'),
            'time' => time());
        
        // 找到微博信息
        $where = array('id'=>$data['wid'],);
        $weibo = M('weibo')->where($where)->find();
        if (!$weibo){
            echo "fail"; die;
        }

        // 找到微博用户信息
        $where = array('id'=>$weibo['uid']);
        $weibouser = M('userinfo')->where($where)->find();
        if (!$weibouser){
            echo "fail"; die;
        }

        // 找到评论用户信息
        $field = array('uid','face50'=>'face','username');
        $where = array('uid'=>session('uid'));
        $commentuser = M('userinfo')->field($field)->where($where)->find();
        if (!$commentuser){
            echo "fail"; die;
        }
        
        // 添加对于微博的评论
        $field = array('uid', 'username');
        $where = array('');
        if (!M('comment')->data($data)->add()){
            echo "fail"; die;
        }
        $where = array('id'=>$data['wid']);
        M('weibo')->where($where)->setInc('comment');

        // 同时转发到我的微博
        if (I('post.forward')){
            if ($weibo['original']){
                // 评论了一条转发微博
                $original = $weibo['original'];
            }else{
                // 评论了一条原创微博
                $original = $weibo['id'];
            }
            $content = $data['content']."//@".$weibouser['username'].":".$weibo['content'];
            $data= array(
                'uid'=>session('uid'),
                'content'=>$content,
                'original'=>$original,
                'time'=>time(),);
            if(M('weibo')->data($data)->add()) {
                M('weibo')->where(array('id'=>I('post.wid')))->setInc('forward');
            }else{
                echo "fail";die;
            }
            echo 1;die;
        }
      
        $str = '';
        $str .= "<dl class = 'comment_content'>";
        $str .= "<dt>";
        $str .= "<a href='".U('User/index', array('id'=>session('uid'),)) ."'>";
        if ($commentuser['face'])
            $str .= "<img src='".__ROOT__."/".$commentuser['face'];
        else
            $str .= "<img src='".__ROOT__."/Public/Images/noface.gif'";
        $str .= "' alt = '".$commentuser['username']."' width ='30' height='30'>";
        $str .= "</a>";
        $str .= "</dt>";
        $str .= "<dd>";
        $str .= "<a href='".U('User/index', array('id'=>session('uid')))."' class = 'comment_name'>";
        $str .= $commentuser['username'] ."</a> : ".I('post.content');
        $str .= "&nbsp;(".time_format($data['time']) .")";
        $str .= "<div class= 'reply'>";
        $str .= "<a href=''> 回复</a>";
        $str .= "</div>";
        $str .= "</dd>";
        $str .= "</dl>";
        echo $str;
    }

    // 转发微博
    public function turn(){
        if (!IS_POST)
            $this->error('页面不存在');
        $data = array(
            'content'=>I('post.content'),
            'original'=>I('post.orgid')?I('post.orgid'):I('post.id'),
            'time'=>time(),
            'uid'=>session('uid'),
        );
        if (M('weibo')->data($data)->add()){
            M('weibo')->where(array('id'=>I('post.id'),))->setInc('forward');
            if (I('post.orgid'))
                M('weibo')->where(array('id'=>I('post.orgid')))->setInc('forward');
            M('userinfo')->where(array('uid'=>session('uid'),))->setInc('weibo');

            // 转发并评论原微博
            if (I('post.becomment')){
                $data = array(
                    'content'=>I('post.content'),
                    'time'=>time(),
                    'wid'=>I('post.id'),
                    'uid'=>session('uid')
                );
                if (M('comment')->data($data)->add()){
                    M('weibo')->where(array('id'=>I('post.id'),))->setInc('comment');
                    $this->success('转发并评论原微博成功', U('Index/index'));
                }
                else
                    $this->error('转发成功，但是无法评论原微博');
            }    
            $this->success('转发微博成功！',U('Index/index'));
        }else{
            $this->error('无法转发微博!');
        }
    }
}