<?php    
    namespace Index\TagLib;
    use Think\Template\TagLib;
    defined('THINK_PATH') or exit();

    class TagLibWbtags extends TagLib{
    	protected $tags = array(
    		'userinfo'=>array('attr'=>'id', 'close'=>1)
    	);

    	public function _userinfo($attr, $content){
    		$attr = $this->parseXmlAttr($attr);
    		$id = $attr['id'];
    		$str = '';
    		$str .= "<?php ";
    		$str .= "$where = array('uid'=>".$id.");";
    		$str .= "$field = array('username', 'face80'=>'face', 'follow', 'fans', 'weibo', 'uid');";
    		$str .= "$userinfo = M('userinfo')->where($where)->field($field)->find();";
    		$str .= "?>";
    		return $str;

    	}
    	
    	// close 是否为闭合标签，<img> 是闭合标签
    	
    };

