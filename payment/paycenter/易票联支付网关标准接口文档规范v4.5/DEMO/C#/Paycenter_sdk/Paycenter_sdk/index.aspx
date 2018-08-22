<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="index.aspx.cs" Inherits="Paycenter_sdk.WebForm1" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
</head>
<body>
    <form runat="server">
	 	<table>
	 		<caption>普通支付</caption>
	 		<tr>
	 			<td>支付币种</td>
	 			<td>
                    <asp:TextBox ID="T_currencyType" runat="server">RMB</asp:TextBox>
                </td>
	 		</tr>
	 		<tr>
	 			<td>支付金额</td>
	 			<td>
                    <asp:TextBox ID="T_amount" runat="server">0.05</asp:TextBox>
                </td>
	 		</tr>
	 		<tr>
	 			<td>商品备注</td>
	 			<td>
                    <asp:TextBox ID="T_remark" runat="server">测试商品</asp:TextBox>
                </td>
	 		</tr>
	 		<tr>
	 			<td>&nbsp;</td>
	 			<td>
                    <asp:Button ID="pay" runat="server" onclick="pay_Click" Text="提交" />
                </td>
	 		</tr>
	 	</table>
	 <hr/>
	 	<table>
	 		<caption>海关电子支付</caption>
	 		<tr>
	 			<td>支付币种</td>
	 			<td>
                    <asp:TextBox ID="Tc_currencyType" runat="server">RMB</asp:TextBox>
                </td>
	 		</tr>
	 		<tr>
	 			<td>支付金额</td>
	 			<td>
                    <asp:TextBox ID="Tc_amount" runat="server">0.05</asp:TextBox>
                </td>
	 		</tr>
	 		<tr>
	 			<td>商品备注</td>
	 			<td>
                    <asp:TextBox ID="Tc_remark" runat="server">测试商品</asp:TextBox>
                </td>
	 		</tr>
	 		<tr>
	 			<td>支付货款</td>
	 			<td>
                    <asp:TextBox ID="T_goodsAmount" runat="server">0.01</asp:TextBox>
                </td>
	 		</tr>
	 		<tr>
	 			<td>支付货款货币代码</td>
	 			<td>
                    <asp:TextBox ID="T_goodsAmountCurr" runat="server">RMB</asp:TextBox>
                </td>
	 		</tr>
	 		<tr>
	 			<td>支付税款</td>
	 			<td>
                    <asp:TextBox ID="T_taxAmount" runat="server">0.01</asp:TextBox>
                </td>
	 		</tr>
	 		<tr>
	 			<td>支付税款货币代码</td>
	 			<td>
                    <asp:TextBox ID="T_taxAmountCurr" runat="server">RMB</asp:TextBox>
                </td>
	 		</tr>
	 		<tr>
	 			<td>支付运费</td>
	 			<td>
                    <asp:TextBox ID="T_freight" runat="server">0.01</asp:TextBox>
                </td>
	 		</tr>
	 		<tr>
	 			<td>支付运费货币代码</td>
	 			<td>
                    <asp:TextBox ID="T_freightCurr" runat="server">RMB</asp:TextBox>
                </td>
	 		</tr>
	 		<tr>
	 			<td>用户信息</td>
	 			<td>
                    &nbsp;
                </td>
	 		</tr>
	 		<tr>
	 			<td>银行账号</td>
	 			<td>
                    <asp:TextBox ID="T_bankAccount" runat="server">6223236500025445</asp:TextBox>
                </td>
	 		</tr>
	 		<tr>
	 			<td>银行账号类型</td>
	 			<td>
                    <asp:TextBox ID="T_bankAccType" runat="server">00</asp:TextBox>
                </td>
	 		</tr>
	 		<tr>
	 			<td>用户ID或会员ID</td>
	 			<td>
                    <asp:TextBox ID="T_userId" runat="server">36090</asp:TextBox>
                </td>
	 		</tr>
	 		<tr>
	 			<td>用户姓名</td>
	 			<td>
                    <asp:TextBox ID="T_userName" runat="server">测试</asp:TextBox>
                </td>
	 		</tr>
	 		<tr>
	 			<td>用户证件类型</td>
	 			<td>
                    <asp:TextBox ID="T_cert_type" runat="server">00</asp:TextBox>
                </td>
	 		</tr>
	 		<tr>
	 			<td>用户证件号码</td>
	 			<td>
                    <asp:TextBox ID="T_cert_no" runat="server">413029197210284229</asp:TextBox>
                </td>
	 		</tr>
	 		<tr>
	 			<td>用户手机号码</td>
	 			<td>
                    <asp:TextBox ID="T_userMobile" runat="server">15089654256</asp:TextBox>
                </td>
	 		</tr>
	 		<tr>
	 			<td>&nbsp;</td>
	 			<td>
                    <asp:Button ID="customsPay" runat="server" onclick="customsPay_Click" 
                        Text="提交" />
                </td>
	 		</tr>
	 	</table>
	 </form>
</body>
</html>
