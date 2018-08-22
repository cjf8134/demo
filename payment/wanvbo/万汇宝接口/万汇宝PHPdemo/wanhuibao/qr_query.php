<?php

/*
 * 全球付扫码--查单 及验签demo
 */
date_default_timezone_set('Asia/Shanghai');
$params = [
    'mer_no' => '123456',//商户号
    'mer_order_no' => 'NO20170919152945',//商户订单号
    
];

ksort($params);
reset($params);
$prestr = '';
foreach ($params as $key => $val) {
    $prestr .= $key . "=" . $val . "&";
}
$prestr = substr($prestr, 0, strlen($prestr) - 1);
$prestr .= '&key=888888';//秘钥

$params['sign_type'] = 'MD5';
$params['sign'] = strtoupper(md5($prestr));

$url = 'http://pay..wanvbo.com/query/order/doquery';


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);


if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
}
curl_close($ch);

if ($result) {
    $arr = json_decode($result, true);
}

//验签
$array = Array
    (
    'auth_result' => $arr['auth_result'],
    'trade_result' => $arr['trade_result'],
    'mer_no' => $arr['mer_no'],
    'mer_order_no' => $arr['mer_order_no'],
    'order_no' => $arr['order_no'],
    'trade_amount' => $arr['trade_amount'],
     'pay_date' => $arr['pay_date'],
);
ksort($array);
reset($array);
$prestr1 = '';
foreach ($array as $key => $val) {
    $prestr1 .= $key . "=" . $val . "&";
}
$prestr1 = substr($prestr1, 0, strlen($prestr1) - 1);
$prestr1 .= '&key=888888';//秘钥

$verifySign = strtoupper(md5($prestr1));

//验签成功，输出返回参数
if($verifySign == $arr['sign']){
    print_r($arr);
    echo "<pre>";
}

?>
