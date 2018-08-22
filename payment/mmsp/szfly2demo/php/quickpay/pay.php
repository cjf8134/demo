<?php
//error_reporting(0);

require_once '../lib/quickpay.class.php';
$msg = ''; $isCheck = true;
if($_POST){

    //head
    $merMod = new quickpay();
    $merMod->SetCommandID(hexdec('0x0303'));
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
    $merMod->SetAMT($_POST['AMT']);
    $merMod->SetCARDTYPE($_POST['CARDTYPE']);
    $merMod->SetEXPDATE($_POST['EXPDATE']);
    $merMod->SetCVN2($_POST['CVN2']);
    $merMod->SetNAME($_POST['NAME']);
    $merMod->SetID_NO($_POST['ID_NO']);
    $merMod->SetPHONENO($_POST['PHONENO']);
    $merMod->SetRANDSTR($_POST['RANDSTR']);
    $merMod->SetNOTIFY_URL($_POST['NOTIFY_URL']);
    $merMod->SetUSER_ID($_POST['USER_ID']);


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
    <title>To pay Page</title>
</head>
<body>

<script src="./js/head.js"></script>
<form method="post" action="pay.php" target="_blank">
    <table width="60%" border="0" align="center" cellpadding="5" cellspacing="5"
           style="border:solid 1px #1a88d5; margin-top:20px">
        <tr>
            <td align="left" bgcolor="#ABD8ED" height="25" colspan="2">支付接口示例：</td>
        </tr>

        <tr>
            <td align="left" width="19%">&nbsp;&nbsp;商户订单号</td>
            <td width="81%" align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="MERORDERID" value="<?php echo time();?>"/>
            </td>
        </tr>


        <tr>
            <td align="left" width="19%">&nbsp;&nbsp;支付金额</td>
            <td align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="AMT" value="999"/>
                <span class="tips">单位(分)</span>
            </td>
        </tr>
        <tr>
            <td align="left" width="19%">&nbsp;&nbsp;银行卡号</td>
            <td align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="CARDNO" value="6225880113756648"/>
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
                <input size="50" type="text" name="PHONENO" value="13552535506"/>
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
            <td align="left" width="19%">&nbsp;&nbsp;后端回调URL</td>
            <td align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="NOTIFY_URL"
                       value="http://127.0.0.1:20044/open/quickpay/merchnoCallBack"/>
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
            <td align="left" width="19%">&nbsp;&nbsp;用户ID</td>
            <td align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="USER_ID" value=""/> 如无需绑卡不需传入此字段
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

</script>

</div>

</body>
</html>