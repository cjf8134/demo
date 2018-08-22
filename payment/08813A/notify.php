<?php
require_once 'config.php';
require_once 'lib.php';
require_once 'log.class.php';
require_once 'fileCache.class.php';
require_once 'leanworkSDK.php';
require ("Util.php"); // 加载配置文件
/*
 * 异步通知处理页面
 */
$log=new Log();
$result=false;

$util = new Util ();
$util->writelog("===========异步通知========");

$input = $_REQUEST;

$log->W("支付通知验证-参数5:\n".$input);
if($input){
	$post = null;
	foreach ( $input as $key => $val ) {
		$post [$key] = urldecode ( $val );
	}
	$util->writelog ("异步通知参数:" .$util->getURLParam($post,$merconfig["Url_Param_Connect_Flag"],true,null));


	//==验签数据
	if ($util->verifySign($post, $merconfig["Url_Param_Connect_Flag"], $removeKeys
		, APP_KEY)){
		$util->writelog("异步通知验证签名成功!");
		$verify=true;
	}else {
		$util->writelog("异步通知验证失败:");
		$verify=false;
	}

	$log->W("支付通知验证-结果:\n".($verify ? "ok" : "fail"));
	if ($verify && strcmp($post['Status'],"1") == 0) { // 签名验证通过
		// 这里商户可以做一些自己的验证方式，如对比订单金额等
		$cache = new fileCache($cache_dir);
		$config = $cache->get(M_ID); //获取数据
//		$order_no= $cache->get($post['fxddh']); //获取数据
		$log->W('通知leanwork地址:'.$config['receiveUrl']);
		$para["signType"]=LeanWorkSDK::$signType;				        //签名类型
		$para["orderNo"]=$post['Remark'];                              //订单号
		$para["orderAmount"]= strval($post['Amount']/100);		            //订单金额(元)
		$para["orderCurrency"]='CNY';			        //货币类型
		$para["transactionId"]=$post['PlatTxSN'];                //第三方平台订单号
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
