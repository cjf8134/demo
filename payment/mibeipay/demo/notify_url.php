<?php
include 'SignAndCheck.php';
header("Content-Type:text/html;charset=GB2312");
//$input = file_get_contents("php://input");
$input = file_get_contents("php://input", 'r');
//����ǲ������ݡ�����첽��ͨ��������ֱ����������ݲ���
$obj = json_decode($input, TRUE);
$signature = $obj['sign'];
$obj['sign'] = '';
$obj['sign_type'] = '';
$myfile = fopen("newfile.txt", "w");
$strData = getStr($obj);
if(verify($strData, $signature, 'yixun.cer')){
	fwrite($myfile, "��֤�ɹ�\n");
	if($obj['status'] == '1'){
		fwrite($myfile, "���׳ɹ�");
	}else if($obj['status'] == '2'){
		fwrite($myfile, "���״�����");
	}else {
		fwrite($myfile, "����ʧ��");
	}
	$arr = array('resp_code'=>'000000'); 
	echo json_encode($arr);
}else{
	fwrite($myfile, "��֤ʧ��");
}
$arr1 = array('resp_code'=>'999999'); 
echo json_encode($arr1);
?>