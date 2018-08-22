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
$post=$_POST;

$log=new Log();
$result=false;
$log->W("支付通知验证-参数:\n".var_export($post,true));



if($post){
	$signature = $post['sign'];
	$log->W("支付通知验证-返回的签名:\n".$signature);
	$strData = sprintf("customerid=%s&status=%s&sdpayno=%s&sdorderno=%s&total_fee=%s&paytype=%s&%s", M_ID, $post["status"], $post["sdpayno"], $post["sdorderno"], $post["total_fee"],$post["paytype"], APP_KEY);

//	$mysign = md5('customerid='.$customerid.'&status='.$status.'&sdpayno='.$sdpayno.'&sdorderno='.$sdorderno.'&total_fee='.$total_fee.'&paytype='.$paytype.'&'.$userkey);

	$log->W("支付通知验证-返回的参数做签名的字符串:\n".$strData);
	$log->W("支付通知验证-生成的签名:\n".md5($strData));
	//签名正确
	if ($signature == md5($strData)){
		$verify=true;
	}else{
		$verify=false;
	}
	$log->W("支付通知验证-结果:\n".($verify ? "ok" : "fail"));
	if ($verify && $post['status'] == 1) { // 签名验证通过
		// 这里商户可以做一些自己的验证方式，如对比订单金额等
		$cache = new fileCache($cache_dir);
		$config = $cache->get(M_ID); //获取数据
		$log->W('通知leanwork地址:'.$config['receiveUrl']);
		$para["signType"]=LeanWorkSDK::$signType;				        //签名类型
		$para["orderNo"]=$post['remark'];                          //订单号
		$para["orderAmount"]= strval($post['total_fee']);		        //订单金额(元)
		$para["orderCurrency"]='CNY';							        //货币类型
		$para["transactionId"]=$post['sdpayno'];	                    //第三方平台订单号
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
echo $result===true ? 'success' : 'fail';
?>
