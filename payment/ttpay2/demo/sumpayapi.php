<!DOCTYPE html>
<html>
<head>
<title>����ͳͳ����׼����̨�ӿ�</title>
<meta http-equiv="Content-Type" content="text/html; charset=GB2312">
</head>
<body>
<?php
header ( "Content-Type:text/html;charset=GB2312" );
$needNotify = $_POST ["needNotify"];
$notify_url = $_POST ["notifyUrl"];
$needReturn = $_POST ["needReturn"];
$return_url = $_POST ["returnUrl"];
$sub_merid = $_POST ["subMerId"];
$trade_code = $_POST ["tradeCode"];
$mer_id = $_POST ["merId"];
$user_id = $_POST ["userId"];
$order_no = $_POST ["orderNo"];
date_default_timezone_set ( "Asia/Shanghai" );
$order_time = date ( 'YmdHis' );
$order_amt = $_POST ["orderAmt"];
$cur_type = $_POST ["curType"];
$terminal_type = $_POST ["cashier_type"];
$goods_name = $_POST ["goodsName"];
$goods_num = $_POST ["goodsNum"];
$goods_type = $_POST ["goodsType"];
$remark = $_POST ["remark"];
$extension = ''; // $_POST["extension"];
$attach = $_POST ["attach"];
$url = $_POST ["url"];
$id_card_no = $_POST ["idCardNo"];
$realname = $_POST ["realname"];
$pay_channels = $_POST ["pay_channels"];
$img_url = $_POST ["img_url"];
$domain = $_POST ["domain"];

$service = '';
if ('web' == $terminal_type) {
	$service = 'fosun.sumpay.cashier.web.trade.order.apply';
} else {
	$service = 'fosun.sumpay.cashier.wap.trade.order.apply';
}

$parameters = array(
		'app_id' => $mer_id,
		'terminal_type' => $terminal_type,
		'version' => '1.0',
		'service' => $service,
		'timestamp' => $order_time,
		'mer_no' => $mer_id,
		'trade_code' => $trade_code,
		'user_id' => $user_id,
		'order_no' => $order_no,
		'order_time' => $order_time,
		'order_amount' => $order_amt,
		'need_notify' => $needNotify,
		'need_return' => $needReturn,
		'goods_name' => $goods_name,
		'goods_num' => $goods_num,
		'goods_type' => $goods_type 
		);

if ($img_url && "" != $img_url) {
	$parameters ['mer_logo_url'] = $img_url;
}

if ($sub_merid && "" != $sub_merid) {
	$parameters ['sub_mer_no'] = $sub_merid;
}
if ($notify_url && "" != $notify_url) {
	$parameters ['notify_url'] = $notify_url;
}
if ($return_url && "" != $return_url) {
	$parameters ['return_url'] = $return_url;
}
if ($cur_type && "" != $cur_type) {
	$parameters ['currency'] = $cur_type;
}
if ($pay_channels && "" != $pay_channels) {
	$parameters ['pay_channels'] = $pay_channels;
}
if ($remark && "" != $remark) {
	$parameters ['remark'] = $remark;
}
if ($extension && "" != $extension) {
	$parameters ['extension'] = $extension;
}
if ($attach && "" != $attach) {
	$parameters ['attach'] = $attach;
}
if ($realname && "" != $realname) {
	$parameters ['realname'] = $realname;
}
if ($id_card_no && "" != $id_card_no) {
	$parameters ['id_no'] = $id_card_no;
}

$encrypted_fields = array (
		"mobile_no",
		"card_no",
		"realname",
		"cvv",
		"valid_year",
		"valid_month",
		"id_no",
		"auth_code" 
);
$charset_change_fields = array (
		"terminal_info",
		"remark",
		"extension",
		"realname",
		"attach" 
);
$special_fields = array (
		"terminal_info",
		"remark",
		"extension",
		"notify_url",
		"return_url",
		"goods_name",
		"attach",
		"mer_logo_url" 
);
$defaultCharset = 'UTF-8';

include 'SumpayService.php';
$returnUrl = execute ( $url, 'GB2312', $parameters, "yixuntiankong.pfx", "sumpay", "yixun.cer", $domain, $charset_change_fields, $encrypted_fields, $special_fields, $defaultCharset );
$urlHead = substr ( $returnUrl, 0, 4 );
if (strcasecmp ( $urlHead, 'http' ) != 0) {
	echo iconv ( 'UTF-8', 'GB2312', $returnUrl );
} else {
	echo <<< HTML
<form hidden=true method=post action=$returnUrl>
<input hidden=true type=submit value=ok>
</form>
<script>
document.forms[0].submit();
</script>
HTML;
}

?>

</body>
</html>
