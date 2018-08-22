<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" /> 
    <title>快捷支付下单</title>
</head>
<body>
<pre>
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



    $data = array(

        'head' => array(
                'version' => '1.0',
                'method' => 'sandPay.fastPay.quickPay.index',
                'productId' => '00000016',
                'accessType' => '1',
                'mid' => M_ID,
                'channelType' => '07',
                'reqTime' => date('YmdHis', time())
            ),
        'body' => array(
                'userId' => $post['customerId'],
                'orderCode' => $post['orderNo'],
                'orderTime' => date('YmdHis', time()),
                'totalAmount' => makeOrderAmount($post['orderAmount']),
                'subject' => "快捷支付",
                'body' => "快捷支付",
                'currencyCode' => 156,
                'notifyUrl' =>$notify_url,
                'frontUrl' => $return_url,
                'clearCycle'=>'0',
                'extend' => ''
            )
    );

$log->W("参数:\n".var_export($data,true));

$prikey = loadPk12Cert(PRI_KEY_PATH,CERT_PWD);
$sign = sign($data, $prikey);
            $log->W("参数:\n".$sign);
    // step3: 拼接post数据
    $post = array(
        'charset' => 'utf-8',
        'signType' => '01',
        'data' => json_encode($data),
        'sign' => urlencode($sign)
    );

    $log->W("表单提交-参数:\n".var_export($post,true));
            ?>
            <form name="pay" id="register_form" action='<?php echo API_HOST;?>' method='post'>
                <?php foreach($post as $name=>$value) {
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
            $log->W("leanwork签名认证—失败:\n".var_export($_POST,true));
            echo "非法访问";
         }

    }else{
        echo "无效参数";
     }
    
  ?>
    
   
</body>
</html> 