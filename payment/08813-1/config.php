<?php 
/*
 * 配置文件
 */
header("Content-type: text/html; charset=utf-8");
define('PAY_URL', 'http://apipay.58ccpsy.com/mertrade/api'); //接口地址
define('M_ID', '36960357'); //
define('APP_KEY', '6675777e6ade14aff868d647e0a6a0fd');    //key
$merconfig = Array(
    "Version"     => "1.0",                                    //版本号
    "MerNo"     => "11570058",                                    //测试商户id
    "Md5Key"     => "a164972347dd49d3012297f00fca0ec8",    		  //测试商户密钥
  //请求地址
    "ReqUrl"      => "http://apipay.58ccpsy.com/mertrade/api",
  //交易成功异步通知地；商户设置自己异步URL地址 商户设置自己异步URL地址 商户设置自己异步URL地址
    "NotifyUrl"      => "http://xxx.xxx.com/AsynCallBack.php",
    "ReturnUrl" =>"",//同步通知URL
    "Charset"   => "UTF-8", //字符编码
    "SignMethod"=> "MD5",//签名类型
    "Url_Param_Connect_Flag"=>"&",//参数分隔符
    "ReqUrl_Show"  => "http://apipay.58ccpsy.com/payshow/index", //收银台显示URL
);
//需做Base64加密的参数
$base64Keys= array("CodeUrl", "ImgUrl", "Token_Id","PayInfo","sPayUrl","PayUrl"
,"NotifyUrl","ReturnUrl");

$removeKeys = array("SignMethod","Signature");
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