<?php 
/*
 * 配置文件
 */
date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");

// define('PAY_URL', 'http://60.12.221.84:28080/pay/anonymousPayOrder.do'); //接口地址
// define('M_ID', 'M100001680');
// //define('APP_ID', 'AWP112897');
// define('APP_KEY', '123123');
// $pfxPath = "./yoyiTestNew.pfx";//你的.pfx私钥文件路径
// $pfxPwd = "1q2w3e4r";  //你的.pfx私钥文件密码
// $cerPath ="./yoyiTestNew.cer";//你的.cer公钥文件路径

define('PAY_URL', 'https://pay.yoyipay.com/pay/anonymousPayOrder.do'); //接口地址
define('M_ID', 'M100002245');
//define('APP_ID', 'AWP112897');
define('APP_KEY', '123123');
$pfxPath = "./baiduyixia.pfx";//你的.pfx私钥文件路径
$pfxPwd = "baiduyi";  //你的.pfx私钥文件密码
$cerPath ="./yoyiNew.cer";//yoyi的.cer公钥文件路径


$cache_dir="cache";//缓存文件夹
$notify_url=getUrl()."notify.php";
// echo $notify_url;
// echo "<pre>";
// var_dump($_SERVER);
function getUrl(){
  $str=substr($_SERVER["REQUEST_URI"],0,strrpos($_SERVER["REQUEST_URI"],"/")+1);
    $pageURL = 'http';
  if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]== "on") 
  {
    $pageURL .= "s";
  }
  $pageURL .= "://";
  //$host=$_SERVER["SERVER_NAME"]?$_SERVER["SERVER_NAME"]:$_SERVER["HTTP_HOST"];
  $host=$_SERVER["HTTP_HOST"];
  if ($_SERVER["SERVER_PORT"] != "80") 
  {
    
    $pageURL .=$host. ":" . $_SERVER["SERVER_PORT"];
  } 
  else
  {
    $pageURL .= $host;
  }
  return $pageURL.$str;
}

?>