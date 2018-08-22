<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; pageEncoding=UTF-8; charset=UTF-8">
<style>
.show {
	width: 200px;
	height: 340px;
	background-color: white;
	float: left;
	margin-top: 100px;
	z-index: 80;
	position: absolute;
}

.show .up {
	width: 200px;
	height: 60px;
	float: left;
	background-color: #0066FF;
	text-align: center;
	line-height: 60px;
	color: #DEDEDE;
}

a {
	text-decoration: none;
	color: #778899;
	margin-top: 15px;
	margin-left: 15px;
}

.show .down div {
	width: 198px;
	height: 38px;
	float: left;
	border: 1px solid #DDDDDD;
	line-height: 40px;
	margin-top: 0px;
}

.show .down {
	width: 200px;
	height: 480px;
	float: left;
	background-color: #CDC9C9;
}
</style>
<title>易付宝PC端下单支付接口快速通道</title>
<link type="text/css" rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="cont">

    <div class="main">
    
	<div
		style="margin-top: 60px; width: 100%; height: 680px; border: 0px solid #EBEBEB">
		<p
		style="margin-left: 300px; margin-top: -0px; font-size: 28px; color: #787878; float: left">易付宝网银网关接入功能DEMO功能列表</p>
		<div class="show" style="margin-left: 70px">
			<div class="up">支付相关</div>
			<div class="down">
				<div>
					<a target="_blank" href="./pay/ebppPCPay.php"><span>PC在线支付(收银台模式)</span></a>
				<div>
					<a target="_blank" href="./pay/ebpgPCPay.php"><span>PC在线支付(API模式)</span></a>
				</div>
				<div>
					<a target="_blank" href="./refund/refundOrder.php"><span>退款</span></a>
				</div> 
				</div>
			</div>
		</div>
		<div class="show" style="margin-left: 280px;">
			<div class="up">订单相关</div>
			<div class="down">
				<div>
					<a target="_blank" href="./query/queryOrder.php"><span>查询订单</span></a>
				</div>
				<div>
					<a target="_blank" href="./revise/reviseOrder.php"><span>修改订单</span></a>
				</div>
				<div>
					<a target="_blank" href="./close/closeOrder.php"><span>关闭订单</span></a>
				</div>
			</div>
		</div>
</div>

<div class="foot">
    <div class="foot-bd">
        Copyright &copy; 2002-2015 All Rights Reserved. 苏宁版权所有
    </div>
</div>
</div>
</body>
</html>