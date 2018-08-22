<?php
/* *
 * 查询调试入口页面
 * 版本：1.0
 * 日期：2015-03-26
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码。
 */
	$time		= time();
	$tradeDate	= date("Ymd",$time); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>支付平台商户接口范例-查询</title>
	<!--
	<link rel="stylesheet" type="text/css" href="styles.css">
	<link href="Styles/pay.css" type="text/css" rel="stylesheet" />
	-->
</head>
<body>
 
    
 <form method="post" action="query.php">   
    <table width="100%">
				<tr>
					<th colspan="2" scope="col">
						<a href="http://www.xxxpay.com" target="_blank">
                        <img src="images/xxxpay.png" border="0" align='left' width="180px" /> 
                        </a>
					</th>
				</tr>
                <tr>
    				<td colspan="2" height="2" bgcolor="#ff7300"></td>
  				</tr>		
			
              
				 <tr>
					<td width="24%" align="right">交易单号：					</td>
			  		<td width="76%">
						<input type="text" name="orderNo" id="orderNo" value="" />
					</td>
				</tr>
				<tr>
                    <td width="24%" align="right">加密方式：</td>
                    <td width="76%"><select name="signType">
                        
                            <option value="MD5">MD5</option>
                    </select></td>
			    </tr>
            	<tr>
					<td width="24%" align="right">时间：</td>
					<td width="76%"><input type="text" name="tradeDate" id="tradeDate" value='<?php echo $tradeDate; ?>' /></td>
				</tr>
				<tr>
					<td align="right">
						操作：
					</td>
					<td>
						<input type="submit" name="submit" value="订单查询" />
					</td>
				</tr>
		</table>
         </form>
</body>
</html>
