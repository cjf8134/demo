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


//    $data = array(
//        'Merchant'               => M_ID,      //商户开发者流水号/平台订单号
//        'Amount'                 => number_format($post['orderAmount'],2,".","") * 100,                     // 商户号
//        'Source'                 => "Transfer",
//        'Account'                => "6228480059353791177",
//        'Serial'                 => $order_no,    // 订单金额 alipayonepc
//        'NotifyUrl'              => $notify_url,   // 同步响应地址
//        'BackUrl'                => $post['pickupUrl'],          // 异步回调
//        'SignType'               => 'HMAC',
//    );
//
    $log->W("未签名前的请求数据:\n".var_export($post,true));
    $data = array(
        'Merchant'               => M_ID,      //商户开发者流水号/平台订单号
        'Amount'                 => number_format($post['Amount'],2,".","") * 100,                     // 商户号
        'Source'                 => "Transfer",
        'Account'                => $post['Account'],    //"6228480059353791177"
        'Serial'                 => $post['Serial'],    // 订单金额 alipayonepc
        'NotifyUrl'              => $post['NotifyUrl'],   // 同步响应地址 $notify_url
        'BackUrl'                => $post['BackUrl'],          // 异步回调
        'SignType'               => 'HMAC',
    );

    $log->W("未签名前的请求数据:\n".var_export($data,true));

    $str = getUrlStr($data);

    $log->W("生成签名请求参数11:\n".$str);

    $data['Sign'] = strtoupper(getSignature($str, hex2bin(APP_KEY)));


    $log->W("生成签名请求参数11:\n".$data['Sign']);
    $log->W("请求数据:\n".var_export($data,true));

    $con =  httpRequest(PAY_URL,'post',json_encode($data));
    $res = json_decode($con,true);

    if($res['Code'] == "00"){
        Header("Location:".$res['CodeUrl']);die;
    }else{
        echo $res['Desc'];
    }

}else{
    echo "无效参数";
}

?>


</body>
</html>