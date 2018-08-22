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
<?php
    if($_POST){
        require_once 'log.class.php';
        require_once 'leanworkSDK.php';
        require_once 'fileCache.class.php';
        require_once 'config.php';
        $log=new Log();
        $post=$_POST;
        $sign=LeanWorkSDK::makePaySign($post);
        if($sign==$post['sign']){
            //缓存回调地址，以商户号作为文件名，
            //如果地址有变或者没有初始化则缓存
            $cache = new fileCache($cache_dir);
            $result = $cache->get(M_ID); //获取数据
            if(!$result || $result['receiveUrl'] != $post['receiveUrl']){
                $data = array(
                'receiveUrl' => $post['receiveUrl']
                );
                $cache->set(M_ID, $data);  					//保存数据
            }
            //参数
            $field['orderNo'] = $post['orderNo'];			//商品订单号
            $field['pickupUrl']=$post['pickupUrl'];			//支付成功后跳转的页面
            $field['notify_url']=$notify_url;				//异步支付结果通知页面
            $field['orderAmount']=$post['orderAmount'];		//金额（元）
            //银行列表
            $banks=[
				"ICBC"  =>	"工商银行",
				"ABC"   =>	"农业银行",
				"CCB"   =>	"建设银行",
				"BOC"   =>	"中国银行", 
				"BCCB"  =>	"北京银行", 
				"CMBC"  =>	"民生银行",
				"CEB"   =>	"光大银行",
				"CITIC" =>	"中信银行",
				"SHB"   =>	"上海银行",
				"PSBS"  =>	"中国邮政",
            ];

            $log->W('leanwork传进来的参数');
            $log->W(var_export($field,true));
        }else{
            exit('非法访问');
        }
    }else{
        exit('无效参数');
    }

?>     

<div class="containBox">
    <div class="containBox-bg"></div>
    <div class="wap-container">
        <div class="container ui-sortable">
            <div class="panel panel-default">
                <div class="panel-header">支付详情</div>
                <div class="panel-body">
                    <form action="paying.php" method="post" class="form form-horizontal responsive" id="demoform">
                                <?php 
                                 foreach ($field as $name => $value) {
                                    echo "<input type='hidden' name='$name' value='$value'>";
                                }
                                ?>      
                                <div class="row cl">
                                    <label class="form-label col-xs-3">商品订单号:</label>
                                    <div class="formControls col-xs-8"><?php echo $field['orderNo'];?></div>
                                </div>
                                <div class="row cl">
                                    <label class="form-label col-xs-3">金额：</label>
                                    <div class="formControls col-xs-8"><?php echo $post['orderAmount'];?></div>
                                </div>
                                <div class="row cl">
                                    <label class="form-label col-xs-3">银行名称：</label>
                                    <div class="formControls col-xs-8">
                                    <span class="select-box">
                                            <select class="select" size="1" name="banktype">
                                                <?php foreach($banks as $k=>$v): ?>
                                                    <option value="<?php echo $k;?>"><?php echo $v;?></option>
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
                    </div>
                </div> 
            </div>
        </div>
    </div>
</body>
</html>