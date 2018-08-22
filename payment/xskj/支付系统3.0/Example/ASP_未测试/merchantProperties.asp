<%

'***********************************************
'* @Description 优宝支付产品通用支付接口范例
'* @Version 1.0
'***********************************************

Dim ybpKey
Dim payUrl
Dim returnUrl
Dim notifyUrl
Dim merchPlatformId
Dim merchAccNo
Dim apiname_pay
Dim apiname_query
Dim apiname_refund
Dim api_version
Dim logName

'商户MD5密钥，切换到正式环境需要替换为正式密钥
ybpKey = "22c41d776c24deddca95b1709a88f04b"
'商户用地址-测试
payUrl = "http://cto.xskjpay.net/pay.php"
'商户用地址-正式
'payUrl = "https://trade.uospay.com/cgi-bin/netpayment/pay_gate.cgi";
'商户接受支付通知地址(商户自己系统的地址,必须是公网地址，否则无法收到支付结果通知)
returnUrl = "http://192.168.31.234/ASP/callBack.asp"
notifyUrl = "http://192.168.31.234/ASP/notify.asp"
'商户平台号及商户帐号
merchPlatformId = "311"
merchAccNo = "ceshi@qq.com"
'日志文件名
logFileName = "merchtest"

'以下配置项不需要修改
apiname_pay = "WWW_PAY"
apiname_query = "TRAN_QUERY"
apiname_refund = "TRAN_RETURN"
api_version = "V.1.0.0"

%>