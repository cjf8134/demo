<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
    include_once("leanworkSDK.php");
	    // pickupUrl	付款客户成功后的页面
		// receiveUrl 	服务器接受支 付结果的后台 地址 
		// signType	签名类型 
		// orderNo 	订单号
		// orderAmount 	订单金额
		// orderCurrency	货币类型
		// customerId	客户交易者账号
		// sign	签名
	//通过客户传递 价格和 银行编码 和 账户号id  目前写死
	
	
	
	
	$para['pickupUrl']="http://localhost/pay/success";
    $para['receiveUrl']="http://localhost/pay/";
    $para['signType']="MD5";
    $para['orderNo']="180322000449TW001375000001140".mt_rand(100, 999);
    $para['orderAmount']="10";
    $para['orderCurrency']="CNY";
    $para['customerId']="1";
   
   
   
   
   
   
   
   LeanWorkSDK::buildMockUrl($para);
?>
</body>
</html>

