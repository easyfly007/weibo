<?php
	function p($arr)
	{
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}
?>

<?php
	// $type = 0 for encryption, default behavior
	// $type = 1 for decryption
	function encryption($val, $type =0){
		$key = md5(C('encryption_key'));
		if ($type==0){
			$ret = base64_encode($val ^ $key);
			$ret = str_replace('=', '', $ret);
		}else{
			$ret = base64_decode($val);
			$ret = $ret ^ $key;
		}
		return $ret;
	}
?>
