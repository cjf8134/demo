<?php

	/* *
	 *功能：易付宝退款接口调试入口页面
	 *版本：1.0
	 *日期：2015-07-13
	 *说明：
	 *以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
	 *界面暂时列出了参数中的一部分，商户可以根据业务来添加需要界面输入的内容，其他固定参数可以在后台拼接。
	 */

?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; pageEncoding=UTF-8; charset=UTF-8">
<title>易付宝退款接口快速通道</title>
<link type="text/css" rel="stylesheet" href="../css/style.css">
</head>
<body>
<script src="../js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="../js/WdatePicker.js"></script>
<script>
function refund()
{
	var refundOrderNo = document.forms[0].refundOrderNo.value;
	var origOutOrderNo = document.forms[0].origOutOrderNo.value;
	var refundOrderTime = document.forms[0].refundOrderTime.value;
	var origOrderTime = document.forms[0].origOrderTime.value;
	var refundOrderTime = document.forms[0].refundOrderTime.value;
	var refundAmount = document.forms[0].refundAmount.value;
	var refundReason = document.forms[0].refundReason.value;
	var url = 'refundOrderApi.php?refundOrderNo=' + refundOrderNo + "&origOutOrderNo=" + origOutOrderNo
	+ '&refundOrderTime=' + refundOrderTime + '&origOrderTime=' + origOrderTime
	+ '&refundOrderTime=' + refundOrderTime + '&refundAmount=' + refundAmount + '&refundReason=' + refundReason;
	$(window.parent.document).find("#resultframe").attr("src",url);
}
</script>

<div class="step">
    <span class="pass">1、确认信息→</span>
    <span class="pass">2、点击退款→</span>
    <span>3、退款完成</span>
</div>
<div class="cont">

    <div class="main" height="900">
    <form name=refundForm action=refundOrderApi.php method=post target="_blank">
        <table class="table-data" width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>退款单号：</th>
                <td><input class="ui-input" type="text" name="refundOrderNo"/>
                    商户网站生成的退款业务订单号，必填</td>
            </tr>
            <tr>
                <th>原商户唯一订单号：</th>
                <td><input class="ui-input" type="text" name="origOutOrderNo"/>
                    正向下单时的商户网站生成的唯一订单号，必填</td>
            </tr>
            <tr>
                <th>退款订单创建时间：</th>
                <td><input class="Wdate" type="text" name="refundOrderTime" onfocus="WdatePicker({lang:'zh-cn',dateFmt:'yyyyMMddHHmmss'})"/>
                    退款订单创建时间，必填</td>
            </tr>
            <tr>
                <th>原商品订单创建时间：</th>
                <td><input class="Wdate" type="text" name="origOrderTime" onfocus="WdatePicker({lang:'zh-cn',dateFmt:'yyyyMMddHHmmss'})"/>
                    商户发起支付时传入的订单创建时间，必填</td>
            </tr>
            <tr>
                <th>退款金额：</th>
                <td><input class="ui-input" type="text" name="refundAmount" value="1.00"/>
                    必填(RMB元)</td>
            </tr>
            <tr>
                <th>退款理由：</th>
                <td><input class="ui-input" type="text" name="refundReason" value="退货需要退款"/></td>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <td>
                <button class="btn-blue" type="button" style="text-align:center;" onclick="refund();">退 款</button>
                </td>
            </tr>
            <tr height="50"></tr>
        </table>
        </form>
        <IFRAME id="resultframe" src="" width="100%" height="300" frameborder="0" scrolling="auto"></IFRAME>
    </div>
</div>

<div class="foot">
    <div class="foot-bd">
        Copyright &copy; 2002-2015 All Rights Reserved. 苏宁版权所有
    </div>
</div>
</body>
</html>