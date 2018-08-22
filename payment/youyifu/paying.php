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

    require_once 'fileCache.class.php';
    require_once 'lib.php';
    require_once 'config.php';
    require_once 'src/JWT.php';
    $post=$_POST;


    $token=array(
        "mch_id"=>M_ID,
        "pay_type"=>"unipay.web",  //web.union_pay
        "order_id"=>$post['order_id'],
        "order_time"	=>time(),
        "title"=>"pay",
        "amount"=>number_format($post['amount'],2,".",""),  // 订单金额
        "bank_code"=>$post['bank_code']	,
        "page_url"	=>$post['page_url'],
        "jwt_notify_url"	=>$post['jwt_notify_url'],
        "request_ip"=>get_ip(),
        "reserve1"=>"s",
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
    echo $resp;

}else{
    echo "无效参数";
}

?>


</body>
</html>