<?php
/* *
 * 配置文件
 * 版本：1.0
 * 日期：2015-03-25
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码。
 */
 	//设置编码
	header("Content-type:text/html; charset=utf-8");
	// 商户APINAME，WEB渠道一般支付
	$apiname_pay = "WWW_PAY";
	//
	$apiname_wap_pay = "WAP_PAY";
	
	// 商户APINAME，商户订单信息查询
	$pay_apiname_query = "TRAN_QUERY";
	// 商户APINAME，退款申请
	$pay_apiname_refund = "TRAN_RETURN";	
	// 商户APINAME，代发订单查询
	$apiname_df_query = "TRAN_DF_QUERY";
	// 商户APINAME，代发申请
	$apiname_df = "TRAN_DF";	
	// 商户API版本
	$api_version = "V.1.0.0";
	//支付系统网关地址（正式环境）
	$pay_gateway = "http://cto.xskjpay.net/pay.php";
	//查单，退单
	$pay_other = "http://cto.xskjpay.net/pay_other.php";
	//代发
	$pay_df = "http://cto.xskjpay.net/pay_df.php";
	
	///////////////////////////////////////////////////////////
	/*--请在这里配置您的基本信息--*/
	// 支付平台系统商户密钥
	$key = "508C1BC08230C8F";
	// 商户在支付平台的平台号
	$platform_id = "";
	// 支付平台分配给商户的账号
	$merchant_acc = "";
	// 商户通知地址（请根据自己的部署情况设置下面的路径）
	$merchant_notify_url = "http://www.xxx.com/notify.php";
	$merchant_return_url = "http://www.xxx.com/callback.php";
	

?>
