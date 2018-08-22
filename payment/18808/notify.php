<?php
require_once 'config.php';
require_once 'lib.php';
require_once 'log.class.php';
require_once 'fileCache.class.php';
require_once 'leanworkSDK.php';
require_once 'RSA.php';

/*
 * 异步通知处理页面
 */


$log=new Log();
$result=false;

$log=new Log();
$result=false;
//
$data = file_get_contents("php://input");
$input = $data;
$log->W("支付通知验证-参数:\n".var_export($data,true));

$log=new Log();
$result=false;

$log->W("支付通知验证-参数:\n".var_export($input,true));
if($input){
	$post = json_decode($input,true);
	//验签通过
	$sign = $post['sign'];
	unset($post['resultMsg']);
	unset($post['sign']);
	$secretkey = '';
	$signmd5="";

	ksort($post,SORT_NATURAL | SORT_FLAG_CASE);
	foreach($post as $x=>$x_value)
	{
		if(!$x_value==""||$x_value==0){
			if($signmd5==""){
				$signmd5 =$signmd5.$x .'='. $x_value;
			}else{
				$signmd5 = $signmd5.'&'.$x .'='. $x_value;
			}
		}
	}
	$mysign =  md5($signmd5.APP_KEY);
	$log->W("支付通知验证-参数msg:\n".var_export($post,true));
	$log->W("支付通知验证-sign:\n".$mysign);

	if($mysign == $sign){
		$verify=true;
	}else{
		$verify=false;
	}

	$log->W("支付通知验证-结果:\n".($verify ? "ok" : "fail"));

	if ($verify && $post['resultCode'] == "000000") { // 签名验证通过
		// 这里商户可以做一些自己的验证方式，如对比订单金额等
		$cache = new fileCache($cache_dir);
		$config = $cache->get(M_ID); //获取数据
		$log->W('通知leanwork地址:'.$config['receiveUrl']);
		$para["signType"]=LeanWorkSDK::$signType;				        //签名类型
		$para["orderNo"]=$post['orderNo'];
		//订单号
		$para["orderAmount"]= strval($post['orderAmount'] / 100);		            //订单金额(元)
		$para["orderCurrency"]='CNY';							        //货币类型
		$para["transactionId"]=$post['orderNo'];			               //第3方支付流水
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
