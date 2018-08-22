<?php 
/*
 * 配置文件
 */
date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");

define('PAY_URL', 'https://openapi.alipay.com/gateway.do'); //接口地址
define('APP_ID', '2018061560384407');
define('APP_KEY', 'MIIEpAIBAAKCAQEAyKNMFBQsvaFCENzA3BPM/obT7dbc+g81yoOm5efmETA+WNnbe6rw3X3hcJYX6OBbcOdi1bcdRU7MBMnPs2654ogG5nhK2X7LDmK83cTkjlhijvaQB0KJ8HiyPVCh4iv438ujeRJcqJyyaLGPZXDUnsiGk3c5UWE+8mC5/0Zop79oyy5WnzOXW/wl9All7FZslk0nRyyMHjOljPitk/xyKVGxZHXFYdPnVmBfVzNzRm0mJcRZl3WQ2CmgwDRY0Vd2j6Nb9uAasmEgJKyBB5RbkJDNkaFeGIjnxQ7rr6NVOUaf5J2iwAqhBMzD9YTGyEfRVdcBk7Yv2ioCr8b0N+F5jQIDAQABAoIBAGruHO3WksG93+f8vwyLwQUl9m0bxkm/MXvtDlYZcZRXkeLouQD/6b8iB7RpSfTjHdjeeN5N6Vu20yT6KagHqyoANS0/jyS7Xp0cImxPM0Bp+p0W60vzOnDe4p+rCZvws4MSlN1B3ABBAxSpDTOTHr5BQPf24qVsno+u3XIfpEdB2c678ut839khhdoC3jMAyGk/S9o9ZkGWwcX0ecEQNDz3NApZ07xWT3rsaXB2eKvgJECmapw4JGDNzn1sYDDUR9WrwF62ObxLUxdrbHckma4UqUOdoqZ0TpYu4YX2G68vKjzxQ9FzQ36Igo1wnX0vfmIHPadqph5IXGxoXjjOtEECgYEA9YXXuzhxMlF/sQ9ROfo8pU3Qv/drcIT0noDypjONJT8QcP14UFh8TN3j35puwlJCKQhER3D26vnN1VKVDvrfaTUemLiWPwTk6AudqwunGKf3XE35r4elKHNCNUxGWCyzkKvYC+a2sz37q9pvE7WbZ6dElE+WE7Q4TlC6Y/y+0pMCgYEA0TMeijm6sGbEd72ay0W4tnCnK28dZUBgqMlAUGUresnN980HynsjNuZH7hx2DbJupwiMTTwrYclZ7Gp+WmSvOQW0zIxXhEsPC6HsNnpz/5N5QbWXN9vkLfICP47ughyPlu50quHWLej4uTDfrN+u6HB+ulJ9H3vL+4TkYRR1d18CgYEAmQ5Z4S2ba2ng92j8Eu+LVOWAp9s+0AMiV5k9Kxzh9YEt57IribLPsj91KdSlDWCoO9oaborecrdNeJmlsJP2KCjkLQKNLzYG2R08qf92qGk1TAaUC7e83s2TTZSCGb+sJRjrcufdpzmRpZ1jN180RNbCas5+WUQ1AaVTvLc34h8CgYA/sRGeQd8977vnPNnRA4QuP3QV/Dl15zjGiqdDEto/AwvrYwf5NK5O+6Nwskea+fVIc4jLxwLqPbRcDzwy5y6V7M/T6vKGO5f0EbNqDrQcXtjvEYtdnVwGRQU8NpcVE/7/k8//asybo69+KowfBOcqq31Z2t1vZXCAPkCN8f2lfwKBgQDrx9fHeU1eJ1S/byHmArWKNICr+IG+vBSQV2IX+zofI33S1p7SOlRO1+bA4ZypHcdDAxNx9E2AJzMtAie5yt7GeVTh+3W2mYHD2aeRYezGVdQSp+ezv3rXZ+XyztCSb0OgGbUSoIGxfQpCsQd5Cr/Qa+P9wx9TfvJIK/ePqTykpw==');
define('APP_PUBKEY', 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAh9D7gMo/PDb88r4lebRxkVUofdHkXdVFTliPmTFY7CSI2nb00Ntk/ESri+ffhkDBFdLRP7oH3JUInSPcRr867mG8eW6tJmu9j3mJiB972rBXqC2GM64afzGMDLtC5/PmfHfTUi5h3koMc56rxpux9HVWAtiLr/MEjsnrpqxH8hjQSMhWqQBuTo1mRLUwfMHLdSGF9EQQX855SdOBSE7Em5hZSjntNz3f3/I8YBicveTIUdRQ8Qk2fc4zkWuOfzxFhypaUIPWkbBDqoL9r2C3hXzFew3TbOIeERda+7YmQtNbE795s7979g/EP8HhrH1T2q4XRKFMheIxBY1WZqGMKwIDAQAB');


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