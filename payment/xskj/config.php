<?php 
/*
 * 配置文件
 */
//date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");
//http://h5.yoyuspay.com/pay/order
define('PAY_URL', 'http://cto.xskjpay.net/pay.php'); //接口地址
define('PLATFORM_ID', '20100607');   // 商户在支付平台的平台号$platform_id
define('M_ID', '2714976414@qq.com');   // 支付平台分配给商户的账号

define('APP_KEY', '8838c3d459f85e976f1b765cfa2e9280');    //key
// 商户APINAME，WEB渠道一般支付
$apiname_pay = "WWW_PAY";
//
$apiname_wap_pay = "WAP_PAY";

// 商户APINAME，商户订单信息查询
$pay_apiname_query = "TRAN_QUERY";
// 商户APINAME，退款申请
$pay_apiname_refund = "TRAN_RETURN";
// 商户APINAME，代发订单查询
$apiname_df_query = "TRAN_DF_QUERY";
// 商户APINAME，代发申请
$apiname_df = "TRAN_DF";
// 商户API版本
$api_version = "V.1.0.0";

////查单，退单
//$pay_other = "http://cto.xskjpay.net/pay_other.php";
////代发
//$pay_df = "http://cto.xskjpay.net/pay_df.php";

///////////////////////////////////////////////////////////
/*--请在这里配置您的基本信息--*/


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