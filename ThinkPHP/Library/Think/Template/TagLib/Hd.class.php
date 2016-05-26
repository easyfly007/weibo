<?php
// 载入
namespace Think\Template\TagLib;
use Think\Template\TagLib;

class Hd extends TagLib {
	// 自定义标签
	protected $tags = array(
		'topcates' => array(
			'attr'=> 'limit'
			),
		);
	// 顶级分类 对标签
	public function _topcates($attr, $content)
	{
		$attr = $this->parseXmlAttr($attr);
		$limit = isset($attr['limit'])? $attr['limit']:'';
		$str = "<?php ";
		$str .= "$where = array('pid'=>0); ";
		$str .= "$_topcatesResult = M('category')->where($where)->select(); ";
		$str .= "foreach($_topcatesResult as $v) : ";
		$str .= "extract($v); ?>";
		$str .= $content;
		$str .= "<?php endforeach; ?>";
		// echo $str;
		return $str;
		// foreach ($variable as $key => $value) {
		// 	# code...
		// }
	}
}
?>