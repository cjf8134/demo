<?php 
/*
 * 配置文件
 */
//date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");
//http://h5.yoyuspay.com/pay/order
//define('PAY_URL', 'http://testpayment.shenbianhui.cn/DirectPay/Index'); //接口地址   // p.yoyipay.com
define('PAY_URL', 'http://paymentapi.emaxcard.com/QuickPay/ProtocolOrder/UnionPay'); //接口地址
define('BIND_URL', 'http://paymentapi.emaxcard.com/QuickPay/Bind'); //绑卡地址
define('BIND_RESENDSMS_URL', 'http://paymentapi.emaxcard.com/QuickPay/BindResendSms'); //绑卡地址  //
define('CONFIRM_BIND_URL', 'http://paymentapi.emaxcard.com/QuickPay/ConfirmBind'); //绑卡地址  //
define('CONFIRM_PAY_URL', 'http://paymentapi.emaxcard.com/QuickPay/PayConfirm'); //接口地址  //
define('M_ID', '9001003475');   // 商户号100000024
define('APP_KEY', '66e36e230dace228579dbe0627b94ffe');    //keyBind

$cache_dir="cache";//缓存文件夹
$notify_url=getUrl()."notify.php";
function getUrl(){
  $str=substr($_SERVER["REQUEST_URI"],0,strrpos($_SERVER["REQUEST_URI"],"/")+1);
    $pageURL = 'http';
  if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]== "on") {
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