<?php
include 'SignAndCheck.php';
include 'log.class.php';
include 'leanworkSDK.php';
$config = include 'config.php';
header("Content-Type:text/html;charset=GB2312");
//$input = file_get_contents("php://input");
$input = file_get_contents("php://input", 'r');
$log=new Log();
$result=false;


//����ǲ������ݡ�����첽��ͨ��������ֱ����������ݲ���
$obj = json_decode($input, TRUE);
$log->W("֧��֪ͨ��֤-����:\n".var_export($obj,true));
$signature = $obj['sign'];
$obj['sign'] = '';
$obj['sign_type'] = '';
$myfile = fopen("newfile.txt", "w");
$strData = getStr($obj);
if(verify($strData, $signature, 'yixun.cer')){
	// �����̻�������һЩ�Լ�����֤��ʽ����Աȶ�������
						        //��ȡ����
	$log->W('֪ͨleanwork��ַ:'.$config['receiveUrl']);
	fwrite($myfile, "��֤�ɹ�\n");
	if($obj['status'] == '1'){
		fwrite($myfile, "���׳ɹ�");
	}else if($obj['status'] == '2'){
		fwrite($myfile, "���״�����");
	}else {
		fwrite($myfile, "����ʧ��");
	}
	$para["signType"]=LeanWorkSDK::$signType;				    //ǩ������
	$para["orderNo"]=$obj['order_no'];						//������
	$para["orderAmount"]= strval($obj['success_amount']);		//�������(Ԫ)
	$para["orderCurrency"]='CNY';							    //��������
	$para["transactionId"]=$obj['trade_no'];			    //��3��֧����ˮ
	$para["status"]="success";								    //״̬
	$para["sign"]=LeanWorkSDK::makeRecSign($para);			    //ǩ��
	$count=0;
	do{
		$seconds=$count*2;
		sleep($seconds);
		$log->W("֪ͨleanwork-����:\n".var_export($para,true));
		$result =LeanWorkSDK::doRequest($config['receiveUrl'], $para, $method = 'POST');
		$log->W("֪ͨleanwork-���:\n".var_export($result,true));
		
		$count++;
	}while($count<2);
	$arr = array('resp_code'=>'000000'); 
	echo json_encode($arr);
}else{
	fwrite($myfile, "��֤ʧ��");
}
$arr1 = array('resp_code'=>'999999'); 
echo json_encode($arr1);
?>