<?php
/**
 * 网关，快捷H5请求demo
 */
$params = [
    'mer_no' => '123456',//商家号
    'mer_order_no' => 'NO'.date('YmdHis'),//商户订单号
    'channel_code' => 'ABC',//银行代码
    'trade_amount' => '10', //交易金额,元
    'service_type' => 'b2c',//业务类型：quick-web(快捷H5)   b2c
    'order_date' => date('Y-m-d H:i:s'),//订单提交支付时间
    'page_url' => 'http://www.baidu.com',//页面跳转同步通知地址
    'back_url' => 'http://www.baidu.com',//异步通知地址
];

ksort($params);
reset($params);
$prestr = '';
foreach ($params as $key => $val) {
    $prestr .= $key . "=" . $val . "&";
}
echo '<pre>';

$prestr .= 'key=888888';//秘钥
echo $prestr . '<br><br>'; //加密参数

$params ['sign_type'] = 'MD5';
$params ['sign'] = strtoupper(md5($prestr));
print_r($params); //提交参数

$url = 'http://pay.wanvbo.com/payment/web/receive';
?>


<form method="post" action="<?= $url ?>" target="_blank">
<?php foreach ($params as $key => $val) { ?>
        <input name="<?= $key ?>" value="<?= $val ?>" type="text">

    <?php } ?>
    <input type="submit" value="提交">
</form>
<?php




