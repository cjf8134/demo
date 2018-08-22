<?php
/* *
 * 功能：甬易支付即时到账接口（直连银行）支付请求发送页面
 * 版本：1.0
 * 日期：2014-03-04
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户应根据自己网站的需要，按照技术文档编写。
 */
 
header("content-type:text/html;charset=UTF-8");
include ('./algorithm.php');
$transactionData = $_POST['transactionData']; 	 //订单信息（订单号，金额，备注）


//创建支付请求

////////////////////////////////////////////////////////////
///////支付请求表单域以接口文档为准//////////////
////////////////////////////////////////////////////////////
$configFile="merchantInfo.ini";
$keyValue = getini("keyValue",$configFile);//商家MD5密钥
$nodeAuthorizationURL = getini("payReqURL",$configFile);   //交易请求地址
$merId = getini("merId",$configFile);//商户编号
$merURL = getini("merURL",$configFile);	//商户接收支付成功页面跳转的地址
$serverNotifyURL =getini("serverNotifyURL",$configFile);   //商户接收支付成功后台通知
$interfaceName = 'anonymousPayOrder';	
$curType = 'CNY';
$version='B2C1.0';

$xmlData="<?xml version=\"1.0\" encoding=\"GBK\"?><B2CReq><merchantId>".$merId."</merchantId><curType>".$curType."</curType><returnURL>".$merURL."</returnURL><notifyURL>".$serverNotifyURL."</notifyURL>".$transactionData."</B2CReq>";//支付通道编码

   // 获得MD5-HMAC签名(特殊商户用)
   $signMsg = HmacMd5($xmlData,$keyValue);
   // 获得证书签名(新商户都用此方法)
   $signMsg = certSign($xmlData);
   // tranData做base64编码
   $tranData =  base64_encode($xmlData);
?>
<html>
<head>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>支付平台-商户接口范例</title>
</head>

<body>
		接口名称："<?php echo $interfaceName; ?>"<br>
		版本："<?php echo $version; ?>"	<br>
		交易数据：<textarea  name='t' cols="120"  rows="8"><?php echo $xmlData; ?></textarea><br>
		交易数据Base64编码：<textarea  name='t' cols="120"  rows="8"><?php echo $tranData; ?></textarea><br>
		签名数据:"<?php echo $signMsg; ?>"<br>
		
			<form name="pay" action='<?php echo $nodeAuthorizationURL; ?>' method='POST' target="_blank">
				<input type='hidden' name='interfaceName'   value='<?php echo $interfaceName; ?>'>
				<input type='hidden' name='tranData'        value='<?php echo $tranData; ?>'>
				<input type='hidden' name='version'         value='<?php echo $version; ?>'>
				<input type='hidden' name='merSignMsg'      value='<?php echo $signMsg; ?>'>
				<input type='hidden' name='merchantId'      value='<?php echo $merId; ?>'>
				<input type='submit' value='提交支付信息'/>
			</form>
	</body>

</html>