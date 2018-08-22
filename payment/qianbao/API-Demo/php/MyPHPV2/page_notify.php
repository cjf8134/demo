<?php
//////////////////////////支付返回通知数据  /////////////////////////////////
/**
获取订单支付成功之后，支付通知服务器以post方式返回来的订单通知数据
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

	$result="deposit successful";
	
	
?>
<!DOCTYPE HTML>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
		<title>zhihpay</title>
	</head>
		<body>
		<?php echo $result?>
		</body>
</html>