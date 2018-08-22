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
$input=$_REQUEST['req'];

$log->W("支付通知验证-参数:\n".var_export($_REQUEST,true));

if($input){
    $return_sign =	md5($input.APP_KEY);
	
	if($return_sign==$_REQUEST['sign']){
		$verify=true;
	}else{
		$verify=false;
	}
	$post = json_decode( base64_decode($input),true );
	$log->W("支付通知验证-参数:\n".var_export($post,true));
	$log->W("支付通知验证-结果:\n".($verify?"ok":"fail"));
	
	if ($verify  && $post['resultcode']=="0000") {					 // 签名验证通过
		// 这里商户可以做一些自己的验证方式，如对比订单金额等
		$cache = new fileCache($cache_dir);
	   	$config = $cache->get(M_ID); 					//获取数据
	
		$log->W('通知leanwork地址:'.$config['receiveUrl']);

	   	$para["signType"]=LeanWorkSDK::$signType;				//签名类型
	   	$para["orderNo"]=$post['orderid'];						//订单号
	   	$para["orderAmount"]= strval($post['txnamt'] / 100);			//订单金额(元)
	   	$para["orderCurrency"]='CNY';							//货币类型
	   	$para["transactionId"]=$post['queryid'];				//第3方支付流水
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
echo $result===true ? '0000' : 'fail';	
?>
