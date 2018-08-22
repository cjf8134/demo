<?php 
/*
 * 配置文件
 */
date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");

define('API_HOST', 'https://cashier.sandpay.com.cn/fastPay/quickPay/index'); //接口地址
define('M_ID', '13907027');
define('CERT_PWD', '180301');
define('PUB_KEY_PATH',__DIR__.'/cert/public.cer');
define('PRI_KEY_PATH',__DIR__.'/cert/private-chen.pfx');


$cache_dir="cache";//缓存文件夹
$notify_url=getUrl()."notify.php";
$return_url=getUrl()."return.php";
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