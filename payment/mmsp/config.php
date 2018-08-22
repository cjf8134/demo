<?php 
/*
 * 配置文件
 */
//date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");
//http://h5.yoyuspay.com/pay/order
define('PAY_URL', 'https://gwapi.agclouds.com/mpay/api'); //接口地址
define('M_ID', '017100059696981');   // 商户号100000024
define('APP_KEY', 'ec76d803832be75656de882fbf1bd9fd');    //key
define('TERMNO', '23380001');    // 终端号
define('AGENTNO', '');    //key


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