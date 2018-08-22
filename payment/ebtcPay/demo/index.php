<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>商户支付测试</title>
</head>

<body>
<form method="POST" action="pay.php" target="_blank">
	<table>
		<tr>
			<td>订单号（测试时，请修改订单号）:</td>
			<td><input type="text" name="sdorderno" value="<?= date('YmdHis').mt_rand(10000, 99999); ?>" size="50"/></td>
		</tr>
		<tr>
			<td>交易金额（最低1元）:</td>
			<td><input type="text" name="total_fee" value="<?= '1.'.mt_rand(10, 50); ?>" size="50"/></td>
		</tr>
		<tr>
			<td>支付方式:</td>
			<td>
				<select name="paytype">
					<option value="bank1">bank1</option>
					<option value="bank2">bank2</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>银行编码:</td>
			<td>
				<select name="bankcode">
					<option value="ICBC">中国工商银行 ICBC</option>
					<option value="ABC">中国农业银行 ABC</option>
					<option value="BOC">中国银行 BOC</option>
					<option value="CCB">建设银行 CCB</option>
					<option value="CMB">招商银行 CMB</option>
					<option value="SPDB">浦发银行 SPDB</option>
					<option value="GDB">广发银行 GDB</option>
					<option value="COMM">交通银行 COMM</option>
					<option value="PSBC">邮政储蓄银行 PSBC</option>
					<option value="CNCB">中信银行 CNCB</option>
					<option value="CMBC">民生银行 CMBC</option>
					<option value="CEB">光大银行 CEB</option>
					<option value="HXB">华夏银行 HXB</option>
					<option value="CIB">兴业银行 CIB</option>
					<option value="PAB">平安银行 PAB</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>商户参数（原样返回）:</td>
			<td><input type="text" name="remark" value="测试支付" size="50"/></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" value="提交"/></td>
		</tr>
	</table>
</form>
</body>
</html>