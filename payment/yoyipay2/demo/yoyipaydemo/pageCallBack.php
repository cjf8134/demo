<?php
/* *
 * 功能：甬易支付即时到账（直连银行）接口支付完成返回页面
 * 版本：1.0
 * 日期：2014-03-04
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户应根据自己网站的需要，按照技术文档编写。
 */
include ('./algorithm.php');

$interfaceName = $_GET['interfaceName'];
$version = $_GET['version'];
$tranData = $_GET['tranData'];								// 通知结果数据
$signMsg = $_GET['signData'];								// 甬易对通知结果的签名数据
// $interfaceName = $_POST['interfaceName'];
// $version = $_POST['version'];
// $tranData = $_POST['tranData'];								// 通知结果数据
// $signMsg = $_POST['signData'];								// 甬易对通知结果的签名数据

$configFile="merchantInfo.ini";									// 配置文件
$keyValue = getini("keyValue","merchantInfo.ini");				// 商家密钥
$msg="";
////////////////////////////////////////////////////////////
///////////////表单域以接口文档为准//////////////////
////////////////////////////////////////////////////////////

//对返回的tranData做base64的解码
// $sourceData = base64_decode($tranData);
$sourceData = mb_convert_encoding(base64_decode($tranData),"UTF-8","GBK");

//==========MD5验签，仅限特殊商户和2017年5月前老商户使用===================
// 获得MD5-HMAC签名
$signResult = HmacMd5($sourceData,$keyValue);

// 对返回的数据也进行验签
if ($signResult == $signMsg) {
    $msg .= "MD5验签成功<br>";
	//对返回的XML数据进行解析
    $retXml = simplexml_load_string($sourceData);
	// 下面部分是示例显示用，商户应根据自身实际对解析出来的数据做订单成功失败等操作
	
	//获取订单的支付状态 0-“未支付”；1-“已支付”；2-“支付失败”
	$payStatus=$retXml->tranStat;
	global $msg;
	if($payStatus==1)
		$msg .= "您的订单处理成功";
	else
		$msg .= "您的订单处理失败";
}else {
    $msg .= "MD5验签失败<br>";
}

//===========2017年5月以后的新商户，都用证书验签===========================

// 对返回的数据也进行验签
$signResult = verifyData($tranData, $signMsg);
if ($signResult == 1) {
    $msg .= "证书验签成功<br>";
	//对返回的XML数据进行解析
    $retXml = simplexml_load_string($sourceData);
	// 下面部分是示例显示用，商户应根据自身实际对解析出来的数据做订单成功失败等操作
	
	//获取订单的支付状态 0-“未支付”；1-“已支付”；2-“支付失败”
	$payStatus=$retXml->tranStat;
	global $msg;
	if($payStatus==1)
		$msg .= "您的订单处理成功";
	else
		$msg .= "您的订单处理失败";
	
}else {
    $msg .= "证书验签失败<br>";
}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PHP测试商城</title>
<script language="javaScript">
function out() 
{
	window.close();
}  
</script>
</head>
<body>
<!--主体内容开始-->
<div id="main">
	<!--左侧内容-->
	<div class="left">
		<div class="successful" align="left"><?php echo $msg; ?></div>
		<textarea  name='t' cols="100" rows="5"><?php echo $sourceData; ?></textarea>
		<div class="loginSubmit" align="left">
			<div  class="settlement"><a href="#" onclick="out();">关闭 </a></div>
		</div>
	</div>
	<!--左侧内容-->
</div>
<!--主体内容结束-->
</body>
</html>
