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
        'merCode'                   => M_ID,      //商户开发者流水号/平台订单号
        'orderNo'                   => $post['orderNo'],
        'dateTime'                  => date('YmdHis',time()),
    );

    $data['sign'] = get_sign($data,APP_KEY);
    $log->W('短信post===请求的参数');
    $log->W(var_export($data,true));
    $res = json_decode(curl_post(BIND_RESENDSMS_URL,$data),true);
    $log->W('短信post===解析进来的参数');
    $log->W(var_export($res,true));
    if($res['resultCode'] == "000000"){
        exit(json_encode(array('status'=>1,'msg'=>'发送成功')));
    }else{
        exit(json_encode(array('status'=>-1,'msg'=>$res['resultMsg'])));
    }
}else{
    exit(json_encode(array('status'=>-1,'msg'=>'发送失败')));

}

?>


</body>
</html>