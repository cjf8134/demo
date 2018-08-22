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
    require_once 'PayLib.php';

    $post=$_POST;


        //请求表单初始化
        $form = array(
            'version'    => '1.0',
            'nodeId'     => $key['nodeId'],
            'orgId'      => M_ID,
            'orderTime'  => date('YmdHis'),
            'txnType'    => 'T11113',
            'signType'   => 'RSA',
            'charset'    => 'UTF-8',
            'bizContext' => '',
            'sign'       => '',
            'reserve1'   => '',
        );

        $log->W("请求表单初始化:\n".var_export($form,true));

        $data = array(
            'outTradeNo'                => $post['orderNo'],
            'totalAmount'               => number_format($post['totalAmount'],0,".",""),
            'currency'                  => 'CNY',
            'pageUrl'                   => $post['pageUrl'],   // 同步响应地址
            'notifyUrl'                 => $post['notifyUrl'], // 异步回调
            'body'                      => "text",
            'orgCreateIp'               => get_ip(),
            'payerBank'                 => $post['payerBank'],
            'userType'                  => 1
        );
        $log->W("请求表单初始化:\n".var_export($data,true));


// 1. 业务参数 json 编码
        $bizContextJson = json_encode($data);

// 2. 业务参数签名
        $bizContextSign = PayLib::rsaSHA1Sign($bizContextJson, $key['private_key']);
// 3. 业务参数加密
        $bizContextAESEncrypt = PayLib::AESEncrypt($bizContextJson, $key['base64edAESKey']);

// 4. 回填表单
        $form['sign']       = $bizContextSign;
        $form['bizContext'] = $bizContextAESEncrypt;
        $log->W("回填表单:\n".var_export($form,true));
//
//// 5. 发送请求
//        $response = PayLib::postForm(PAY_URL, $form);
//        var_dump($response);
//
//// 解析响应 json
//        $response = json_decode($response, TRUE);
//        var_dump($response);
//
//// 业务参数解密
//        $bizContextAESDecrypt = PayLib::AESDecrypt($response['bizContext'], $key['base64edAESKey']);
//        print_r($bizContextAESDecrypt);
//// 验签
//        $verify = PayLib::rsaSHA1Verify($bizContextAESDecrypt, $response['sign'], $key['public_key']);
//
//
//
//        $log->W("请求数据:\n".var_export($data,true));


        ?>
        <form name="pay" id="register_form" action='<?php echo PAY_URL; ?>' method='post'>
            <?php foreach($form as $name=>$value) {
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
    echo "无效参数";
}

?>

</body>
</html>