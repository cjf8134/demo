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

PayWirte($sdorderno.'_notify', $_POST);

$mysign = md5('customerid='.$customerid.'&status='.$status.'&sdpayno='.$sdpayno.'&sdorderno='.$sdorderno.'&total_fee='.$total_fee.'&paytype='.$paytype.'&'.$userkey);

if($sign == $mysign){
    if(intval($status) == 1){
        echo 'success';
        PayWirte($sdorderno.'_success', $_POST);
    } else {
        echo 'fail';
        PayWirte($sdorderno.'_fail', $_POST);
    }
} else {
    echo 'sign error';
    PayWirte($sdorderno.'_error', $_POST);
}
?>
