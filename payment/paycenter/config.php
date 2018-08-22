<?php 
/*
 * 配置文件
 */
//date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");
//http://h5.yoyuspay.com/pay/order
define('PAY_URL', 'http://wx.globalcash.cn/paycenter/v2.0/getoi.do'); //接口地址
define('M_ID', '130');   // 商户号100000024
define('APP_KEY', '857e6g8y51b5k365f7v954s50u24h14w');    //key
define('ORDER_URL', 'https://14.23.90.101/paycenter/gateways.do');   // 商户号100000024
//define('ENCODING', 'UTF-8');   // 商户号100000024
//define('VERSION', '4.0');   // 商户号100000024
//define('SIGN_TYPE', 'SHA256withRSA');   // 商户号100000024
//define('PFX_PATH', './certs/yzt.pfx');   // 商户号100000024
//define('KEYSTORE_PASSWORD', 'yzt20160728');   // 商户号100000024
//define('PRIVATEKEY_PASSWORD', 'yzt20160728');   // 商户号100000024
//define('CER_PATH', './certs/epaylinks_pfx.cer');   // 商户号100000024
//define('CURL_PROXY_HOST', '0.0.0.0');   // 商户号100000024
//define('CURL_PROXY_PORT', 0);   // 商户号100000024
//////私钥
//$prifile='./certs/yzt.pfx';
////公钥
//$pubfile="./epaylinks_pfx.cer";
//
//$keystore_password = "yzt20160728";
//$private_password = "yzt20160728";
//
//
//const PARTNER = '130';
////商户密钥
//const KEY = '857e6g8y51b5k365f7v954s50u24h14w';
////支付请求网关访问地址
//const PAY_URL = 'http://14.23.90.101/paycenter/v2.0/getoi.do';
////订单请求类网关访问地址
//const ORDER_URL = 'https://14.23.90.101/paycenter/gateways.do';//'http://14.23.90.100/paycenter/gateways.do';
////本地字符编码
//const ENCODING = 'UTF-8';
////版本号
//const VERSION = "4.0";
////加密类型
//const SIGN_TYPE = "SHA256withRSA";
////密钥地址
//const PFX_PATH = "./certs/yzt.pfx";
////keystore密码
//const KEYSTORE_PASSWORD="yzt20160728";
////私钥密码
//const PRIVATEKEY_PASSWORD="yzt20160728";
////公钥地址
//const CER_PATH = "./certs/epaylinks_pfx.cer";
//
//
//const CURL_PROXY_HOST = "0.0.0.0";//"10.152.18.220";
//const CURL_PROXY_PORT = 0;//8080;

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