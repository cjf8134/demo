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
    require_once 'src/JWT.php';
    $banks = require_once 'Bank.php';
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
        $cache->set($order_no, $post['orderNo']);  //保存数据


//            $field['order_id'] = $order_no;//商品订单号
//            $field['page_url']=$post['pickupUrl'];//支付成功后跳转的页面
//            $field['jwt_notify_url']=$notify_url;//异步支付结果通知页面
//            $field['amount']=$post['orderAmount'];//金额（元）
//
//            $log->W('leanwork传进来的参数');
//            $log->W(var_export($field,true));

        $token=array(
            "mch_id"            =>M_ID,
            "pay_type"          =>"unipay.web",  //web.union_pay
            "order_id"          =>$order_no,
            "order_time"	    =>time(),
            "title"             =>"pay",
            "amount"            =>number_format($post['orderAmount'],2,".","") * 100,  // 订单金额
            "bank_code"         =>"ABC"	,
            "page_url"	        =>$post['pickupUrl'],//支付成功后跳转的页面
            "jwt_notify_url"	=>$notify_url,
            "request_ip"        =>get_ip(),
            "reserve1"          =>"s",
        );
        $log->W("签名前的参数:\n");
        $log->W(var_export($token,true));
        $private_key        = chunk_split($private_key, 64, "\n");
        $private_key = "-----BEGIN RSA PRIVATE KEY-----\n$private_key-----END RSA PRIVATE KEY-----\n";
        $data = JWT::encode($token, $private_key, 'RS256');
        $log->W("签名后返回的参数:\n");
        $log->W($data);
        $header = Array("Content-Type: text/plain");
        $resp = httpRequest(PAY_URL,"post",$data, $header);
        $con = json_decode($resp,true);
        if($con['code'] == "0"){
            echo $con['data'];die;
        }else{
            echo $con['msg'];die;
        }
    }else{
        echo "签名错误";
    }

}else{
    echo "无效参数";
}

?>
</body>
</html>
