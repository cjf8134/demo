<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>代付申请Demo</title>
</head>
<body>
	<form id="submitForm" method="post" name="submitFomm" action="remitRequest" style="margin-left: 20%;margin-top: 40px;">
		<table>
			<tbody>
				<tr>
					<td align="right"><label>mer_no（商户代码 ）</label></td>
					<td align="left"><input  type="text"  value=""  name="mer_no"/></td>
				</tr>
				<tr>
					<td align="right"><label>mer_remit_no（代付订单号）</label></td>
					<td align="left"><input  type="text"  value=""  name="mer_remit_no"/></td>
				</tr>
				<tr>
					<td align="right"><label>apply_date（申请日期2017-09-13 10:10:10）</label></td>
					<td align="left"><input  type="text"  value=""  name="apply_date"/></td>
				</tr>
				<tr>
					<td align="right"><label>bank_code（收款银行）</label></td>
					<td align="left"><input  type="text"  value=""  name="bank_code"/></td>
				</tr>
				<tr>
					<td align="right"><label>province（收款人省份）</label></td>
					<td align="left"><input  type="text"  value=""  name="province"/></td>
				</tr>
				<tr>
					<td align="right"><label>city（收款人城市）</label></td>
					<td align="left"><input  type="text"  value=""  name="city"/></td>
				</tr>
				<tr>
					<td align="right"><label>card（银行账号）</label></td>
					<td align="left"><input  type="text"  value=""  name="card"/></td>
				</tr>
				<tr>
					<td align="right"><label>name（姓名）</label></td>
					<td align="left"><input  type="text"  value=""  name="name"/></td>
				</tr>
				<tr>
					<td align="right"><label>amount（出款金额）</label></td>
					<td align="left"><input  type="text"  value=""  name="amount"/></td>
				</tr>
				<tr>
					<td align="right"><label>remark（备注）</label></td>
					<td align="left"><input  type="text"  value=""  name="remark"/></td>
				</tr>
				<tr>
					<td align="right"></td>
					<td><input type="submit" value="代付申请" >	</td>
				</tr>
			</tbody>
		</table>									
	</form>
</body>
</html>