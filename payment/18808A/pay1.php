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
                        $post=$_POST;
                        $log->W('pay1传进来的参数');
                        $log->W(var_export($post,true));
                        $field['orderNo']          = $post['orderNo'];//商品订单号
                        $field['orderAmount']      = $post['orderAmount'];//金额
                        $log->W('leanwork传进来的参数');
                        $log->W(var_export($field,true));

                            ?>
                            <form action="paying.php" method="post" class="form form-horizontal responsive" id="demoform">
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
                                    <label class="form-label col-xs-3">手机号:</label>
                                    <div class="formControls col-xs-8">
                                        <?php echo $post['mobile'];?>
                                    </div>
                                </div>
                                <div class="row cl">
                                    <label class="form-label col-xs-3">金额：</label>
                                    <div class="formControls col-xs-8">
                                        <?php echo $field['orderAmount']/100;?>
                                    </div>
                                </div>
                                <div class="row cl">
                                    <label class="form-label col-xs-3">重先获取验证码：</label>
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





                </div>
            </div>



        </div>

    </div>
</div>





</body>
</html>
<!--H-ui前端框架提供前端技术支持 h-ui.net @2017-01-01 -->

<script>

    /***点击发送验证码***/
    var InterValObj; //timer变量，控制时间
    var count = 60; //间隔函数，1秒执行
    var curCount;//当前剩余秒数

    function sendMessage(orderNo) {

        curCount = count;
        //设置button效果，开始计时
        $("#btnSendCode").attr("disabled", "true");
        $("#btnSendCode").val("剩余"+curCount+"秒");
        InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
        $.ajax({
            url: "getSmsCode.php" ,
            type: 'post',
            data: {orderNo:orderNo},
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
        var orderNo = $("input[name=orderNo]").val();

        if(orderNo == ""){
            alert("错误请求");
            return false;
        }

        sendMessage(orderNo);
    });
</script>