<?php 
/*
 * 配置文件
 */
//date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");

define('PAY_URL', 'https://ebankpay.suning.com/epps-ebpp/eBankGateway/paymentOrder.htm'); //接口地址
define('M_ID', '70223960');   //商户号
define('APP_KEY', '0001');    // 索引
$goodsName = "培训课程报名费";
$goodsType = "501544";
//私钥
$prifile='./rsa_private_key.pem';
//公钥
$pubfile="./rsa_public_key.pem";

$cache_dir="cache";//缓存文件夹
$notify_url=getUrl()."notify.php";
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