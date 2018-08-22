<?php
/**
 * 客户端请求本接口 实现支付
 * author: fengxing
 * Date: 2017/10/7
 */
error_reporting(E_ALL & ~E_NOTICE);
session_start();
include('./config.php');
$ddh = time() . mt_rand(100, 999); //商户订单号
$_SESSION['ddh'] = $ddh; //session存储商户订单号
$data = array(
    "fxid" => $fxid, //商户号
    "fxddh" => $ddh, //商户订单号
    "fxdesc" => "test", //商品名
    "fxfee" => 10, //支付金额 单位元
    "fxattch" => 'mytest', //附加信息
    "fxnotifyurl" => $notifyUrl, //异步回调 , 支付结果以异步为准
    "fxbackurl" => $backUrl, //同步回调 不作为最终支付结果为准，请以异步回调为准
    "fxpay" => "wxsm", //支付类型 此处可选项以网站对接文档为准 微信公众号：wxgzh   微信H5网页：wxwap  微信扫码：wxsm   支付宝H5网页：zfbwap  支付宝扫码：zfbsm 等参考API
    "fxip" => getClientIP(0, true) //支付端ip地址
);
$data["fxsign"] = md5($data["fxid"] . $data["fxddh"] . $data["fxfee"] . $data["fxnotifyurl"] . $fxkey); //加密
$r = getHttpContent($fxgetway, "POST", $data);
$backr = $r;
$r = json_decode($r, true); //json转数组

if(empty($r)) exit(print_r($backr)); //如果转换错误，原样输出返回

//验证返回信息
if ($r["status"] == 1) {
    header('Location:' . $r["payurl"]); //转入支付页面
    exit();
} else {
    //echo $r['error'].print_r($backr); //输出详细信息
    echo $r['error']; //输出错误信息
    exit();
}
?>