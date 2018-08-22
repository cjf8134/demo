<?php
ini_set('date.timezone','Asia/Shanghai');

require_once 'request/order_query_request.php';
require_once 'request/refund_query_request.php';
require_once 'request/refund_request.php';
require_once 'paycenter_service.php';

//初始化日志
$logHandler= new CLogFileHandler("log/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);
//------------调用方法进行请求测试------------

//queryOrder();
//refundRequest();
refundQuery();

/**
 * 订单查询
 */
function queryOrder(){
	$pcs = new PayCenterService();
	$model = new OrderQueryRequest();
	$model->setOutTradeNo("1447375238908");//商家业务流水号
	$result = $pcs->queryOrder($model);//商家业务流水号
}

/**
 * 退款请求
 */
function refundRequest(){
	$pcs = new PayCenterService();
	$model = new RefundRequest();
	$model->setOutTradeNo("1474963042599");//商家业务流水号
	$model->setOutRefundNo("TK1474963042599");
	$model->setTotalAmount("0.05");
	$model->setRefundAmount("0.01");
	$result = $pcs->refundRequest($model);
}

/**
 * 退款单查询
 */
function refundQuery(){
	$pcs = new PayCenterService();
	$model = new RefundQueryRequest();
	$model->setOutTradeNo("1447299488108");//商家业务流水号
	$model->setOutRefundNo("TK1447299488108");
	$model->setRefundId("1955");
	$result = $pcs->refundQuery($model);
}


?>