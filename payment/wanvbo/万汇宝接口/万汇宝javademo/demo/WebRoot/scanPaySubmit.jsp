<%@page import="java.util.Map"%>
<%@page import="java.util.HashMap"%>
<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>
	<% String reqUrl=(String) request.getAttribute("REQ_URL" ); %>
	<form id="submitForm" method="post" name="submitFomm" action=" <% out.println(reqUrl); %> ">
	<% 
		Map<String,String> paramMap=(Map)request.getAttribute("paramMap");
		for (Map.Entry<String,String> entry : paramMap.entrySet()) {  
		    out.println("<input  type=\"text\"  name=\""+ entry.getKey()+"\" value=\""+  entry.getValue()+"\" /> <br/> ");
		}
	%>
		<input type="submit" value="支付" id="submit">		
	</form>
</body>

<script type="text/javascript">
window.onload = function(){
	var submitInput= document.getElementById("submit");
	submitInput.click();
}
</script>
</html>