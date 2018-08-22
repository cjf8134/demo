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
    require_once 'RSA.php';

    $post=$_POST;
    $sign=LeanWorkSDK::makePaySign($post);
    if($sign==$post['sign']){
        $log->W("leanwork签名认证:成功");
        //缓存回调地址，以商户号作为文件名，
        //如果地址有变或者没有初始化则缓存
        $cache = new fileCache($cache_dir);
        $result = $cache->get(M_ID); //获取数据
        if(!$result || $result['receiveUrl'] != $post['receiveUrl']){
            $data = array(
                'receiveUrl' => $post['receiveUrl'],
            );
            $cache->set(M_ID, $data);  //保存数据
        }
//        $order_time = date ( 'YmdHis' );
//        $order_no=$order_time.mt_rand(1000,9999);
//        $cache->set($order_no, $post['orderNo']);  //保存数据
        $data = array(
            'merchantNo'           => M_ID,      //商户开发者流水号/平台订单号
            'requestNo'            => $post['orderNo'],
            'amount'               => number_format($post['orderAmount'],0,".","") * 100,
            'payMethod'            => '6018',            // 支付类型
            'pageUrl'              => $post['pickupUrl'],   // 同步响应地址
            'backUrl'              => $notify_url,          // 异步回调
            'payDate'              => time(),
            'remark1'              => "text",
            'remark2'              => $post['orderNo'],
            'remark3'              => $post['orderNo'],
        );

        $log->W("未签名前的请求数据:\n".var_export($data,true));
        ///////////////////////////////用私钥加密////////////////////////
        if(!file_exists($prifile) && !file_exists($pubfile)){
            die('密钥或者公钥的文件路径不正确');
        }
        $sign = $data['merchantNo'] . "|" . $data['requestNo'] . "|" . $data['amount'] . "|" . $data['pageUrl'] . "|" . $data['backUrl'] . "|" . $data['payDate'] . "|" . $data['remark1'] . "|" . $data['remark2'] . "|" . $data['remark3'];
        $log->W("生成签名请求参数:\n".$sign);
        $m = new RSA($pubfile, $prifile);
        $data['signature'] = $m->sign($sign);
        $log->W("签名生成:\n".$data['signature']);

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
        $log->W("leanwork签名认证—失败:\n".var_export($_POST,true));
        echo "非法访问";
    }

}else{
    echo "无效参数";
}

?>

</body>
</html>