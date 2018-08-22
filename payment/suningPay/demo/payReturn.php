<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; pageEncoding=UTF-8; charset=UTF-8">
<title>支付通知</title>
</head>
<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once("pay/yfbpay.php");

	$responseCode = $_GET['responseCode'];
	$keyIndex = $_GET['keyIndex'];
	$outOrderNos = $_GET['outOrderNos'];
	$signature = $_GET['signature'];
	
	//验证签名
	$pay = new yfbpay();
	$result = $pay->respond();
	if(result)
	{
		echo '支付成功';
	}
	else
	{
		echo '验签失败';
	}
?>
<body>
</body>
</html>