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
}

$log=new Log();
$result=false;

$log->W("支付通知验证-参数:\n".$input);
if($input){
	$post = json_decode($input, true);
	$log->W("支付通知验证-参数:\n".var_export($post,true));
	$log->W("支付通知验证-结果:\n".($post ? "ok" : "fail"));
	$strData = MakeSign($post['Body'],APP_KEY);
	$log->W("支付通知验证-生成签名:\n".$strData);
	$log->W("支付通知验证-支付返回签名:\n".$post['Sign']);
	if ($post['Sign'] == $strData){
		$verify=true;
	}else{
		$verify=false;
	}

	if ($verify && $post['RetCode'] == 1) { // 签名验证通过
		// 这里商户可以做一些自己的验证方式，如对比订单金额等
		$cache = new fileCache($cache_dir);
		$config = $cache->get(M_ID); //获取数据
		$order_no= $cache->get($post['Body']['REMARK']); //获取数据
		$log->W('通知leanwork地址:'.$config['receiveUrl']);
		$para["signType"]=LeanWorkSDK::$signType;				        //签名类型
		$para["orderNo"]=$order_no;                          //订单号
		$para["orderAmount"]= strval($post['Body']['AMT']);		            //订单金额(元)
		$para["orderCurrency"]='CNY';							        //货币类型
		$para["transactionId"]=$post['Body']['LIST_ID'];	           //第三方平台订单号
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
