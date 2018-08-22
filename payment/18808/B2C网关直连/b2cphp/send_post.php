<?php
	require('./Lib/GateWay.class.php');
	$gateway = new gateway();
	$data = array();
	$url = 'http://testpayment.shenbianhui.cn/DirectPay/Index';
	
	//商户编号
	$data['merCode'] = '9001000938';
	
	//订单号
	$data['orderNo'] = '209384092834';
	
	//订单金额
	$data['orderAmount'] = '1';
	
	//跳转地址
	$data['returnAddress'] = 'https://www.baidu.com';
	
	//回调地址
	$data['backAddress'] = 'http://域名/notify.php';
	
	//发起时间
	$data['dateTime'] = date('YmdHms');
	
	//支付方式
	$data['payType'] = '26';
	
	//支付卡类型
	$data['bankCardType'] = '1';
	
	//银行编码
	$data['bankCode'] = 'CCB';
	
	//签名
	$data['sign'] = $gateway->get_sign($data);

	var_dump($gateway->curl_post($url,$data));