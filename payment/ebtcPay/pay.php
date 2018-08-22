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
        $banks = require_once 'Bank.php';
        $post=$_POST;
        $sign=LeanWorkSDK::makePaySign($post);
        if($sign==$post['sign']){
                $log->W("leanwork签名认证:成功");
                echo "处理中,请别关闭页面...";
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
                $order_time = date ( 'YmdHis' );
                $order_no=$order_time.mt_rand(1000,9999);
//                $cache->set($order_no, $post['orderNo']);  //保存数据
                $data = array(
                    'version'           => "1.0",      //商户开发者流水号/平台订单号
                    'customerid'        => M_ID,
                    'paytype'           => 'bank2',
                    'bankcode'          => 'ABC',            // 支付类型
                    'total_fee'         => number_format($post['orderAmount'],2,".",""),    // 订单金额 alipayonepc
                    'sdorderno'         => $order_no,
                    'returnurl'         => $post['pickupUrl'],   // 同步响应地址
                    'notifyurl'         => $notify_url,          // 异步回调
                    'remark'            => $post['orderNo'],
                );

                $log->W("请求数据:\n".var_export($data,true));
                $signSource = sprintf("version=%s&customerid=%s&total_fee=%s&sdorderno=%s&notifyurl=%s&returnurl=%s&%s", $data['version'],M_ID,$data['total_fee'], $data['sdorderno'], $data['notifyurl'], $data['returnurl'], APP_KEY);
//    $sign = md5('version='.$version.'&customerid='.$customerid.'&total_fee='.$total_fee.'&sdorderno='.$sdorderno.'&notifyurl='.$notifyurl.'&returnurl='.$returnurl.'&'.$userkey);

                $log->W("签名拼接字符串:\n".$signSource);
                $data['sign'] = md5($signSource);
                $log->W("请求数据(加密后):\n".var_export($data,true));

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