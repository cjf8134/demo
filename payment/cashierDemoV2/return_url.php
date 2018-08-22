<?php
include 'SignAndCheck.php';
header("Content-Type:text/html;charset=GB2312");
$res = $_POST['res'];
$data = base64_decode($res);
$obj = json_decode($data, TRUE);
$signature = $obj['sign'];
$obj['sign'] = '';
$obj['sign_type'] = '';

$strData = getStr($obj);
if(verify($strData, $signature, 'yixun.cer')){
	echo "验证成功";
	echo '<br>';
	if($obj['status'] == '1'){
		echo "交易成功";
	}else if($obj['status'] == '2'){
		echo "交易处理中";
	}else {
		echo "交易失败";
	}
}else{
	echo "验证失败";
}


?>