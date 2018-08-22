<?php 
/*
 * 配置文件
 */
//date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");

define('PAY_URL', 'http://47.75.36.94:3020/api/pay/create_order'); //接口地址
//http://pay.meebill.cn/WebGateway/WebGateway/wgzf  正式网关
define('M_ID', '20000034');
define('APP_KEY', 'd6a80d4b301d4b569928b8818a286a08');
define('PAY_KEY', 'VYKXH8ISXSslM8LE8VfVrcZGwWDXrcM80IKTA4PlT20Rcfum');  //请求私钥
define('RES_KEY', 'Y5XfBcIrENxMNi13PgFiYLpJvUJhor2kXe5cQQIfuEvhERI7');  //响应私钥
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