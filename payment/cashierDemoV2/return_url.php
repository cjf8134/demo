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
	echo "��֤�ɹ�";
	echo '<br>';
	if($obj['status'] == '1'){
		echo "���׳ɹ�";
	}else if($obj['status'] == '2'){
		echo "���״�����";
	}else {
		echo "����ʧ��";
	}
}else{
	echo "��֤ʧ��";
}


?>