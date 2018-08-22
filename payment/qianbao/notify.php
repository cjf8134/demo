<?php
require_once 'config.php';
require_once 'lib.php';
require_once 'log.class.php';
require_once 'fileCache.class.php';
require_once 'leanworkSDK.php';

/*
 * 异步通知处理页面
 */


$log=new Log();
$result=false;

if($_REQUEST){
	$input = $_REQUEST;
}elseif ($data = file_get_contents("php://input")){
	$input = $data;
}elseif($_GET){
	$input=$_GET;
}elseif($_POST){
	$input=$_POST;
}



$log->W("支付通知验证-参数:\n".var_export($input,true));

if($input){
	$log->W("支付通知验证-参数:\n".var_export($input,true));
	$signature =  base64_decode($input["sign"]);;
	$signStr= "";
	$signStr = $signStr."code=".$input['code']."&";
	$signStr = $signStr."input_charset=".$input['input_charset']."&";

	$signStr = $signStr."order_amount=".$input['order_amount']."&";
	$signStr = $signStr."orderId=".$input['orderId']."&";

	if($input['orderInfo'] != ""){
		$signStr = $signStr."orderInfo=".$input['orderInfo']."&";
	}

	$signStr = $signStr."orderTime=".$input['orderTime']."&";

	if($input['product_code'] != ""){
		$signStr = $signStr."product_code=".$input['product_code']."&";
	}
	if($input['product_name'] != ""){
		$signStr = $signStr."product_name=".$input['product_name']."&";
	}
	$signStr = $signStr."sign_type=".$input['sign_type']."&";
	$signStr = $signStr."trade_status=".$input['trade_status'];
	$log->W("支付通知验证-生成的签名的字符串:\n".$signStr);
	//$rs = file_put_contents('C:/log.txt', "\r\n".$signStr, FILE_APPEND);

/////////////////////////////   RSA-S验证  /////////////////////////////////


	$dinpay_public_key = openssl_get_publickey($dinpay_public_key);

	$flag = openssl_verify($signStr,$signature,$dinpay_public_key,OPENSSL_ALGO_MD5);
	//签名正确
	if ($flag){
		$verify=true;
	}else{
		$verify=false;
	}

	$log->W("支付通知验证-结果:\n".($verify ? "ok" : "fail"));

	if ($verify && $input['trade_status'] == "SUCCESS") { // 签名验证通过
		// 这里商户可以做一些自己的验证方式，如对比订单金额等
		$cache = new fileCache($cache_dir);
		$config = $cache->get(M_ID); //获取数据
		$log->W('通知leanwork地址:'.$config['receiveUrl']);
		$para["signType"]=LeanWorkSDK::$signType;				        //签名类型
		$para["orderNo"]=$input['orderId'];                          //订单号
		$para["orderAmount"]= strval($input['order_amount']);		            //订单金额(元)
		$para["orderCurrency"]='CNY';							        //货币类型
		$para["transactionId"]=$input['orderId'];	                    //第三方平台订单号
		$para["status"]="success";        //状态
		$para["sign"]=LeanWorkSDK::makeRecSign($para);
		$count=0;
	   do{
			$seconds = $count * 2;
			sleep($seconds);
			$log->W("通知leanwork-请求:\n".var_export($para,true));
			$result =LeanWorkSDK::doRequest($config['receiveUrl'], $para, $method = 'POST');
			$log->W("通知leanwork-结果:\n".var_export($result,true));
				if($result=="success"){
					$result=true;
					break;
				}
			$count++;
	   }while($count<2);
	}
}	
echo $result===true ? 'SUCCESS' : 'FAIL';
?>
