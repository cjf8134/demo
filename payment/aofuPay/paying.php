<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>快捷支付下单</title>
</head>
<body>
<?php
require_once 'log.class.php';
$log=new Log();
if($_POST){
    require_once 'leanworkSDK.php';
    require_once 'fileCache.class.php';
    require_once 'lib.php';
    require_once 'config.php';

    $post=$_POST;




    $data = array(
        'version'         => '1.0.0',
        'transType'       => 'SALES',
        'productId'       => '0001',
        'merNo'           => M_ID,
        'orderDate'       => date("Ymd"),     //交易日期
        'orderNo'         => $post['orderNo'],   //订单号
        'returnUrl'       => $post['returnUrl'],
        'notifyUrl'       => $post['notifyUrl'],
        'transAmt'        => number_format($post['transAmt'],0,".","") * 100,     //分为
        'commodityName'   => 'test',  //产品名称
        'commodityDetail' => 'test', //产品描述
        'bankCode'        => $post['bankCode'],
    );

    $log->W("请求表单初始化:\n".var_export($data,true));

    ksort($data);

    $temp =  '';
    foreach($data as $key=>$value)
    {
        $temp = $temp . $key . '=' . $value . '&';
    }
    $privateKey = openssl_pkey_get_private(trim(file_get_contents($pri_Key)));
    $log->W("请求表单初始化:\n".var_export($data,true));


    $temp = substr($temp, 0,  strlen($temp) -1 );

    openssl_sign($temp, $sign, $privateKey, OPENSSL_ALGO_SHA1);


    $sign = base64_encode($sign);

    $data['signature'] =  $sign;
    $log->W("请求表单sign参数:\n".var_export($data,true));

    $postdata = http_build_query($data);
    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-type:application/x-www-form-urlencoded',
            'content' => $postdata,
            'timeout' => 15 * 60 // 超时时间（单位:s）
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents(PAY_URL, false, $context);
    echo $result;

}else{
    echo "无效参数";
}

?>

</body>
</html>