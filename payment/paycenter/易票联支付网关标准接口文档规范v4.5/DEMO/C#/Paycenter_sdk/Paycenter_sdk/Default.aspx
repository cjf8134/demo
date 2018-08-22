<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="Default.aspx.cs" Inherits="Paycenter_sdk.Default" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
</head>
<body>
    <form id="form1" runat="server">
        <div>
            
            <br />
            基础配置：lib/Config.cs<br />
            <br />
            支付接口<br />
            发起请求页面：index.aspx<br />
            接受同步请求返回：PayResponse.aspx<br />
            接受异步请求返回：NotifyPayResponse.aspx<br />
            <asp:Button ID="pay_test" runat="server" onclick="pay_test_Click" Text="支付请求" />
            <br />
            <br />
            订单类接口<br />
            填写参数提交请求并得到返回结果<br />
            代码地址：Default.aspx.cs<br />
            <asp:Button ID="order_query" runat="server" onclick="order_query_Click" 
                Text="订单查询" />
            <br />
            <br />
            <asp:Button ID="refund_request" runat="server" onclick="refund_request_Click" 
                Text="退款请求" />
            <br />
            <br />
            <asp:Button ID="refund_query" runat="server" onclick="refund_query_Click" 
                Text="退款单查询" />
            
        </div>
    </form>
</body>
</html>
