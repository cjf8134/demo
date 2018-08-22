<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>PC在线支付接口</title>
</head>
<?php

	/* *
	 *功能：易付宝PC下单支付接口调试入口页面
	 *版本：1.0
	 *日期：2015-07-13
	 *说明：
	 *以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
	 *界面暂时列出了参数中的一部分，商户可以根据业务来添加需要界面输入的内容，其他固定参数可以在后台拼接。
	 */
error_reporting(E_ALL & ~E_NOTICE);
require_once("yfbpay.php");

$order= array();
$order["order_sn"] = $_POST['WIDout_trade_no'];
$order["goodsName"] = $_POST['WIDsubject'];
$order['order_amount'] = $_POST['WIDtotal_fee'];
$order["body"] = $_POST['WIDbody'];
$order["returnUrl"] = $_POST['returnUrl'];

$payment = array();
$payment['yfbpay_account'] = "70223960";
$payment['yfbpay_Pindex'] = "0001";

//建立请求
$pay = new yfbpay();
$html_text = $pay->get_code_ebpp($order, $payment);
echo $html_text;

?>
</body>
</html>