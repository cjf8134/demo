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
                $data = array(
                    'partner'        => M_ID,
                    'banktype'       => 'wypay',
                    'paymoney'       => number_format($post['orderAmount'],2,".",""),    // 订单金额 alipayonepc
                    'ordernumber'    => $post['orderNo'],
                    'hrefbackurl'    => $post['pickupUrl'],   // 同步响应地址
                    'callbackurl'    => $notify_url,          // 异步回调
                    'attach'         => $post['orderNo'],
                );

                $log->W("请求数据:\n".var_export($data,true));
                $signSource = sprintf("partner=%s&banktype=%s&paymoney=%s&ordernumber=%s&callbackurl=%s%s", M_ID, $data['banktype'], $data['paymoney'], $data['ordernumber'], $data['callbackurl'], APP_KEY); //字符串连接处理
                $log->W("签名拼接字符串:\n".$signSource);
                $data['sign'] = md5($signSource);  //字符串加密处理
                $log->W("请求数据(加密后):\n".var_export($data,true));
                $postUrl = PAY_URL.urls($data);
                $log->W("请求数据(完整url):\n".$postUrl);
                header ("location:$postUrl");
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