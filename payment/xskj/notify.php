<?php
require_once 'config.php';
require_once 'lib.php';
require_once 'log.class.php';
require_once 'fileCache.class.php';
require_once 'leanworkSDK.php';
require_once "doPay.class.php";

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
//$input = "eyJhbGciOiJSUzI1NiJ9.eyJtY2hfaWQiOiI1YjQ0MmRhNDdkMDJkN2Q1Nzk3OTZkMzgiLCJvcmRlcl9pZCI6IjIwMTgwNzEyMTEwMjA3NzE3MCIsImFtb3VudCI6MTAwLCJ0cmFkZV9zdGF0ZSI6OCwidHJhZGVfdGltZSI6MTUzMTM2NDYzOSwiYWdlbnRfb3JkZXJfaWQiOiI1YjQ2YzRiMTdkMDJkN2VmMTkwNDhmMTAifQ.heh4z41fKfN5nwkmvcy_xaMfCtZExKPtXpnXKFesNmlU7P6g4Qpu_3KkFxp95260LJZhWLvVkNEgSYJeXcHvzUn2AtttoK9LSi0e1kh7zTI8rGL2JFylgLj8lo_VjMyNfhQFZ8l-yMe9e3Idkv5X8gwxfrDAxgT5_BYaQ4W2MvK34pklmEGCkld3BcqUdDc_HECzv4ws9N9tJiZYrzlPAD785SPVcxn17fAa73gK5P-u24KoT9f8zkDoVQ0Jg-dOx5UQPas1Ebor0ZDM6-hoFOPgk96yoJKM55mLNroOSdWWYMAogI00_I4DxP_UGIGfN4k8hgPI13bf3_vFaN9fHg";

$log=new Log();
$result=false;

$log->W("支付通知验证-参数:\n".var_export($input,true));
if($input){

	//接收参数
	$data="";
	$data['apiName']     = $input['apiName'];
	$data['notifyTime']  = $input['notifyTime'];
	$data['merchNo']     = $input['merchNo'];
	$data['merchParam']  = $input['merchParam'];
	$data['orderNo']     = $input['orderNo'];
	$data['tradeDate']   = $input['tradeDate'];
	$data['tradeAmt']    = $input['tradeAmt'];
	$data['accNo']       = $input['accNo'];
	$data['orderStatus'] = $input['orderStatus'];
	$log->W("支付通知验证-参数res:\n".var_export($data,true));

	$signtrue=$input['signMsg'];

	$string ="apiName=".$data['apiName']
		."&tradeAmt=".$data['tradeAmt']
		."&merchNo=".$data['merchNo']
		."&orderNo=".$data['orderNo']
		."&tradeDate=".$data['tradeDate']
		."&accNo=".$data['accNo']
		."&orderStatus=".$data['orderStatus']
		.APP_KEY;
	$log->W("支付通知验证-ZIFUCHUAN:\n".$string);
	$signstr=md5($string);

	$log->W("支付通知验证-sign:\n".$signtrue);
	if($signtrue == $signstr){

		$verify=true;
	}else{
		$verify=false;
	}

	$log->W("支付通知验证-结果:\n".($verify ? "ok" : "fail"));

	if ($verify && $data['orderStatus'] == 1) { // 签名验证通过
		// 这里商户可以做一些自己的验证方式，如对比订单金额等
		$cache = new fileCache($cache_dir);
		$config = $cache->get(M_ID); //获取数据

		$orderNo = $cache->get($data['orderNo']); //获取数据
		$log->W('通知leanwork地址:'.$config['receiveUrl']);
		$para["signType"]=LeanWorkSDK::$signType;				        //签名类型
		$para["orderNo"]=$orderNo;
		//订单号
		$para["orderAmount"]= strval($data['tradeAmt']);		            //订单金额(元)
		$para["orderCurrency"]='CNY';							        //货币类型
		$para["transactionId"]=$data['accNo'];	                        //第3方支付流水
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
