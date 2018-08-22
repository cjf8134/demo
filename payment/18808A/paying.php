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
    require_once 'AES.class.php';
    $post=$_POST;

    $data = array(
        'merCode'                   => M_ID,      //商户开发者流水号/平台订单号
        'orderNo'                   => $post['orderNo'],
        'dateTime'                  => date('YmdHis',time()),
        'smsCode'                   => $post['smsCode'],
    );

	$data['sign'] = get_sign($data,APP_KEY);
    $log->W("确认下单请求数据:\n".var_export($data,true));
    $res = json_decode(curl_post(CONFIRM_PAY_URL,$data),true);
    $log->W("确认下单请求数据:\n".var_export($res,true));

    if($res['resultCode'] == "000000"){
        echo "SUCCESS";die;
    }else{
        echo $res['resultMsg'];
    }



}else{
    echo "无效参数";
}

?>


</body>
</html>