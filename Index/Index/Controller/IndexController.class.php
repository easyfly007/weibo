<?php
namespace Index\Controller;
use Think\Controller;
class IndexController extends CommonController {
	    
    public function index(){
        $today = time();
        time_format($today);
        die;
        $db = D('WeiboView');

        // 获取我关注的 用户id列表
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
        $this->weibo = $db->getAllWeibo($where);
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
            'original'=>1,
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
}