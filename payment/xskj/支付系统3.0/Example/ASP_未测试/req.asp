<!-- #include file="ybpMD5.asp" -->
<!-- #include file="merchantProperties.asp" -->
<%
'***********************************************
'* @Description 付产品通用支付接口范例
'* @Version 1.0
'***********************************************
Dim apiName
Dim apiVersion
Dim platformID
Dim merchNo
Dim orderNo
Dim tradeDate
Dim amt
Dim merchParam
Dim tradeSummary
Dim bankCode
Dim payType
Dim srcMsg
Dim signMsg

apiName = apiname_pay
apiVersion = api_version
platformID = merchPlatformId
merchNo = merchAccNo
orderNo = request("orderNo")
tradeDate = request("tradeDate")
amt = request("amt")
merchParam = Server.UrlEncode(request("merchParam"))
tradeSummary = request("tradeSummary")

payType = request("payType")  '支付通道方式，分网银，支付宝，微信  为空则到收银台
bankCode = request("bankCode")   '银行编号，

'apiName=%s&apiVersion=%s&platformID=%s&merchNo=%s&orderNo=%s&tradeDate=%s&amt=%s&notifyUrl=%s&returnUrl=%s&merchParam=%s
srcMsg = "apiName=" & apiName
srcMsg = srcMsg & "&apiVersion=" & apiVersion
srcMsg = srcMsg & "&platformID=" & platformID
srcMsg = srcMsg & "&merchNo=" & merchNo
srcMsg = srcMsg & "&orderNo=" & orderNo
srcMsg = srcMsg & "&tradeDate=" & tradeDate
srcMsg = srcMsg & "&tradeAmt=" & amt
srcMsg = srcMsg & "&notifyUrl=" & notifyUrl
srcMsg = srcMsg & "&returnUrl=" & returnUrl
srcMsg = srcMsg & "&merchParam=" & merchParam


signMsg = MD5(srcMsg&ybpKey)

%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>To pay Page</title>
</head>
<body onLoad="document.pay.submit()">
	<form name="pay" action="<%=payUrl%>" method="post" accept-charset="UTF-8" target="_self">
		<input type="hidden" name="apiName" value="<%=apiName%>">
		<input type="hidden" name="apiVersion" value="<%=apiVersion%>">
		<input type="hidden" name="platformID" value="<%=platformID%>">
		<input type="hidden" name="merchNo" value="<%=merchNo%>">
		<input type="hidden" name="orderNo" value="<%=orderNo%>">
		<input type="hidden" name="tradeDate" value="<%=tradeDate%>">
		<input type="hidden" name="tradeAmt" value="<%=amt%>">
		<input type="hidden" name="notifyUrl" value="<%=notifyUrl%>">
        <input type="hidden" name="returnUrl" value="<%=returnUrl%>">
		<input type="hidden" name="merchParam" value="<%=merchParam%>">
		<input type="hidden" name="tradeSummary" value="<%=tradeSummary%>">
		<input type="hidden" name="signMsg" value="<%=signMsg%>">
		<input type="hidden" name="bankCode" value="<%=bankCode%>">
        <input type="hidden" name="payType" value="<%=payType%>">
	</form>
</body>
</html>