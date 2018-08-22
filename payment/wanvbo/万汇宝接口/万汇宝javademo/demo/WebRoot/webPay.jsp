<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>web支付Demo</title>
</head>
<body>
	<form id="submitForm" method="post" name="submitFomm" target="_blank" action="webPay" style="margin-left: 40%;margin-top: 40px;">
		<label>商家订单号</label>
		<input  type="text" id="mer_order_no" name="mer_order_no" />
		</br>
		<label>银行code</label>
		<input  type="text" id="channel_code" name="channel_code"  value=""/>
		</br>										
		<label>银行卡号</label>
		<input  type="text" id="card_no" name="card_no"  value=""/>
		</br>												
		<label>交易金额</label>
		<input  type="text" id="trade_amount"  value="" name="trade_amount"/>
		</br>											
		<label>商户代码</label>
		<input  type="text" id="mer_no" value=""  name="mer_no"/>
		</br>												
		<label>业务类型</label>
		<select class="col-sm-6" id="service_type" name="service_type">
				<option value="b2c">B2C网关</option>
				<option value="quick-web">快捷支付-web模式</option>
		</select>
		</br>									
		<input type="submit" value="支付" >											
	</form>
</body>
</html>