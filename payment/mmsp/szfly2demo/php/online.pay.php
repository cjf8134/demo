<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0" />
    <title>开放接口网关订单支付-测试demo</title>
    <link rel="stylesheet" type="text/css" href="./css/common.css" />
<style>
.red{ color:red}
input[type="checkbox"] {
    visibility:visible !important;
	 width:auto !important;
}
</style>   

</head>

<body>

<div class="ox">
    <!--支付状态-->
    <div class="state" style="padding:10px 1px 1px 1px;">
    	<span class="fail">开放接口网关订单支付</span>
    </div>
    <hr/>
    <div style="padding-left:30px; color:red; font-size:18px;"><?php echo $msg;?></div>
    <form method="post" action="online.pay.do.php">
    <div class="state" style="margin-top:20px; padding:0px;">
    	<table width="100%" style=" border-collapse:   separate;   border-spacing:   10px;"  border="1">

            
 <tr>
            <td align="left" width="19%">&nbsp;&nbsp;商户订单号</td>
            <td width="81%" align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="MERORDERID" value="0123456789" id="MERORDERID"/>
            </td>
        </tr>
        <tr>
            <td align="left" width="19%">&nbsp;&nbsp;支付金额</td>
            <td align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="AMT" value="200"/>
                <span class="tips">单位(分)</span>
            </td>
        </tr>

        <tr>
            <td align="left" width="19%">&nbsp;&nbsp;商品名称</td>
            <td align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="GOODSNAME" value="product"/>
            </td>
        </tr>

        <tr>
            <td align="left" width="19%">&nbsp;&nbsp;后端回调URL</td>
            <td align="left">&nbsp;&nbsp;
                <input size="50" type="text" id="NOTIFY_URL" name="NOTIFY_URL"
                       value="http://www.baidu.com:20046/online_callback.php"/>
            </td>
        </tr>
        <tr>
            <td align="left" width="19%">&nbsp;&nbsp;前端回调URL</td>
            <td align="left">&nbsp;&nbsp;
                <input size="50" type="text" id="JUMP_URL" name="JUMP_URL" value="http://www.baidu.com:20046/online_return.php"/>
            </td>
        </tr>
        <tr>
            <td align="left" width="19%">&nbsp;&nbsp;支付通道编码</td>
            <td align="left">&nbsp;&nbsp;

                <select name="PAY_CHANNEL">
                    <option value="ABC-NET-B2C" selected="selected">中国农业银行</option>
		    <option value="YLBILL-NET-B2C">银联通道</option>
                    <option value="CCB-NET-B2C">建设银行</option>
                    <option value="BCCB-NET-B2C">北京银行</option>
                    <option value="BOCO-NET-B2C">交通银行</option>
                    <option value="CIB-NET-B2C">兴业银行</option>
                    <option value="CMBC-NET-B2C">中国民生银行</option>
                    <option value="CEB-NET-B2C">光大银行</option>
                    <option value="BOC-NET-B2C">中国银行</option>
                    <option value="PINGANBANK-NET-B2C">平安银行</option>
                    <option value="ECITIC-NET-B2C">中信银行</option>
                    <option value="SDB-NET-B2C">深圳发展银行</option>
                    <option value="GDB-NET-B2C">广发银行</option>
                    <option value="SHB-NET-B2C">上海银行</option>
                    <option value="SPDB-NET-B2C">上海浦东发展银行</option>
                    <option value="POST-NET-B2C">中国邮政</option>
                    <option value="BJRCB-NET-B2C">北京农村商业银行</option>
                    <option value="HXB-NET-B2C">华夏银行</option>
                    <option value="CMBCHINA-NET-B2C">招商银行</option>
                    <option value="ICBC-NET-B2C">工商银行</option>
                    <option value="ALI-PAY">支付宝</option>
                    <option value="WEIXIN-PAY">微信</option>
                </select>
                <span class="tips">请查看手册里附录银行通道编码表</span>
            </td>
        </tr>
        <tr>
            <td align="left" width="19%">&nbsp;&nbsp;商户扩展信息</td>
            <td align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="REMARK" value="remark"/>
            </td>
        </tr>

             <tr>
            	<td></td>
                <td align="left" ><input type="submit" style="cursor:pointer;"  value=" 新建订单 "/></td>
             </tr>
         </table>
    </div>
    </form>
</div>

<script>
	var r = parseInt((Math.random()*1000000)); //偏移量 
	document.getElementById("MERORDERID").value = r;

</script>
</body>
</html>