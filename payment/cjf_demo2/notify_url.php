<?php
include_once "functions.php";
include_once "log.php";
$config = include "config.php";
$log=new Log();
$data = $_REQUEST;
$log->W("支付通知验证-参数:\n".var_export($data,true));
$result=false;
if($data){
    //准备签名参数
    $VirifySign = $data['sign'];
    unset($data['sign']);

    if( common::md5sign($data) == $VirifySign ){
        $verify=true;
    }else{
        $verify=false;
    }

    $post = $data;
    $log->W("支付通知验证-参数:\n".var_export($post,true));
    $log->W("支付通知验证-签名:\n".$res);
    $log->W("支付通知验证-结果:\n".($verify?"ok":"fail"));

    if ($verify && isset($post['return_code']) &&  $post['return_code']=="SUCCESS" && isset($post['rresult_code']) &&  $post['rresult_code']=="SUCCESS") {					 // 签名验证通过
        $result=true;
       echo  "....";
//        // 这里商户可以做一些自己的验证方式，如对比订单金额等
//        $cache = new fileCache($config['cache']);
//        $cache_data = $cache->get($config['mch_id']); 					//获取数据
//
//        $log->W('通知leanwork地址:'.$cache_data['receiveUrl']);
//
//        $para["signType"]=LeanWorkSDK::$signType;				//签名类型
//        $para["orderNo"]=$post['out_trade_no'];						//订单号
//        $para["orderAmount"]= strval($post['total_fee']);			//订单总金额(元)
//        $para["orderCurrency"]='CNY';							//货币类型
//        $para["transactionId"]=$post['transaction_id'];				//第3方支付流水
//        $para["status"]="success";								//状态
//        $para["sign"]=LeanWorkSDK::makeRecSign($para);			//签名
//
//        $count=0;
//        do{
//            $seconds=$count*2;
//            sleep($seconds);
//            $log->W("通知leanwork-请求:\n".var_export($para,true));
//            $result =LeanWorkSDK::doRequest($config['receiveUrl'], $para, $method = 'POST');
//            $log->W("通知leanwork-结果:\n".var_export($result,true));
//            if($result=="success"){
//                include "insert.php";
//                $result=true;
//                break;
//            }
//            $count++;
//        }while($count<2);
    }
}

echo $result===true ? 'success' : 'fail';
