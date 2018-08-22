<?php
ini_set('date.timezone','Asia/Shanghai');

require_once '../common/Tool.php';
include_once '../common/config.php';
require_once '../common/log.php';
require_once '../paycenter_service.php';

//初始化日志
$logHandler= new CLogFileHandler("../log/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

Log::INFO("======同步消息返回=======\r\n");

$pcs = new PayCenterService();
$params = $pcs->acceptResponse($_GET, $_POST);
//3、判断返回结果
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
echo "</br>";
if("1" == $params["pay_result"]){
	Log::INFO("返回处理结果为：支付成功\r\n");
	echo "支付成功";
}else{
	Log::INFO("返回处理结果为：支付失败\r\n");
	echo "支付失败";
}


?>