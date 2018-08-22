<?php
/* *
 * 功能：一般支付处理文件
 * 版本：1.0
 * 日期：2012-03-26
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码。
 */
 
	require_once("pay.Config.php");
	require_once("lib/doDf.class.php");

	// 请求数据赋值
	$data = "";
	// 商户APINMAE，WEB渠道一般支付
	$data['apiName'] = $apiname_df;
	// 商户在支付平台的平台号
	$data['platformID'] = $platform_id;
	// 支付平台分配给商户的账号
	$data['merchNo'] = $merchant_acc;
	
	
	//商户订单号
	$data['orderNo'] = $_POST["orderNo"];
	
	
	// 商户交易金额,必须保留为2位小数如100.00
	$data['amt'] = sprintf('%.2f',$_POST["amt"]);
	$bank=explode('|',$_POST["bankCode"]);
	// 商户参数
	$data['bankName'] =$bank[1];
	// 商户交易摘要 商品名，数量等，不能有特殊符号，如 & = ？
	$data['bankCode'] =$bank[0];
	
	// 银行代码，微信或支付宝必填，网银不为空则直连
	$data['account'] = $_POST['account'];
	$data['name'] = $_POST['name'];
	$data['province'] = $_POST['province'];
	$data['city'] = $_POST['city'];
	$data['branchName'] = $_POST['branchName'];
	$data['ms'] = $_POST['ms'];
	// 初始化
	$ybPay = new YbPfa($key, $pay_df);
	// 准备待签名数据
	$str_to_sign = $ybPay->prepareSign($data);
	// 数据签名
	$sign = $ybPay->sign($str_to_sign);
	$data['signMsg'] = $sign;
	// 生成表单数据
	echo $ybPay->buildForm($data);
	

?> 