<!-- #include file="ybpMD5.asp" -->
<!-- #include file="merchantProperties.asp" -->
<%
'***********************************************
'* @Description 优宝支付产品通用支付接口范例
'* @Version 1.0
'***********************************************

Dim srcString
Dim checkRst
Dim checkRstString

Dim apiName
Dim notifyTime
Dim tradeAmt
Dim merchNo
Dim merchParam
Dim orderNo
Dim tradeDate
Dim accNo
Dim orderStatus
Dim sigString
Dim notifyType


	
apiName = Request.Form("apiName")
notifyTime = Request.Form("notifyTime")
tradeAmt = Request.Form("tradeAmt")
merchNo = Request.Form("merchNo")
merchParam = Request.Form("merchParam")
orderNo = Request.Form("orderNo")
tradeDate = Request.Form("tradeDate")
accNo = Request.Form("accNo")
orderStatus = Request.Form("orderStatus")
sigString = Request.Form("signMsg")

'组装签名串
srcString = "apiName="&apiName&"&tradeAmt="&tradeAmt&"&merchNo="&merchNo"&orderNo="&orderNo&"&tradeDate="&tradeDate&"&accNo="&accNo&"&orderStatus="&orderStatus
sigString = URLDecode(sigString)

chkResult = StrComp(MD5(srcString & ybpKey), LCase(sigString), 1)
if (chkResult <> 0) then
    Response.Write("验证签名失败")
    Response.Flush
    Response.End
else
    '只有支付成功，当前页面才会被支付系统调用
    '验签通过，表示当前请求来自支付系统，接下来应该处理支付成功后响应的业务逻辑
    '例如：减少库存，标记订单为已支付等   
    '以下代码处理支付系统后台通知--服务器点对点通知
 	 if (orderStatus == 1 ) then
	 	Response.Write("支付成功")
     	Response.Flush
     	Response.End
	 else
	 	Response.Write("支付失败")
     	Response.Flush
     	Response.End
	 end if
     
 
end if
%>