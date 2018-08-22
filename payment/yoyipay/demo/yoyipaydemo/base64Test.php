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

$responseText = $_POST['tranData'];

echo $responseText;
if ($responseText==null||$responseText==''){
    $responseText = "5pyq6I635Y+W5Yiw5YC8";
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Example</title>
</head>

<body>
	base64密文：<br>
	<textarea id='t1' name='t' cols="120" rows="8"><?php echo $responseText; ?></textarea>
	<br> 原文直转: <br>
	<textarea id='t2' name='t' cols="120" rows="8"><?php echo base64_decode($responseText); ?></textarea>
	<br> 原文(GBK转UTF-8): <br>
	<textarea id='t3' name='t' cols="120" rows="8"><?php echo mb_convert_encoding(base64_decode($responseText),"UTF-8","GBK"); ?></textarea>
	<br> 原文(UTF-8转GBK): <br>
	<textarea id='t4' name='t' cols="120" rows="8"><?php echo mb_convert_encoding(base64_decode($responseText),"GBK","UTF-8"); ?></textarea>
	<br>
</body>

</html>