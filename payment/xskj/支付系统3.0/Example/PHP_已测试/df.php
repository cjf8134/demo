<?php
/* *
 * 功能：支付平台即时到帐接口调试入口页面
 * 版本：1.0
 * 日期：2011-11-03
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 */

 date_default_timezone_set("Asia/Shanghai"); 
 require_once("pay.Config.php");
 $time		= time();
 $orderNo	= date("YmdHis",$time);
 $tradeDate	= date("Ymd",$time); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>支付平台--即时代发接口</title>
	</head>
	<body>
			
			
		
		<form name="direct" action="dfpay.php" method="post" target="_blank">
			<table width="100%" border="0">
				<tr>
					<th colspan="2" scope="col">
						<a href="http://www.xxxpay.com" target="_blank">
                        <img src="images/xxxpay.png" border="0" align='left' width="180px" /> 
                        </a>
                        <a href="dfqueryOrd.php" target="_blank">订单查询</a>
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
							value="<?php echo date("YmdHis");?>" />
					</td>
				</tr>
                 <tr>
					<td width="24%" align="right">密匙：					</td>
			  		<td width="76%">
						<input type="text" name="ms" id="ms">
					</td>
				</tr>
                <tr>
					<td width="24%" align="right">持卡人姓名：					</td>
			 		 <td width="76%">
						<input type="text" name="name" id="name" value="" />
					</td>
				</tr>
                <tr>
					<td width="24%" align="right">银行卡号：					</td>
			  		<td width="76%">
						<input  type="text" name="account" id="account" value="" />
					</td>
				</tr>
                <tr>
					<td width="24%" align="right">订单总价：					</td>
			  		<td width="76%">
						<input type="text" name="amt" id="amt">
					</td>
				</tr>
                <tr>
				<td width="24%" align="right">开卡银行：</td>
				<td width="76%"><select name="bankCode">
						<option value="ABC|中国农业银行">中国农业银行</option>						
						<option value="BOC|中国银行">中国银行</option>
						
                      
				</select></td>
			</tr>
                  <tr>
					<td width="24%" align="right">银行卡开户所在省：					</td>
			 		 <td width="76%">
						<input type="text" name="province" id="province" value="" />
					</td>
				</tr>
                <tr>
					<td width="24%" align="right">银行卡开户所在市：					</td>
			  		<td width="76%">
						<input  type="text" name="city" id="city" value="" />
					</td>
				</tr>
                <tr>
					<td width="24%" align="right">具体分行名称：					</td>
			  		<td width="76%">
						<input type="text" name="branchName" id="branchName" value=""/>
					</td>
				</tr>
				
	
			
			
			
			<tr>
				<td align="right">操作：</td>
				<td><input type="submit" name="submit" value="提交支付" /></td>
			</tr>
			</table>
		</form>
		
	</body>
</html>