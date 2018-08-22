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
    $sign=LeanWorkSDK::makePaySign($post);
    if($sign==$post['sign']) {
        $log->W("leanwork签名认证:成功");
        //缓存回调地址，以商户号作为文件名，
        //如果地址有变或者没有初始化则缓存
        $cache = new fileCache($cache_dir);
        $result = $cache->get(M_ID); //获取数据
        if (!$result || $result['receiveUrl'] != $post['receiveUrl']) {
            $data = array(
                'receiveUrl' => $post['receiveUrl'],
            );
            $cache->set(M_ID, $data);  //保存数据
        }

//
//        $data = array(
//            "mer_no" => M_ID,
//            "mer_order_no" => $post['mer_order_no'],  //web.union_pay
//            "channel_code" => $post['channel_code'],
//            "trade_amount" => number_format($post['trade_amount'], 2, ".", ""),
//            "service_type" => "b2c",
//            "order_date" => date('Y-m-d H:i:s'),
//            "page_url" => $post['page_url'],
//            "back_url" => $post['back_url'],
//        );

        $data = array(
            "mer_no" => M_ID,
            "mer_order_no" => $post['orderNo'],  //web.union_pay
            "channel_code" => 'ABC',
            "trade_amount" => number_format($post['orderAmount'], 2, ".", ""),
            "service_type" => "b2c",
            "order_date"   => date('Y-m-d H:i:s'),
            "page_url"     => $post['pickupUrl'],
            "back_url"     => $notify_url ,
        );


        $log->W("签名前的参数:\n");
        $log->W(var_export($data, true));

        $Sign_str = createSign($data, APP_KEY);
        $data['sign_type'] = 'MD5';
        $data['sign'] = strtoupper(md5($Sign_str));

        $log->W("签名后的参数:\n");
        $log->W(var_export($data, true));

        ?>
        <form name="pay" id="register_form" action='<?php echo PAY_URL; ?>' method='post'>
            <?php foreach ($data as $name => $value) {
                echo "<input type='hidden' name='$name' value='$value'>";
            }; ?>
        </form>
        <script>
            window.onload = function () {
                document.getElementById('register_form').submit();
                return false; //必须加上这个！！！
            }
        </script>
        <?php
    }else{
        $log->W("leanwork签名认证—失败:\n".var_export($_POST,true));
        echo "非法访问";
    }
}else{
    echo "无效参数";
}

?>


</body>
</html>