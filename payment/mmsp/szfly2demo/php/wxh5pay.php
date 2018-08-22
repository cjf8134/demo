<?php
require_once './lib/wxh5pay.class.php';

error_reporting(E_ERROR);

if($_POST)
{ 
    $wxh5payMod = new wxh5pay();
    $wxh5payMod->SetCommandID(hexdec('0x0911'));
    $wxh5payMod->SetSeqID('1');
    $wxh5payMod->SetNodeType('3');
    $wxh5payMod->SetNodeID('openplat');
    $wxh5payMod->SetVersion('1.0.0');
    $wxh5payMod->SetAGENTNO($_POST['AGENTNO']);//不传代理商就默认是商户交易
    $wxh5payMod->SetMERNO($_POST['MERNO']);
    $wxh5payMod->SetTERMNO($_POST['TERMNO']);
    $wxh5payMod->SetAMT($_POST['AMT']);
    $wxh5payMod->SetCUR($_POST['CUR']);
    $wxh5payMod->SetGOODSNAME($_POST['GOODSNAME']);
    $wxh5payMod->SetNOTIFY_URL($_POST['NOTIFY_URL']);
    $wxh5payMod->SetJUMP_URL($_POST['JUMP_URL']);
    $wxh5payMod->SetTIME_END($_POST['TIME_END']);
    $wxh5payMod->SetIP($_POST['IP']);
    $wxh5payMod->SetMERORDERID($_POST['MERORDERID']);
    $wxh5payMod->SetRANDSTR($_POST['RANDSTR']);
	$wxh5payMod->SetLIMIT_PAY($_POST['LIMIT_PAY']);
	
    $wxh5payMod->BodyAes();
    $wxh5payMod->MakeSign();
    $result =$wxh5payMod->send();
    if($result['STATUS'] == 1)
    {
        //STATUS表示上送成功，此处可以开始设置商户自己的密钥过期时间
        $msg = '返回报文：'.json_encode($result);
        //$img = '支付连接(用工具转成二维码用手机扫码支付)：'.$result['URL'];
        $img = '支付连接(用工具转成二维码用手机扫码支付)：<br /><img style="width:200px;height:200px;" src="./qrcode.php?url='.urlencode($result['URL']).'" ';
    }else
    {
        $msg = '请求失败';
    }
        
    
}



$MERORDERID = rand(10000000,99999999);
$rand = rand(10000000,99999999);//每次请求下预订单随机一个字符串
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0" />
    <title>微信H5交易-测试demo</title>
    <link rel="stylesheet" type="text/css" href="./css/common.css" />
   
</head>

<body>

<div class="ox">
    <!--支付状态-->
    <div class="state" style="padding:10px 1px 1px 1px;">
    	<span class="fail">微信正扫/公众号支付测试</span>
    </div>
    <hr/>
    <div style="padding-left:30px; color:red; font-size:18px;"><?php echo $msg;?><br/><?php echo $img;?></div>
    <form method="post" action="wxh5pay.php">
    <div class="state" style="margin-top:20px; padding:0px;">
    	<table width="60%" style=" border-collapse:   separate;   border-spacing:   10px;"  border="1">
        	 <tr>
            	<td align="left" width="25%" style="padding-left:10px;">代理商编号</td>
                <td align="left"><input type="text" name="AGENTNO" value="<?php echo payconfig::AGENTNO;?>"/></td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;">商户号</td>
                <td  align="left"><input type="text" name="MERNO" value="<?php echo payconfig::MERNO;?>"/></td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;">终端号</td>
                <td  align="left"><input type="text" name="TERMNO" value="<?php echo payconfig::TERMNO;?>"/></td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;">金额</td>
                <td  align="left"><input type="text" name="AMT"/>单位：分</td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;">币种</td>
                <td  align="left"><input type="text" name="CUR" value="CNY" readonly/></td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;">商品名称</td>
                <td  align="left"><input type="text" name="GOODSNAME" value="零食"/></td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;">支付回调地址</td>
                <td  align="left"><input type="text" name="NOTIFY_URL" value="http://www.baidu.com:20046/wxh5pay.php"/></td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;">前端跳转地址</td>
                <td  align="left"><input type="text" name="JUMP_URL" value="http://www.baidu.com:20046/wxh5pay.php"/></td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;">订单过期时间</td>
                <td  align="left"><input type="text" name="TIME_END" placeholder="格式：2017-03-07 10：05：00"/></td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;">IP地址</td>
                <td  align="left"><input type="text" name="IP" value="www.baidu.com"/></td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;">商户订单号</td>
                <td  align="left"><input type="text" name="MERORDERID"  value="<?php echo $MERORDERID;?>"/></td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;">随机字符串</td>
                <td  align="left"><input type="text" name="RANDSTR" value="<?php echo $rand;?>"/></td>
             </tr>
			  <tr>
            	<td align="left" width="25%" style="padding-left:10px;">是否限制信用卡</td>
                <td  align="left"><input type="text" name="LIMIT_PAY" value="2"/></td>
             </tr>
             <tr>
            	<td></td>
                <td align="left" ><input type="submit" style="cursor:pointer;"  value=" 提交下单 "/></td>
             </tr>
         </table>
    </div>
    </form>
</div>
</body>
</html>