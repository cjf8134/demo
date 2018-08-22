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
$log->W("支付通知验证-参数:\n".$input);

if($input){
	$post=json_decode($input,true);
	$signature = $post['signature'];

	$log->W("支付通知验证-参数:\n".var_export($post,true));
	$log->W("返回签名:\n".$signature);
	$strData = sign_verify(json_encode($post['biz_content'],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES),APP_KEY);
	$log->W("生成签名:\n".$strData);

	if ($strData == $signature){
		$verify=true;
	}else{
		$verify=false;
	}

	if ($verify && $post['ret_code'] == '0') { // 签名验证通过
		// 这里商户可以做一些自己的验证方式，如对比订单金额等
		$cache = new fileCache($cache_dir);
		$config = $cache->get(M_ID); //获取数据
		$log->W('通知leanwork地址:'.$config['receiveUrl']);
		$para["signType"]      = LeanWorkSDK::$signType;				        //签名类型
		$para["orderNo"]       = $post['biz_content']['out_order_no'];                          //订单号
		$para["orderAmount"]   = strval($post['biz_content']['payment_fee']) / 100;		            //订单金额(元)
		$para["orderCurrency"] = 'CNY';							        //货币类型
		$para["transactionId"] = $post['biz_content']['order_no'];	        //第3方支付流水
		$para["status"]        = "success";								        //状态
		$para["sign"]          = LeanWorkSDK::makeRecSign($para);
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
