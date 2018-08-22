<?php 
/*
 * 配置文件
 */
//date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");
//http://h5.yoyuspay.com/pay/order
define('PAY_URL', 'https://account.csepay.com/CSEPay/Pay'); //接口地址
define('M_ID', '5026');   // 商户号100000024
//define('APP_KEY', '8440a9bf584077a4682841fc4c78571b');    //key
//8440a9bf584077a4682841fc4c78571b
$cache_dir="cache";//缓存文件夹
$notify_url=getUrl()."notify.php";
$merchant_private_key = trim(file_get_contents("private_key.txt"));
$merchant_public_key  = trim(file_get_contents("public_key.txt"));

$merchant_private_key        = chunk_split($merchant_private_key, 64, "\n");
$merchant_private_key = "-----BEGIN RSA PRIVATE KEY-----\n$merchant_private_key-----END RSA PRIVATE KEY-----\n";

$merchant_public_key        = chunk_split($merchant_public_key, 64, "\n");
$merchant_public_key = "-----BEGIN PUBLIC KEY-----\n$merchant_public_key-----END PUBLIC KEY-----\n";
//$merchant_private_key='-----BEGIN PRIVATE KEY-----
//MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBALq0mkjfAi8bEpP6
//MdvlwHPDXqajtKZBOV+SSyOuxxYMBEcLaiHZgCF+hUXD5Gl8aEISqkjEIJ8HxhCi
//VEeDZTU303shg6kmtOuRu9crx+jAPmSdJbpLsgdVKOKTWhbMsCczIIdkw10aYcoH
//yKw2QLvCUXB9KskV96CcHhQcnKvbAgMBAAECgYEAguEZil2yFT1gH5VyoBiFeWEK
//F7yIZUcxpdpSi/f4HW9dDERnKMVkOZaMbCRvGLcaCr802X+K8pArevugIuVr6tdy
///2iSJ+9HDq6ZLD3QfG5WNdJilAZiLUh4lWrd0BAUH+T7bGAbjXRnGXFcd1hcOObX
//20GCn3Hzf2dwmWFhPYkCQQDxKzKfOYIQVzhIfahpXXTWlWkKZkMINYw9UNSMduZz
//uA94eCybrverNKB8NlL3zngOS8REIulDE2CdoHMFev7XAkEAxi/4mogovWzw4/i3
//7Fre/3M1YKwjfSi65KJ6JR3Cp/kZ9/f1ncFDujBBfLGn4dHARHnVbamUOdSIr5pO
//PwJunQJAZP2l8S9v28/qbdDRGW5dYw6mMgiowWNLGtIib7/KuWK2d8g7ReZ7KGKd
//YeaNz9/SPopT4gSMkd4nc1qhUAY1eQJABftIq5FUeXMiSh8lnfKYLGmTwNkxMQPb
//sC7fNOOTDnLMP9myBhLhMmtmbpcGFCC6htaOhILLwHsTrQkhN3GhWQJBAIcNQWgc
//SZxbqij1e0mVI60rWbfcGSxycqVJCOhzsariU2JkJ0PhV1Dlqh+y994KOj/FcRTa
//0UoQ+MuCOUJ7cjw=
//-----END PRIVATE KEY-----';
//
////merchant_public_key,商户公钥，按照说明文档上传此密钥到商家后台，代码中不使用到此变量
//$merchant_public_key = '-----BEGIN PUBLIC KEY-----
//MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC3/DQcfghijyJfwqM3+sokwsED
//OnaOnFd7KvBKnEsttHPA4SR8Io/vGf0qSLirU1Gnl0+s/rVST+Yi0kqRZavR+18A
//rFuQzK3S4zqA4MAI0VDXB5/cUO+9l4wY0CJGBdb5sWxu5jg1Uv/jbDs754Z4xPgh
//N8cAyTjIvx8iX2oVoQIDAQAB
//	-----END PUBLIC KEY-----';
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