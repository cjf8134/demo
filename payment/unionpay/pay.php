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
              

                $data = array(
                    'action'=>'goAndPay',
                    'txnamt'=>(string)$post['orderAmount'] * 100,
                    'merid'=>M_ID,
                    'orderid'=>$post['orderNo'],
                    'backurl'=>$notify_url,
                    'fronturl'=>$post['pickupUrl']
                ); 
                $rqdata =  base64_encode( json_encode($data) ) ; 
                $sign = md5($rqdata.APP_KEY);
             
                $log->W('银联跳转');
                $log->W(var_export($data,true));
          
                $url = PAY_URL."?req=$rqdata&sign=$sign";
                Header('Location: '.$url);
    

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