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


//这个是测试数据。如果异步不通外网可以直接用这个数据测试
$obj = json_decode($input, TRUE);
$log->W("支付通知验证-参数:\n".var_export($obj,true));
$signature = $obj['sign'];
$obj['sign'] = '';
$obj['sign_type'] = '';
$myfile = fopen("newfile.txt", "w");
$strData = getStr($obj);
if(verify($strData, $signature, 'yixun.cer')){
	// 这里商户可以做一些自己的验证方式，如对比订单金额等
						        //获取数据
	$log->W('通知leanwork地址:'.$config['receiveUrl']);
	fwrite($myfile, "验证成功\n");
	if($obj['status'] == '1'){
		fwrite($myfile, "交易成功");
	}else if($obj['status'] == '2'){
		fwrite($myfile, "交易处理中");
	}else {
		fwrite($myfile, "交易失败");
	}
	$para["signType"]=LeanWorkSDK::$signType;				    //签名类型
	$para["orderNo"]=$obj['order_no'];						//订单号
	$para["orderAmount"]= strval($obj['success_amount']);		//订单金额(元)
	$para["orderCurrency"]='CNY';							    //货币类型
	$para["transactionId"]=$obj['trade_no'];			    //第3方支付流水
	$para["status"]="success";								    //状态
	$para["sign"]=LeanWorkSDK::makeRecSign($para);			    //签名
	$count=0;
	do{
		$seconds=$count*2;
		sleep($seconds);
		$log->W("通知leanwork-请求:\n".var_export($para,true));
		$result =LeanWorkSDK::doRequest($config['receiveUrl'], $para, $method = 'POST');
		$log->W("通知leanwork-结果:\n".var_export($result,true));
		
		$count++;
	}while($count<2);
	$arr = array('resp_code'=>'000000'); 
	echo json_encode($arr);
}else{
	fwrite($myfile, "验证失败");
}
$arr1 = array('resp_code'=>'999999'); 
echo json_encode($arr1);
?>