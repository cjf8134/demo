<?php
	require('./Lib/Unionpay.class.php');
	require('./Lib/AES.class.php');
	$unionpay = new Unionpay();

	$data = array();

	//绑卡请求地址
	$url = 'http://paymentapi.emaxcard.com/QuickPay/Bind';

	//商户密钥
	$secretkey = '';

	/*//无需加密参数
	$data['orderNo'] = '28282828282828';
	$data['merCode'] = '';
	$data['userId'] = '334422414123123';
	$data['IDCardType'] = '01';
	$data['dateTime'] = date('YmdHis',time());

	//需要加密参数
	$aes = new AES(substr($secretkey,0,16));

	$data['mobile'] = $aes->encrypt('');
	$data['userName'] = $aes->encrypt('');
	$data['IDCardNo'] = $aes->encrypt('');
	$data['bankCardCode'] = $aes->encrypt('');

	//获取签名
	$data['sign'] = $unionpay->get_sign($data,$secretkey);

	$res = json_decode($unionpay->curl_post($url,$data),true);

	unset($data);
	$data = array();*/

	//重发短信地址
	// $url = 'http://paymentapi.emaxcard.com/QuickPay/BindResendSms';

	// $data['orderNo'] = '28282828282828';
	// $data['merCode'] = '';
	// $data['dateTime'] = date('YmdHis',time());
	// $data['sign'] = $unionpay->get_sign($data,$secretkey);

	// $res = json_decode($unionpay->curl_post($url,$data),true);

	// unset($data);
	// $data = array();

	//确认绑定
	// $url = 'http://paymentapi.emaxcard.com/QuickPay/ConfirmBind';

	// $data['orderNo'] = '28282828282828';
	// $data['merCode'] = '';
	// $data['dateTime'] = date('YmdHis',time());
	// $data['smsCode'] = '986049';
	// $data['sign'] = $unionpay->get_sign($data,$secretkey);

	// $res = json_decode($unionpay->curl_post($url,$data),true);


	//预下单
	// $url = 'http://paymentapi.emaxcard.com/QuickPay/ProtocolOrder/UnionPay';

	$data['protocolId'] = '';
	$data['orderNo'] = '11223344556677788';
	$data['orderAmount'] = 0.01;
	$data['callbackUrl'] = 'http://域名/notify.php';
	$data['showUrl'] = 'http://www.baidu.com';
	$data['productDesc'] = 'test products';
	$data['merCode'] = '';
	$data['dateTime'] = date('YmdHis',time());
	$data['sign'] = $unionpay->get_sign($data,$secretkey);

	$res = json_decode($unionpay->curl_post($url,$data),true);

	echo "<pre>";
	var_dump($res);

