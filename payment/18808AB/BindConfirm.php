<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="h-ui/lib/html5shiv.js"></script>
    <script type="text/javascript" src="h-ui/lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="h-ui/static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="h-ui/lib/Hui-iconfont/1.0.8/iconfont.min.css" />
    <!--[if lt IE 9]>
    <link href="h-ui/static/h-ui/css/H-ui.ie.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    <!--[if IE 6]>
    <script type="text/javascript" src="h-ui/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <style type="text/css">
        .ui-sortable .panel-header{ cursor:move}
    </style>
    <title>支付</title>

</head>
<body ontouchstart>

<div class="containBox">
    <div class="containBox-bg"></div>

    <div class="wap-container">
        <div class="container ui-sortable">

            <div class="panel panel-default">
                <div class="panel-header">支付详情</div>
                <div class="panel-body">
<?php
require_once 'log.class.php';
$log=new Log();
if($_POST) {
    require_once 'leanworkSDK.php';
    require_once 'fileCache.class.php';
    require_once 'lib.php';
    require_once 'config.php';
    require_once 'AES.class.php';

     $post = $_POST;
    $log->W('确定绑卡传进来的参数');
    $log->W(var_export($post, true));
     if(empty($post['protocolId'])){
            $data['orderNo']   = $post['orderNo'];
            $data['merCode']   = M_ID;
            $data['dateTime']  = date('YmdHis',time());
            $data['smsCode']   = $post['smsCode'];
            $data['sign']      = get_sign($data,APP_KEY);
            $log->W('确定绑卡请求的参数');
            $log->W(var_export($data, true));
            $res = json_decode(curl_post(CONFIRM_BIND_URL,$data),true);

            $log->W('确定绑卡解析的参数');
            $log->W(var_export($res, true));
            if($res['resultCode'] == "000000") {
                $cache = new fileCache($cache_dir);
                //            $user_data = array(
                //                'userId' => $res['userId'],
                //                'protocolId'=>$res['protocolId'],
                //            );
                $result = $cache->get(M_ID . "_userid"); //获取数据
                if (!$result || empty($result['userId']) || empty($result['protocolId'])) {
                    $data = array(
                        'userId' => $res['userId'],
                        'protocolId' => $res['protocolId'],
                    );
                    $cache->set(M_ID . "_userid", $data);  //保存数据
                }

                $UnionPay_data = array(
                    'protocolId' => $res['protocolId'],
                    'orderNo' => $post['orderNo'],
                    'orderAmount' => strval($post['orderAmount']),
                    'callbackUrl' => $post['backAddress'],
                    'showUrl' => $post['returnAddress'],
                    'productDesc' => 'test products',
                    'merCode' => M_ID,
                    'dateTime' => date('YmdHis', time()),
                );
                $UnionPay_data['sign'] = get_sign($UnionPay_data, APP_KEY);
                $log->W('确定提交订单解析的参数');
                $log->W(var_export($UnionPay_data, true));
            }else{
                 echo $res['resultMsg'];die;

             }
     }else{
        $UnionPay_data = array(
            'protocolId'  => $post['protocolId'],
            'orderNo'     => $post['orderNo'],
            'orderAmount' => strval($post['orderAmount']),
            'callbackUrl' => $post['backAddress'],
            'showUrl'     => $post['returnAddress'],
            'productDesc' => 'test products',
            'merCode'     => M_ID,
            'dateTime'    => date('YmdHis',time()),
        );
        $UnionPay_data['sign'] = get_sign($UnionPay_data,APP_KEY);
        $log->W('预下单订单解析的参数');
        $log->W(var_export($UnionPay_data, true));

     }

    $res = json_decode(curl_post(PAY_URL,$UnionPay_data),true);
    $log->W('预下单返回进来的参数');
    $log->W(var_export($res, true));
    if($res['resultCode'] == "000000"){

        $post_data = array(
            'orderNo'     =>$post['orderNo'],
            'orderAmount' =>$post['orderAmount'],
        );

        ?>
            <form name="pay" id="register_form" action='pay1.php' method='post'>
                <?php foreach($UnionPay_data as $name=>$value) {
                    echo "<input type='hidden' name='$name' value='$value'>";
                };?>
            </form>
            <script>
                window.onload= function(){
                    document.getElementById('register_form').submit();
                    return false; //必须加上这个！！！
                }
            </script>
        <?php
        die;

    }else{
        echo $res['resultMsg'];die;

    }




}else{
    echo "请求错误。。";
}





