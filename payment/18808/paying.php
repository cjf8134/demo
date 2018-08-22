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
        'merCode'           => M_ID,      //商户开发者流水号/平台订单号
        'orderNo'            => $post['orderNo'],
        'orderAmount'               => number_format($post['orderAmount'],0,".","") * 100,
        'returnAddress'              => $post['returnAddress'],   // 同步响应地址
        'backAddress'              => $notify_url,          // 异步回调
        'dateTime'              => date('YmdHms'),
        'payType'              => "26",
        'bankCardType'              => '1',
        'bankCode'              => $post['bankCode'],
    );


    //签名
    $data['sign'] = get_sign($data,APP_KEY);

    $log->W("请求数据:\n".var_export($data,true));


    ?>
    <form name="pay" id="register_form" action='<?php echo PAY_URL; ?>' method='post'>
        <?php foreach($data as $name=>$value) {
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

}else{
    echo "无效参数";
}

?>


</body>
</html>