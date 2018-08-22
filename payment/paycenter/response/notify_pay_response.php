<?php
ini_set('date.timezone','Asia/Shanghai');

require_once '../common/Tool.php';
require_once '../common/config.php';
require_once '../common/log.php';
require_once '../paycenter_service.php';

//初始化日志
$logHandler= new CLogFileHandler("../log/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

Log::INFO("======异步消息返回=======\r\n");

$pcs = new PayCenterService();
$params = $pcs->acceptNotifyResponse($_GET, $_POST);

Log::INFO("amount:".$params["amount"]."\r\n");
Log::INFO("base64_memo:".$params["base64_memo"]."\r\n");
Log::INFO("out_trade_no:".$params["out_trade_no"]."\r\n");
Log::INFO("partner:".$params["partner"]."\r\n");
Log::INFO("pay_no:".$params["pay_no"]."\r\n");
Log::INFO("pay_result:".$params["pay_result"]."\r\n");
Log::INFO("pay_time:".$params["pay_time"]."\r\n");
Log::INFO("sett_date:".$params["sett_date"]."\r\n");
Log::INFO("sett_time:".$params["sett_time"]."\r\n");
Log::INFO("sign:".$params["sign"]."\r\n");
Log::INFO("sign_type:".$params["sign_type"]."\r\n");
//3、判断返回结果
if("1" == $params["pay_result"]){
	Log::INFO("返回处理结果为：支付成功\r\n");
}else{
	Log::INFO("返回处理结果为：支付失败\r\n");
}

?>