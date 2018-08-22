<?php
/**
 * 接收回调
 */
error_reporting(0);
require_once('lib/lib_tools_class.php');
require_once('lib/lib_config_class.php');
$randkey = file_get_contents('randstr.txt');
$call_data = $GLOBALS['HTTP_RAW_POST_DATA'];

$back_res = json_decode($call_data,true);
Tools::wrtLog("接收到回调结果",$call_data);

if ($back_res['RetCode'] == 1) {
    $verify = Tools::rsa_verify($back_res, $back_res['Sign'], Config::$PLATFORM_PUB_KEY);
    if ($verify) {
        $Body = $back_res['Body'];
        $decry_Body = Tools::decrypt3DES($Body, $randkey);
        $Body_arr = json_decode($decry_Body,true);
        Tools::wrtLog("Body:",$Body_arr);
        echo "success";
    } else {
        echo "fail";
    }
} else {
    Tools::wrtLog(sprintf("错误码:%s,错误描述:%s", $back_res['RetCode'], $back_res['ErrorMsg']));
}


