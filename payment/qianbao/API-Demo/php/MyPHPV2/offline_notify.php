<?php

//////////////////////////	支付返回通知数据  /////////////////////////////////
/**
获取订单支付成功之后，支付通知服务器以post方式返回来的订单通知数据，参数详情请看接口文档,
*/	
	include_once("./merchant.php");
  
	$code	= $_POST["code"];	
	$input_charset = $_POST["input_charset"];

	$order_amount = $_POST["order_amount"];
	
	$orderId = $_POST["orderId"];

	$orderInfo = $_POST["orderInfo"];

	$orderTime = $_POST["orderTime"];

	$product_code = $_POST["product_code"];	

	$product_name = $_POST["product_name"];
  
    $sign_type = $_POST["sign_type"];
	
	$trade_status = $_POST["trade_status"];
	
    $sign = base64_decode($_POST["sign"]);


/////////////////////////////   参数组装  /////////////////////////////////
/**	
  sign参数除外，其他非空参数都要参与组装，组装顺序是按照a~z的顺序，下划线"_"优先于字母	
*/



	$signStr= "";
	$signStr = $signStr."code=".$code."&";	
	$signStr = $signStr."input_charset=".$input_charset."&";
	
	$signStr = $signStr."order_amount=".$order_amount."&";		
	$signStr = $signStr."orderId=".$orderId."&";	
	
	if($orderInfo != ""){
	$signStr = $signStr."orderInfo=".$orderInfo."&";
	}
	
	$signStr = $signStr."orderTime=".$orderTime."&";	
	

   
	if($product_code != ""){
	$signStr = $signStr."product_code=".$product_code."&";
	}
	
	if($product_name != ""){
	$signStr = $signStr."product_name=".$product_name."&";
	}	
	
	$signStr = $signStr."sign_type=".$sign_type."&";
    $signStr = $signStr."trade_status=".$trade_status;

	//$rs = file_put_contents('C:/log.txt', "\r\n".$signStr, FILE_APPEND);
	
/////////////////////////////   RSA-S验证  /////////////////////////////////

    
	$dinpay_public_key = openssl_get_publickey($dinpay_public_key);
	$flag = openssl_verify($signStr,$sign,$dinpay_public_key,OPENSSL_ALGO_MD5);	
	

	if($flag){		
		echo"SUCCESS";	
		//$rs = file_put_contents('C:/log.txt', "\r\n"."TESTSUCCESS", FILE_APPEND);

	}else{
      //  echo $trade_status;
		echo"Verification Error"; 
	// $rs = file_put_contents('C:/log.txt', "\r\n"."TESTError", FILE_APPEND);
	}
	
?>