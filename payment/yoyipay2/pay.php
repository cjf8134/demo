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
        require_once 'config.php';

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
                    $cache->set(M_ID, $data);  //保存数据
                }
				$banks=$cache->get("banks");
				if(!$banks){
					$getBank_url=getUrl()."getBank.php";
					
					$bank_data = file_get_contents($getBank_url);
					
					$bank_data=json_decode($bank_data,true);
					
					if($bank_data){
						$banks=$bank_data["bankList"]["bankRow"];
						$cache->set("banks", $banks);  //保存数据
					}
                   
				}
				
				//$bank_data='{"bankCount":"10","bankList":{"bankRow":[{"bankName":"\u4e2d\u56fd\u5de5\u5546\u94f6\u884c","bankID":"102C","otherBankID":"102C","cardType":"X"},{"bankName":"\u4e2d\u56fd\u519c\u4e1a\u94f6\u884c","bankID":"103C","otherBankID":"103C","cardType":"X"},{"bankName":"\u4e2d\u4fe1\u94f6\u884c","bankID":"302C","otherBankID":"302C","cardType":"X"},{"bankName":"\u94f6\u8054\u5168\u6e20\u9053\u53ea\u501f","bankID":"988C","otherBankID":"988C","cardType":"01"},{"bankName":"\u5efa\u8bbe\u94f6\u884c","bankID":"105C","otherBankID":"CCB","cardType":"01"},{"bankName":"\u5149\u5927\u94f6\u884c","bankID":"303C","otherBankID":"CEB","cardType":"01"},{"bankName":"\u6c11\u751f\u94f6\u884c","bankID":"305C","otherBankID":"CMBC","cardType":"X"},{"bankName":"\u5317\u4eac\u94f6\u884c","bankID":"309C","otherBankID":"BCCB","cardType":"X"},{"bankName":"\u4e0a\u6d77\u94f6\u884c","bankID":"312C","otherBankID":"BOS","cardType":"X"},{"bankName":"\u90ae\u653f\u94f6\u884c","bankID":"403C","otherBankID":"PSBC","cardType":"01"}]}}';
				
				

                $field['orderNo'] = $post['orderNo'];//商品订单号
                $field['pickupUrl']=$post['pickupUrl'];//支付成功后跳转的页面
                $field['notify_url']=$notify_url;//异步支付结果通知页面
                $field['orderAmount']=$post['orderAmount'];//金额（元）

				
 
                
                
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
							<label class="form-label col-xs-3">金额：</label>
							<div class="formControls col-xs-8">
							<?php echo $post['orderAmount'];?>
							</div>
						</div>
			
						
						

						<div class="row cl">
							<label class="form-label col-xs-3">银行名称：</label>
							<div class="formControls col-xs-8">
							<span class="select-box">
									<select class="select" size="1" name="bank_data">
										<?php foreach($banks as $bank): ?>
										<option value="<?php echo $bank['bankID']."-".$bank['cardType'];?>"><?php echo $bank['bankName'];?></option>
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