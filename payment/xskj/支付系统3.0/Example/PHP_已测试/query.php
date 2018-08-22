<?php
/* *
 * 功能：查询处理文件
 * 版本：1.0
 * 日期：2012-03-26
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码。
 */
 
	require_once("pay.Config.php");
	require_once("lib/doPay.class.php");
	
	// 请求数据赋值
	$data = "";
	// 商户APINMAE，商户订单信息查询
	$data['apiName'] = $pay_apiname_query;
	// 商户API版本
	$data['apiVersion'] = $api_version;
	// 商户在支付平台的平台号
	$data['platformID'] = $platform_id;
	// 支付平台分配给商户的账号
	$data['merchNo'] = $merchant_acc;
	//商户订单号
	$data['orderNo']=$_POST["orderNo"];
	// 商户订单日期
	$data['tradeDate']=$_POST["tradeDate"];
	
	
	
	$cybPay = new YbPay($key, $pay_other);
	// 准备待签名数据
	$str_to_sign = $cybPay->prepareSign($data);
	// 数据签名
	$sign = $cybPay->sign($str_to_sign);
	// 准备请求数据
	$to_requset = $cybPay->prepareRequest($str_to_sign, $sign);
	// 请求数据
	$resultData = $cybPay->request($to_requset);
	// 准备验签数据
	$to_verify = $cybPay->prepareVerify($resultData);
	if($to_verify[1]=="ERRO"){ //途中出错
		preg_match('{<respDesc>(.*?)</respDesc>}', $resultData, $match);
		$errDate = $match[1];
		echo "错误信息: ".$errDate.'<br>';
		exit();
	}
	
	
		
	// 签名验证
	$resultVerify = $cybPay->verify($to_verify[0], $to_verify[1]);
	if ($resultVerify) {
		// 响应吗
		preg_match('{<respCode>(.*?)</respCode>}', $resultData, $match);
		$respCode = $match[1];
		// 响应信息
		preg_match('{<respDesc>(.*?)</respDesc>}', $resultData, $match);
		$respDesc = $match[1];
		if ($respCode == '00')
		{
			// 查询成功
			// 支付平台订单日期
			preg_match('{<accDate>(.*?)</accDate>}', $resultData, $match);
			$accDate = $match[1];
			echo "订单日期 ".$accDate.'<br>';
			// 商户订单号
			preg_match('{<orderNo>(.*?)</orderNo>}', $resultData, $match);
			$orderNo = $match[1];
			echo "订单号 ".$orderNo.'<br>';
			preg_match('{<accNo>(.*?)</accNo>}', $resultData, $match);
			$accNo = $match[1];
			echo "交易流水 ".$accNo.'<br>';
			// 商户订单状态
			preg_match('{<Status>(.*?)</Status>}', $resultData, $match);
			$Status = $match[1];
			echo "订单状态 ";
			if ($Status == '0')
				echo "未付款[".$Status."]";
			else if ($Status == '1')// 需更新商户系统订单状态
				echo "成功[".$Status."]";
			else if ($Status == '2')// 需更新商户系统订单状态
				echo "失败[".$Status."]";
			else
				echo "其他[".$Status."]";
		}
	} else {
		echo "验证签名失败";
		return false;
	}	

?>
