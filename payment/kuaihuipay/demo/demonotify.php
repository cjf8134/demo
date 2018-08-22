<?php
$reskey = "JZ9LVj35CPckkpouLqL6BxOL09MtOaD8pwSf6Kpt3FouRMJh";
$p = $_GET;
$sign = $p['sign'];
unset($p['sign']);

ksort($p);

$str = "";
foreach($p as $k => $v)
{
	$str .= $k ."=". $v ."&";
}

$str .= "key=".$reskey;

//验证签名成功
if(strtoupper(md5($str)) == $sign)
{

	$amt = intval($_GET['amount']) / 100;
	echo "订单号：".$_GET['mchOrderNo']."<br>";
	echo "支付金额：".$amt."<br>";
	echo "状态：".$_GET['status'].'<br>';
	

}




?>