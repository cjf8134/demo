<?php
/* *
 * 功能：甬易支付即时到账（直连银行）接口甬易后台通知处理页面
 * 版本：1.0
 * 日期：2014-03-04
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户应根据自己网站的需要，按照技术文档编写。
 */
include ('./algorithm.php');

// $interfaceName = $_GET['interfaceName'];
// $version = $_GET['version'];
// $tranData = $_GET['tranData'];	// 通知结果数据
// $signMsg = $_GET['signData'];	// 甬易对通知结果的签名数据
$interfaceName = $_POST['interfaceName'];
$version = $_POST['version'];
$tranData = $_POST['tranData'];	// 通知结果数据
$signMsg = $_POST['signData'];	// 甬易对通知结果的签名数据

$configFile="merchantInfo.ini";	// 配置文件
$keyValue = getini("keyValue",$configFile);// 商家密钥

////////////////////////////////////////////////////////////
///////////////表单域以接口文档为准//////////////////
////////////////////////////////////////////////////////////

//对返回的tranData做base64的解码
// $tranDataDecode = mb_convert_encoding(base64_decode($tranData),"UTF-8","GBK");
$tranDataDecode = base64_decode($tranData);

//==========MD5验签，仅限特殊商户和2017年5月前老商户使用===================
// 获得MD5-HMAC签名
// $signResult = HmacMd5($tranDataDecode,$keyValue);

// // 对返回的数据也进行验签
// if ($signResult == $signMsg) {
// 	//MD5验签通过
// 	//对返回的XML数据进行解析
// 	$retXml = simplexml_load_string($tranDataDecode);
// 	// 下面部分商户应根据自身实际对解析出来的数据做订单成功失败等操作
//     echo "succsee";
// } else {
//     //MD5验签失败
//     echo "fail";
// }

//===========2017年5月以后的新商户，都用证书验签===========================

// 对返回的数据也进行验签
$signResult = verifyData($tranData, $signMsg);
if ($signResult==1) {
	//证书验签通过
	//对返回的XML数据进行解析
	$retXml = simplexml_load_string($tranDataDecode);
	// 下面部分商户应根据自身实际对解析出来的数据做订单成功失败等操作
    echo "success";
}else {
    //证书验签失败
    echo "fail";
}

?>
