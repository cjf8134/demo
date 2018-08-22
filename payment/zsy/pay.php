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
                    'receiveUrl' => $post['receiveUrl']
                    );
                    $cache->set(M_ID, $data);  //保存数据
                }
              
                // var_dump($result);
                // exit;
                
 
    
                   $time = time();
                   $data = array(
                    'shop_id' => M_ID,
                    'trading_account' => "tll45604",///
                    'trade_no'=>$post['orderNo'],
                    //'totalPrice'=>sprintf("%.2f",$post['orderAmount']),
                    'price'=>number_format($post['orderAmount'],2,".",""),
                    'type'=> 1,
                    'start_time'=>$time,
                    'pass_type'=>"post",
                    'sign_type'=>"md5",
                    'is_repeat'=>0,
                    'goods_name'=>"zhesgiss",
                    'goods_dec'=>"abcdef",
                    'return_url'=> $post['pickupUrl'],
                    'success_url'=> $notify_url,
                   );

                $sign = md5(md5(M_ID.md5($time.APP_KEY)));

                $data['sign'] = $sign;

                $log->W('表单提交');
                $log->W(var_export($data,true));
            ?>
            <form action="<?php echo PAY_URL ;?>" method="post" id="register_form">
                <?php
                foreach ($data as $name => $value) {
                    echo "<input type='hidden' name='$name' value='$value'>";
                }
                ?>
            </form>
            <script>
                window.onload= function(){
                    document.getElementById('register_form').submit();
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