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
    include_once 'request/pay_request.php';
    include_once 'common/config.php';
    require_once 'paycenter_service.php';

    $post=$_POST;

    $sign=LeanWorkSDK::makePaySign($post);
    if($sign==$post['sign']){
        $log->W("leanwork签名认证:成功");
        $log->W("加密前组装参数res:\n".var_export($post,true));
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
        
        //1、获取商品信息参数----------------------
        $currencyType = "RMB";
        $totalFee     = number_format($post['orderAmount'],0,".","");
        $remark       = $post['orderNo'];
        //$temp = $_POST["temp"];
        $remark       = iconv(SysConfig::ENCODING,"GBK",$remark);

//2、生成订单流水号------------------------
        $input = new PayRequest();
        $input->setOutTradeNo($order_no);

        $input->setTotalFee($totalFee);
        $input->setCurrencyType($currencyType);
        $input->setReturnUrl($post['pickupUrl']);
        $input->setNotifyUrl($notify_url);
        $input->setPayId("unionquickpay");
//中文base64编码
        $input->setBase64Memo(base64_encode($remark));
        $log->W("加密前组装参数res:\n".var_export($input->values,true));


//3、封装请求参数
        $submissionType = "00";
        $input->setSubmissionType($submissionType);
        $pcs = new PayCenterService();
        $pcs->sendPayRequest($input);


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