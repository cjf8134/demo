<?php
require_once 'inc.php';

$status = $_POST['status'];
$customerid = $_POST['customerid'];
$sdorderno = $_POST['sdorderno'];
$total_fee = $_POST['total_fee'];
$paytype = $_POST['paytype'];
$sdpayno = $_POST['sdpayno'];
$remark = $_POST['remark'];
$sign = $_POST['sign'];

$sign2 = md5('customerid='.$customerid.'&status='.$status.'&sdpayno='.$sdpayno.'&sdorderno='.$sdorderno.'&total_fee='.$total_fee.'&paytype='.$paytype.'&'.$userkey);

if($sign == $sign2){
    if(intval($status) == 1){
        echo '支付成功，订单信息如下：<br>';
        echo '商户号：'.$customerid.'<br>';
        echo '商户订单号：'.$sdorderno.'<br>';
        echo '订单金额：'.$total_fee.'<br>';
        echo '支付方式：'.$paytype.'<br>';
        echo '平台订单号：'.$sdpayno.'<br>';
        echo '商户参数：'.urldecode($remark).'<br>';
    } else {
        echo '支付失败';
    }
} else {
    echo '签名错误';
}
?>
