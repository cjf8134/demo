<?php 
/*
 * 配置文件
 */
define('PAY_URL', "http://103.97.229.106/trans-api/trans/api/back.json"); //接口地址
define('M_ID', '850440058115341');   // 商户号100000024
define('APP_KEY', '183114910293');    //key

// rsa sha1 签名私钥
$pri_Key = "./cert/1005136_prv.pem";
//===========================================================================
$pub_Key = "./cert/1005136_pub.pem";


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