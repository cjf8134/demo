<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link href="bank_img/bank.css" rel="stylesheet" type="text/css" />

    <!--[if lt IE 9]>
    <script type="text/javascript" src="h-ui/lib/html5shiv.js"></script>
    <script type="text/javascript" src="h-ui/lib/respond.min.js"></script>
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
    <div class="payment_top">
        <div class="box1">
            <div class="logo fl">
                <img src="bank_img/logo.png"/>
            </div>
            <div class="register fr">
                <a href="javascript:void(0);">登录</a>
                <span>|</span>
                <a href="javascript:void(0);">注册</a>
            </div>
        </div>
    </div>
    <?php
    require_once 'log.class.php';
    $log=new Log();
    if($_POST){
    require_once 'leanworkSDK.php';
    require_once 'fileCache.class.php';
    require_once 'lib.php';
    require_once 'config.php';
    $banks = require_once 'Bank.php';
    $post=$_POST;
    $sign=LeanWorkSDK::makePaySign($post);
    if($sign==$post['sign']) {
        $log->W("leanwork签名认证:成功");
        //缓存回调地址，以商户号作为文件名，
        //如果地址有变或者没有初始化则缓存
        $cache = new fileCache($cache_dir);
        $result = $cache->get(M_ID); //获取数据
        if (!$result || $result['receiveUrl'] != $post['receiveUrl']) {
            $data = array(
                'receiveUrl' => $post['receiveUrl'],
            );
            $cache->set(M_ID, $data);  //保存数据
        }

        //                            $order_time = date ( 'YmdHis' );
        //                            $order_no=$order_time.mt_rand(1000,9999);
        //                            $cache->set($order_no, $post['orderNo']);  //保存数据


        $field['orderNo'] = $post['orderNo'];//商品订单号
        $field['returnUrl'] = $post['pickupUrl'];//支付成功后跳转的页面
        $field['notifyUrl'] = $notify_url;//异步支付结果通知页面
        $field['transAmt'] = $post['orderAmount'];//金额（元）

        $log->W('leanwork传进来的参数');
        $log->W(var_export($field, true));
    ?>

    <div class="box">
        <div class="box1">
            <div class="information">
                <h1>订单信息</h1>
                <p>商品订单号：<span> <?php echo $field['orderNo'];?></span></p>
                <h2>金额：¥<b> <?php echo $field['transAmt'];?></b></h2>
            </div>
            <div class="bank">
                <h1>支付银行</h1>

                <form action="paying.php" method="post" class="form form-horizontal responsive" id="demoform">
                    <?php
                    foreach ($field as $name => $value) {
                        echo "<input type='hidden' name='$name' value='$value'>";
                    }
                    ?>
                    <ul>
                        <?php
                        foreach ($banks as $name1 => $value1) {
                            echo "<li class='bank1'>";
                            echo "<input type='radio' name='bankCode' value='$name1'>";
                            echo "<div class='bank_img fr'><img src='bank_img/$value1'/></div></li>";

                        }
                        ?>
                    </ul>
                    <button>立即支付</button>
                </form>
            </div>
            <?php  }else{ ?>
                <div class="Huialert Huialert-danger"><i class="Hui-iconfont">&#xe6a6;</i>非法访问</div>
            <?php    }?>

            <?php }else{?>
                <div class="Huialert Huialert-danger"><i class="Hui-iconfont">&#xe6a6;</i>无效参数</div>
            <?php }?>
            <div class="number">
                <div class="number_img fl">
                    <img src="bank_img/logo02.png"/>
                </div>
                <p class="fl">Copyright © 2018 Honorfalcon Global Limited All Rights Reserved</p>
            </div>
        </div>

    </div>
</body>
</html>
