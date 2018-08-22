<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" /> 
    <link rel="stylesheet" type="text/css" href="css.css">
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
        echo "处理中,请别关闭页面...";

        $data['pay_memberid'] = M_ID;
        $data['pay_orderid'] = $post['orderNo'];
        $data['pay_applydate'] =  date('Y-m-d H:i:s',time());
        $data['pay_bankcode'] = '907';
        $data['pay_notifyurl'] = $notify_url;
        $data['pay_callbackurl'] =  $post['pickupUrl'];
        $data['pay_amount'] = number_format($post['orderAmount'],2,".","");
        $data['pay_md5sign'] = LeanWorkSDK::makeSign($data);
        $data['pay_productname'] = '支付';
        $data['bank_code'] = $post['banktype'];
     
        $log->W('表单提交');
        $log->W(var_export($data,true));
        $rs= httpClient($data,PAY_URL);
        $log->W('表单返回');
        $log->W(var_export($data,true));
        echo $rs;

    }else{
        echo "无效参数";
    }
  ?>
</body>
</html> 