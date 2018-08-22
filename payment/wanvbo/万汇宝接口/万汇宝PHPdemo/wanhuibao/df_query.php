<?php
/**
 * 全球付代付查单及验签demo
 */
$params = [
    'mer_no'    => '123456',//商家号
    'apply_date' => '2017-09-18 11:01:21',//原代付订单申请时间
    'mer_remit_no' => '111617036811',//商家代付订单号
];

ksort($params);
reset($params);
$prestr = '';
foreach ($params as $key => $val) {
    $prestr .= $key . "=" . $val . "&";
}

$prestr .= 'key=888888';//秘钥

$params['sign_type'] = 'MD5';
$params['sign'] = strtoupper(md5($prestr));

$url = 'http://remit.wanvbo.com/remit/query';


$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
$output = curl_exec($ch);
$error = '';
if (curl_errno($ch)) {
    $error = curl_error($ch);
    echo $error;
}
curl_close($ch);

if ($output) {

    $jsonArr = json_decode($output, true);
    $signArr = $jsonArr;
    unset($signArr['sign_type']);
    unset($signArr['sign']);

    ksort($signArr);
    reset($signArr);
    $prestr = '';
    foreach ($signArr as $key => $val) {
        if (strlen($val) > 0) {
            $prestr .= $key . "=" . $val . "&";
        }
    }
    $prestr .= 'key=' . '888888';//秘钥

    //验签成功，输出返回参数
    if(strtoupper(md5($prestr)) == $jsonArr['sign']){
        print_r($jsonArr);
    }
}





