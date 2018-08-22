<?php
require_once 'config.php';
require_once 'lib.php';
require_once 'log.class.php';
require_once 'fileCache.class.php';
require_once 'leanworkSDK.php';
require_once 'src/JWT.php';

/*
 * 异步通知处理页面
 */


$log=new Log();
$result=false;

$input=file_get_contents("php://input");
//$input = "eyJhbGciOiJSUzI1NiJ9.eyJtY2hfaWQiOiI1YjQ0MmRhNDdkMDJkN2Q1Nzk3OTZkMzgiLCJvcmRlcl9pZCI6IjIwMTgwNzEyMTEwMjA3NzE3MCIsImFtb3VudCI6MTAwLCJ0cmFkZV9zdGF0ZSI6OCwidHJhZGVfdGltZSI6MTUzMTM2NDYzOSwiYWdlbnRfb3JkZXJfaWQiOiI1YjQ2YzRiMTdkMDJkN2VmMTkwNDhmMTAifQ.heh4z41fKfN5nwkmvcy_xaMfCtZExKPtXpnXKFesNmlU7P6g4Qpu_3KkFxp95260LJZhWLvVkNEgSYJeXcHvzUn2AtttoK9LSi0e1kh7zTI8rGL2JFylgLj8lo_VjMyNfhQFZ8l-yMe9e3Idkv5X8gwxfrDAxgT5_BYaQ4W2MvK34pklmEGCkld3BcqUdDc_HECzv4ws9N9tJiZYrzlPAD785SPVcxn17fAa73gK5P-u24KoT9f8zkDoVQ0Jg-dOx5UQPas1Ebor0ZDM6-hoFOPgk96yoJKM55mLNroOSdWWYMAogI00_I4DxP_UGIGfN4k8hgPI13bf3_vFaN9fHg";

$log=new Log();
$result=false;

$log->W("支付通知验证-参数:\n".$input);
if($input){
	$post = JWT::decode($input, $public_key, array('RS256'));
	$post = json_decode(json_encode($post),true);
	$log->W("支付通知验证-参数:\n".var_export($post,true));

	if(is_array($post)){
		$verify=true;
	}else{
		$verify=false;
	}
	$log->W("支付通知验证-结果:\n".($post ? "ok" : "fail"));
	if ($verify && $post['trade_state'] == 8) { // 签名验证通过
		// 这里商户可以做一些自己的验证方式，如对比订单金额等
		$cache = new fileCache($cache_dir);
		$config = $cache->get(M_ID); //获取数据
		$order_no= $cache->get($post['order_id']); //获取数据
		$log->W('通知leanwork地址:'.$config['receiveUrl']);
		$para["signType"]=LeanWorkSDK::$signType;				        //签名类型
		$para["orderNo"]=$order_no;                          //订单号
		$para["orderAmount"]= strval($post['amount']/100);		            //订单金额(元)
		$para["orderCurrency"]='CNY';							        //货币类型
		$para["transactionId"]=$post['agent_order_id'];	           //第三方平台订单号
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
