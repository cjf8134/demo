<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>扫码支付Demo</title>
</head>
<body>
	<form id="submitForm" method="post" name="submitFomm" action="scanPay" style="margin-left: 40%;margin-top: 40px;">
		<label>商家订单号</label>
		<input  type="text" id="mer_order_no" name="mer_order_no" />
		</br>
		<label>交易金额</label>
		<input  type="text" id="trade_amount"  value="" name="trade_amount"/>
		</br>											
		<label>商户代码</label>
		<input  type="text" id="mer_no" value=""  name="mer_no"/>
		</br>												
		<label>业务类型</label>
		<select class="col-sm-6" id="service_type" name="service_type">
			<option value="weixin_scan">微信扫码</option>
			<option value="alipay_scan">支付宝扫码</option>
			<option value="qq_scan">QQ扫码</option>
			<option value="jd_scan">京东扫码</option>
		</select>
		</br>									
		<input type="submit" value="支付" >											
	</form>
</body>
</html>