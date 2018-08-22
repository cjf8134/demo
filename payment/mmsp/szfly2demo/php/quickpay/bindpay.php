<?php
//error_reporting(0);
//快捷支付绑卡DEMO
require_once '../lib/quickpay.class.php';
$msg = ''; $isCheck = true;
if($_POST){

    //head
    $merMod = new quickpay();
    $merMod->SetCommandID(hexdec('0x030B'));
    $merMod->SetSeqID('1');
    $merMod->SetNodeType('3');
    $merMod->SetNodeID('openapi');
    $merMod->SetVersion('1.0.0');
	$merMod->SetAGENTNO(payconfig::AGENTNO);//报文头机构或代理ID
	$merMod->SetMERNO(payconfig::MERNO);
	$merMod->SetTERMNO(payconfig::TERMNO);
    
    //业务数据包 Body
    $merMod->SetMERORDERID($_POST['MERORDERID']);

    $merMod->SetRANDSTR((string)time());
    $merMod->SetUSER_ID($_POST['USER_ID']);
    $merMod->SetMSG_CODE($_POST['MSG_CODE']);
    $merMod->SetAMT($_POST['AMT']);
    $merMod->SetNOTIFY_URL($_POST['NOTIFY_URL']);
    $merMod->SetBIND_ID($_POST['BIND_ID']);
    if($isCheck){
            //设置附件
            $merMod->BodyAes();
            $merMod->MakeSign();
            $result = $merMod->send();
            var_dump($result);            
       }
}

?>

<html>
<head>
    <meta charset="utf-8">
    <title>快捷支付绑卡DEMO</title>
</head>
<body>

<script src="./js/head.js"></script>
<form method="post" action="bindpay.php" target="_blank">
    <table width="60%" border="0" align="center" cellpadding="5" cellspacing="5"
           style="border:solid 1px #1a88d5; margin-top:20px">
        <tr>
            <td align="left" bgcolor="#ABD8ED" height="25" colspan="2">快捷支付绑卡DEMO接口示例：</td>
        </tr>
<?php $MERORDERID =  time();?>
        <tr>
            <td align="left" width="19%">&nbsp;&nbsp;商户订单号</td>
            <td width="81%" align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="MERORDERID" value="<?php echo $MERORDERID;?>" id="MERORDERID"/>
            </td>
        </tr>
        
                <tr>
            <td align="left" width="19%">&nbsp;&nbsp;绑定ID</td>
            <td width="81%" align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="BIND_ID" value="100003" id="BIND_ID"/>
            </td>
        </tr>

        <tr>
            <td align="left" width="19%">&nbsp;&nbsp;用户ID</td>
            <td align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="USER_ID" value="12345678" id="USER_ID"/>
            </td>
        </tr>
        
        <tr>
            <td align="left" width="19%">&nbsp;&nbsp;金额</td>
            <td align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="AMT" value="999" id="AMT"/>
            </td>
        </tr>        
       <tr>
            <td align="left" width="19%">&nbsp;&nbsp;手机号码</td>
            <td align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="PHONENO" value="13552535506" id="PHONENO"/>
            </td>
        </tr>
       <tr>
            <td align="left" width="19%">&nbsp;&nbsp;短信验证码</td>
            <td align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="MSG_CODE" value="123456"/> <a href="javascript:;" onclick="send()">发送短信</a>
            </td>
        </tr>
        <tr>
            <td align="left" width="19%">&nbsp;&nbsp;后端回调URL</td>
            <td align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="NOTIFY_URL"
                       value="http://127.0.0.1:20044/open/quickpay/merchnoCallBack"/>
            </td>
        </tr>
            

        <tr>
            <td align="left" width="19%">&nbsp;&nbsp;</td>
            <td align="left">&nbsp;&nbsp;<input type="submit" value="马上支付"/>&nbsp;&nbsp;<a href="index.php">返回</a></td>
        </tr>

    </table>
</form>


<div><?php echo $msg;?></div>

<script type="text/javascript">

function send(){
	var MERORDERID = document.getElementById('MERORDERID').value;
	var USER_ID = document.getElementById('USER_ID').value;
	var PHONENO = document.getElementById('PHONENO').value;
	var BIND_ID = document.getElementById('BIND_ID').value;
	var AMT = document.getElementById('AMT').value;
	window.location.href="bindpaymsg.php?"+"MERORDERID="+MERORDERID+"&USER_ID="+USER_ID+"&PHONENO="+PHONENO+"&BIND_ID="+BIND_ID+"&AMT="+AMT;
}
</script>

</div>

</body>
</html>