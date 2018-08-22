<?php
/**
 * 
 * 所有功能测试入口，用于测试
 * 
 * 
 *
 *
 *
 *
 */
$wxsan = 'wxsan.php';
$wxrescan = 'wxrescan.php';
$query = 'query.php';
$wxpayh5 = 'wxsan.php';
$sendrand = 'sendrand.php';

$zfbsan = 'zfbsan.php';
$zfbrescan = 'zfbrescan.php';
$zfbpayh5 = 'zfbsan.php';

$cannl = 'cancel.php';//撤销订单
$close = 'close.php';//关闭订单
$refund = 'refund.php';//退款
$refundQuery = 'refundquery.php';//退款查询
$payresult = 'payresult.php';//支付结果通知处理
$downloadbill = 'downloadbill.php';

$wxh5pay = 'wxh5pay.php';

$sign = 'sign.php';


//快捷支付
$quickpay = 'quickpay/index.php';

//线上支付
$onl_pay = 'online.pay.php';
$onl_query = 'online.query.php';

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0" />
    <title>测试demo</title>
    <link rel="stylesheet" type="text/css" href="./css/common.css" />
    <style>
   .topbox{ margin:30px auto; width:80%;}
   li,ul{ display:block; margin:0; padding:0px}
   li{ line-height:36px; float:left; padding:5px 20px; border:#CCC solid 1px; margin:10px}
   li a{ color:#09C}
   .box{ display:block; clear:both;}
   .clear{ display:block; clear:both; line-height:1px; height:1px;}
   </style>  
</head>

<body>
<div class="topbox">
	<ul>
    	<li><a href="/api/gateway.html" target="_blank">网关支付文档</a></li>
        <li><a href="/api/quickpay.html" target="_blank">快捷支付文档</a></li>
        <li><a href="/api/open.html" target="_blank">扫码支付文档</a></li>
        <li><a href="/api/payment.html" target="_blank">代收付文档</a></li>
        <li><a href="/api/SDK.zip" target="_blank">DEMO下载</a></li>
    </ul>   
</div>
<div class="box">
    <!--支付状态-->    
<fieldset style="border:1px solid #CCC;margin: 10px;padding: 10px;">
	 <legend style="border-width:0px; font-size:12px;margin-bottom:0px; width:auto;">微信/支付宝</legend>
<div class="state" style="margin-top:20px; padding:0px;">
    	<table width="100%" style="padding:10px; border-collapse:   separate;   border-spacing:   10px;" >
        	<tr>
				<td align="left"   style="padding-left:10px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $sendrand;?>'" style="width:150px; height:50px;cursor:pointer;">获取微信OPENID/支付宝USER_ID</button></div></td>
            	<td align="left"  style="padding-left:10px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $wxsan;?>'" style="width:150px; height:50px;cursor:pointer;">微信正扫</button></div></td>
                <td align="right" style="padding-right:20px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $wxrescan;?>'" style="width:150px; height:50px;cursor:pointer;">微信反扫</button></div></td>
                <td align="right" style="padding-right:20px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $wxpayh5;?>'" style="width:150px; height:50px;cursor:pointer;">微信公众号</button></div></td>
                
            </tr>
            <tr>
            	<td align="left"   style="padding-left:10px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $zfbsan;?>'" style="width:150px; height:50px;cursor:pointer;">支付宝正扫</button></div></td>
                <td align="right"  style="padding-left:10px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $zfbrescan;?>'" style="width:150px; height:50px;cursor:pointer;">支付宝反扫</button></div></td>
                <td align="right" style="padding-right:20px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $zfbpayh5;?>'" style="width:150px; height:50px;cursor:pointer;">支付宝服务窗支付</button></div></td>
                <td align="right" style="padding-right:20px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $query;?>'" style="width:150px; height:50px;cursor:pointer;">订单查询</button></div></td>
                
            </tr>
            <tr >
            	<td align="left"   style="padding-left:10px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $cannl;?>'" style="width:150px; height:50px;cursor:pointer;" >(刷卡)撤销订单</button></div></td>
            	<td align="left"   style="padding-left:10px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $close;?>'" style="width:150px; height:50px;cursor:pointer;" >(正扫)关闭订单</button></div></td>
                <td align="right" style="padding-right:20px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $refund;?>'" style="width:150px; height:50px;cursor:pointer;">退款</button></div></td>
                <td align="right" style="padding-right:20px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $refundQuery;?>'" style="width:150px; height:50px;cursor:pointer;">退款查询订单</button></div></td>
               
            </tr>
            <tr >
            	 <td align="left"   style="padding-left:10px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $payresult;?>'" style="width:150px; height:50px;cursor:pointer;">支付结果通知</button></div></td>
				 
                <td align="right"   style="padding-left:10px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $wxh5pay;?>'" style="width:150px; height:50px;cursor:pointer;">微信H5支付</button></div></td>
                <td align="left"   style="padding-right:20px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $payresult;?>'" style="width:150px; height:50px;cursor:pointer;">支付结果通知</button></div></td>
                <td align="left"  style="padding-right:20px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $downloadbill;?>'" style="width:150px; height:50px;cursor:pointer;">下载对账单</button></div></td>
            </tr>
	    
	    <tr >
            	 
                <td align="right" width="30%" style="padding-left:10px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $merCreate;?>'" style="width:150px; height:50px;cursor:pointer;">商户入网</button></div></td>
                
                <td align="right" width="20%" style="padding-left:10px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $merQuery;?>'" style="width:150px; height:50px;cursor:pointer;">商户入网查询</button></div></td>
                <td align="right" style="padding-right:20px;"><div align="center" ><button type="button" onClick="javascript:window.location.href=''" style="width:150px; height:50px;cursor:pointer;">代付</button></div></td>
                <td align="right" style="padding-right:20px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $sign;?>'" style="width:150px; height:50px;cursor:pointer;">在线签名工具</button></div></td>
               
            </tr>
  	    
        
        </table>
    </div>
</fieldset>

<fieldset style="border:1px solid #CCC;margin: 10px;padding: 10px;">
	 <legend style="border-width:0px; font-size:12px;margin-bottom:0px; width:auto;">快捷支付</legend>
<div class="state" style="margin-top:20px; padding:0px;">
    	<table width="100%" style="padding:10px; border-collapse:   separate;   border-spacing:   10px;" >
            <tr >
 <td align="left"   style="padding-left:10px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $quickpay;?>'" style="width:150px; height:50px;cursor:pointer;">快捷支付</button></div></td>
 
<td align="left"   style="padding-left:10px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $quickpay;?>'" style="width:150px; height:50px;cursor:pointer;">快捷支付查询</button></div></td>

 <td align="left"   style="padding-right:20px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $quickpay;?>'" style="width:150px; height:50px;cursor:pointer;">快捷批量查询</button></div></td>
 
<td align="left"   style="padding-right:20px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $quickpay;?>'" style="width:150px; height:50px;cursor:pointer;">xxxx</button></div></td>

            </tr>
	    
	    	    
        
        </table>
    </div>
</fieldset>

<fieldset style="border:1px solid #CCC;margin: 10px;padding: 10px;">
	 <legend style="border-width:0px; font-size:12px;margin-bottom:0px; width:auto;">网关支付</legend>
<div class="state" style="margin-top:20px; padding:0px;">
    	<table width="100%" style="padding:10px; border-collapse:   separate;   border-spacing:   10px;" >

<td align="right" style="padding-left:10px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $onl_pay;?>'" style="width:150px; height:50px;cursor:pointer;">线上网关支付</button></div></td>

<td align="right" style="padding-left:10px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $onl_query;?>'" style="width:150px; height:50px;cursor:pointer;">线上网关支付查询</button></div></td>

<td align="left"   style="padding-left:20px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $quickpay;?>'" style="width:150px; height:50px;cursor:pointer;">xxxx</button></div></td>

<td align="left"   style="padding-left:20px;"><div align="center" ><button type="button" onClick="javascript:window.location.href='<?php echo $quickpay;?>'" style="width:150px; height:50px;cursor:pointer;">xxxx</button></div></td>
            </tr>
                
        
        </table>
    </div>
</fieldset>    
</div>
</body>
</html>