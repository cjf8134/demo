<?php
require_once './lib/base.class.php';
error_reporting(E_ERROR);
if($_POST)
{
    $rtn = $_POST['result']?$_POST['result']:file_get_contents("php://input");
    $rtn = json_decode($rtn, true);
    $resultMod = new base();
    $chkStatus = $resultMod->ckSign($rtn);
    if($chkStatus)
    {
        $Body = $rtn['Body'];

        if($Body['STATUS'] == 1)
        {
            //把支付结果更改商户自己的交易流水
	    print_r($Body);
            echo 'SUCCESS';
            $msg = '交易成功';
        }else
        {
            $msg = 'Body解密失败';
        }
    }else
    {
        $msg = '验证签名通不过';
    }
    
}

$result = '{"CommandID":2324,"SeqID":"1","NodeType":"3","NodeID":"openplat","Version":"1.0.0","TokenID":"","RetCode":0,"ErrorMsg":"","AGENTNO":"","MERNO":"001100099202843","TERMNO":"40170002","Body":{"AMT":1,"ORDERNO":"100000000013","TRDTIME":"2017-05-17 16:11:24","PAYTIME":"2017-05-17 16:11:38","STATUS":"1","MERORDERID":18294677,"TRADETYPE":"1"},"Sign":"A26F592B5294B42E3CC403712F6479EE"}';

$rand = rand(10000000,99999999);//每次请求下预订单随机一个字符串
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0" />
    <title>支付结果通知-测试demo</title>
    <link rel="stylesheet" type="text/css" href="./css/common.css" />
   
</head>

<body>

<div class="ox">
    <!--支付状态-->
    <div class="state" style="padding:10px 1px 1px 1px;">
    	<span class="fail">支付结果通知测试</span>
    </div>
    <hr/>
    <div style="padding-left:30px; color:red; font-size:18px;"><?php echo $msg;?></div>
    <form method="post" action="payresult.php">
    <div class="state" style="margin-top:20px; padding:0px;">
    	<table width="60%" style=" border-collapse:   separate;   border-spacing:   10px;"  border="1">
        	<tr>
            	<td align="left" width="25%" style="padding-left:10px;">推送支付结果返回的样例报文：</td>
                <td align="left"><textarea rows="10" cols="20" style="width: 656px; height: 244px;" name="result"><?php echo $result;?></textarea></td>
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