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

if($_REQUEST){
	$input = $_REQUEST;
}elseif ($data = file_get_contents("php://input")){
	$input = $data;
}elseif($_GET){
	$input=$_GET;
}elseif($_POST){
	$input=$_POST;
}
//orders=[{"payChannels":[{"payAmount":"1","payProvider":"NJABC","payTypeCode":"DEBIT_NETPAY"}],"orderAmount":1,"outOrderNo":"201807201610524027","buyerUserNo":"EM0000005697497","tunnelData":"eyJwYXlVc2VyTm8iOiJFTTAwMDAwMDU2OTc0OTcifQ==","orderTime":"20180720161052","payTime":"20180720161223","orderId":1807209093217222460}]&responseCode=0000

$log=new Log();
$result=false;
if($input){
	$log->W("支付通知验证-参数:\n".var_export($input,true));
	/*取返回参数*/
	$pay_result     = $input['responseCode'];//响应码
	$body = json_decode($input['orders'], true);
	if ($pay_result != "0000"){
		$verify=false;
	}else{
		/* 检查数字签名是否正确 */
		if(!file_exists($prifile) && !file_exists($pubfile)){
			die('密钥或者公钥的文件路径不正确');
		}
		$sigstr="orders=".$input['orders']."&responseCode=".$pay_result;
		$log->W("参与验签的字符串-参数:\n".$sigstr);
		$sign = strtoupper(md5($sigstr));
		$signature = str_replace(array('-','_'),array('+','/'),$input['signature']);
		$m = new RSA($pubfile, $prifile);
		if($m->verify($sign,$signature)){
			$verify=true;
		}else{
			$verify=false;
		}
	}
	$log->W("支付通知验证-结果:\n".($verify ? "ok" : "fail"));

	if ($verify) { // 签名验证通过
		// 这里商户可以做一些自己的验证方式，如对比订单金额等
		$cache = new fileCache($cache_dir);
		$config = $cache->get(M_ID); //获取数据
		$order_no= $cache->get($body[0]['outOrderNo']); //获取数据

		$log->W('通知leanwork地址:'.$config['receiveUrl']);
		$para["signType"]=LeanWorkSDK::$signType;				        //签名类型
		$para["orderNo"]=$order_no;
		//订单号
		$para["orderAmount"]= strval($body[0]['orderAmount']/100);		            //订单金额(元)
		$para["orderCurrency"]='CNY';							        //货币类型
		$para["transactionId"]=number_format($body[0]['orderId'],"0",".","");			        //第3方支付流水
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
echo $result===true ? 'true' : 'FAIL';
?>
