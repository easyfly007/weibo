<?php
namespace Index\Controller;
use Think\Controller;
class IndexController extends CommonController {
	    
    public function index(){
        // $content = replace_weibo($content);
        $db = D('WeiboView');

            // $db = M('follow');
            // $where = array('fans'=>session('uid'));
            // $myfollow = $db->where($where)->select();
            // foreach ($myfollow as $key => $value) {
            //     $myfollow[$key] = $value['follow'];
            // }
            // p($myfollow);
            // $excludefollow = $myfollow;
            // $excludefollow[] = session('uid');

            // // 要查看我关注的人所关注的人中，哪些人我还没有关注的
            // $where = array(
            //     'fans'=>array('IN', $myfollow),
            //     'follow'=>array('NOT IN', $excludefollow)
            // );
            // // 按照相关数目排序
            // $field = array("followcount", "follow", );
            // $interest = D('FollowView')->where($where)->field($field)->group('follow')->order('followcount DESC')->limit(10)->select();
            // p($interest);
            // $field = array('uid', 'face', 'username' );
            // // $db = D('FollowView');
            // // $interest = D('FollowView')->where($where)->field($field)->order('follow')->limit(10)->select();

        // 获取我关注的 用户id列表 +我自己的id
        $uid_where = array('fans'=>session('uid'),);
        
        // 如果分组，则不显示自己，只获取分组用户
        $uid = array();
        if (I('get.gid')){
            $uid_where['gid'] = I('get.gid');
        }
        else
            $uid[] = session('uid');

        $result = M('follow')->field('follow')->where($uid_where)->select();
        
        if ($result){
            foreach ($result as $v){
                $uid[] = $v['follow'];
            }
        }
        if(!empty($uid)){
            // $uid 包含了我自己的应该出现在我的timeline 上面的微博用户
            // 获取这些人的微博
            $where = array(
                'uid'=>array('IN', $uid),);

            $count = $db->getWeiboCount($where);

            $page = new \Think\Page($count, 20);
            $limit = $page->firstRow.','.$page->listRows;

            $this->page = $page->show();
            $this->weibo = $db->getAllWeibo($where, $limit);   
        }else{
            $this->page = '';
        }
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
            $this->_atmehandle($content, $wid); // 处理 @ 
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


    // 异步调用获取对某个微博的评论,返回 html
    public function getComment(){
        if (!IS_AJAX)
            $this->error("页面不存在");
        $wid = I('post.wid');
        //需要获取用户username, face, comemnt content, time
        $where = array('wid'=>$wid);
        $db = D('CommentView');
        $count = $db->where($where)->count('*');
        $comment_per_page = 10;
        $total_page = ceil($count / $comment_per_page); // 每页显示5条评论
        $visit_page = 1;
        if (I('post.page'))
            $visit_page = I('post.page');

        // 分页获取评论数目
        $start = ($visit_page-1)*$comment_per_page;
        $limit = $start .','.$comment_per_page;
        $comments = $db->where($where)->limit($limit)->order('time DESC')->select();
        // 分页实现，每次获取10条，并返回一个 下一页，该下一页的点击会产生一个新的异步调用
        if ($comments){
            $str = '';
            foreach ($comments as $key => $value) {
                $str .= "<dl class = 'comment_content'>";
                $str .= "<dt>";
                $str .= "<a href='".U('User/index', array('id'=>$value['uid'],)) ."'>";
                if ($value['face'])
                    $str .= "<img src='".__ROOT__."/".$value['face'];
                else
                    $str .= "<img src='".__ROOT__."/Public/Images/noface.gif'";
                $str .= "' alt = '".$value['username']."' width ='30' height='30'>";
                $str .= "</a>";
                $str .= "</dt>";
                $str .= "<dd>";
                $str .= "<a href='".U('User/index', array('id'=>$value['uid']))."' class = 'comment_name'>";
                $str .= $value['username'] ."</a> : ".replace_weibo($value['content']);
                $str .= "&nbsp;(".time_format($value['time']) .")";
                $str .= "<div class= 'reply'>";
                $str .= "<a href=''> 回复</a>";
                $str .= "</div>";
                $str .= "</dd>";
                $str .= "</dl>";
            }
            if ($total_page>1){
                $str .= "<dl class ='comment_page' >";
                if($visit_page>1)
                    $str .= "<dd page = '".($visit_page-1)."' wid = '".$wid."' > 上一页</dd>";
                if ($visit_page<$total_page)
                    $str .= "<dd page = '".($visit_page+1)."' wid = '".$wid."' > 下一页</span></dd>";
                $str .= "</dl>";
            }
            echo $str;            
        }
        else
            echo 'false';
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
        $str .= $commentuser['username'] ."</a> : ".replace_weibo(I('post.content'));
        $str .= "&nbsp;(".time_format($data['time']) .")";
        $str .= "<div class= 'reply'>";
        $str .= "<a href=''> 回复</a>";
        $str .= "</div>";
        $str .= "</dd>";
        $str .= "</dl>";
        echo $str;
        set_msg($weibo['uid'],1);
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
            $this->success('转发微博成功！', $_SERVER['HTTP_REFERER']);// U('Index/index'));
        }else{
            $this->error('无法转发微博!');
        }
    }

    // 1: 收藏成功,  -1: 已经收藏, 0: 收藏失败
    public function keep(){
        if (!IS_AJAX)
            $this->error('页面不存在');
        $wid = I('post.wid');
        if (!$wid){
            echo 0; exit;
        }
        $data = array(
            'uid'=>session('uid'),
            'time'=>time(),
            'wid'=>$wid,
        );
        if (M('keep')->where(array('uid'=>session('uid'), 'wid'=>$wid))->find())
        {
            // 已经收藏
            echo -1; exit;
        }
        if (M('keep')->data($data)->add()){
            M('weibo')->where(array('id'=>$wid))->setInc('keep');
            echo 1;
        }
        else
            echo 0;
    }


    // 取消收藏, 1, 取消成功， 0 取消失败
    public function cancel(){
        if (!IS_AJAX)
            $this->error('页面不存在');
        $wid = I('post.wid');
        $uid = session('uid');
        $where = array(
            'wid'=>$wid,
            'uid'=>$uid, );
        if (M('keep')->where($where)->delete()){
            M('userinfo')->where($where)->setDec('keep');
            M('weibo')->where(array('id'=>$wid))->setDec('keep');
            echo 1;
        }else{
            echo 0;
        }
    }



    public function delWeibo(){
        if (!IS_AJAX)
            $this->error('页面不存在');
        $wid = I('post.wid');
        // 先用一个变量保存所有相关的weibo信息
        $weibo = M('weibo')->where(array('id'=>$wid))->find();

        // 删除 收藏这条微博的相关信息
        $data = M('keep')->where(array('wid'=>$wid))->select();
        foreach ($data as $v) {
            M('userinfo')->where(array('uid'=>$v['uid'],))->setDec('keep');
        }
        M('keep')->where('wid='.$wid)->delete();
        
        //删除转发微博的原微博信息,将转发微博的original 设置为-1
        $forwards = M('weibo')->where(array('original'=>$wid))->select();
        $data['original'] = -1;
        M('weibo')->where('original = '.$wid)->save($data);
        
        // 删除图片
        $imgs = M('picture')->where(array('wid'=>$wid))->select();
        foreach ($imgs as $value) {
            M('picture')->delete($value['id']);
            @unlink('./'.$value['mini']);
            @unlink('./'.$value['medium']);
            @unlink('./'.$value['max']);
        }
        
        // 删除微博        
        if (M('weibo')->where(array('id'=>$wid))->delete()){
            M('userinfo')->where(array('uid'=>$weibo['uid']))->setDec('weibo');
            // 删除微博的评论么？
            $where = array('wid'=>$weibo['id']);
            M('comment')->where($where)->delete();
            echo 1;
        }else{
             echo 0;
        }
    }


    // 删除私信
    public function delLetter(){
        if (!IS_AJAX)
            $this->error('页面不存在');
        $lid = I('post.lid');
        $letter = M('letter')->find($lid);

        // 只能删除发送给自己的私信
        $where = array('id'=>$lid, $uto=>session('uid'));
        if(M('letter')->where($where)->find()){
            if (M('letter')->delete($lid)){
                echo 1; exit;
            }
        }
        echo 0;
    }

    // 删除评论
    public function delComment(){
        if (!IS_AJAX)
            $this->error('页面不存在');
        $cid = I('post.cid');
        $comment = M('comment')->find($cid);
        $wid = $comment['wid'];

        // 只能删除自己发出的评论
        $where = array('id'=>$cid, 'uid'=>session('uid'));
        if (M('comment')->where($where)->find()){
            if (M('comment')->delete($cid)){
                M('weibo')->where(array('id'=>$wid))->setDec('comment');
                echo 1; exit;
            }
        }
        echo 0;
    }

    // 传入微博正文，进行at 操作
    private function _atmehandle($content, $wid){
        $pattern = '/@(\S+?)\s/is';
        preg_match_all($pattern, $content,  $matches);
        $atids = array();
        if ($matches[1]){
            foreach ($matches[1] as $key => $value) {
                $uid = M('userinfo')->where(array('username'=>$value))->getField('id');
                if ($uid && array_search($uid, $atids)=== false){
                    $data = array(
                        'uid'=>$uid,
                        'wid'=>$wid,
                        'time'=>time());
                    // 写入消息推送
                    set_msg($uid, 3);

                    if (!M('atme')->data($data)->add())
                        return false;
                    $atids[] = $uid;
                }
            }
        }
        return true;
    }
}