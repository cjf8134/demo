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
    <script type="text/javascript" src="h-ui/lib/jquery-3.3.1.min.js" ></script>

    <style type="text/css">
        .ui-sortable .panel-header{ cursor:move}
    </style>
    <title>支付</title>

</head>
<style>
    input{
        width: 300px;line-height: 30px;
    }
</style>
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
                    if($_POST){
                        require_once 'leanworkSDK.php';
                        require_once 'fileCache.class.php';
                        require_once 'lib.php';
                        require_once 'config.php';
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
                            
//                            $user = $cache->get(M_ID."_userid"); //获取用户信息
//                            if(!$user || empty($user['userId']) || empty($user['protocolId'])){
//                                $user_data = array(
//                                    'userId'     => 1,
//                                    'protocolId' => 'jpd172KcQ',
//                                );
//                                $cache->set(M_ID."_userid", $user_data);  //保存数据
//                            }
                            $user = $cache->get(M_ID."_userid"); //获取用户信息



                            if($user && !empty($user['userId']) && !empty($user['protocolId'])){

                                $UnionPay_data = array(
                                    'protocolId'        => $user['protocolId'],
                                    'orderNo'           => $post['orderNo'],
                                    'orderAmount'       => strval($post['orderAmount'] * 100),
                                    'returnAddress'     => $post['pickupUrl'],//支付成功后跳转的页面
                                    'backAddress'       => $notify_url,
                                    'productDesc'       => 'test products',
                                    'merCode'           => M_ID,
                                    'dateTime'          => date('YmdHis',time()),
                                );
                                $UnionPay_data['sign'] = get_sign($UnionPay_data,APP_KEY);
                                $log->W('确定提交订单解析的参数');
                                $log->W(var_export($UnionPay_data, true));
                                ?>
                                    <form name="pay" id="register_form" action='BindConfirm.php' method='post'>
                                        <?php foreach($UnionPay_data as $name=>$value) {
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
                                die;
                            }
                            $field['orderNo']      = $post['orderNo'];//商品订单号
                            $field['returnAddress']=$post['pickupUrl'];//支付成功后跳转的页面
                            $field['backAddress']  =$notify_url;//异步支付结果通知页面
                            $field['orderAmount']  =$post['orderAmount'];//金额（元）
                            $field['userId']       =$post['customerId'];//金额（元）
                            $field['IDCardType']   = 01;//金额（元）
                            $log->W('leanwork传进来的参数');
                            $log->W(var_export($field,true));

                            ?>
                            <form action="BindConfirm.php" method="post" class="form form-horizontal responsive" id="demoform">
                                <?php
                                foreach ($field as $name => $value) {
                                    echo "<input type='hidden' name='$name' value='$value'>";
                                }
                                ?>

                                <div class="row cl">
                                    <label class="form-label col-xs-3">商品订单号:</label>
                                    <div class="formControls col-xs-8">
                                        <?php echo $field['orderNo'];?>
                                    </div>
                                </div>
                                <div class="row cl">
                                    <label class="form-label col-xs-3">金额：</label>
                                    <div class="formControls col-xs-8">
                                        <?php echo $field['orderAmount'];?>
                                    </div>
                                </div>



                                <div class="row cl">
                                    <label class="form-label col-xs-3">输入手机号：</label>
                                    <div class="formControls col-xs-8">
                                        <input type='text' name='mobile' value='' / >
                                    </div>
                                </div>

                                <div class="row cl">
                                    <label class="form-label col-xs-3">输入持卡人姓名：</label>
                                    <div class="formControls col-xs-8">
                                        <input type='text' name='userName' value='' / >
                                    </div>
                                </div>


                                <div class="row cl">
                                    <label class="form-label col-xs-3">输入身份证号：</label>
                                    <div class="formControls col-xs-8">
                                        <input type='text' name='IDCardNo' value='' / >
                                    </div>
                                </div>

                                <div class="row cl">
                                    <label class="form-label col-xs-3">输入银行卡号：</label>
                                    <div class="formControls col-xs-8">
                                        <input type='text' name='bankCardCode' value='' / >
                                    </div>
                                </div>
                                <div class="row cl">
                                    <label class="form-label col-xs-3">输入验证码：</label>
                                    <div class="formControls col-xs-8">
                                        <input type='text' name='smsCode' value='' / >
                                        <input type="button" class="fl daojishi" style="width:27%;font-size: 0.4rem;background: #bdbdbd;color: #FFF;padding: 0.2rem;"id="btnSendCode" value="发送验证码" />
                                    </div>
                                </div>
                                <div class="row cl">
                                    <div class="col-xs-8 col-xs-offset-3">
                                        <input class="btn btn-primary" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                                    </div>
                                </div>
                            </form>


                        <?php  }else{ ?>
                            <div class="Huialert Huialert-danger"><i class="Hui-iconfont">&#xe6a6;</i>非法访问</div>
                        <?php    }?>

                    <?php }else{?>
                        <div class="Huialert Huialert-danger"><i class="Hui-iconfont">&#xe6a6;</i>无效参数</div>
                    <?php }?>



                </div>
            </div>



        </div>

    </div>
</div>

<!-- <script type="text/javascript" src="h-ui/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="h-ui/lib/jquery-ui/1.9.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="h-ui/static/h-ui/js/H-ui.js"></script> -->



</body>
</html>
<!--H-ui前端框架提供前端技术支持 h-ui.net @2017-01-01 -->

<script>
    $("#getsmsCode").click(function(){
        alert(1);
    })


    /***点击发送验证码***/
    var InterValObj; //timer变量，控制时间
    var count = 60; //间隔函数，1秒执行
    var curCount;//当前剩余秒数

    function sendMessage(phone) {
        var userName     = $("input[name=userName]").val();   // userName
        var IDCardNo     = $("input[name=IDCardNo]").val();   // 输入身份证号
        var bankCardCode = $("input[name=bankCardCode]").val();   // 银行卡
        var orderNo      = $("input[name=orderNo]").val();   // 银行卡
        var userId       = $("input[name=userId]").val();   // 银行卡
       // var smsCode      = $("input[name=smsCode]").val();   //验证码
        curCount = count;
        //设置button效果，开始计时
        $("#btnSendCode").attr("disabled", "true");
        $("#btnSendCode").val("剩余"+curCount+"秒");
        InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
        $.ajax({
            url: "bindCart.php",
            type: 'post',
            data: {phone:phone,IDCardNo:IDCardNo,bankCardCode:bankCardCode,userName:userName,orderNo:orderNo,userId:userId},
            async: false,
            cache: false,
            dataType:'json',
            success: function (res) {
                if(res.status == 1){
                    alert(res.msg);
                }else{
                    alert(res.msg);
                    return false;
                }
            },
        });

    }




    

    //timer处理函数
    function SetRemainTime() {
        if (curCount == 0) {
            window.clearInterval(InterValObj);//停止计时器
            $("#btnSendCode").removeAttr("disabled");//启用按钮
            $("#btnSendCode").val("发送验证码");
        }
        else {
            curCount--;

            $("#btnSendCode").val("剩余"+curCount+"秒");
        }
    }
    $("#btnSendCode").click(function(){
        var mobile = $("input[name=mobile]").val();
        if(mobile == ""){
            alert("亲，手机号不能为空...");
            return false;
        }

        sendMessage(mobile);
    });
</script>