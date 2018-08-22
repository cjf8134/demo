<?php
//error_reporting(0);
//快捷支付绑卡DEMO
require_once '../lib/quickpay.class.php';
$msg = ''; $isCheck = true;
if($_GET){

    //head
    $merMod = new quickpay();
    $merMod->SetCommandID(hexdec('0x030C'));
    $merMod->SetSeqID('1');
    $merMod->SetNodeType('3');
    $merMod->SetNodeID('openapi');
    $merMod->SetVersion('1.0.0');
	$merMod->SetAGENTNO(payconfig::AGENTNO);//报文头机构或代理ID
	$merMod->SetMERNO(payconfig::MERNO);
	$merMod->SetTERMNO(payconfig::TERMNO);
    
    //业务数据包 Body
    $merMod->SetMERORDERID($_GET['MERORDERID']);
    $merMod->SetPHONENO($_GET['PHONENO']);
    $merMod->SetRANDSTR((string)time());
    $merMod->SetBIND_ID($_GET['BIND_ID']);
    $merMod->SetAMT($_GET['AMT']);
    $merMod->SetUSER_ID($_GET['USER_ID']);

    if($isCheck){
            //设置附件
            $merMod->BodyAes();
            $merMod->MakeSign();
            $result = $merMod->send();
            var_dump($result);            
       }
}

?>