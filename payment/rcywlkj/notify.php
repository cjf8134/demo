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
$input=file_get_contents("php://input");
$log->W("支付通知验证-参数:\n".$input);
if($input){
	//接受的参数
	$memberid = $post['memberid'];          			//商户编号
	$orderid = $post['orderid'];						//订单号
	$amount = $post['amount'];							//订单金额
	$transaction_id = $post['transaction_id'];			//交易流水号
    $datetime = $post['datetime'];						//交易时间
	$returncode = $post['returncode'];					//交易状态(“00” 为成功)
	$sign = $post['sign'];								//签名
	//去除不参加签名的参数
	unset($post['sign']);
	unset($post['attach']);
	$mySign = LeanWorkSDK::MakeSign($post);
	
	if ( $mySign == $sign ) {
		$verify=true;
	}else {
		$verify=false;
	}
	$log->W("支付通知验证-参数:\n".var_export($post,true));
	$log->W("支付通知验证-结果:\n".($verify?"ok":"fail"));

	//验签成功，通知下游
	if ($verify  && $returncode == '00') { 	
		//这里商户可以做一些自己的验证方式，如对比订单金额等
		//回调地址获取
		$cache = new fileCache($cache_dir);
	   	$config = $cache->get(M_ID); //获取数据
		$log->W('通知leanwork地址:'.$config['receiveUrl']);
		//回调数据
	   	$para["signType"] = LeanWorkSDK::$signType;				//签名类型
	   	$para["orderNo"] = $orderid;							//订单号
	   	$para["orderAmount"]= $amount;							//订单金额(元)
	   	$para["orderCurrency"]='CNY';							//货币类型
	   	$para["transactionId"]=$transaction_id;					//第3方支付流水
	   	$para["status"]="success";								//状态
	   	$para["sign"]=LeanWorkSDK::makeRecSign($para);			//签名
		//记录次数（最大通知三次）
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
echo $result===true ? 'SUCCESS' : 'fail';	
?>
