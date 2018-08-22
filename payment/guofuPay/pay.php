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
//            $cache->set($order_no, $post['orderNo']);  //保存数据
            $data = array(
                "fxid"        => M_ID, //商户号
                "fxddh"       => $order_no, //商户订单号
                "fxdesc"      => "test", //商品名
                "fxfee"       => number_format($post['orderAmount'],2,".",""), //支付金额 单位元
                "fxattch"     => $post['orderNo'], //附加信息
                "fxnotifyurl" => $notify_url, //异步回调 , 支付结果以异步为准
                "fxbackurl"   => $post['pickupUrl'], //同步回调 不作为最终支付结果为准，请以异步回调为准
                "fxpay"       => "bank", //支付类型 此处可选项以网站对接ylkj文档为准 微信公众号：wxgzh   微信H5网页：wxwap  微信扫码：wxsm   支付宝H5网页：zfbwap  支付宝扫码：zfbsm 等参考API
                "fxip"        => get_ip() //支付端ip地址
            );

            $data["fxsign"] = md5($data["fxid"] . $data["fxddh"] . $data["fxfee"] . $data["fxnotifyurl"] . APP_KEY); //加密
            $log->W('表单提交');
            $log->W(var_export($data,true));
            $con = httpRequest(PAY_URL,'post',$data);
            $con = json_decode($con,true);
            $log->W('表单提交返回数据');
            $log->W(var_export($con,true));
            if(empty($con)) exit(print_r($con)); //如果转换错误，原样输出返回
            if ($con["status"] == 1) {
                header('Location:' . $con["payurl"]); //转入支付页面
                exit();
            } else {
                echo $con['error']; //输出错误信息
                exit();
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