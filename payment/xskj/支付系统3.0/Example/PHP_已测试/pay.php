<?php
/* *
 * 功能：一般支付处理文件
 * 版本：1.0
 * 日期：2012-03-26
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码。
 */
 
	require_once("pay.Config.php");
	require_once("lib/doPay.class.php");

	// 请求数据赋值
	$data = "";
	// 商户APINMAE，WEB渠道一般支付
	$data['apiName'] = $apiname_pay;
	// 商户API版本
	$data['apiVersion'] = $api_version;
	// 商户在支付平台的平台号
	$data['platformID'] = $platform_id;
	// 支付平台分配给商户的账号
	$data['merchNo'] = $merchant_acc;
	// 商户通知地址
	$data['notifyUrl'] = $merchant_notify_url;
	$data['returnUrl'] = $merchant_return_url;
	
	
	//商户订单号
	$data['orderNo'] = $_POST["orderNo"];
	
	// 商户订单日期
	$data['tradeDate'] = $_POST["tradeDate"];
	
	// 商户交易金额,必须保留为2位小数如100.00
	$data['tradeAmt'] = sprintf('%.2f',$_POST["tradeAmt"]);
	
	// 商户参数
	$data['merchParam'] = $_POST["merchParam"];
	
	// 商户交易摘要 商品名，数量等，不能有特殊符号，如 & = ？
	$data['tradeSummary'] = $_POST["tradeSummary"];
	
	//微信或支付宝必填，网银不为空则直连，，不为空时银行编号必须不为空
	$data['payType'] =$_POST['payType'];
	// 银行代码，微信或支付宝必填，网银不为空则直连
	$data['bankCode'] = $_POST['bankCode'];
	// 对含有中文的参数进行UTF-8编码
	// 将中文转换为UTF-8
	if(!preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $data['notifyUrl']))
	{
  	$data['notifyUrl'] = iconv("GBK","UTF-8", $data['notifyUrl']);
	}
	
	if(!preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $data['merchParam']))
	{

  	$data['merchParam'] = iconv("GBK","UTF-8", $data['merchParam']);
	}

	if(!preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $data['tradeSummary']))
	{
  	$data['tradeSummary'] = iconv("GBK","UTF-8", $data['tradeSummary']);
	}
	
	// 初始化
	$ybPay = new YbPay($key, $pay_gateway);
	// 准备待签名数据
	$str_to_sign = $ybPay->prepareSign($data);
	// 数据签名
	$sign = $ybPay->sign($str_to_sign);
	$data['signMsg'] = $sign;
	// 生成表单数据
	echo $ybPay->buildForm($data);
	

?> 