<!-- #include file="merchantCommon.asp" -->
<%
'***********************************************
'* @Description 支付产品通用支付接口范例
'* @Version 1.0
'***********************************************
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>即时支付接口</title>
	</head>
	<body>
			
			
		
		<form name="direct" action="req.asp" method="post" target="_blank">
			<table width="100%" border="0">
				<tr>
					<th colspan="2" scope="col">
						
                        <a href="queryOrd.html" target="_blank">订单查询</a>
						<a href="refundOrd.html" target="_blank">网银支付订单退货</a>
                  <!--      <a href="pfa.php" target="_blank">实时代发接口</a>
                        <a href="pfaqueryOrd.php" target="_blank">代发查询接口</a>-->
					</th>
				</tr>
                <tr>
    				<td colspan="2" height="2" bgcolor="#ff7300"></td>
  				</tr>
  				<tr>
				
				<tr>
					<td align="right">
						商家订单号：
					</td>
					<td>
						<input type="text" name="orderNo" id="orderNo"
							value="<%= generatOrderNo() %>" />
					</td>
				</tr>
                <tr>
					<td width="24%" align="right">商户参数：</td>
			 		 <td width="76%">
						<input type="text" name="merchParam" id="merchParam" value="abcd" />
					</td>
				</tr>
                <tr>
					<td width="24%" align="right">商品描述：					</td>
			  		<td width="76%">
						<input  type="text" name="tradeSummary" id="tradeSummary" value="" />
					</td>
				</tr>
                <tr>
					<td width="24%" align="right">订单总价：					</td>
			  		<td width="76%">
						<input type="text" name="amt" id="amt">
					</td>
				</tr>
				
			<tr>
				<td width="24%" align="right">交易日期：</td>
				<td width="76%"><input type="text" name="tradeDate" id="tradeDate" 
										value='<%= getTradeDate() %>' /></td>
			</tr>
			<tr>
				<td width="24%" align="right">支付方式：</td>
				<td width="76%">
					
					<select name="payType">
						<option value="YOUBAO">网银支付</option>
						<option value="ALIPAY">支付宝</option>
                        <option value="WEIXIN">微信支付</option>
					</select>	
				</td>
			</tr>
			<tr>
				<td width="24%" align="right">（网上银行必要参数）默认银行卡编号：</td>
				<td width="76%"><select name="bankCode">
						<option value="ABC">中国农业银行</option>						
						<option value="BOC">中国银行</option>
						<option value="CEB">中国光大银行</option>
						<option value="CIB">兴业银行</option>
						<option value="CITIC">中信银行</option>
						<option value="CMBC">中国民生银行</option>
						<option value="ICBC">中国工商银行</option>						
						<option value="PSBC">中国邮政储蓄银行</option>						
						<option value="CCB">中国建设银行</option>
						<option value="GDB">广发银行</option>
                        <option value="WEIXIN">微信支付</option>
						<option value="ALIPAY">支付宝</option>
						
				</select></td>
			</tr>
			
			
			
			<tr>
				<td width="24%" align="right">加密方式：</td>
				<td width="76%"><select name="signType">
						<option value="MD5">MD5</option>				

				</select></td>
			</tr>
			
			<tr>
				<td align="right">操作：</td>
				<td><input type="submit" name="submit" value="提交支付" /></td>
			</tr>
			</table>
		</form>
		
	</body>
</html>