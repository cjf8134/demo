<?php

require_once 'config.php';
require_once 'lib.php';
require_once 'log.class.php';
require_once 'fileCache.class.php';
require_once 'leanworkSDK.php';
require_once 'common/Tool.php';
require_once 'common/config.php';
require_once 'paycenter_service.php';

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
	$log->W("支付通知验证-参数GET:\n".var_export($_GET,true));
	$log->W("支付通知验证-参数POST:\n".var_export($_POST,true));

	$pcs = new PayCenterService();
	$post = $pcs->acceptNotifyResponse($_GET, $_POST);


//	if ($ret['code'] != "1000" && $ret['msg'] != "SUCCESS" ){
//		$verify=false;
//	}else{
//		/* 检查数字签名是否正确 */
//		if(!file_exists($prifile) && !file_exists($pubfile)){
//			die('密钥或者公钥的文件路径不正确');
//		}
//		$sigstr=$input['ret'] . "|" . $input['msg'];
//		$log->W("参与验签的字符串-参数:\n".$sigstr);
//		$signature = str_replace(array('-','_'),array('+','/'),$signtrue);
//		$log->W("支付通知验证(字符过滤)-sign:\n".$signtrue);
//		$m = new RSA($pubfile, $prifile);
//		if($m->verify($sigstr,$signature)){
//			$verify=true;
//		}else{
//			$verify=false;
//		}
//	}
//	$log->W("支付通知验证-结果:\n".($verify ? "ok" : "fail"));

	if ($post['pay_result'] == "1") { // 签名验证通过
		// 这里商户可以做一些自己的验证方式，如对比订单金额等
		$cache = new fileCache($cache_dir);
		$config = $cache->get(M_ID); //获取数据
		$order_no = $cache->get($post['out_trade_no']); //获取数据
		$log->W('通知leanwork地址:'.$config['receiveUrl']);
		$para["signType"]=LeanWorkSDK::$signType;				        //签名类型
		$para["orderNo"] =$order_no;
		//订单号
		$para["orderAmount"]= strval($post['amount']);		            //订单金额(元)
		$para["orderCurrency"]='CNY';							        //货币类型
		$para["transactionId"]=$post['pay_no'];			               //第3方支付流水
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
