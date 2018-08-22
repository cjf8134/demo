<?php

/**
 * 客户端请求本接口 获取订单信息
 * author: fengxing
 * Date: 2017/10/7
 */
error_reporting(E_ALL & ~E_NOTICE);
include('./config.php');
$ddh = ''; //需要查询的订单号
$data = array(
    "fxid" => $fxid, //商户号
    "fxddh" => $ddh, //商户订单号
    "fxaction" => "orderquery"//查询动作
);

$data["fxsign"] = md5($data["fxid"] . $data["fxddh"] . $data["fxaction"] . $fxkey); //加密
$r = file_get_contents($fxgetway . "?" . http_build_query($data));
$backr = $r;
$r = json_decode($r, true); //json转数组
if ($r['fxstatus'] == 1) {
    //支付成功
    exit('支付成功');
} else {
    //支付失败
    //exit(print_r($backr)); //返回的详细信息
    exit($r['error']); //返回的错误信息
}
?>