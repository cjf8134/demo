欢迎您使用支付平台提供的支付接入服务。此目录是PHP样本代码(MD5签名版)。

1)关键文件列表说明
|---pay.Config.php	    (共通配置文件，正式请求地址在此文件中修改，商家可以在此文件中修改商家的ID和密钥和支付通知地址等信息)
|---lib/pay.class.php	(共通交易函数文件，做签名和验证签名及交易相关处理)
|---pay.php			        (支付请求处理文件，通过此文件发起支付请求，商家可以在此文件中处理订单信息等，然后把请求提交给支付平台)
|---callback.php	        (支付结果通知处理文件，通过此文件商家判断对应订单的支付成功状态，并且根据结果修改自己数据库中的订单状态)
|---query.php               (订单信息查询接口样例)

2)商家测试可以先用支付平台的测试商家测试成功，再在pay.Config.php文件中修改成自己的商家ID和私钥密码信息
$merchant_acc = "";
$platform_id = "";
$ybp_key = "";

3)共通文件采用服务器包含的方式进行处理
如：
	require_once("pay.Config.php");
	require_once("lib/pay.class.php");

4) 中文商品名称请注意使用UTF-8编码


集成测试步骤简要说明
1)将pay.Config.php添加到工程中，并根据注释修改相应设置。
2)将lib/pay.class.php添加到工程中。
3)设置PHP支持CURL扩展。
4)支付接口调试请参考
	normalPay.php		支付请求订单表单样例
	pay.php			支付请求处理文件
	callback.php		支付结果同步通知及异步通知处理文件
5)支付订单查询接口调试请参考
	queryOrd.php		支付订单查询表单样例
	query.php		支付订单查询处理文件
