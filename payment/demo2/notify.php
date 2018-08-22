<?php
require_once 'config.php';

require_once 'log.class.php';
require_once 'fileCache.class.php';
require_once 'leanworkSDK.php';


			
             



/*
 * 异步通知处理页面
 */
$log=new Log();




			$partner =M_ID;//商户ID
            $Key = M_KEY;//商户KEY
			
			$orderstatus = $_GET["orderstatus"];
            $ordernumber = $_GET["ordernumber"];
            $paymoney = $_GET["paymoney"];
            $sign = $_GET["sign"];
            $attach = $_GET["attach"];
            $signSource = sprintf("partner=%s&ordernumber=%s&orderstatus=%s&paymoney=%s%s", $partner, $ordernumber, $orderstatus, $paymoney, M_KEY); 
           
		   if ($sign == md5($signSource))//签名正确
		   {
				$verify=true;
			}else{
				$verify=false;
			}
	$log->W("支付通知验证-参数:\n".var_export($_GET,true));
	$log->W("支付通知验证-结果:\n".($verify?"ok":"fail"));
	
		$result=false;
	
		if ($verify  && $orderstatus==1) { // 签名验证通过
			// 这里商户可以做一些自己的验证方式，如对比订单金额等
			$cache = new fileCache($cache_dir);
			   $config = $cache->get(M_ID); //获取数据
			
				$log->W('通知leanwork地址:'.$config['receiveUrl']);
			   $para["signType"]=LeanWorkSDK::$signType;//签名类型
			   $para["orderNo"]= $ordernumber;//订单号
			   $para["orderAmount"]= strval($paymoney);//订单金额(元)
			   $para["orderCurrency"]='CNY';//货币类型
			   $para["transactionId"]=$ordernumber;//第3方支付流水
			   $para["status"]="success";//状态
			   $para["sign"]=LeanWorkSDK::makeRecSign($para);//签名
			  
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
	echo $result===true ? 'ok' : 'fail';	
		

?>
