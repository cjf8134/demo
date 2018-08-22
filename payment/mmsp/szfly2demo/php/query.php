<?php
require_once './lib/query.class.php';
error_reporting(E_ERROR);
if($_POST)
{
    $queryMod = new query();
    $queryMod->SetCommandID($value);
    $queryMod->SetCommandID(hexdec('0x0906'));
    $queryMod->SetSeqID('1');
    $queryMod->SetNodeType('3');
    $queryMod->SetNodeID('openplat');
    $queryMod->SetVersion('1.0.0');
    $queryMod->SetAGENTNO($_POST['AGENTNO']);//不传代理商就默认是商户交易
    $queryMod->SetMERNO($_POST['MERNO']);
    $queryMod->SetTERMNO($_POST['TERMNO']);
    $queryMod->SetORDERNO($_POST['ORDERNO']);
    $queryMod->SetMERORDERID($_POST['MERORDERID']);
    $queryMod->SetRANDSTR($_POST['RANDSTR']);
    if($queryMod->IsORDERNOSet() == false && $queryMod->IsMERORDERIDSet() == false)
    {
        $msg = '平台订单号和商户订单号必须填写一个';
    }else
    {
        $queryMod->BodyAes();
        $queryMod->MakeSign();
        $result = $queryMod->send();
        if($result['STATUS'] == 1 || $result['STATUS'] == 3)
        {
            
            $msg = '返回报文：'.json_encode($result , JSON_UNESCAPED_UNICODE);
        
        
        }else
        {
            $msg = '返回报文：'.json_encode($result , JSON_UNESCAPED_UNICODE);
        }
    }
    
    
    
}

$rand = rand(10000000,99999999);//每次请求下预订单随机一个字符串
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0" />
    <title>查询订单-测试demo</title>
    <link rel="stylesheet" type="text/css" href="./css/common.css" />
   
</head>

<body>

<div class="ox">
    <!--支付状态-->
    <div class="state" style="padding:10px 1px 1px 1px;">
    	<span class="fail">查询订单测试</span>
    </div>
    <hr/>
    <div style="padding-left:30px; color:red; font-size:18px;"><?php echo $msg;?></div>
    <form method="post" action="query.php">
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
            	<td align="left" width="25%" style="padding-left:10px;">平台订单号</td>
                <td  align="left"><input type="text" name="ORDERNO"/></td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;">商户订单号</td>
                <td  align="left"><input type="text" name="MERORDERID" /></td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;">随机字符串</td>
                <td  align="left"><input type="text" name="RANDSTR" value="<?php echo $rand;?>"/></td>
             </tr>
             <tr>
            	<td></td>
                <td align="left" ><input type="submit" style="cursor:pointer;" value=" 提 交 "/></td>
             </tr>
         </table>
    </div>
    </form>
</div>
</body>
</html>