<?php
require_once 'inc.php';

$total_fee = number_format($_POST['total_fee'], 2, '.', ''); //订单金额，一定要带上两位小数，例如：135.00
$sdorderno = $_POST['sdorderno']; //订单号，最多30位字符长度
$paytype = isset($_POST['paytype']) ? $_POST['paytype'] : ''; //支付通道
$bankcode = isset($_POST['bankcode']) ? $_POST['bankcode'] : ''; //银行编号
$remark = isset($_POST["remark"]) && $_POST["remark"] ? $_POST["remark"] : ''; //remark字段，最大50字符

PayWirte($sdorderno, $_POST);

//生成签名，请一定要按以下顺序进行签名
$sign = md5('version='.$version.'&customerid='.$customerid.'&total_fee='.$total_fee.'&sdorderno='.$sdorderno.'&notifyurl='.$notifyurl.'&returnurl='.$returnurl.'&'.$userkey);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>正在转到付款页</title>
</head>

<!-- 表单以post方式提交，银行直付提交地址：http://www.ebtc8.com/apisubmit -->
<body onLoad="document.pay.submit()">
    <form name="pay" action="<?php echo $postUrl; ?>" method="post">
        <input type="hidden" name="version" value="<?php echo $version; ?>">
        <input type="hidden" name="customerid" value="<?php echo $customerid; ?>">
        <input type="hidden" name="sdorderno" value="<?php echo $sdorderno; ?>">
        <input type="hidden" name="total_fee" value="<?php echo $total_fee; ?>">
        <input type="hidden" name="paytype" value="<?php echo $paytype; ?>">
        <input type="hidden" name="bankcode" value="<?php echo $bankcode; ?>">
        <input type="hidden" name="notifyurl" value="<?php echo $notifyurl; ?>">
        <input type="hidden" name="returnurl" value="<?php echo $returnurl; ?>">
        <input type="hidden" name="remark" value="<?php echo $remark; ?>">
        <input type="hidden" name="sign" value="<?php echo $sign; ?>">
    </form>
</body>
</html>