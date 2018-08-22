<?php
error_reporting(E_ERROR);
require_once './lib/online.class.php';
$msg = ''; $isCheck = true;
header('Content-Type:text/html; charset=utf-8');
if($_POST)
{
    //head
    $merMod = new online();
    $merMod->SetCommandID(hexdec('0x0912'));
    $merMod->SetSeqID('1');
    $merMod->SetNodeType('3');
    $merMod->SetNodeID('openapi');
    $merMod->SetVersion('1.0.0');
	$merMod->SetAGENTNO(payconfig::AGENTNO);//报文头机构或代理ID
	$merMod->SetMERNO(payconfig::MERNO);
	$merMod->SetTERMNO(payconfig::TERMNO);
	
	//业务数据包	Body
	$merMod->SetMERORDERID($_POST['MERORDERID']);
	$merMod->SetAMT($_POST['AMT']);
	$merMod->SetGOODSNAME($_POST['GOODSNAME']);
	$merMod->SetNOTIFY_URL($_POST['NOTIFY_URL']);
	$merMod->SetJUMP_URL($_POST['JUMP_URL']);
	$merMod->SetPAY_CHANNEL($_POST['PAY_CHANNEL']);
	$merMod->SetREMARK($_POST['REMARK']);

    if($isCheck){
			//设置附件
            $merMod->BodyAes();
            $merMod->MakeSign();

		$result = $merMod->sendHtml();
			echo $result;
	   }
    
}

	
?>
