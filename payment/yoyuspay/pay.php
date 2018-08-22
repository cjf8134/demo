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
                'orderId'           => $order_no,      //商户开发者流水号/平台订单号
                'seller'            => M_ID,                       // 商户号
                'payType'           => 'oneswepay',            // 支付类型
                'amount'            => number_format($post['orderAmount'],2,".",""),    // 订单金额 alipayonepc
                'backUrl'           => $post['pickupUrl'],   // 同步响应地址
                'notifyUrl'         => $notify_url,          // 异步回调
                'userId'            => $post['customerId'],  // 商户平台支付的用户ID
                'signType'          => 'md5',                // 支付方式默认强制md5
                'orderDesc'         => 'ceshitext',          // 订单描述
                'ordeDev'           => 'ceshitext',          // 支付拓展字段
                'transTime'         => time(),               // 时间戳
            );
            $data['signData'] = md5sign($data,APP_KEY);
            $log->W('表单提交');
            $log->W(var_export($data,true));
            $con = httpRequest(PAY_URL,'post',$data);
            $con = json_decode($con,true);
            $log->W('表单提交返回数据');
            $log->W(var_export($con,true));
            if($con['errcode'] == "T0000"){
                header("Location:".$con['url']);die;
            }
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