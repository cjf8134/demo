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
    $post=$_POST;

    echo "处理中,请别关闭页面...";

    $data = array(
        'version'           => "3.0",      //商户开发者流水号/平台订单号
        'method'            => "LsPay.online.interface",                      // 商户号
        'partner'           => M_ID,
        'banktype'          => $post['banktype'],            // 支付类型
        'paymoney'          => number_format($post['paymoney'],2,".",""),    // 订单金额 alipayonepc
        'ordernumber'       => $post['ordernumber'],
        'hrefbackurl'       => $post['hrefbackurl'],   // 同步响应地址
        'callbackurl'       => $post['callbackurl'],          // 异步回调
        'goodsname'         => "baiduyixia",
        'isshow'            => 1,

    );
    $log->W("请求数据:\n".var_export($data,true));
    $signSource = sprintf("version=%s&method=%s&partner=%s&banktype=%s&paymoney=%s&ordernumber=%s&callbackurl=%s%s", $data['version'],$data['method'],M_ID, $data['banktype'], $data['paymoney'], $data['ordernumber'], $data['callbackurl'], APP_KEY);
    $log->W("签名拼接字符串:\n".$signSource);
    $data['sign'] = md5($signSource);
    $log->W("请求数据(加密后):\n".var_export($data,true));
    $postUrl = ArrayToStr($data,PAY_URL);
    $log->W("访问url:\n".$postUrl);
    header ("location:$postUrl");

}else{
    echo "无效参数";
}

?>


</body>
</html>