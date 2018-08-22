<?php $danhao = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);  ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	
	<title>微信扫码支付接口</title>
	<script type="text/javascript" src="style/js/jquery-1.7.2.min.js"></script>
<link rel="stylesheet" href="css/chinaz.min.css">
<script type="text/javascript">
var mobileAgent = new Array("iphone", "ipod", "ipad", "android", "mobile", "blackberry", "webos", "incognito", "webmate", "bada", "nokia", "lg", "ucweb", "skyfire");
var browser = navigator.userAgent.toLowerCase(); 
var isMobile = false; 
for (var i=0; i<mobileAgent.length; i++){ if (browser.indexOf(mobileAgent[i])!=-1){ isMobile = true; 
//alert(mobileAgent[i]); 
location.href = 'http://demo.390pay.com/wap';
break; } } 
</script>
</head>

<style>
	html,body {
		width:100%;
		min-width:1200px;
		height:auto;
		padding:0;
		margin:0;
		font-family:"微软雅黑";
		background-color:#242736
	}
	.header {
		width:100%;
		margin:0 auto;
		height:150px;
		background-color:#fff
	}
	.container {
		width:100%;
		min-width:100px;
		height:auto
	}
	.black {
		background-color:#242736
	}
	.blue {
		background-color:#0ae
	}
	.qrcode {
		width:1200px;
		margin:0 auto;
		height:30px;
		background-color:#242736
	}
	.littlecode {
		width:16px;
		height:16px;
		margin-top:6px;
		cursor:pointer;
		float:right
	}
	.showqrs {
		top:30px;
		position:absolute;
		width:100px;
		margin-left:-65px;
		height:160px;
		display:none
	}
	.shtoparrow {
		width:0;
		height:0;
		margin-left:65px;
		border-left:8px solid transparent;
		border-right:8px solid transparent;
		border-bottom:8px solid #e7e8eb;
		margin-bottom:0;
		font-size:0;
		line-height:0
	}
	.guanzhuqr {
		text-align:center;
		background-color:#e7e8eb;
		border:1px solid #e7e8eb
	}
	.guanzhuqr img {
		margin-top:10px;
		width:80px
	}
	.shmsg {
		margin-left:10px;
		width:80px;
		height:16px;
		line-height:16px;
		font-size:12px;
		color:#242323;
		text-align:center
	}
	.nav {
		width:1200px;
		margin:0 auto;
		height:70px;
	}
	.open,.logo {
		display:block;
		float:left;
		height:40px;
		width:85px;
		margin-top:20px
	}
	.divier {
		display:block;
		float:left;
		margin-left:20px;
		margin-right:20px;
		margin-top:23px;
		width:1px;
		height:24px;
		background-color:#d3d3d3
	}
	.open {
		line-height:30px;
		font-size:20px;
		text-decoration:none;
		color:#1a1a1a
	}
	.navbar {
		float:right;
		width:500px;
		height:40px;
		margin-top:15px;
		list-style:none
	}
	.navbar li {
		float:left;
		width:100px;
		height:40px
	}
	.navbar li a {
		display:inline-block;
		width:100px;
		height:40px;
		line-height:40px;
		font-size:16px;
		color:#1a1a1a;
		text-decoration:none;
		text-align:center
	}
	.navbar li a:hover {
		color:#00AAEE
	}
	.title {
		width:1200px;
		margin:0 auto;
		height:3px;
		line-height:3px;
		font-size:20px;
		color:#FFF
	}
	.content {
		width:100%;
		min-width:1200px;
		height:660px;
		background-color:#fff;		
	}
	.alipayform {
		width:800px;
		margin:0 auto;
		height:600px;
		border:1px solid #0ae
	}
	.element {
		width:600px;
		height:80px;
		margin-left:100px;
		font-size:20px
	}
	.etitle,.einput {
		float:left;
		height:26px
	}
	.etitle {
		width:150px;
		line-height:26px;
		text-align:right
	}
	.einput {
		width:200px;
		margin-left:20px
	}
	.einput input {
		width:398px;
		height:24px;
		border:1px solid #0ae;
		font-size:16px
	}
	.mark {
        margin-top: 10px;
        width:500px;
        height:30px;
        margin-left:80px;
        line-height:30px;
        font-size:12px;
        color:#999
    }
	.legend {
		margin-left:200px;
		font-size:24px
	}
	.alisubmit {
		width:400px;
		height:40px;
		border:0;
		background-color:#0ae;
		font-size:16px;
		color:#FFF;
		cursor:pointer;
		margin-left:170px
	}
	.footer {
		width:100%;
		height:120px;
		background-color:#242735
	}
	.footer-sub a,span {
		color:#808080;
		font-size:12px;
		text-decoration:none
	}
	.footer-sub a:hover {
		color:#00aeee
	}
	.footer-sub span {
		margin:0 3px
	}
	.footer-sub {
		padding-top:40px;
		height:20px;
		width:600px;
		margin:0 auto;
		text-align:center
	}
</style>
<!--<script> 
function sub(){
document.form1.submit();
}
setTimeout(sub,10000);//以毫秒为单位的.1000代表一秒钟.根据你需要修改这个时间.
</script>
-->
<body>
	<div class="header">
		<div class="container black">
			<div class="qrcode">
				<div class="littlecode">
				</div>		
			</div>
		</div>
		<div class="container">
			<div class="nav">
				<a href="http://www.390pay.com/" class="logo"><img src="style/images/alipay_logo.png" height="30px"></a>
				<span class="divier"></span>
				<a href="#" class="open">Demo</a>
				<ul class="navbar">
				<li><a href="http://demo.390pay.com/" target="_blank">支付宝接口</a></li>
				<li><a href="http://demo.390pay.com/weixin.php" target="_blank">微信支付接口</a></li>
				<li><a href="http://m.390pay.com/" target="_blank">商户登陆</a></li>
					<li><a href="http://m.390pay.com/down/api.rar" target="_blank">下载文档</a></li>
				</ul>
			</div>
		</div>
		<div class="container blue">
			<div class="title"></div>
		</div>
	</div>
	<div class="content">
		<form name='form1' action="pay.php" class="alipayform" method="post" target="_blank">
			<div class="element" style="margin-top:30px;">
				<div class="legend">微信支付接口</div>
			</div>
			<div class="element">
				<div class="etitle">商户订单号:</div>
				<div class="einput"><input type="text" name="txtordernumber" value="<?php echo $danhao?>" readonly></div>
				<br>
				<div class="mark">注意：商户订单号参数名 ordernumber ，建议是英文字母和数字,不能含有特殊字符(必填)</div>
			</div>
			
			<div class="element">
				<div class="etitle">商户号:</div>
				<div class="einput"><input type="text" name="txtpartner" value="17178" readonly></div>
				<br>
				<div class="mark">注意：商户号参数名 partner ，商户中心获取(必填)</div>
			</div>
			
			<div class="element">
				<div class="etitle">密钥:</div>
				<div class="einput"><input type="text" name="txtkey" value="d3b81a4642a00c884f8da472d70a0608" readonly></div>
				<br>
				<div class="mark">注意：密钥参数名 key ，商户中心获取(必填)</div>
			</div>
			
			<div class="element">
				<div class="etitle">付款金额:</div>
				<div class="einput"><input type="text" name="txtpaymoney" value="1"></div>
				<br>
				<div class="mark">注意：付款金额参数名 paymoney(必填)</div>
			</div>
			
			<div class="element">
				<div class="etitle">支付类型:</div>
				<div class="einput"><input type="text" name="txtbanktype" value="WEIXIN"></div>
				<br>
				<div class="mark">注意：支付类型参数名 banktype ，微信扫码支付: WEIXIN(必填)</div>
			</div>

			<div class="element">
				<input type="submit" class="alisubmit" value ="确认支付">
			</div>
		</form>
		
	</div>
	<div class="footer">
		<p class="footer-sub">
		     <span><a href="http://www.390pay.com" target="_blank">云盾支付</a> 版权所有</span>
		    <span class="footer-date">2016-2018</span>
		</p>

		   
	</div>
</body>

</html>