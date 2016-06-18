<?php
// 载入
namespace Think\Template\TagLib;
use Think\Template\TagLib;
    class Wbtags extends TagLib{
    	protected $tags = array(
    		'userinfotag' => array('attr'=>'uid', 'close'=>1),
    		'interesttag' => array('attr'=>'uid,limit', 'level'=>2, 'close'=>1),
    	);

    	// 通过这一个标签，我们可以获取这个 uid 相关的用户的 
    	// uid, username, face, follow, fans, weibo,
    	// 存放在 $userinfo 里面
    	public function _userinfotag($attr, $content){
    		$id = $attr['uid'];
    		$str = '';
    		$str .= '<?php ';
    		$str .= '$where = array("uid"=>'.$id.');';
    		$str .= '$field = array("username", "face80"=>"face", "follow", "fans", "weibo", "uid");';
    		$str .= '$userinfo = M("userinfo")->where($where)->field($field)->find();';
    		$str .= ' ?>';
            $str .= $content;
    		return $str;
    	}

    	// 通过这个标签，我们可以获取要推荐给这个用户的 其他的用户信息
    	// 存放在 $interestusers 这个里面
    	public function _interesttag($attr, $content){
    		$uid = $attr['uid'];
            $limit = $attr['limit'];

    		$str = '';
    		$str .= "<?php ";
            $str .= '$uid = '.$uid.';';
            $str .= '$limit = '.$limit.';';

            $str .= '$db = M("follow");';
            $str .= '$where = array("fans"=>$uid);';
            $str .= '$myfollow = $db->where($where)->field("follow")->select();';
            $str .= 'foreach ($myfollow as $key => $value):';
            $str .= '$myfollow[$key] = $value["follow"];';
            $str .= 'endforeach;';
            $str .= '$excludefollow = $myfollow;';
            $str .= '$excludefollow[] = $uid;';

            $str .= ' $sql ="select `uid`, `username`, `face50` as `face`, count(f.`follow`) as `common` ';
            $str .= ' from `tb_follow` f left join `tb_userinfo` u ';
            $str .= ' on f.`follow` = u.`uid` ';
            $str .= ' where f.`fans` in (".implode(\',\',$myfollow).") ';
            $str .= ' and f.`follow` not in (".implode(\',\',$excludefollow).") ';
            $str .= ' group by f.`follow` ';
            $str .= ' order by `common` DESC limit $limit  ";';
            $str .= ' $interestusers = M("follow")->query($sql);';

			$str .= ' ?>';
            $str .= $content;
            return $str;
        }
    }


