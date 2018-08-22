<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>易付宝退款接口</title>
</head>
<?php

	/* *
	 *功能：易付宝退款接口调试入口页面
	 *版本：1.0
	 *日期：2015-07-13
	 *说明：
	 *以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
	 *界面暂时列出了参数中的一部分，商户可以根据业务来添加需要界面输入的内容，其他固定参数可以在后台拼接。
	 */
error_reporting(E_ALL & ~E_NOTICE);
require_once("refundOrderForm.php");

$order= array();
$order['yfbpay_account'] = "70056868";
$order['yfbpay_Pindex'] = "0001";
$order["refundOrderNo"] = $_GET['refundOrderNo'];
$order["origOutOrderNo"] = $_GET['origOutOrderNo'];
$order["refundOrderTime"] = $_GET['refundOrderTime'];
$order["origOrderTime"] = $_GET['origOrderTime'];
$order["refundAmount"] = $_GET['refundAmount'];
$order["refundReason"] = $_GET['refundReason'];

//建立请求
$refundOrder = new refundOrderForm();
$html_text = $refundOrder->refundOrder($order);
echo $html_text;

?>
</body>
</html>