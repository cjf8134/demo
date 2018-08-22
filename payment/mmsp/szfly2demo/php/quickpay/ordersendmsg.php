<?php

require_once '../lib/quickpay.class.php';
$msg = ''; $isCheck = true;
if($_POST){

    //head
    $merMod = new quickpay();
    $merMod->SetCommandID(hexdec('0x030A'));
    $merMod->SetSeqID('1');
    $merMod->SetNodeType('3');
    $merMod->SetNodeID('openapi');
    $merMod->SetVersion('1.0.0');
	$merMod->SetAGENTNO(payconfig::AGENTNO);//报文头机构或代理ID
	$merMod->SetMERNO(payconfig::MERNO);
	$merMod->SetTERMNO(payconfig::TERMNO);
	//业务数据包	Body
	$merMod->SetLIST_ID($_POST['LIST_ID']);
	//$merMod->SetMSG_CODE($_POST['MSG_CODE']);

    
    if($isCheck){
            //设置附件
            $merMod->BodyAes();
            $merMod->MakeSign();
            $result = $merMod->send();
            var_dump($result);   
       }
}

?>
<meta charset="utf-8">
<script src="./js/head.js"></script>
<form method="post" action="sendmsg.php" target="_blank">
    <table width="60%" border="0" align="center" cellpadding="5" cellspacing="5"
           style="border:solid 1px #1a88d5; margin-top:20px">
        <tr>
            <td align="left" bgcolor="#ABD8ED" height="25" colspan="2">接口示例：</td>
        </tr>
        <tr>
            <td align="left" width="16%">&nbsp;&nbsp;平台流水号</td>
            <td width="84%" align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="LIST_ID" value=""/>
            </td>
        </tr>

        <tr>
            <td align="left" width="16%">&nbsp;&nbsp;</td>
            <td align="left">&nbsp;&nbsp;<input type="submit" value="重发"/>&nbsp;&nbsp;<a href="index.php">返回</a></td>
        </tr>

    </table>
</form>


</div>

</body>
</html>








