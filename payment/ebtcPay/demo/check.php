<?php
//查询订单信息
require_once 'inc.php';

$total_fee = number_format($_POST['total_fee'], 2, '.', ''); //订单金额，一定要带上两位小数，例如：135.00
$sdorderno = $_POST['sdorderno']; //订单号，最多30位字符长度

$signStr = 'customerid='.$customerid.'&total_fee='.$total_fee.'&sdorderno='.$sdorderno.'&';

$sign = md5($signStr.$userkey);

$post_data = $signStr.'sign='.$sign;

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $checkUrl);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);//运行curl
curl_close($ch);

echo $result;