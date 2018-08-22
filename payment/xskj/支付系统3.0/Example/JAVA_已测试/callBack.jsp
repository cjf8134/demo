<%@ page language="java" pageEncoding="UTF-8"%>
<%@page import="java.io.PrintWriter"%>
<%@page import="java.security.*"%>

<%
try {
											
	// 获取请求参数，并将数据组织成前面验证源字符串
	request.setCharacterEncoding("utf-8");
	String key = "508C1BB548B55623EAC08230C8F";
	String platformID = "10352";	//商户接口编号，请根据开户信息填写
	String merchNo = "8758563631@qq.com";	//商户帐号，请根据开户信息填写
	
	String apiName = request.getParameter("apiName");
	String notifyTime = request.getParameter("notifyTime");
	String tradeAmt = request.getParameter("tradeAmt");
	String merchParam = request.getParameter("merchParam");
	String orderNo = request.getParameter("orderNo");
	String tradeDate = request.getParameter("tradeDate");
	String accNo = request.getParameter("accNo");
	String orderStatus = request.getParameter("orderStatus");
	String signMsg = request.getParameter("signMsg");
	//signMsg.replaceAll(" ", "\\+");
	
	String srcMsg = String.format("apiName=%s&tradeAmt=%s&merchNo=%s&orderNo=%s&tradeDate=%s&accNo=%s&orderStatus=%s",
	apiName, tradeAmt, merchNo, orderNo, tradeDate, accNo, orderStatus);
	//加KEY
	srcMsg=srcMsg+key;
	
	//计算签名
	MessageDigest md5 = MessageDigest.getInstance("MD5");
	byte[] sign = md5.digest(srcMsg.getBytes("UTF-8"));
	StringBuffer ret = new StringBuffer(sign.length);
	String hex = "";
	for (int i = 0; i < sign.length; i++) {
		hex = Integer.toHexString(sign[i] & 0xFF);

		if (hex.length() == 1) {
				hex = '0' + hex;
		}
		ret.append(hex);
	}
	
	String mysignMsg = ret.toString();
	//判断签名和状态
	if ( mysignMsg.equals(signMsg) && orderStatus.equals("1")) {
		/**
		* 验证通过后，请在这里加上商户自己的业务逻辑处理代码.
		* 比如：
		* 1、根据商户订单号取出订单数据
		* 2、根据订单状态判断该订单是否已处理（因为通知会收到多次），避免重复处理
		* 3、比对一下订单数据和通知数据是否一致，例如金额等
		* 4、接下来修改订单状态为已支付或待发货
		* 5、...
		*/
		// 判断通知类型，若为后台通知需要回写"SUCCESS"给支付系统表明已收到支付通知
		// 否则支付系统将按一定的时间策略在接下来的24小时内多次发送支付通知。
		out.print("支付成功");
	}else{											
		out.print("验签失败");
	}
} catch (Exception ex) {
	out.print(ex.getMessage());
}
%>
							