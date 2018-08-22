<?php
/* *
 * 功能：查询处理文件
 * 版本：1.0
 * 日期：2012-03-26
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码。
 */
 
	require_once("pay.Config.php");
	require_once("lib/doDf.class.php");
	
	// 请求数据赋值
	$data = "";
	// 商户APINMAE，商户订单信息查询
	$data['apiName'] = $apiname_df_query;
	
	// 商户在支付平台的平台号
	$data['platformID'] = $platform_id;
	// 支付平台分配给商户的账号
	$data['merchNo'] = $merchant_acc;
	//商户订单号
	$data['orderNo']=$_POST["orderNo"];

	$cybPay = new YbPfa($key, $pay_df);
	// 准备待签名数据
	$str_to_sign = $cybPay->prepareSign($data);
	// 数据签名
	$sign = $cybPay->sign($str_to_sign);

	$data['signMsg'] = $sign;
	// 生成表单数据
	echo $cybPay->buildForm($data);

?>
