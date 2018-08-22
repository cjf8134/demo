<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="h-ui/lib/html5shiv.js"></script>
    <script type="text/javascript" src="h-ui/lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="h-ui/static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="h-ui/lib/Hui-iconfont/1.0.8/iconfont.min.css" />
    <!--[if lt IE 9]>
    <link href="h-ui/static/h-ui/css/H-ui.ie.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    <!--[if IE 6]>
    <script type="text/javascript" src="h-ui/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <style type="text/css">
        .ui-sortable .panel-header{ cursor:move}
    </style>
    <title>支付</title>

</head>
<body ontouchstart>

<div class="containBox">
    <div class="containBox-bg"></div>

    <div class="wap-container">
        <div class="container ui-sortable">

            <div class="panel panel-default">
                <div class="panel-header">支付详情</div>
                <div class="panel-body">
        <?php
            require_once 'log.class.php';
            $log=new Log();
            if($_POST) {
                require_once 'leanworkSDK.php';
                require_once 'fileCache.class.php';
                require_once 'lib.php';
                require_once 'config.php';
                require_once 'AES.class.php';

                $post = $_POST;
                $data['orderNo'] = $post['orderNo'];
                $data['merCode'] = M_ID;
                $data['userId'] =  $post['userId'];
                $data['dateTime'] = date('YmdHis',time());
                //需要加密参数
                $aes = new AES(substr(APP_KEY,0,16));
                $data['mobile'] = $aes->encrypt($post['phone']);
                $data['userName'] = $aes->encrypt($post['userName']);
                $data['IDCardType'] = '01';
                $data['IDCardNo'] = $aes->encrypt($post['IDCardNo']);
                $data['bankCardCode'] = $aes->encrypt($post['bankCardCode']);

                $log->W('leanwork传进来的参数');
                $log->W(var_export($data, true));
                $data['sign'] = get_sign($data,APP_KEY);

	            $res = json_decode(curl_post(BIND_URL,$data),true);
                $log->W('leanwork传进来的参数');
                $log->W(var_export($res, true));
                if($res['resultCode'] == "000000"){
                    exit(json_encode(array("status"=>1,"msg"=>"获取短信成功")));
                }else{

                    exit(json_encode(array("status"=>-1,"msg"=>"获取短信失败")));
                }

            }else{
                echo "请求错误。。";
            }





