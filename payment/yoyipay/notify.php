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
$input=file_get_contents("php://input");
//$input="%7B%22sign%22%3A%22084d8103e179beb9772b25866dd12689%22%2C%22rate%22%3A0.008000%2C%22orderidinf%22%3A%22180322000449TW001375000001140105%22%2C%22tradeFee%22%3A%220.00%22%2C%22appid%22%3A%22AWP112897%22%2C%22paysucctime%22%3A%222018-04-18+04%3A31%3A09%22%2C%22tradeAmount%22%3A%220.01%22%2C%22msg%22%3A%22ok%22%2C%22success%22%3Atrue%2C%22orderId%22%3A%22R2018041812294201204%22%2C%22totalPrice%22%3A0.01%7D";

$log->W("支付通知验证-参数:\n".$input);
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
	$log->W("支付通知验证-参数:\n".var_export($input,true));
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
		    $para["orderAmount"]= strval($data['orderAmt']);//订单金额(元)
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
