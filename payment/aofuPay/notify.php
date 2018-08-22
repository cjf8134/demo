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

$input=$_POST;
$log->W("支付通知验证-参数:\n".var_export($input,true));


if($input){

	//解析响应 json
	$post = $input;
	//获取签名数据并从返回数据中移除
	$sign = $post['signature'];
	unset($post['signature']);
	$log->W("支付通知验证-参数:\n".var_export($post,true));
	//对返回数据按 ascii 方式排序   注意：如果值为空  不参与签名
	ksort($post);
	$temp =  '';
	foreach($post as $key=>$value)
	{
		$temp = $temp . $key . '=' . $value . '&';
	}
	$temp = substr($temp, 0,  strlen($temp) -1 );

	$log->W("支付通知验证-验签参数:\n".$temp);

	$publicKey = openssl_pkey_get_public(trim(file_get_contents($pub_Key)));

	if( openssl_verify($temp, base64_decode($sign), $publicKey, OPENSSL_ALGO_SHA1)){
		$log->W("支付通知验证-验签参数:\n".base64_decode($sign));
		$verify=true;
	}else{
		$verify=false;
	}

	$log->W("支付通知验证-结果:\n".($verify ? "ok" : "fail"));

	if ($verify) { // 签名验证通过
		// 这里商户可以做一些自己的验证方式，如对比订单金额等
		$cache = new fileCache($cache_dir);
		$config = $cache->get(M_ID); //获取数据
		$log->W('通知leanwork地址:'.$config['receiveUrl']);
		$para["signType"]=LeanWorkSDK::$signType;				        //签名类型
		$para["orderNo"]=$post['orderNo'];
		//订单号
		$para["orderAmount"]= strval($post['transAmt']/100);		            //订单金额(元)
		$para["orderCurrency"]='CNY';							        //货币类型
		$para["transactionId"]=$post['serialId'];			               //第3方支付流水
		$para["status"]="success";								        //状态
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
