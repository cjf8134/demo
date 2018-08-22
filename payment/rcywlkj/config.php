<?php 
/*
 * 配置文件
 */
date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");
//公用参数
define('PAY_URL', 'http://pays.rcywlkj.com/'); //接口地址
define('M_ID', '10033');
define('APP_KEY', 'bn250whr0tbkgga4b9ssdjy7ze59188n');

$cache_dir="cache";//缓存文件夹
$notify_url=getUrl()."notify.php";
function getUrl(){
  $str=substr($_SERVER["REQUEST_URI"],0,strrpos($_SERVER["REQUEST_URI"],"/")+1);
    $pageURL = 'http';
  if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]== "on") {
    $pageURL .= "s";
  }
  $pageURL .= "://";
  $host=$_SERVER["HTTP_HOST"];
  if ($_SERVER["SERVER_PORT"] != "80") {
    $pageURL .=$host. ":" . $_SERVER["SERVER_PORT"];
  }else{
    $pageURL .= $host;
  }
  return $pageURL.$str;
}

?>