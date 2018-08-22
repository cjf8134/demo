<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>余额查询Demo</title>
</head>
<body>
	<form id="submitForm" method="post" name="submitFomm" action="balanceQuery" style="margin-left: 20%;margin-top: 40px;">
		<table>
			<tbody>
				<tr>
					<td align="right"><label>mer_no（商户代码 ）</label></td>
					<td align="left"><input  type="text" id="mer_no" value=""  name="mer_no"/></td>
				</tr>
				<tr>
					<td align="right"></td>
					<td><input type="submit" value="余额查询" ></td>
				</tr>
			</tbody>
		</table>									
	</form>
</body>
</html>