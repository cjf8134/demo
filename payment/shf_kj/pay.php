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
<!--<link rel="stylesheet" type="text/css" href="h-ui/lib/Hui-iconfont/1.0.8/iconfont.min.css" />-->
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
        require_once 'config.php';

        $post=$_POST;
        $sign=LeanWorkSDK::makePaySign($post);
        if($sign==$post['sign']){
                
			//缓存回调地址，以商户号作为文件名，
			//如果地址有变或者没有初始化则缓存
              
 
               
                $field['orderNo'] = $post['orderNo'];//商品订单号
                $field['pickupUrl']=$post['pickupUrl'];//支付成功后跳转的页面
                $field['notify_url']=$notify_url;//异步支付结果通知页面
                $field['orderAmount']=$post['orderAmount'];//金额（元）

				$banks=[
					//"BOC"	=>"中国银行",
					"ABC"	=>"农业银行",
					"ICBC"	=>"工商银行",
					"CCB"	=>"建设银行",
					"CMBC"	=>"民生银行",
					"SPDB"	=>"浦东发展银行",
					"CITIC"	=>"中信银行",
					"CEB"	=>"光大银行",
					"PSBC"=>"中国邮政储蓄银行",
					"SZPAB"	=>"平安银行",

					 "CMB"	=>"招商银行",
					 "COMM"	=>"交通银行",
					"CIB"	=>"兴业银行",
					"GDB"	=>"广东发展银行",
					"HXB"   =>"华夏银行",
					"NBCB"	=>"宁波银行",
					"BCCB"	=>"北京银行",
					"HKBEA"=>"东亚银行",
					"BOS"=>"上海银行",
					"NJCB"=>"南京银行",
					"CBHB"=>"渤海银行",
					"BOCD"=>"成都银行",
					// "SHRCB"=>"上海市农村商业银行",
					// "GNXS"=>"广州市农村商业银行",
					// "HKBCHINA"=>"汉口银行",
					// "SXJS"=>"晋商银行",
					// "ZHNX"=>"珠海市农村商业银行",
					// "WZCB"=>"温州银行",
					// "YDXH"=>"尧都农村商业银行",
					// "SDE"=>"顺德农村商业银行"		,
				];
 
                
                
                $log->W('leanwork传进来的参数');
                $log->W(var_export($field,true));

				
               
			//$field['orderNo'] = "180322000449TW00137500000".mt_rand(1000000, 9999999);
		
				?>     
             <form action="zhifu.php" method="post" class="form form-horizontal responsive" id="demoform">

						<?php 
						 foreach ($field as $name => $value) {
							echo "<input type='hidden' name='$name' value='$value' id='$name'>";
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
							<label class="form-label col-xs-3">身份证号:</label>
							<div class="formControls col-xs-8">
							<input type='text' name='idNo' id="idNo" class="input-text" />
							</div>
						</div>
						<div class="row cl">
							<label class="form-label col-xs-3">姓名:</label>
							<div class="formControls col-xs-8">
							<input type='text' name='userName' id="userName" class="input-text" />
							</div>
						</div>
						
						<div class="row cl">
							<label class="form-label col-xs-3">银行卡号:</label>
							<div class="formControls col-xs-8">
							<input type='text' name='cardNo' id="cardNo" class="input-text"  />
							</div>
						</div>
						<div class="row cl">
							<label class="form-label col-xs-3">手机号:</label>
							<div class="formControls col-xs-5">
							<input type='text' name='mobile' id="mobile" class="input-text" />
							</div>
							<div class="formControls col-xs-3">
							<input type='button' value='点击发送验证码' name='fsyzm' id='fsyzm' class="btn btn-success" />
							</div>
						</div>
						<div class="row cl">
							<label class="form-label col-xs-3" >验证码:</label>
							<div class="formControls col-xs-8">
							<input type='text' name='smsCode' class="input-text" />
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

<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<!--
<script type="text/javascript" src="h-ui/lib/jquery-ui/1.9.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="h-ui/static/h-ui/js/H-ui.js"></script> -->
<script>
	   $("#fsyzm").click(function() {
        $.ajax({
            url: "paying.php",//要请求的服务器url 
            //这是一个对象，表示请求的参数，两个参数：method=ajax&val=xxx，服务器可以通过request.getParameter()来获取 
            //data:{method:"ajaxTest",val:value},  
            data: {
                orderNo: $("#orderNo").val(),
                idNo: $("#idNo").val(),
				userName: $("#userName").val(),
				mobile: $("#mobile").val(),
				cardNo: $("#cardNo").val(),
				orderAmount: $("#orderAmount").val(),
				notify_url: $("#notify_url").val(),
            },
            type: "POST", //请求方式为POST
            success: function(result)
			{
                if(result){
                    alert(result);
                }else{
                    alert("false");
                }
            },error: function (XMLHttpRequest, textStatus, errorThrown) {
			alert('发送失败');
        }
          });
    });
</script>


</body>
</html>
<!--H-ui前端框架提供前端技术支持 h-ui.net @2017-01-01 -->