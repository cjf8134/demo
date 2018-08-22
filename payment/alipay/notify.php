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
$input=$_REQUEST;

$log->W("支付通知验证-参数:\n".var_export($input,true));

if($input){
	//准备签名参数
	$alipaySign = $input['sign'];
	unset($input['sign']);
	unset($input['sign_type']);

	if( $res = checkRsaSign(getSignContent($input),$alipaySign) ){
		$verify=true;
	}else{
		$verify=false;
	}
	$post = $input;
	$log->W("支付通知验证-参数:\n".var_export($post,true));
	$log->W("支付通知验证-签名:\n".$res);
	$log->W("支付通知验证-结果:\n".($verify?"ok":"fail"));
	
	if ($verify && isset($post['trade_status']) &&  $post['trade_status']=="TRADE_SUCCESS") {					 // 签名验证通过
		// 这里商户可以做一些自己的验证方式，如对比订单金额等
		$cache = new fileCache($cache_dir);
	   	$config = $cache->get(M_ID); 					//获取数据
	
		$log->W('通知leanwork地址:'.$config['receiveUrl']);

	   	$para["signType"]=LeanWorkSDK::$signType;				//签名类型
	   	$para["orderNo"]=$post['out_trade_no'];						//订单号
	   	$para["orderAmount"]= strval($post['total_amount']);			//订单金额(元)
	   	$para["orderCurrency"]='CNY';							//货币类型
	   	$para["transactionId"]=$post['trade_no'];				//第3方支付流水
	   	$para["status"]="success";								//状态
	   	$para["sign"]=LeanWorkSDK::makeRecSign($para);			//签名
	  
		$count=0;
	   	do{
		 	$seconds=$count*2;
			sleep($seconds);
			$log->W("通知leanwork-请求:\n".var_export($para,true));
			$result =LeanWorkSDK::doRequest($config['receiveUrl'], $para, $method = 'POST');
			$log->W("通知leanwork-结果:\n".var_export($result,true));
			if($result=="success"){
				include "insert.php";
				$result=true;
				break;
			}
			$count++;
	   }while($count<2);
	}	
	
}	
echo $result===true ? 'success' : 'fail';
//拼接参数
function getSignContent($params) {
	ksort($params);
	$stringToBeSigned = "";
	$i = 0;
	foreach ($params as $k => $v) {
		if ($v != '' && "@" != substr($v, 0, 1)) {
			if ($i == 0) {
				$stringToBeSigned .= "$k" . "=" . "$v";
			} else {
				$stringToBeSigned .= "&" . "$k" . "=" . "$v";
			}
			$i++;
		}
	}
	unset ($k, $v);
	return $stringToBeSigned;
}
//RSA2签名参数
function checkRsaSign($data,$sign) {
   	$pubKeyValue = APP_PUBKEY;
   	$res = "-----BEGIN PUBLIC KEY-----\n" .wordwrap($pubKeyValue, 64, "\n", true) ."\n-----END PUBLIC KEY-----";
    $result = openssl_verify($data, base64_decode($sign), $res, OPENSSL_ALGO_SHA256);
    return $result;
}	
?>
