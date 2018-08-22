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
                'mchId'      => M_ID,
                'appId'      => APP_KEY,
                'passageId'  => "1",
                'mchOrderNo' => $order_no,
                'channelId'  => 'gomepay_b2c',
                'currency'   => 'cny',
                'amount'     => number_format($post['orderAmount'],0,".",""),   // 订单金额
                'clientIp'   =>get_ip(),
                'notifyUrl'  => $notify_url,
                'subject'    => 'charge',
                'body'       => 'charge',
                'param1'     => $post['orderNo']

            );
            $data['sign'] = md5sign($data,PAY_KEY);

            $log->W('表单提交');
            $log->W(var_export($data,true));
            $res= httpRequest(PAY_URL,"post","params=".json_encode($data));
            $res = json_decode($res,true);
            $log->W('表单返回信息');
            $log->W($res);
            if($res['retCode'] == 'SUCCESS'){
                Header("Location:".$res['payUrl']);die;
            }
            else {

                echo "请求失败";
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