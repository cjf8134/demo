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
    require_once "doPay.class.php";
    $post=$_POST;


    
    // 请求数据赋值
    // 商户APINMAE，WEB渠道一般支付
    $data['apiName']    = $apiname_pay;
    // 商户API版本
    $data['apiVersion'] = $api_version;
    // 商户在支付平台的平台号
    $data['platformID'] = PLATFORM_ID;
    // 支付平台分配给商户的账号
    $data['merchNo'] = M_ID;
    // 商户通知地址
    $data['notifyUrl'] = $post['notifyUrl'];
    $data['returnUrl'] = $post['returnUrl'];
    //商户订单号
    $data['orderNo'] = $post['orderNo'];
    // 商户订单日期
    $data['tradeDate'] = date("Ymd",time());
    // 商户交易金额,必须保留为2位小数如100.00
    $data['tradeAmt'] = $post['tradeAmt'];
    // 商户参数
    $data['merchParam'] = "abcd";
    // 商户交易摘要 商品名，数量等，不能有特殊符号，如 & = ？
    $data['tradeSummary'] = "text";
    //微信或支付宝必填，网银不为空则直连，，不为空时银行编号必须不为空
    $data['payType'] = "WANGYIN2";
    // 银行代码，微信或支付宝必填，网银不为空则直连
    $data['bankCode'] = $post['bankCode'];
    // 对含有中文的参数进行UTF-8编码
    // 将中文转换为UTF-8
    if(!preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $data['notifyUrl']))
    {
        $data['notifyUrl'] = iconv("GBK","UTF-8", $data['notifyUrl']);
    }

    if(!preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $data['merchParam']))
    {

        $data['merchParam'] = iconv("GBK","UTF-8", $data['merchParam']);
    }

    if(!preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $data['tradeSummary']))
    {
        $data['tradeSummary'] = iconv("GBK","UTF-8", $data['tradeSummary']);
    }

    $log->W("未签名前的请求数据:\n".var_export($data,true));

    // 初始化
    $ybPay = new YbPay(APP_KEY, PAY_URL);
    // 准备待签名数据
    $str_to_sign = $ybPay->prepareSign($data);
    // 数据签名
    $sign = $ybPay->sign($str_to_sign);
    $log->W("生成签名请求参数:\n".$sign);

    $data['signMsg'] = $sign;
    $log->W("请求数据:\n".var_export($data,true));
    // 生成表单数据
    echo $ybPay->buildForm($data);

}else{
    echo "无效参数";
}

?>


</body>
</html>