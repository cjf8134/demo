<?php 
/*
 * 配置文件
 */
date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");

define('PAY_URL', 'http://gateway.alwaypay.com/service/api/controller/alwaypay/topayByMc'); //接口地址
define('M_ID', 'AWP1128477492');
define('APP_ID', 'AWP112897');
define('APP_KEY', '349a3a031669f71bc1bceff9027c33a8');

define('PRIVATE_KEY', '-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQCleEERkWX7bH6ZlozjzhQ4PW2tdr9+VPa4B3OcaFDWyB1C79Np2JllMNr4DueKjXZMFushmaxFSgwBLM5IJKo6pkeOFuKj4Kjpe8E/hqnvjd5CEinw5+a0X26wj0tUwro9VSsYw4LmOaj5jeV/M9LXlkdqrLsaJMnZD8QfrYw0zQIDAQABAoGBAKVb0ILS77xbhwTLu85oAjLVyIZCFkoUdF4iLDnQ0YBiiUN8UaUELP8/3INquZ7vkZmmiaGRZeP0hJyj/x1/bpEEYA4e11f3lNJC+ydN+j9Zkaw0beQPGKEE9nmVNJXEZUyDsPYvPmzQsgPN/CNmFw6+P90OHNLJlFPbWV04B84BAkEA0vEpIRr2a12HvlBWaVsAvr9Mt5kLkxKOhIG0jG4pWC2joxeIEGGzXT7MjLOATFPN4ygWEP7F+9LAIo6swr60gQJBAMjQjfvGOGe1T7CbVvSgjDC9VS6PaJfjuVscBV3BRMHTMaSb07YuGfgc/4qPICnaukR5I2N+AMqPIAa5g4gy6k0CQEFJmu1AJxy76hOhUd1x6R0goGIC4G44xBuG+ZatUeaU2ZzU36wSUS1/DlhOBluZZJP2CD5iXGzAoe8QMbBkzgECQG3F26eC/rhqW4qOD+WfkaLfDJ5sFF/bQyqz0ZcjnCNcAGocKIoQ/28q4uHqRUm74FCn65lqeqI/xOEILgeY1Y0CQQC3Bu1cgIDIKoDHd43m0INmAllSeJtbMP2ZEYxzTXWFxEyXDfdI1UurIzMC/FlC6Ct4gPU00tKFHhTh8v+cdva1
-----END RSA PRIVATE KEY-----');/*商户自己生成的私钥*/

define('PUBLIC_KEY', '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCleEERkWX7bH6ZlozjzhQ4PW2tdr9+VPa4B3OcaFDWyB1C79Np2JllMNr4DueKjXZMFushmaxFSgwBLM5IJKo6pkeOFuKj4Kjpe8E/hqnvjd5CEinw5+a0X26wj0tUwro9VSsYw4LmOaj5jeV/M9LXlkdqrLsaJMnZD8QfrYw0zQIDAQAB
-----END PUBLIC KEY-----');/*商户自己生成的公钥*/

define('PAY_KEY', '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCZCVsGjoRi7XKoi0biZLfg5cgBVrzIeFeFAHAnga/bMSFdBMLjZ3f5SAh6FgaovdBEpw/DcJ1NdBG4ycsIBguvQbkThq9pbWjHASDshCnPGNSdMEl4/9rHsHzKi5Ad+taGkPzrFjHswdodPKs2YvFLkMYCxlDv5WDKtKKxzJ9kVQIDAQAB
-----END PUBLIC KEY-----');/*由PAY提供的公钥*/


define('CHANT', 'PAY000053000250');/*由PAY提供的公钥*/



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