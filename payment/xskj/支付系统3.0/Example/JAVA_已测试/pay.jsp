<%@page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@page import="java.io.PrintWriter"%>
<%@page import="java.security.*"%>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>跳转中...</title>
	</head>
	<%
	
	request.setCharacterEncoding("utf-8");
	String payUrl = "http://cto.xskjpay.net/pay.php";	//支付网关地址
	String key = "508C1BB548B7998279634AC08230C8F";
	
	String apiName = "WWW_PAY";	//接口名称
	String apiVersion = "V.1.0.0";	//接口版本号
	String platformID = "10352";	//商户接口编号，请根据开户信息填写
	String merchNo = "8837544@qq.com";	//商户帐号，请根据开户信息填写
	String orderNo = request.getParameter("orderNo");	//请求订单号，不可重复
	String tradeDate = request.getParameter("tradeDate");	//交易日期
	float  amtt=Float.parseFloat(request.getParameter("tradeAmt"));
	java.text.DecimalFormat df = new java.text.DecimalFormat("#.00");
	String amt=df.format(amtt); //订单金额,必须保留2位小数
	String notifyUrl = "http://www.xxx.com/ybpay/notify.jsp";	//异步通知地址
	String returnUrl = "http://www.xxx.com/ybpay/callback.jsp";	//同步通知地址
	String merchParam = request.getParameter("merchParam");	//订单参数，跟随通知返回
	String tradeSummary = request.getParameter("tradeSummary");	//订单描述
	String bankCode = request.getParameter("bankCode");	//银行编号
	String payType = request.getParameter("payType");	//通道编号
	
	//组装待签名
	String preStr="apiName="+apiName+"&apiVersion="+apiVersion+"&platformID="+platformID+"&merchNo="+merchNo+"&orderNo="+orderNo+"&tradeDate="+tradeDate+"&tradeAmt="+amt+"&notifyUrl="+notifyUrl+"&returnUrl="+returnUrl+"&merchParam="+merchParam+key;
	
	//计算签名
	MessageDigest md5 = MessageDigest.getInstance("MD5");
	byte[] sign = md5.digest(preStr.getBytes("UTF-8"));
	StringBuffer ret = new StringBuffer(sign.length);
	String hex = "";
	for (int i = 0; i < sign.length; i++) {
		hex = Integer.toHexString(sign[i] & 0xFF);

		if (hex.length() == 1) {
				hex = '0' + hex;
		}
		ret.append(hex);
	}
	
	String signMsg = ret.toString();
		
	
	%>
    
    
	<body>
    <form action="<% out.print(payUrl); %>" name="payform" method="post" target="_self">
    
    <input type='hidden' name='apiName' value='<% out.print(apiName); %>'>
    <input type='hidden' name='apiVersion' value='<% out.print(apiVersion); %>'>
    <input type='hidden' name='platformID' value='<% out.print(platformID); %>'>
    <input type='hidden' name='merchNo' value='<% out.print(merchNo); %>'>
    <input type='hidden' name='orderNo' value='<% out.print(orderNo); %>'>
    <input type='hidden' name='tradeDate' value='<% out.println(tradeDate); %>'>
    <input type='hidden' name='tradeAmt' value='<% out.print(amt); %>'>
    <input type='hidden' name='notifyUrl' value='<% out.print(notifyUrl); %>'>
    <input type='hidden' name='returnUrl' value='<% out.print(returnUrl); %>'>
    <input type='hidden' name='merchParam' value='<% out.print(merchParam); %>'>
    <input type='hidden' name='tradeSummary' value='<% out.print(tradeSummary); %>'>
    <input type='hidden' name='bankCode' value='<% out.print(bankCode); %>'>
    <input type='hidden' name='payType' value='<% out.print(payType); %>'>
    <input type='hidden' name='signMsg' value='<% out.print(signMsg); %>'>
    <input type="submit" value="submit">
    
    </form>
	</body>
</html>


