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
                 'orderNo'   =>$post['orderNo']
                );
                $cache->set(M_ID, $data);  //保存数据
            }
            $order_time = date ( 'YmdHis' );
            $order_no=$order_time.mt_rand(1000,9999);
            $data['mch_id'] = M_ID;   // 商户号
            $data['nonce_str'] = "text";      //  随机字符串
            $data['body'] = "测试商品";   // 商品描述
            $data['out_trade_no'] = $order_no;   // 商户订单号
            $data['total_fee'] = "1";   // 总金额
            $data['trade_type'] = "trade.gateway.pay";   // 交易类型  微信H5：WX 微信内WAP：WX_WAP微信扫码：WX_SCAN 支付宝WAP：ALI 支付宝扫码：ALI_SCAN
            $data['spbill_create_ip'] = get_ip();//终端IP;   // 客户端ip地址
            $data['notify_url'] = $notify_url;   // 通知地址
            $data['return_url'] = $post['pickupUrl'];   // 前端地址
            $data['bankType'] = 9156;   // 银行类型
            $data['accountType'] = "1";    // 账户类型，1-个人   2-企业
            $data['sign'] = md5sign($data,APP_KEY);
            $xml = arrayToXml($data);
            $log->W('表单提交');
            $log->W(var_export($data,true));

            $rs= httpRequest(PAY_URL,"post",$xml);
/*            $res = common::xmltoarray($con);*/
            $log->W('表单返回信息');
            $log->W($rs);
          
                   

             
            
               


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