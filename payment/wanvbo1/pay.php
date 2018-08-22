<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="renderer" content="webkit"/>
    <title>快捷支付下单</title>
    <script type="text/javascript" src="scripts/paymentjs.js"></script>
    <script type="text/javascript" src="scripts/jquery-1.7.2.min.js"></script>
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


        $data = array(
            'mch_id' => M_ID,
            'user_id' => $post['customerId'],
            'out_order_no' => $post['orderNo'],
            'card_type' => '1',
            'pay_type' => 'B2C',
            'bank_code' => 'ABC',
            'payment_fee' => strval($post['orderAmount']) * 100,
            'body' => 'text',
            'notify_url' => $notify_url,
            'return_url' => $post['pickupUrl'],
            'user_ip' => get_ip(),
        );


        $log->W("签名前的参数:\n");
        $log->W(var_export($data, true));

        $sign_src = json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        $log->W("签名前的参数（json）:\n".$sign_src);
        $sign = sign($sign_src,APP_KEY);
        $post = array(
            'sign_type' => 'MD5',
            'biz_content' => $sign_src,
            'signature' => $sign
        );
        $log->W(var_export($post, true));
        $result = http_post_json(PAY_URL, $post);
      
        $con = json_decode($result, true);
        $log->W("返回偶的的参数(post):\n");
        $log->W(var_export($con, true));


        if ($con['ret_code'] == "0") {
            $res = verify(json_encode($con['biz_content'],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES),$con['signature'],APP_KEY);
            if(!$res){
                echo '签名验证未通过';die;
            }
            $credential = $con['biz_content']['credential'];
        } else {
            print_r($con['ret_msg']);
        }
        ?>
        <script>
            function wap_pay() {
                var responseText = $("#credential").text();
                console.log(responseText);
                paymentjs.createPayment(responseText, function (result, err) {
                    console.log(result);
                    console.log(err.msg);
                    console.log(err.extra);
                });
            }
        </script>

        <div style="display: none">
            <p id="credential"><?php echo $credential; ?></p>
        </div>
        </body>

        <script>
            window.onload = function () {
                wap_pay();
            };
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