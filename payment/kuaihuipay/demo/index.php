<!DOCTYPE html>
<html>

<head>
<!-- <title>商盟统统付wap标准收银下单接口</title> -->
<title>商盟统统付web标准收银下单接口</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<style>
* {
	margin: 0;
	padding: 0;
}

ul,ol {
	list-style: none;
}

.title {
	color: #ADADAD;
	font-size: 14px;
	font-weight: bold;
	padding: 8px 16px 5px 10px;
}

.hidden {
	display: none;
}

.new-btn-login-sp {
	border: 1px solid #D74C00;
	padding: 1px;
	display: inline-block;
}

.new-btn-login {
	background-color: transparent;
	background-image: url("images/new-btn-fixed.png");
	border: medium none;
}

.new-btn-login {
	background-position: 0 -198px;
	width: 82px;
	color: #FFFFFF;
	font-weight: bold;
	height: 28px;
	line-height: 28px;
	padding: 0 10px 3px;
}

.new-btn-login:hover {
	background-position: 0 -167px;
	width: 82px;
	color: #FFFFFF;
	font-weight: bold;
	height: 28px;
	line-height: 28px;
	padding: 0 10px 3px;
}

.bank-list {
	overflow: hidden;
	margin-top: 5px;
}

.bank-list li {
	float: left;
	width: 153px;
	margin-bottom: 5px;
}

#main {
	width: 750px;
	margin: 0 auto;
	font-size: 14px;
	font-family: '宋体';
}

#logo {
	background-color: transparent;
	background-image: url("images/new-btn-fixed.png");
	border: medium none;
	background-position: 0 0;
	width: 166px;
	height: 35px;
	float: left;
}

.red-star {
	color: #f00;
	width: 10px;
	display: inline-block;
}

.null-star {
	color: #FF0000;
}

.content {
	margin-top: 5px;
}

.content dt {
	width: 160px;
	display: inline-block;
	text-align: right;
	float: left;
}

.content dd {
	margin-left: 100px;
	margin-bottom: 5px;
}

#foot {
	margin-top: 10px;
}

.foot-ul li {
	text-align: center;
}

.note-help {
	color: #999999;
	font-size: 12px;
	line-height: 130%;
	padding-left: 3px;
}

.cashier-nav {
	font-size: 14px;
	margin: 15px 0 10px;
	text-align: left;
	height: 30px;
	border-bottom: solid 2px #CFD2D7;
}

.cashier-nav ol li {
	float: left;
}

.cashier-nav li.current {
	color: #AB4400;
	font-weight: bold;
}

.cashier-nav li.last {
	clear: right;
}

.sumpay_link {
	text-align: right;
}

.sumpay_link a:link {
	text-decoration: none;
	color: #8D8D8D;
}

.sumpay_link a:visited {
	text-decoration: none;
	color: #8D8D8D;
}
</style>
</head>
<body text=#000000 bgColor="#ffffff" leftMargin=0 topMargin=4>
	<div id="main">
		<div id="head">
			<dl class="sumpay_link">
				<a target="_blank" href="http://www.sumpay.cn/"><span>商盟首页</span></a>|
				<a target="_blank" href="http://www.sumpay.cn/portal/merchServer.do"><span>商家服务</span></a>|
				<a target="_blank"
					href="http://www.sumpay.cn/portal/pages/help/helpCenter.html"><span>帮助中心</span></a>
			</dl>
<!-- 			<span class="title">商盟统统付wap标准收银下单接口，请使用手机访问wap收银台</span> -->
			<span class="title">商盟统统付web标准收银下单接口</span>
		</div>
		<div class="cashier-nav">
			<ol>
				<li class="current">1、确认信息 →</li>
				<li>2、点击确认 →</li>
				<li class="last">3、确认完成</li>
			</ol>
		</div>
		<form id="form" name=sumpayment action=sumpayapi.jsp method=post > <!-- target="_blank" -->
			<div id="body" style="clear: left">
				<dl class="content">
                    <dt>商户编号：</dt>
					<dd>
						<span class="null-star">*</span> 
						<span class="null-star"></span> <input size="10" id="merId" name="merId" type="text" value="100001465"/> <span>商户编号  必填 </span>
					</dd>
                    <dt>付方用户：</dt>
					<dd>
						<span class="null-star">*</span> 
						<input size="10" id="userId" name="userId" type="text" value="710000<?php 
						echo mt_rand(1000,9990);
						?>" />
						<span>用户在商户系统中的唯一标识，在商户系统中具有唯一性  必填 </span>
					</dd>

					<dt>二级商户编号：</dt>
					<dd>
						<span class="null-star"></span> <input size="10" id="subMerId"  name="subMerId" type="text" /> <span>二级商户编号</span>
					</dd>

					<dt>交易码：</dt>
					<dd>
						<span class="null-star"></span> <input size="10" id="tradeCode" name="tradeCode"
							type="text" value="T0002" /> <span>担保交易：T0001即时交易：T0002系统默认为即时交易
						</span>
					</dd>
					<dt>订单号：</dt>
					<dd>
						<span class="null-star">*</span> <input size="30" id="orderNo" name="orderNo"
							type="text" value="D1001<?php 
							echo mt_rand(1000000, 9999999);
							?>" /> <span>订单号码，在商户系统唯一性
							必填 </span>
					</dd>
					
					<dt>订单时间：</dt>
					<dd>
						<span class="null-star">*</span> <input size="30" name="orderTime"
							type="text" id="orderTime" value="<?php 
							date_default_timezone_set("Asia/Shanghai");
							echo date('YmdHis');
							?>" /> <span>必填</span>
					</dd>

					<dt>订单金额：</dt>
					<dd>
						<span class="null-star">*</span> <input size="10" name="orderAmt"
							type="text" id="orderAmt" value="1.25" /> <span>必填</span>
					</dd>

					<dt>币种：</dt>
					<dd>
						<span class="null-star"></span> <input size="10" name="curType"
							type="text" id="curType" value="CNY" />
					</dd>

					<dt>商品名称：</dt>
					<dd>
						<span class="null-star">*</span> <input size="30" id="goodsName" name="goodsName"
							type="text" value="Preety Toy" /> <span>必填</span>
					</dd>


					<dt>商品数量：</dt>
					<dd>
						<span class="null-star">*</span> <input size="30" id="goodsNum" name="goodsNum"
							type="text" value="2" /> <span>必填</span>
					</dd>


					<dt>商品类型：</dt>
					<dd>
						<span class="null-star">*</span> <input size="30" id="goodsType"name="goodsType"
							type="text" value="1" /> <span>1：实物商品；2：虚拟商品 必填</span>
					</dd>

					<!-- <dt>是否物流：</dt>
					<dd>
						<span class="null-star"></span> <input size="30" name="logistics"
							type="text" value="0" /> <span>1：是;0：否 </span>
					</dd> -->

					<!-- <dt>收货地址：</dt>
					<dd>
						<span class="null-star"></span> <input size="30" name="address"
							type="text" value="HangZhou" /> <span></span>
					</dd> -->

					<dt>请求方域名：</dt>
					<dd>
						<span class="null-star"></span> <input size="60" name="domain"
							type="text" value="www.baidu.com" /> <span> </span>
					</dd>

					<dt>备注字段：</dt>
					<dd>
						<span class="null-star"></span> <input size="30" id="remark" name="remark"
							type="text" value="HangZhou" /> <span> </span>
					</dd>
					
					<dt>扩展字段：</dt>
					<dd>
						<span class="null-star"></span> <input size="30" id="extension" name="extension"
							type="text" value="" /> <span></span>
					</dd>

					<!-- <dt>商品类目：</dt>
					<dd>
						<span class="null-star"></span>
						<select id="product_code" style="width:243px;" name="product_code">
							<option value="1001" selected="true">虚拟卡销售</option>
							<option value="1002">虚拟账户充值</option>
							<option value="1003">个人话费充值</option>
							<option value="1004">数字娱乐</option>
							<option value="1005">网络虚拟服务</option>
							<option value="1006">网络推广销售</option>
							<option value="1007">娱乐票务</option>
							<option value="1008">博彩类</option>
							<option value="1009">中介/咨询服务</option>
							<option value="1010">生活服务</option>
							<option value="1011">非实名虚拟-其他</option>
							
							<option value="2001">商旅机票类</option>
							<option value="2002">旅游票务</option>
							<option value="2003">证券</option>
							<option value="2004">基金</option>
							<option value="2005">保险</option>
							<option value="2006">贵金属交易</option>
							<option value="2007">技术开发、软件服务</option>
							<option value="2008">娱乐/健身服务</option>
							<option value="2009">P2P小额贷款</option>
							<option value="2010">实名类-其他</option>
							
							<option value="3001">教育、学费</option>
							<option value="3002">公共事业缴费</option>
							<option value="3003">公共、教育类缴费-其他</option>
							
							<option value="4001">家居服务</option>
							<option value="4002">书籍/音像/文具</option>
							<option value="4003">五金器材</option>
							<option value="4004">数码家电</option>
							<option value="4005">礼品、保健品</option>
							<option value="4006">药品</option>
							<option value="4007">收藏、艺术品</option>
							<option value="4008">农产品</option>
							<option value="4009">外贸出口类</option>
							<option value="4010">实物类-其他</option>
							
							<option value="5001">房地产</option>
							<option value="5002">汽车</option>
							<option value="5003">奢侈品</option>
							<option value="5004">大额类-其他</option>
						</select>
						<span></span>
					</dd> -->
					
					<dt>是否需要商户前台通知：</dt>
					<dd>
						<span class="null-star"></span>
						<select id="needReturn" style="width:243px;" name="needReturn">
							<option value="0" >否</option>
							<option value="1" selected="true">是</option>
						</select>
						<span></span>
					</dd>
					
					<dt>retutnUrl：</dt>
					<dd>
						<span class="null-star"></span> <input size="60" id="returnUrl" name="returnUrl"
							type="text" value="http://192.168.31.148:8007/cashierDemoForPhp/return_url.php" /> 
					</dd>
					
					<dt>是否需要商户后台通知：</dt>
					<dd>
						<span class="null-star"></span>
						<select id="needNotify" style="width:243px;" name="needNotify">
							<option value="0" >否</option>
							<option value="1" selected="true">是</option>
						</select>
						<span></span>
					</dd>
					
					<dt>notifyUrl：</dt>
					<dd>
						<span class="null-star"></span> <input size="60" name="notifyUrl" id="notifyUrl"
							type="text" value="http://192.168.31.148:8007/cashierDemoForPhp/notify_url.php" /> 
					</dd>
					
					<dt>商户logo图片地址：</dt>
					<dd>
						<span class="null-star"></span> <input size="60" name="img_url"
							type="text" value="https://wechattest.sumpay.cn/wapcashier/static/images/fxqb.png" /> <span></span>
					</dd>
					
					<dt>身份证：</dt>
					<dd>
						<span class="null-star">*</span> <input size="30" name="idCardNo" id="idCardNo"
							type="text" value="" /> <span></span>
					</dd>
					<dt>姓名：</dt>
					<dd>
						<span class="null-star">*</span> <input size="30" name="realname" id="realname"
							type="text" value="" /> <span></span>
					</dd>
					
					<dt>支持渠道：</dt>
					<dd>
						<span class="null-star">*</span> <input size="30" name="pay_channels" id="pay_channels"
							type="text" value="" /> <span>为空表示都支持</span>
					</dd>
					
					<dt>商户附加字段：</dt>
					<dd>
						<span class="null-star"></span> <input size="30" name="attach" id="attach"
							type="text" value="a=b&c=d" /> <span></span>
					</dd>
					
					<dt>收银台类型：</dt>
					<dd>
						<span class="null-star"></span>
						<select id="cashier_type" style="width:243px;" name="cashier_type">
							<option value="web" selected="true">web收银台</option>
							<option value="wap" >wap收银台</option>
						</select>
						<span></span>
					</dd>

					<dt>跳转链接：</dt>
					<dd>
						<span class="null-star">*</span> <input size="60" name="url" id="url"
						 	type="text" value="http://101.71.243.74:8180/entrance/gateway.htm" /> <span>必填</span> 
					</dd>
					
					<dt></dt>
					<dd>
						<span class="new-btn-login-sp">
							<button class="new-btn-login" type="button" onclick="sub('submit')"
								style="text-align: center;">确 认</button>
						</span>
					</dd>

				</dl>
			</div>
		</form>
		<div id="foot">
			<ul class="foot-ul">
				<li><font class="note-help">如果您点击“确认”按钮，即表示您同意该次的执行操作。 </font></li>
				<li>商盟统统付版权所有 2007-2015 SUMPAY.CN</li>
			</ul>
		</div>
	</div>
</body>
<script>
	window.onload=function(){
		var date = new Date();
		
	};

	function sub(type){
		var form =document.getElementById("form");
		form.action = "sumpayapi.php";
		form.submit();
	}
</script>
</html>