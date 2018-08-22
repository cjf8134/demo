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
$notify_data = json_decode(file_get_contents('php://input'), true);
//$input="%7B%22sign%22%3A%22084d8103e179beb9772b25866dd12689%22%2C%22rate%22%3A0.008000%2C%22orderidinf%22%3A%22180322000449TW001375000001140105%22%2C%22tradeFee%22%3A%220.00%22%2C%22appid%22%3A%22AWP112897%22%2C%22paysucctime%22%3A%222018-04-18+04%3A31%3A09%22%2C%22tradeAmount%22%3A%220.01%22%2C%22msg%22%3A%22ok%22%2C%22success%22%3Atrue%2C%22orderId%22%3A%22R2018041812294201204%22%2C%22totalPrice%22%3A0.01%7D";
$notify_data=array (
	'context' => 'OPNCT7jOFpwC8yyqtjuCFkOX7uET6ihnvuasf/gSiowZowK30XnLbeaGXmxcVdx5kG8gN5pPJ/XnNNkKiaC3/X1FW2e7ktq29K0Lele/APjd1dHBJfiU9oaLJ/2lR5b1OeyYQRvq5i8uYliqzbgRufQwCyRbEEQDauv/P+1+OeBqsROZFv+MOWMYiiJPJeeBBQAvzmvCDwUQQvmnRNOuRHFQceqD8iJnyPTgU8Y8R4ZXF1rxQnNsVD4OEoL811bojHaZ6Poyr3zEfHKh2OgAxVa8xXZNps0E49rExsfOpXMp5I/WvUGdGN3bAnz9HmUUxSWiCt8EQFm4zqgRkvSWhJWxNqsjzxXVALelyIOVOWB5Zf7VqLyGL9KBgZEgTk4XjJHRBqOEvGXXz8m4xWyrVgfj3OThLBQOk5h/A7K42Yf0AcfkiY9vUQs/kdtpApbtbI41ZZgDoZfyPlcjEREovpoOZQBzNc0I87ev4fq6CeZTlVsjHQV9zqEcbT4OKNlJCm696hSlxAXq++UlrgksVhdeEcn13OR2LHZ0ufKNi2DySyFIafZZaF1UfkNzJVUqgiFLVdpn3HdlWDayVhYOrG8qYoHXAEHIf6GcUXofHFaKXVRqh/ChUgWFar/8rf91SuRFADgu8u3A9VwDPTzyE+t3/TkC/jbBaixnrDlVBNQ=',
	'orderNumber' => '180322000449TW001375000001140391',
);
$log->W("支付通知验证-参数:\n".var_export($notify_data,true));
if($notify_data){
	$notify = $notify_data['context'];//提取密文

	$merchant_private_key = PRIVATE_KEY;
	$ecpay_public_key = PAY_KEY;
    $mer_private_key = openssl_pkey_get_private($merchant_private_key);//取私钥资源号

    $ec_public_key = openssl_pkey_get_public($ecpay_public_key);//取PAY公钥资源号

    $data = rsa_decrypt($notify, $mer_private_key);//执行解密流程

    $context_arr = json_decode($data, true);//转为数组格式

    $sign = $context_arr['businessHead']['sign'];//取SIGN

    $businessContext = $context_arr['businessContext'];//取businessContext

    ksort($businessContext);//按ASCII码从小到大排序

    $json_businessContext = json_encode($businessContext, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    $isVerify = (boolean) openssl_verify($json_businessContext, base64_decode($sign), $ec_public_key, OPENSSL_ALGO_MD5);
//-------------------------

if ($isVerify) {
        /**
         * 验签成功，执行商户自己的逻辑
         */
		 $post = $context_arr;
		 // 这里商户可以做一些自己的验证方式，如对比订单金额等
			$cache = new fileCache($cache_dir);
		   $config = $cache->get(M_ID); //获取数据
		
			$log->W('通知leanwork地址:'.$config['receiveUrl']);
		   $para["signType"]=LeanWorkSDK::$signType;//签名类型
		   $para["orderNo"]=$post['orderNumber'];//订单号
		   $para["orderAmount"]= strval($post['amount']/100);//订单金额(元)
		   $para["orderCurrency"]='CNY';//货币类型
		   $para["transactionId"]=$post['payOrderNumber'];//第3方支付流水
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
			 
			 
			echo 'SUC';  //成功返回SUC，系统则不会继续推送notify
		}else{
			echo 'FAIL';

    }
		
?>
