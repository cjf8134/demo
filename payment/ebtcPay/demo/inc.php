<?php
header('Content-Type:text/html;charset=utf-8');
date_default_timezone_set('Asia/Shanghai');

$customerid = '280101'; //商户编号，280101是测试商户号
$userkey = 'f4a353a90be0094d95ac9ced6a18aed72acdf692'; //MD5密钥，测试密钥：f4a353a90be0094d95ac9ced6a18aed72acdf692

$version = '1.0'; //版本号
$notifyurl = 'http://www.yoursite.com/notify.php'; //异步通知
$returnurl = 'http://www.yoursite.com/return.php'; //同步通知
$postUrl = 'http://www.ebtc8.com/apisubmit'; //请求地址，银行直付提交地址：http://www.ebtc8.com/apisubmit
$checkUrl = 'http://www.ebtc8.com/apicheck'; //查询订单地址

function PayWirte($OrderNo, $content)
{
    $path = dirname(__FILE__);
    $path = $path."/Log/";
    $file = $path.$OrderNo.".txt";
    if(!is_dir($path)){	mkdir($path); }
    $logfile = fopen($file, "w") or die("Unable to open file!");
    fwrite($logfile, json_encode($content));
    fclose($logfile);
}