<?php
/*
 * 功能：甬易支付即时到账（直连银行）接口获取支付银行页面
 * 版本：1.0
 * 日期：2014-03-04
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户应根据自己网站的需要，按照技术文档编写。
 */
header("content-type:text/html;charset=UTF-8");
include ('./algorithm.php');

// 创建获取付款银行的请求

// //////////////////////////////////////////////////////////
// /////获取付款银行请求表单域以接口文档为准//////////////
// //////////////////////////////////////////////////////////
$configFile = "merchantInfo.ini";
$keyValue = getini("keyValue", $configFile); // 商家密钥
$getBankURL = getini("getBankURL", $configFile); // 获取付款银行请求地址
$merId = getini("merId", $configFile); // 商户编号
$interfaceName = 'getBanksForPay';
$version = 'B2C1.0';

$xmlData = "<?xml version=\"1.0\" encoding=\"GBK\"?><B2CReq><remark>mark</remark></B2CReq>"; // 获取付款银行的xml
                                                                                           
// 获得MD5-HMAC签名(特殊商户用)
$signMsg = HmacMd5($xmlData, $keyValue);
// 获得证书签名(新商户都用此方法)
$signMsg = certSign($xmlData);
// tranData做base64编码
$tranData = base64_encode($xmlData);
// 组成post数据，需要对其中有符号的数据参数做转换
$para = 'interfaceName=' . $interfaceName . '&version=' . urlencode($version) . '&tranData=' . urlencode($tranData) . '&merSignMsg=' . urlencode($signMsg) . '&merchantId=' . $merId;

$curl = curl_init($getBankURL); // curl初始化
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // SSL证书认证
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 非严格认证
                                                   // curl_setopt($curl, CURLOPT_CAINFO,$cacert_url);//证书地址
curl_setopt($curl, CURLOPT_PORT, 28080); // 设置端口，视测试环境配置。上生产环境时注释掉
curl_setopt($curl, CURLOPT_HEADER, 0); // 过滤HTTP头
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 显示输出结果
curl_setopt($curl, CURLOPT_POST, true); // post传输数据
curl_setopt($curl, CURLOPT_POSTFIELDS, $para); // post传输数据
$responseText = curl_exec($curl);
// var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
curl_close($curl);

// 对返回的数据做base64的解码
$sourceData = base64_decode($responseText);
// 对返回的XML数据进行解析
$retXml = simplexml_load_string($sourceData);
// 下面部分是示例显示用，商户应根据自身实际对解析出来的银行数据做相应的处理
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Example</title>
</head>

<body>
	Return Data:
	<br>
	<textarea name='t' cols="120" rows="8"><?php echo $responseText; ?></textarea>
	<br> Base64 decode result(UTF-8): <br>
	<textarea name='t' cols="120" rows="8"><?php echo mb_convert_encoding(base64_decode($responseText),"UTF-8","GBK"); ?></textarea>
	<br> Base64 decode result(GBK): <br>
	<textarea name='t' cols="120" rows="8"><?php echo mb_convert_encoding(base64_decode($responseText),"GBK","UTF-8"); ?></textarea>
	<br>
</body>

</html>