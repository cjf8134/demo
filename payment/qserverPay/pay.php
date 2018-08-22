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
            $cache->set($order_no, $post['orderNo']);  //保存数据

            $data = array(
                'merchNo'           => M_ID,      //商户号
                'merchOrderNo'      => $order_no,   //商户订单号
                'money'             => number_format($post['orderAmount'],2,".",""),   // 订单金额 （美元）
                'notifyUrl'         => $notify_url,    //通知地址
                'returnUrl'         => $post['pickupUrl'],  // 同步响应地址
                'payType'           => 'PayBao',
                'signType'          => 'MD5',
                'note'              => $post['orderNo']
            );
            $data['sign'] = md5sign($data,APP_KEY);
            $log->W('表单提交');
            $log->W(var_export($data,true));

            ?>
            <form name="pay" id="register_form" action='<?php echo PAY_URL; ?>' method='post' target="_blank">
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