<?php

$time = time();
$ding = '7'.rand(10000000,99990000).rand(100000,999999);
$trading_account='tll45604';//交易账号
$a = '45604';//商户id
$c = '7744a1b5a6897c632e64082c36427017';//MD5 key
$sign = md5(md5($a.md5($time.$c)));

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <title>测试</title>
        <link rel="stylesheet" href="./../new_css/style.css">
        <link rel="stylesheet" href="./../new_css/iconfont.css">
        <style>
        #switcher {
            height: 54px;
            background: url(bg2.png) repeat-x;
            z-index: 99999;
            position: fixed;
            width: 100%;
            top: 0;
            background: #000;
        }

        .logoTop li {
            height: 54px;
            line-height: 54px;
            font-size: 24px;
            background: #000;
            color: rgb(255, 255, 255);
            font-weight: bold;
            font-family: 微软雅黑;
            text-align: center;
        }

        .login-box input {
            background: #fff;
        }
        .login-box input, .signup-form{
            color: #333333;
        }
        .hide{
            display: none;
        }
        </style>

        <body style="color: #333;background: #f5f5f5;">
            <div class="logoTop">
                <li><a href="">测试</a></li>
            </div>
            <div class="login-box" style="clear:both;">
                <div class="box-con tran">
                    <div class="login-con f-l">
                        <form action="https://pay.palmcloudpay.com/home/pay/pay" method="post" id="register_form">
                            <div class="form-group">
                                <input type="text" name="price" value="0.01" placeholder="订单价格">
                            </div>
                            <div class="form-group">
                                <input type="text" name="type" value="1" placeholder="支付类型">
                            </div>
                            <div class="form-group">
                                <input type="text" name="shop_id" value="<?php echo $a;?>" placeholder="商户号">
                            </div>
                            <div class="form-group">
                                <input type="text" name="trading_account" value="<?php echo $trading_account;?>" placeholder="交易号">
                            </div>
                            <div class="form-group">
                                <input type="text" name="trade_no" value="<?php echo $ding;?>" placeholder="交易订单号">
                            </div>
                            <div class="form-group">
                                <input type="text" name="start_time" value="<?php echo $time;?>" placeholder="二维码生成时间">
                            </div>
                            <div class="form-group hide">
                                <input type="text" name="pass_type" value="post" placeholder="传值方式">
                            </div>
                            <div class="form-group hide">
                                <input type="text" name="sign_type" value="md5" placeholder="加密方式">
                            </div>
                            <div class="form-group hide">
                                <input type="text" name="good_name" value="哈士气" placeholder="商品名称">
                            </div>
                            <div class="form-group hide">
                                <input type="text" name="good_dec" value=神兵兽 placeholder="商品描述">
                            </div>
                            <div class="form-group hide">
                                <input type="text" name="sign" value="<?php echo $sign;?>" placeholder="签名">
                            </div>
                            <div class="form-group">
                                <button type="button" class="tran pr" onClick="reg()">
                            <input type="submit" value="提交" style="display: block;background: #03a9f4;color: #fff;">
                                </button>
                            </div>
                            </form>
                    </div>
                </div>
            </div>
            <script src="http://www.jq22.com/jquery/jquery-2.1.1.js"></script>
            <!--公共JS-->
            <script type="text/javascript">
            function reg() {
                    $('#submit').click();
            }
            </script>
        </body>

    </html>