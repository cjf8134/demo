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

    require_once 'fileCache.class.php';
    require_once 'lib.php';
    require_once 'config.php';
    $post=$_POST;


    $data = array(
        'mch_id'                => M_ID,
        'total_fee'             => $post['total_fee'],    // 订单金额 alipayonepc
        'service'               => "CSYF_GATEWAY",      //商户开发者流水号/平台订单号
        'out_trade_no'          => $post['out_trade_no'],
        'sign_type'             => 'MD5',
        'return_url'            => $post['return_url'],   // 同步响应地址
        'notify_url'            => $post['notify_url'],          // 异步回调
        'bankno'                => $post['bankno'],
        'body'                  => 'text',
    );


    $log->W("请求数据:\n".var_export($data,true));


    $data['sign'] = md5sign($data,APP_KEY);
    
    $log->W("请求数据(加密后):\n".var_export($data,true));

    $con = httpRequest(PAY_URL,"post",$data);
    $content = json_decode($con,true);
    if($content['ret_code'] == "SUCCESS"){
        echo $content['payinfo'];die;
    }else{
        echo $content['ret_message'];die;
    }

}else{
    echo "无效参数";
}

?>


</body>
</html>