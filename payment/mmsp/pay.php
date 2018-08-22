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
            echo "处理中,请别关闭页面...";
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
            
            $order_time = date ( 'YmdHis' );
            $order_no=$order_time.mt_rand(1000,9999);
//            $cache->set($order_no, $post['orderNo']);  //保存数据


            $field['MERORDERID'] = $order_no;//商品订单号
            $field['JUMP_URL']   = $post['pickupUrl'];//支付成功后跳转的页面
            $field['NOTIFY_URL'] = $notify_url;//异步支付结果通知页面
            $field['AMT']        = $post['orderAmount'];//金额（元）
            $field['GOODSNAME']  = "text";//金额（元）
            $field['REMARK']     = $order_no;//金额（元）REMARK
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
                        <?php echo $field['MERORDERID'];?>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3">金额：</label>
                    <div class="formControls col-xs-8">
                        <?php echo $field['AMT']/100;?>
                    </div>
                </div>




                <div class="row cl">
                    <label class="form-label col-xs-3">银行名称：</label>
                    <div class="formControls col-xs-8">
							<span class="select-box">
									<select class="select" size="1" name="PAY_CHANNEL">
                                        <?php foreach($banks as $name => $value): ?>
                                            <option value="<?php echo $name;?>"><?php echo $value;?></option>
                                        <?php endforeach;?>
                                    </select>
								</span>
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