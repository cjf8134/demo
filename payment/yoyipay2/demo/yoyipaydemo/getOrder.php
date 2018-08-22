<?php
/* *
 * 功能：甬易支付即时到账（直连银行）接口订单查询页面
 * 版本：1.0
 * 日期：2014-03-04
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户应根据自己网站的需要，按照技术文档编写。
 */
 
header("content-type:text/html;charset=UTF-8");
include ('./algorithm.php');
$orderNo = $_POST['orderNo']; 	 //订单号

//创建订单查询的请求

////////////////////////////////////////////////////////////
///////订单查询请求表单域以接口文档为准//////////////
////////////////////////////////////////////////////////////
$configFile="merchantInfo.ini";
$keyValue = getini("keyValue",$configFile);				//商家MD5密钥
$getOrderURL = getini("getOrderURL",$configFile);   //订单查询请求地址
$merId = getini("merId",$configFile);		//商户编号
$interfaceName = 'QueryOrder';	
$version='B2C1.0';

$xmlData="<?xml version=\"1.0\" encoding=\"GBK\"?><B2CReq><merchantId>".$merId."</merchantId><orderNo>".$orderNo."</orderNo></B2CReq>";//订单查询xml

 // 获得MD5-HMAC签名(特殊商户用)
 $signMsg = HmacMd5($xmlData,$keyValue);
 // 获得证书签名(新商户都用此方法)
 $signMsg = certSign($xmlData);
 // tranData做base64编码
 $tranData =  base64_encode($xmlData);
 // 组成post数据，需要对其中有符号的数据参数做转换
 $para = 'interfaceName='.$interfaceName.'&version='.urlencode($version).'&tranData='.urlencode($tranData).'&merSignMsg='.urlencode($signMsg).'&merchantId='.$merId;
 
//生产环境是https协议，测试环境是http协议
 $curl = curl_init($getOrderURL);      // curl初始化
 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);// SSL证书认证
 curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);// 非严格认证
// curl_setopt($curl, CURLOPT_CAINFO,$cacert_url);//证书地址
 curl_setopt($curl,CURLOPT_PORT, 28080 ); // 设置端口，视测试环境配置。上生产环境时注释掉
 curl_setopt($curl,CURLOPT_HEADER, 0 ); // 过滤HTTP头
 curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
 curl_setopt($curl,CURLOPT_POST,true); // post传输数据
 curl_setopt($curl,CURLOPT_POSTFIELDS,$para);// post传输数据
 $responseText = curl_exec($curl);
// var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
 curl_close($curl);
 
 // 对返回的数据做base64的解码
 $responseText = base64_decode($responseText); 
 
 	//对返回的XML数据进行解析
	$retXml = simplexml_load_string($responseText);
	// 下面部分是示例显示用，商户应根据自身实际对解析出来的数据做相应的处理
?>
<html>
<head>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Example</title>
</head>

<body>		
		Return Data<textarea name='t' cols="120"  rows="8"><?php echo $responseText; ?></textarea><br>		
</body>

</html>