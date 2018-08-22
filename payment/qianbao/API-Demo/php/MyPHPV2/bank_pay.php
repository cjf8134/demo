<? header("content-Type: text/html; charset=UTF-8");?>
<?php
/* *
 *功能：支付个人网银支付接口
 *版本：2.0
 *日期：2018-04-23
 *说明：
 *以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,
 *并非一定要使用该代码。该代码仅供学习和研究快银支付接口使用，仅为提供一个参考。
 **/
 
///////////////////////////  初始化接口参数  //////////////////////////////
/**
接口参数请参考快银支付网银支付文档，除了sign参数，其他参数都要在这里初始化
*/
    date_default_timezone_set("Asia/Shanghai");
	include_once("./merchant.php");
	$orderId =date( 'YmdHis' );// date( 'YmdHis' );	 //订单号
	$code = "1685";    //商户号
	$offline_notify ="http://192.168.0.104:8080/MyPHPV2/offline_notify.php";  	 
    $page_notify =  "http://192.168.0.104:8080/MyPHPV2/page_notify.php"; 
	$orderInfo="测试";
	$interfaceVersion ="2.0.1";
	$orderTime=date( 'YmdHis' );    //
	$sign_type ="RSA-S";
    $product_name ="奥利奥";	
	$product_code="100002";
	$order_amount = "7.3";	
	$input_charset="UTF-8";
// code=1611&input_charset=UTF-8&interfaceVersion=2.0.1&offline_notify=http://localhost:57350/home/PayNotify&order_amount=6.3&orderId=636592237421387070&orderInfo=测试&orderTime=20180413134222&page_notify=http://localhost:57350/home/ReturnPage&product_code=100002&product_name=奥利奥&sign_type=RSA-S	
// code=1611&interfaceVersion=2.0.1&offline_notify=http://192.168.0.107:8080/MyPHPV2/offline_notify.php&order_amount=0.5&orderId=20180413054328&orderInfo=测试&orderTime=70707070JanJan0101000001010000&page_notify=http://192.168.0.107:8080/MyPHPV2/page_notify.php&product_code=100002&product_name=奥利奥&sign_type=RSA-S&

/////////////////////////////   参数组装  /////////////////////////////////
/**
除了sign_type参数，其他非空参数都要参与组装，组装顺序是按照a~z的顺序，下划线"_"优先于字母	
*/
	
	$signStr= "";
	$signStr = $signStr."code=".$code."&";	
	$signStr = $signStr."input_charset=".$input_charset."&";
	$signStr = $signStr."interfaceVersion=".$interfaceVersion."&";
	$signStr = $signStr."offline_notify=".$offline_notify."&";		
	$signStr = $signStr."order_amount=".$order_amount."&";		
	$signStr = $signStr."orderId=".$orderId."&";	
	
	if($orderInfo != ""){
	$signStr = $signStr."orderInfo=".$orderInfo."&";
	}
	
	$signStr = $signStr."orderTime=".$orderTime."&";	
	
	$signStr = $signStr."page_notify=".$page_notify."&";	
   
	if($product_code != ""){
	$signStr = $signStr."product_code=".$product_code."&";
	}
	
	if($product_name != ""){
	$signStr = $signStr."product_name=".$product_name."&";
	}	
	
	$signStr = $signStr."sign_type=".$sign_type;	


	
//	echo $signStr."<br>";  
		
	  //	$fp = fopen("C:/log.txt",'w');
	//	file_put_contents($fp,"abc",FILE_APPEND);
	//fwrite($fp, "SUCCESS");
	//$rs = file_put_contents('C:/log.txt', "\r\n"."aa", FILE_APPEND);

/////////////////////////////   获取sign值（RSA-S加密）  /////////////////////////////////

	$merchant_private_key= openssl_get_privatekey($merchant_private_key);
	openssl_sign($signStr,$sign_info,$merchant_private_key,OPENSSL_ALGO_MD5);
	$sign = base64_encode($sign_info);
	
 //   echo $sign;
?>

<!-- 以post方式提交所有接口参数到快银支付支付网关https://pay.fastbank.net/gateway?input_charset=UTF-8 -->
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>	
	<body onLoad="document.dinpayForm.submit();">
		<form name="dinpayForm" method="post" action="https://account.csepay.com/CSEPay/Pay" target="_blank">
			<input type="hidden" name="sign"	value="<?php echo $sign?>" />
			<input type="hidden" name="orderId" value="<?php echo $orderId?>" />
			<input type="hidden" name="code"     value="<?php echo $code?>"/>
			<input type="hidden" name="offline_notify"      value="<?php echo $offline_notify?>"/>
			<input type="hidden" name="page_notify"  value="<?php echo $page_notify?>"/>		
			<input type="hidden" name="orderInfo"  value="<?php echo $orderInfo?>"/>
			<input type="hidden" name="interfaceVersion" value="<?php echo $interfaceVersion?>"/>
			<input type="hidden" name="orderTime"    value="<?php echo $orderTime?>">
	     	<input type="hidden" name="sign_type" value="<?php echo $sign_type?>"/>			
			<input type="hidden" name="product_name"     value="<?php echo $product_name?>"/>
			<input type="hidden" name="product_code"    value="<?php echo $product_code?>"/>
			<input type="hidden" name="order_amount"  value="<?php echo $order_amount?>"/>	
			<input Type="hidden" Name="input_charset"     value="<?php echo $input_charset?>"/>		
		</form>
	</body>
</html>