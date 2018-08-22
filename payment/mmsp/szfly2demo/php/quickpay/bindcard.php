<?php
//error_reporting(0);
//快捷支付绑卡DEMO
require_once '../lib/quickpay.class.php';
$msg = ''; $isCheck = true;
if($_POST){

    //head
    $merMod = new quickpay();
    $merMod->SetCommandID(hexdec('0x0306'));
    $merMod->SetSeqID('1');
    $merMod->SetNodeType('3');
    $merMod->SetNodeID('openapi');
    $merMod->SetVersion('1.0.0');
	$merMod->SetAGENTNO(payconfig::AGENTNO);//报文头机构或代理ID
	$merMod->SetMERNO(payconfig::MERNO);
	$merMod->SetTERMNO(payconfig::TERMNO);
    
    //业务数据包 Body
    $merMod->SetMERORDERID($_POST['MERORDERID']);
    $merMod->SetCARDNO($_POST['CARDNO']);
    $merMod->SetCARDTYPE($_POST['CARDTYPE']);
    $merMod->SetEXPDATE($_POST['EXPDATE']);
    $merMod->SetCVN2($_POST['CVN2']);
    $merMod->SetNAME($_POST['NAME']);
    $merMod->SetID_NO($_POST['ID_NO']);
    $merMod->SetPHONENO($_POST['PHONENO']);
    $merMod->SetRANDSTR((string)time());
    $merMod->SetUSER_ID($_POST['USER_ID']);
    $merMod->SetMSG_CODE($_POST['MSG_CODE']);

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
<form method="post" action="bindcard.php" target="_blank">
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
            <td align="left" width="19%">&nbsp;&nbsp;用户ID</td>
            <td align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="USER_ID" value="12345678" id="USER_ID"/>
            </td>
        </tr>

        <tr>
            <td align="left" width="19%">&nbsp;&nbsp;银行卡号</td>
            <td align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="CARDNO" value="6225880113756648" id="CARDNO"/>
            </td>
        </tr>
        
        <tr>
            <td align="left" width="19%">&nbsp;&nbsp;持卡人姓名</td>
            <td align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="NAME" value="张珊"/>
            </td>
        </tr>
        <tr>
            <td align="left" width="19%">&nbsp;&nbsp;身份证号</td>
            <td align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="ID_NO" value="341126197709218366"/>
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
            <td align="left" width="19%">&nbsp;&nbsp;银行卡类型</td>
            <td align="left">&nbsp;&nbsp;
                <select name="CARDTYPE">
                    <option value="1" selected="selected">借记卡</option>
                    <option value="2" >信用卡</option>
                </select>
            </td>
        </tr>

        <tr>
            <td align="left" width="19%">&nbsp;&nbsp;信用卡背面cvn2</td>
            <td align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="CVN2" value="123"/>
            </td>
        </tr>
        
        <tr>
            <td align="left" width="19%">&nbsp;&nbsp;信用卡有效期</td>
            <td align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="EXPDATE" value="1017"/> 格式 MMYY 如：0117
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
// window.onload = function(){
//     var n = parseInt(Math.random() * 1000000 + 12311);
//     document.getElementById('MERORDERID').value = n;
//     var base_url = window.location.protocol+"//"+window.location.hostname+":"+window.location.port

//     document.getElementById('NOTIFY_URL').value = base_url+"/quickpay/callback.php";
//     document.getElementById('JUMP_URL').value = base_url+"/quickpay/return.php";
// }

function send(){
	var MERORDERID = document.getElementById('MERORDERID').value;
	var USER_ID = document.getElementById('USER_ID').value;
	var CARDNO = document.getElementById('CARDNO').value;
	var PHONENO = document.getElementById('PHONENO').value;
	window.location.href="bindcardmsg.php?"+"MERORDERID="+MERORDERID+"&USER_ID="+USER_ID+"&CARDNO="+CARDNO+"&PHONENO="+PHONENO;
}
</script>

</div>

</body>
</html>