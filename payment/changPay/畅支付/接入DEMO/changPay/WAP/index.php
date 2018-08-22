<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
		<meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
		<link rel="stylesheet" type="text/css" href="css/aui.css" />
        <link rel="stylesheet" type="text/css" href="css.css" media="screen">

<style type="text/css">
	body {
		background: #f4f4f4; height: auto; padding-bottom: 15px;
	}
	.bar-bgcolor {
		position: fixed;
		top: 0;
        background: rgba(255,255,255,0);
        color: #ffffff;
	}
	.small-avatar {
		position: relative;
	}
	.small-avatar .avatar{
		opacity: 0;
		position: absolute;
		left: 40px;
		width: 30px;
		border: 1px solid #fff;
	}
	.small-avatar .avatar.show {
		-webkit-animation: showIn .8s ease both;
                animation: showIn .8s ease both;
	}
	.small-avatar .avatar.hide {
		-webkit-animation: hideIn .8s ease both;
                animation: hideIn .8s ease both;
	}
	#aui-header.white {
		background: #3bafda;
        opacity: 0.1;
        -webkit-animation: fadeIn .8s ease both;
                animation: fadeIn .8s ease both;
	}
	#aui-header.nowhite {
		background: rgba(62,100,145,0);
        -webkit-animation: fadeOut .8s ease both;
                animation: fadeOut .8s ease both;
	}
    
    .aui-content { background: #ffffff; margin-bottom: 10px;}
    .aui-content.image { margin-bottom: 0; position: relative; height: 220px; padding-top: 45px; }
    .image img { 
    	width: 100%;
   	}
    img.avatar {
    	position: absolute;
    	width: 25%;
    	height: auto;
    	left: 50%;
    	top: 25%;
    	margin-left: -12.5%;
    	border-radius: 50%;
    	border: 2px solid #ffffff;
   	}
   	.helper-name {
   		width: 100%;
   		text-align: center;
   		font-size: 1.2em;
   		color: #fff;
   		position: absolute;
   		bottom:30px;
   	}
    .helper-info {
    	width: 100%;
    	color: #666;
    	font-size: 14px;
    	padding: 5px 0;
    	overflow: hidden;
    	text-align: center;
    }
    .helper-info p {
    	margin-bottom: 5px;
    }
    .helper-tag { 
		color: #ff9900;
    }
    .wantmeet, .wantmeet .aui-iconfont, p.helper-info span.aui-iconfont{
    	color: #999;
    }
    .helper-otherinfo { margin-bottom: 10px; overflow: hidden;}
    
    
    .aui-card { border:none;}
    .about-box { border: none; border-bottom: 2px solid #eeeeee;}
    .about, .about .aui-list-view { background: #fff3cc;}
    .about-title { padding: 10px;}
    .about-image  img { width: 100%; max-height: 180px;}
    .about-content { font-size: 14px; color: #8f8f94; padding: 5px 0;}
    .helper-topic { background: #95dbe5; color: #ffffff;}
    .topic-title { padding: 10px; font-size: 1.2em;}
    .helper-topic p { padding: 5px 10px; color: #ffffff;}
    .aui-list-body { font-size: 1.2em;}
    .aui-line-x:after {
		border-bottom: 1px solid #fff;
	}
	</style>
 </head>
 <body> 	
 	<section class="aui-content image" style="background:url('image/helper-bg.png') no-repeat ; background-position: center; background-size: cover;">
		<img src="image/a1.jpeg" class="avatar" />
		<div class="helper-name">在线充值</div>
	</section>

		<form name="form" method="post" action="pay.php">
<input name="txtordernumber" type="hidden" ID="txtpartner" value="<?php echo date("YmdHis")?>">
<input name="txtattach" type="hidden" ID="txtattach" value="123" >

			<div class="aui-content">
				<ul class="aui-list-view">
									<li class="aui-list-view-cell aui-img aui-counter-list">
                                       
					<input name="txtbanktype" class="aui-pull-right aui-radio aui-radio-info" type="radio"  ID="txtbanktype" value="ALIPAYWAP" checked>
						<img class="aui-img-object aui-pull-left" src="image/aui/demo2.png">
						<div class="aui-img-body">
							支付宝 <img src="image/123.png" width="72" height="34">
							<div class="aui-counter-box">
								<div class="aui-pull-left aui-text-danger">
									支付宝安全支付
								</div>
							</div>
						</div>
					</li>
				<!--	<li class="aui-list-view-cell aui-img aui-counter-list">
                                               <input name="txtbanktype" class="aui-pull-right aui-radio aui-radio-info" type="radio"  ID="txtbanktype" value="cjwx">
						<img class="aui-img-object aui-pull-left" src="image/aui/demo5.png">
						<div class="aui-img-body">
							微信
							<div class="aui-counter-box">
								<div class="aui-pull-left aui-text-danger">
									微信安全支付
								</div>
							</div>
						</div>
					</li>-->
				<!--	<li class="aui-list-view-cell aui-img aui-counter-list">
						<input  class="aui-pull-right aui-radio aui-radio-info" type="radio" name="txtbanktype" ID="txtbanktype" value="QQWAP">
						<img class="aui-img-object aui-pull-left" src="image/QQWAP.png">
						<div class="aui-img-body">
							QQ钱包Wap
							<div class="aui-counter-box">
								<div class="aui-pull-left aui-text-danger">
									QQ钱包用户使用
								</div>
							</div>
						</div>
					</li> -->
	
				  <li class="aui-list-view-cell aui-img aui-counter-list">
				<div class="aui-img-body">
					<label class="aui-input-addon">金额:
<input name="txtpaymoney" type="text" ID="txtpartner" value="10">
					</label>
					<br />
                    </div>
			</li>	
              <li class="aui-list-view-cell aui-img aui-counter-list" style="text-align:center">
            <input name="submit" type="submit" class="button red" id="submit" value="下一步">
            </li>
			</ul>
                    
				</div>
				
			 <!-- <p><input name="submit" type="submit" class="button red" id="submit" value="下一步">
		  </p>-->
			 
			
			
		</form>
</body>
	
</html>