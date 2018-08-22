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
$input=$_POST;
// $input=array (
// 	'tranData' => 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iR0JLIiA/PjxCMkNSZXM+PHRyYW5TZXJpYWxObz5aRjIwMTgwNjI5MTA0NTIyODAxNzwvdHJhblNlcmlhbE5vPjxjdXJUeXBlPkNOWTwvY3VyVHlwZT48bWVyY2hhbnRJZD5NMTAwMDAyMjQ1PC9tZXJjaGFudElkPjx0cmFuU3RhdD4xPC90cmFuU3RhdD48b3JkZXJObz4yMDE4MDYyOTE3MDUyMTUzOTE3PC9vcmRlck5vPjxyZW1hcms+MTgwMzIyMDAwNDQ5VFcwMDEzNzUwMDAwMDExNDA0NzE8L3JlbWFyaz48dHJhblRpbWU+MjAxODA2MjkxNzA3Mjc8L3RyYW5UaW1lPjxvcmRlckFtdD4uMDE8L29yZGVyQW10PjxzdWJtZXJuby8+PC9CMkNSZXM+',
// 	'signData' => 'Wn/NcJACrATU8ZzJTkq4EhvsyzrAILkhnTvOrxgCe/3PR8O8pG1P36QeD9WTGns7OLfjbA2Pth5XnLS57ruu4v1cmUYHLZ9KM1TfZ5ovzu+6nHbHtrdbjx93k2jCDAafXFgzE3Qzz2B7vQORhu5eMNUBcIuayvvKqcvD6YNEB50DRnqPtjUEsDy6n58Rm5vNhvto99ZxLldDJLWXLbiasbDbQ/ij50sN+J/j3h4gtGdQb888F8+MO3qL3CpkVIwajl5FHKADDhd0udogvIOfQBK13qOXnvZPx4MAHXcHNheIZa+BPflnzPrN/nGd1K0GtoCVZQjsAc05KyLB418Xng==',
// 	'interfaceName' => 'PayOrderNotify',
// 	'version' => 'B2C1.0',
// );
$log->W("支付通知验证-参数:\n".var_export($input,true));

if($input){

	$interfaceName = $input['interfaceName'];
	$version = $input['version'];
	$tranData = $input['tranData'];	// 通知结果数据
	$signMsg = $input['signData'];	// 甬易对通知结果的签名数据
	$keyValue = APP_KEY;// 商家密钥
	$tranDataDecode = base64_decode($tranData);
	// 对返回的数据也进行验签
	$signResult = verifyData($tranData, $signMsg);

	if ($signResult==1) {
		$verify=true;
	}else {
		//证书验签失败
		$verify=false;
	}
	
	$log->W("支付通知验证-结果:\n".($verify?"ok":"fail"));
		if ($verify) { // 签名验证通过
			//对返回的XML数据进行解析
			$retXml = simplexml_load_string($tranDataDecode, 'SimpleXMLElement', LIBXML_NOCDATA);
			$data = json_decode(json_encode($retXml),true);  // 转为数组
			// 这里商户可以做一些自己的验证方式，如对比订单金额等
			$cache = new fileCache($cache_dir);
			$config = $cache->get(M_ID); //获取数据
		    $log->W('通知leanwork地址:'.$config['receiveUrl']);
		    $para["signType"]=LeanWorkSDK::$signType;//签名类型
		    $para["orderNo"]=$data['remark'];//订单号
		    $para["orderAmount"]= strval(number_format($data['orderAmt'],2,".",""));//订单金额(元)
		    $para["orderCurrency"]='CNY';//货币类型
		    $para["transactionId"]=$data['tranSerialNo'];//第3方支付流水
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
						$result=true;
						break;
					}
				$count++;
		   	}while($count<2);
			   
			
		}	
	
}	
echo $result===true ? 'SUCCESS' : 'fail';	
?>
