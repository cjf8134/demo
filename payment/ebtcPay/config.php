<?php 
/*
 * 配置文件
 */
//date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");
define('PAY_URL', 'http://www.ebtc8.com/apisubmit'); //接口地址
define('M_ID', '280107');   // 商户号100000024
define('APP_KEY', 'bfb5b0326b8dd37e3fc57190b1a51f2a1b379659');    //keySSS
//8440a9bf584077a4682841fc4c78571b
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