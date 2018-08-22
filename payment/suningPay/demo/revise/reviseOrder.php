<?php

	/* *
	 *功能：易付宝PC订单修改接口调试入口页面
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
<title>易付宝PC端订单修改接口快速通道</title>
<link type="text/css" rel="stylesheet" href="../css/style.css">
</head>
<script language="javascript" type="text/javascript" src="../js/WdatePicker.js"></script>
<script src="../js/jquery-1.11.3.min.js"></script>
<body>

<div class="step">
    <span class="pass">1、确认信息→</span>
    <span class="pass">2、点击修改→</span>
    <span>3、修改结果</span>
</div>
<div class="cont">

    <div class="main">
    <form name=reviseForm action=reviseOrderApi.php method=post target="_blank">
        <table class="table-data" width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>商户订单号：</th>
                <td><input class="ui-input" type="text" name="outOrderNo"/>
                    商户网站订单系统中唯一订单号，必填</td>
            </tr>
            <tr>
                <th>订单修改后的金额：</th>
                <td><input class="ui-input" type="text" name="orderAmount"/>
                    订单金额，单位为元，必填</td>
            </tr>
            <tr>
                <th>订单创建时间：</th>
                <td><input class="Wdate" type="text" name="orderTime" onfocus="WdatePicker({lang:'zh-cn',dateFmt:'yyyyMMddHHmmss'})"/>
                    </td>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <td>
                <button class="btn-blue" type="button" style="text-align:center;" onclick="reviseOrder();">修 改</button>
                </td>
            </tr>
        </table>
        </form>
        <IFRAME id="resultframe" src="" width="100%" height="300" frameborder="0" scrolling="auto"></IFRAME>
    </div>


<div class="foot">
    <div class="foot-bd">
        Copyright &copy; 2002-2015 All Rights Reserved. 苏宁版权所有
    </div>
</div>
</div>
</body>
<script>
function reviseOrder()
{
	var outOrderNo = document.forms[0].outOrderNo.value;
	var orderTime = document.forms[0].orderTime.value;
	var orderAmount = document.forms[0].orderAmount.value;
	$(window.parent.document).find("#resultframe").attr("src",'reviseOrderApi.php?outOrderNo='
			+ outOrderNo + "&orderTime=" + orderTime + "&orderAmount=" + orderAmount);
}
</script>
</html>