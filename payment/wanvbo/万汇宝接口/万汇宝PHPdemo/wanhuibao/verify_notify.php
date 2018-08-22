<?php

/*
 * 快捷H5，网关，异步回调验签
 */
//异步接收用：$_POST
$json = '{"order_no":"10000094","notify_type":"back_notify","order_date":"2017-09-18 17:26:55","pay_date":"2017-09-18 17:28:18","trade_result":"1","mer_no":"100000000008","trade_amount":"10.00","sign":"1FD25F36E5EFCE9CB812852224D44580","currency":"CNY","sign_type":"MD5","mer_order_no":"458310378661"}';//回调的参数
$signArr = json_decode($json,TRUE);


ksort($signArr);
reset($signArr);
$prestr = '';
foreach ($signArr as $key => $val) {
    if ($key != 'sign' && $key != 'sign_type') {
        $prestr .= $key . "=" . $val . "&";
    }
}
$prestr .= 'key=' . '888888'; //秘钥

if (strtoupper(md5($prestr)) == $signArr['sign']) {
    echo 'SUCCESS';
}
?>
