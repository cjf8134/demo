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
        $order_no=$order_time.mt_rand(10,99);
        $cache->set($order_no, $post['orderNo']);  //保存数据
        $data = array(

            "insCode"               => INS_CODE, //机构号
            "insMerchantCode"       => MER_CODE, //机构商户编号
            "hpMerCode"             => M_ID, //瀚银商户号M_ID
            "orderNo"               => $order_no,
            "orderTime"             => $order_time,

            "currencyCode"          => "156",
            "orderAmount"           => number_format($post['orderAmount'],2,".","") * 100, //支付金额 单位元
            "name"                  => "",   //姓名  全渠道
            "idNumber"              => "",   //身份证号 341126197709218366
            "accNo"                 => "",   //卡号 6216261000000000018
            "telNo"                 => "",   //手机号 13552535506
            "productType"           => "100000",   //产品类型
            "paymentType"           => "2000",    //支付类型
            "backUrl"               => $notify_url, //异步回调 , 支付结果以异步为准
            "frontUrl"              => $post['pickupUrl'], //同步回调 不作为最终支付结果为准，请以异步回调为准
            "merGroup"              => "", //同步回调 不作为最终支付结果为准，请以异步回调为准
            "nonceStr"              => $post['orderNo'], //随机参数
            "paymentChannel"        => "unionACPB2C",
        );
        $log->W('表单提交');
        $log->W(var_export($data,true));
        $str = $data['insCode']."|".$data['insMerchantCode']."|".$data['hpMerCode']."|".$data['orderNo']."|".$data['orderTime']."|".$data['orderAmount']."|".$data['name']."|".$data['idNumber']."|";
        $str .= $data['accNo']."|".$data['telNo']."|".$data['productType']."|".$data['paymentType']."|".$data['nonceStr']."|".APP_KEY;
        $log->W("签名字符串:\n".$str);

        $data["signature"] = md5($str);
        $log->W('表单提交sign');
        $log->W(var_export($data,true));
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