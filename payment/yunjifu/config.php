<?php 
/*
 * 配置文件
 */
date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");

define('PAY_URL', 'http://p.fengtuowuxian.com/Payapi_Index_Pay'); //接口地址
define('M_ID', '10493');
define('APP_KEY', 'bc341791ce6e156e739d5c0a877716ab');


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