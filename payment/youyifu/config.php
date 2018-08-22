<?php 
/*
 * 配置文件
 */
//date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");
//http://h5.yoyuspay.com/pay/order
define('PAY_URL', 'http://168.63.151.74:8001/pay'); //接口地址
define('M_ID', '1801');   // 商户号100000024
define('APP_KEY', '8440a9bf584077a4682841fc4c78571b');    //key
//$public_key  = trim(file_get_contents("public_key.txt"));
$private_key = trim(file_get_contents("private_key.txt"));
$public_key  = trim(file_get_contents("pooul_rsa_public.pem"));
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