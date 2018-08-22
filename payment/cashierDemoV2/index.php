<!DOCTYPE html>
<html>
<?php header("Content-Type:text/html;charset=GB2312");
?>
<head>
<!-- <title>����ͳͳ��wap��׼�����µ��ӿ�</title> -->
<title>����ͳͳ��web��׼�����µ��ӿ�</title>
<meta http-equiv="Content-Type" content="text/html; charset=GB2312">
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
	font-family: '����';
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
				<a target="_blank" href="http://www.sumpay.cn/"><span>������ҳ</span></a>|
				<a target="_blank" href="http://www.sumpay.cn/portal/merchServer.do"><span>�̼ҷ���</span></a>|
				<a target="_blank"
					href="http://www.sumpay.cn/portal/pages/help/helpCenter.html"><span>��������</span></a>
			</dl>
<!-- 			<span class="title">����ͳͳ��wap��׼�����µ��ӿڣ���ʹ���ֻ�����wap����̨</span> -->
			<span class="title">����ͳͳ��web��׼�����µ��ӿ�</span>
		</div>
		<div class="cashier-nav">
			<ol>
				<li class="current">1��ȷ����Ϣ ��</li>
				<li>2�����ȷ�� ��</li>
				<li class="last">3��ȷ�����</li>
			</ol>
		</div>
		<form id="form" name=sumpayment action=sumpayapi.jsp method=post > <!-- target="_blank" -->
			<div id="body" style="clear: left">
				<dl class="content">
                    <dt>�̻���ţ�</dt>
					<dd>
						<span class="null-star">*</span> 
						<span class="null-star"></span> <input size="10" id="merId" name="merId" type="text" value="100001465"/> <span>�̻����  ���� </span>
					</dd>
                    <dt>�����û���</dt>
					<dd>
						<span class="null-star">*</span> 
						<input size="10" id="userId" name="userId" type="text" value="710000<?php 
						echo mt_rand(1000,9990);
						?>" />
						<span>�û����̻�ϵͳ�е�Ψһ��ʶ�����̻�ϵͳ�о���Ψһ��  ���� </span>
					</dd>

					<dt>�����̻���ţ�</dt>
					<dd>
						<span class="null-star"></span> <input size="10" id="subMerId"  name="subMerId" type="text" /> <span>�����̻����</span>
					</dd>

					<dt>�����룺</dt>
					<dd>
						<span class="null-star"></span> <input size="10" id="tradeCode" name="tradeCode"
							type="text" value="T0002" /> <span>�������ף�T0001��ʱ���ף�T0002ϵͳĬ��Ϊ��ʱ����
						</span>
					</dd>
					<dt>�����ţ�</dt>
					<dd>
						<span class="null-star">*</span> <input size="30" id="orderNo" name="orderNo"
							type="text" value="D1001<?php 
							echo mt_rand(1000000, 9999999);
							?>" /> <span>�������룬���̻�ϵͳΨһ��
							���� </span>
					</dd>
					
					<dt>����ʱ�䣺</dt>
					<dd>
						<span class="null-star">*</span> <input size="30" name="orderTime"
							type="text" id="orderTime" value="<?php 
							date_default_timezone_set("Asia/Shanghai");
							echo date('YmdHis');
							?>" /> <span>����</span>
					</dd>

					<dt>������</dt>
					<dd>
						<span class="null-star">*</span> <input size="10" name="orderAmt"
							type="text" id="orderAmt" value="1.25" /> <span>����</span>
					</dd>

					<dt>���֣�</dt>
					<dd>
						<span class="null-star"></span> <input size="10" name="curType"
							type="text" id="curType" value="CNY" />
					</dd>

					<dt>��Ʒ���ƣ�</dt>
					<dd>
						<span class="null-star">*</span> <input size="30" id="goodsName" name="goodsName"
							type="text" value="Preety Toy" /> <span>����</span>
					</dd>


					<dt>��Ʒ������</dt>
					<dd>
						<span class="null-star">*</span> <input size="30" id="goodsNum" name="goodsNum"
							type="text" value="2" /> <span>����</span>
					</dd>


					<dt>��Ʒ���ͣ�</dt>
					<dd>
						<span class="null-star">*</span> <input size="30" id="goodsType"name="goodsType"
							type="text" value="1" /> <span>1��ʵ����Ʒ��2��������Ʒ ����</span>
					</dd>

					<!-- <dt>�Ƿ�������</dt>
					<dd>
						<span class="null-star"></span> <input size="30" name="logistics"
							type="text" value="0" /> <span>1����;0���� </span>
					</dd> -->

					<!-- <dt>�ջ���ַ��</dt>
					<dd>
						<span class="null-star"></span> <input size="30" name="address"
							type="text" value="HangZhou" /> <span></span>
					</dd> -->

					<dt>����������</dt>
					<dd>
						<span class="null-star"></span> <input size="60" name="domain"
							type="text" value="www.baidu.com" /> <span> </span>
					</dd>

					<dt>��ע�ֶΣ�</dt>
					<dd>
						<span class="null-star"></span> <input size="30" id="remark" name="remark"
							type="text" value="HangZhou" /> <span> </span>
					</dd>
					
					<dt>��չ�ֶΣ�</dt>
					<dd>
						<span class="null-star"></span> <input size="30" id="extension" name="extension"
							type="text" value="" /> <span></span>
					</dd>
					<dt>�Ƿ���Ҫ�̻�ǰ̨֪ͨ��</dt>
					<dd>
						<span class="null-star"></span>
						<select id="needReturn" style="width:243px;" name="needReturn">
							<option value="0" >��</option>
							<option value="1" selected="true">��</option>
						</select>
						<span></span>
					</dd>
					
					<dt>retutnUrl��</dt>
					<dd>
						<span class="null-star"></span> <input size="60" id="returnUrl" name="returnUrl"
							type="text" value="http://192.168.31.148:8007/cashierDemoForPhp/return_url.php" /> 
					</dd>
					
					<dt>�Ƿ���Ҫ�̻���̨֪ͨ��</dt>
					<dd>
						<span class="null-star"></span>
						<select id="needNotify" style="width:243px;" name="needNotify">
							<option value="0" >��</option>
							<option value="1" selected="true">��</option>
						</select>
						<span></span>
					</dd>
					
					<dt>notifyUrl��</dt>
					<dd>
						<span class="null-star"></span> <input size="60" name="notifyUrl" id="notifyUrl"
							type="text" value="http://192.168.31.148:8007/cashierDemoForPhp/notify_url.php" /> 
					</dd>
					
					<dt>�̻�logoͼƬ��ַ��</dt>
					<dd>
						<span class="null-star"></span> <input size="60" name="img_url"
							type="text" value="https://wechattest.sumpay.cn/wapcashier/static/images/fxqb.png" /> <span></span>
					</dd>
					
					<dt>���֤��</dt>
					<dd>
						<span class="null-star">*</span> <input size="30" name="idCardNo" id="idCardNo"
							type="text" value="" /> <span></span>
					</dd>
					<dt>������</dt>
					<dd>
						<span class="null-star">*</span> <input size="30" name="realname" id="realname"
							type="text" value="" /> <span></span>
					</dd>
					
					<dt>֧��������</dt>
					<dd>
						<span class="null-star">*</span> <input size="30" name="pay_channels" id="pay_channels"
							type="text" value="03-2,16-2,02-2,01-0,10-2,09-2" /> <span>Ϊ�ձ�ʾ��֧��</span>
					</dd>
					
					<dt>�̻������ֶΣ�</dt>
					<dd>
						<span class="null-star"></span> <input size="30" name="attach" id="attach"
							type="text" value="a=b&c=d" /> <span></span>
					</dd>
					
					<dt>����̨���ͣ�</dt>
					<dd>
						<span class="null-star"></span>
						<select id="cashier_type" style="width:243px;" name="cashier_type">
							<option value="web" >web����̨</option>
							<option value="wap" selected="true">wap����̨</option>
						</select>
						<span></span>
					</dd>

					<dt>��ת���ӣ�</dt>
					<dd>
						<span class="null-star">*</span> <input size="60" name="url" id="url"
						 	type="text" value="http://101.71.243.74:8180/entrance/gateway.htm" /> <span>����</span>
					</dd>
					
					<dt></dt>
					<dd>
						<span class="new-btn-login-sp">
							<button class="new-btn-login" type="button" onclick="sub('submit')"
								style="text-align: center;">ȷ ��</button>
						</span>
					</dd>
				</dl>
			</div>
		</form>
		<div id="foot">
			<ul class="foot-ul">
				<li><font class="note-help">����������ȷ�ϡ���ť������ʾ��ͬ��ôε�ִ�в����� </font></li>
				<li>����ͳͳ����Ȩ���� 2007-2015 SUMPAY.CN</li>
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