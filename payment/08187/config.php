<?php 
/*
 * 配置文件
 */
//date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");
define('PAY_URL', 'http://180.168.61.86:27380/hpayTransGatewayWeb/trans/debit.htm'); //接口地址
define('M_ID', 'WKJGWKQTCS@20180813184721');   // 银商户号M_ID
define('INS_CODE', '80000384');    //机构号
define('MER_CODE', '887581298600470');    //机构商户编号
define('APP_KEY', '86950ECA654C1D6757FDCD4B89DDF775');    //keySSS
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