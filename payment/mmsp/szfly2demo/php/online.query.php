<?php
error_reporting(E_ERROR);
require_once './lib/online.class.php';
$msg = ''; $isCheck = true;
header('Content-Type:text/html; charset=utf-8');
if($_POST)
{
    //head
    $merMod = new online();
    $merMod->SetCommandID(hexdec('0x0913'));
    $merMod->SetSeqID('1');
    $merMod->SetNodeType('3');
    $merMod->SetNodeID('openapi');
    $merMod->SetVersion('1.0.0');
	$merMod->SetAGENTNO(payconfig::AGENTNO);//报文头机构或代理ID
	$merMod->SetMERNO(payconfig::MERNO);
	$merMod->SetTERMNO(payconfig::TERMNO);
	//业务数据包	Body
	$merMod->SetMERORDERID($_POST['MERORDERID']);

    if($isCheck){
			//设置附件
            $merMod->BodyAes();
            $merMod->MakeSign();
            $result = $merMod->send();  
	    //var_dump($result);die;
			if($result['STATUS'] == 1)
			{
			     //支付结果
				$msg = '返回报文：'.json_encode($result , JSON_UNESCAPED_UNICODE);
			}else
			{
			    $msg = '返回报文：'.json_encode($result , JSON_UNESCAPED_UNICODE);
			}
	   }
    
}

	
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0" />
    <title>开放接口网关订单查询-测试demo</title>
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
    	<span class="fail">开放接口网关订单查询</span>
    </div>
    <hr/>
    <div style="padding-left:30px; color:red; font-size:18px;"><?php echo $msg; ?></div>
    <form method="post" action="online.query.php">
    <div class="state" style="margin-top:20px; padding:0px;">
    	<table width="100%" style=" border-collapse:   separate;   border-spacing:   10px;"  border="1">

            
 		<tr>
            <td align="left" width="19%">&nbsp;&nbsp;商户订单号</td>
            <td width="81%" align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="MERORDERID" value="" id="MERORDERID"/>
            </td>
        </tr>
        
       	
             
             
             <tr>
            	<td></td>
                <td align="left" ><input type="submit" style="cursor:pointer;"  value="查询订单 "/></td>
             </tr>
         </table>
    </div>
    </form>
</div>


</body>
</html>