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
          
           
//            $order_time = date ( 'YmdHis' );
//            $order_no=$order_time.mt_rand(1000,9999);
//            $cache->set($order_no, $post['orderNo']);  //保存数据
            $data = array(
                'code'                       => M_ID,
                'orderId'                    => $post['orderNo'],
                'input_charset'              => 'UTF-8',
                'order_amount'               => number_format($post['orderAmount'],2,".",""),
                'product_code'               => $post['orderNo'],
                'product_name'               => 'text',
                'sign_type'                  => "RSA-S",
                'orderTime'                  => date( 'YmdHis' ),
                'interfaceVersion'           => "2.0.1",
                'orderInfo'                  => "测试",
                'page_notify'                => $post['pickupUrl'],
                'offline_notify'             => $notify_url,
            );
            $log->W("请求签名前数据:\n".var_export($data,true));
            $signStr= "";
            $signStr = $signStr."code=".$data['code']."&";
            $signStr = $signStr."input_charset=".$data['input_charset']."&";
            $signStr = $signStr."interfaceVersion=".$data['interfaceVersion']."&";
            $signStr = $signStr."offline_notify=".$data['offline_notify']."&";
            $signStr = $signStr."order_amount=".$data['order_amount']."&";
            $signStr = $signStr."orderId=".$data['orderId']."&";

            if($data['orderInfo'] != ""){
                $signStr = $signStr."orderInfo=".$data['orderInfo']."&";
            }
            $signStr = $signStr."orderTime=".$data['orderTime']."&";
            $signStr = $signStr."page_notify=".$data['page_notify']."&";
            if($data['product_code'] != ""){
                $signStr = $signStr."product_code=".$data['product_code']."&";
            }
            if($data['product_name'] != ""){
                $signStr = $signStr."product_name=".$data['product_name']."&";
            }
            $signStr = $signStr."sign_type=".$data['sign_type'];
            $log->W("生成签名的字符串:\n".$signStr);

            $merchant_private_key= openssl_get_privatekey($merchant_private_key);
            openssl_sign($signStr,$sign_info,$merchant_private_key,OPENSSL_ALGO_MD5);
            $data['sign'] = base64_encode($sign_info);
            $log->W("生成签名:\n".$data['sign']);

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