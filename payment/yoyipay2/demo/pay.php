<?php
/* *
 * 功能：甬易支付即时到账（直连银行）接口输入订单信息页面
 * 版本：1.0
 * 日期：2014-03-04
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户应根据自己网站的需要，按照技术文档编写。
 */

header("content-type:text/html;charset=UTF-8");
include ('./algorithm.php');

//创建支付请求
///////支付请求表单域以接口文档为准//////////////
$configFile="merchantInfo.ini";
$keyValue = getini("keyValue",$configFile);//商家MD5密钥
$nodeAuthorizationURL = getini("payReqURL",$configFile);   //交易请求地址
$merId = getini("merId",$configFile);//商户编号
$merURL = getini("merURL",$configFile);	//商户接收支付成功页面跳转的地址
$serverNotifyURL =getini("serverNotifyURL",$configFile);   //商户接收支付成功后台通知
$interfaceName = 'anonymousPayOrder';	
$curType = 'CNY';
$version='B2C1.0';

$xmlData="<?xml version=\"1.0\" encoding=\"GBK\"?><B2CReq><merchantId>".$merId."</merchantId><curType>".$curType."</curType><returnURL>".$merURL."</returnURL><notifyURL>".$serverNotifyURL."</notifyURL></B2CReq>";//支付通道编码

   // 获得MD5-HMAC签名(特殊商户用)
   $signMsg = HmacMd5($xmlData,$keyValue);
   // 获得证书签名(新商户都用此方法)
   $signMsg = certSign($xmlData);
   // tranData做base64编码
   $tranData =  base64_encode($xmlData);

?>


<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<title>甬易支付-商品接口范例</title>
	</head>
	<script type="text/javascript" language="javascript">
	var transactionData='';
	var rowIndex=1;

	function createOrderID(){
	// 创建订单号
    var tp='';
	var i=0;
    while(i<10) 
    {
       var tmp=parseInt(Math.random()*10);	
       tp=tp+tmp;
       i++;
    } 
    document.getElementById("orderNo").value=tp;
} 

	function doSubmit(){
	// 传递订单信息，同时构成一部分的报文
	var orderAmt = document.getElementById('orderAmt').value;
	var orderNo = document.getElementById('orderNo').value;
	var bankId = document.getElementById('bankId').value;	
	var cardType = document.getElementById('cardType').value;
	var goodsName = document.getElementById('goodsName').value;	
	var remark = document.getElementById('remark').value;
	var userId = document.getElementById('userId').value;
	var isBind = document.getElementById('isBind').value;
	var MSMerchantIdB = document.getElementById('MSMerchantIdB').value;
	var returnFlag = document.getElementById('returnFlag').value;
	var random = document.getElementById('random').value;

        transactionData = "<orderNo>"+orderNo+"</orderNo><orderAmt>"+orderAmt+"</orderAmt><bankId>" + bankId + 
        "</bankId><cardType>"+cardType+"</cardType><goodsName>"+goodsName+"</goodsName><remark>"+remark+"</remark><userId>"+userId+"</userId>" +
	"<isBind>"+isBind+"</isBind><MSMerchantIdB>"+MSMerchantIdB+"</MSMerchantIdB><returnFlag>"+returnFlag+"</returnFlag><random>" +random + "</random>";

	document.submitForm1.transactionData.value =transactionData;	
	document.submitForm1.submit();//发送到reqpay.php，进一步封装数据
}
	</script>
	<body onload="createOrderID();">
		
		<div id="input">
		    <div align="center">甬易支付-商户订单信息</div>
		<form  name="submitForm1" method="post" action="reqpay.php">
		     <table align="center">  
	
			<tr><td>订单号:  </td>
		            <td><input type="text" name="orderNo" id="orderNo" value="201705201234" ></input>&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td>
			</tr>
			<tr><td>订单金额:</td>
		            <td><input type="text" name="orderAmt" id="orderAmt" value="9000.00"  ></input>&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td>
			</tr>
			<tr><td>付款银行:</td>
		            <td><input type="text" name="bankId" id="bankId" value="888C"  ></input>&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td>
			</tr>
			<tr><td>卡种:</td>
		            <td><input type="text" name="cardType" id="cardType" value="X"  ></input>&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td>
			</tr>
			<tr><td>商品名称:</td>
			    <td><input type="text" name="goodsName" id="goodsName" value="iphone X" ></input></td>
			</tr>
            <tr><td>商品备注:</td>
			    <td><input type="text" name="remark" id="remark" value="60001439300020" ></input></td>
			</tr>
			<tr><td>商城自己的用户编号:</td>
			    <td><input type="text" name="userId" id="userId" value="shopUserId123456" ></input></td>
			</tr>
			<tr><td>是否绑卡</td>
		            <td><input type="text" name="isBind" id="isBind" value="0" ></input></td>
		    </tr>
			<tr><td>扫码二级商户号</td>
		            <td><input type="text" name="MSMerchantIdB" id="MSMerchantIdB" value="" ></input>&nbsp;<span style="color:#FF0000;font-weight:100;">有扫码二级商户号时才必输</span></td>
		    </tr>
			<tr><td>返回类型</td>
		            <td><input type="text" name="returnFlag" id="returnFlag" value="1" ></input>&nbsp;<span style="color:#FF0000;font-weight:100;">扫码支付用（0:返回页面,1:返回字符串）</span></td>
		    </tr>
			<tr><td>预留随机数字段</td>
		            <td><input type="text" name="random" id="random" value="123456" ></input>&nbsp;<span style="color:#FF0000;font-weight:100;">可不传</span></td>
		    </tr>
			<tr><td><input type="hidden" name="transactionData" id="transactionData" value="" ></input></td></tr>

			</table>			
		  </form>
		</div>
		<div align="center"><input type="button"  value="支付"  onclick="doSubmit()"></input></div>
	</body>
</html>