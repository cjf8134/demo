<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>

<!DOCTYPE html>

<html>
<head>
<title>Index</title>
<link href="css/styles.css" rel="stylesheet" />
</head>
<body>
	<div>
		<form method="post" action="http://localhost/CSEPay/Pay" target="_blank">
			<input type="hidden" value="<%=request.getAttribute("sign") %>" name="sign" />
			<ul>
				<li><span>订单编号：</span> <input type="text" name="orderId"
					value="<%=request.getAttribute("orderId") %>" /></li>

				<li><span>商户号：</span> <input type="text" name="code"
					value="<%=request.getAttribute("code") %>" /></li>
				<li><span>订单信息：</span> <input type="text" name="orderInfo"
					value="<%=request.getAttribute("orderInfo") %>" /></li>


				<li><span>商品名称：</span> <input type="text" name="product_name"
					value="<%=request.getAttribute("product_name") %>" /></li>
				<li><span>商品编号：</span> <input type="text" name="product_code"
					value="<%=request.getAttribute("product_code") %>" /></li>
				<li><span>付款金额：</span> 
				<input type="number" name="order_amount"
					value="<%=request.getAttribute("order_amount") %>" /></li>
				<li><span>订单时间：</span> <input type="text" name="orderTime"
					value="<%=request.getAttribute("orderTime") %>" /></li>
				<li><span>接口版本：</span> <input type="text"
					name="interfaceVersion" value="<%=request.getAttribute("interfaceVersion") %>" /></li>
				<li><span>加密类型：</span> <input type="text" name="sign_type"
					value="<%=request.getAttribute("sign_type") %>" /></li>
				<li><span>异步通知地址：</span> <input type="text"
					name="offline_notify" value="<%=request.getAttribute("offline_notify") %>" /></li>
				<li><span>同步通知地址：</span> <input type="text" name="page_notify"
					value="<%=request.getAttribute("page_notify") %>" /></li>

				<li><span>编码格式：</span> <input type="text" name="input_charset"
					value="<%=request.getAttribute("input_charset") %>" /></li>

				<li><input class="btn" type="submit" value="提 交" /></li>

			</ul>
		</form>

	</div>


</body>
</html>

