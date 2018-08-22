<?php
include 'SignAndCheck.php';
header("Content-Type:text/html;charset=GB2312");
//$input = file_get_contents("php://input");
$input = file_get_contents("php://input", 'r');
//这个是测试数据。如果异步不通外网可以直接用这个数据测试
$obj = json_decode($input, TRUE);
$signature = $obj['sign'];
$obj['sign'] = '';
$obj['sign_type'] = '';
$myfile = fopen("newfile.txt", "w");
$strData = getStr($obj);
if(verify($strData, $signature, 'yixun.cer')){
	fwrite($myfile, "验证成功\n");
	if($obj['status'] == '1'){
		fwrite($myfile, "交易成功");
	}else if($obj['status'] == '2'){
		fwrite($myfile, "交易处理中");
	}else {
		fwrite($myfile, "交易失败");
	}
	$arr = array('resp_code'=>'000000'); 
	echo json_encode($arr);
}else{
	fwrite($myfile, "验证失败");
}
$arr1 = array('resp_code'=>'999999'); 
echo json_encode($arr1);
?>