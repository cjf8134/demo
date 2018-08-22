<?php
require_once './lib/wxscan.class.php';

error_reporting(E_ERROR);

if($_POST)
{
    
    $wxscanMod = new wxscan();
    if($_POST['WAY'] == '1'){
        $wxscanMod->SetCommandID(hexdec('0x0902'));
    }else{
        $wxscanMod->SetCommandID(hexdec('0x0915'));
    }
    
    $wxscanMod->SetSeqID('1');
    $wxscanMod->SetNodeType('3');
    $wxscanMod->SetNodeID('openplat');
    $wxscanMod->SetVersion('1.0.0');
    $wxscanMod->SetAGENTNO($_POST['AGENTNO']);//不传代理商就默认是商户交易
    $wxscanMod->SetMERNO($_POST['MERNO']);
    $wxscanMod->SetTERMNO($_POST['TERMNO']);
    $wxscanMod->SetTRADETYPE($_POST['TRADETYPE']);
    $wxscanMod->SetIST0($_POST['IST0']);
    $wxscanMod->SetAMT($_POST['AMT']);
    $wxscanMod->SetCUR($_POST['CUR']);
    $wxscanMod->SetGOODSNAME($_POST['GOODSNAME']);
    $wxscanMod->SetNOTIFY_URL($_POST['NOTIFY_URL']);
    $wxscanMod->SetTIME_END($_POST['TIME_END']);
    $wxscanMod->SetIP($_POST['IP']);
    $wxscanMod->SetJUMP_URL($_POST['JUMP_URL']);
    $wxscanMod->SetMERORDERID($_POST['MERORDERID']);
    $wxscanMod->SetRANDSTR($_POST['RANDSTR']);
    $wxscanMod->SetOPENID($_POST['OPENID']);
    $wxscanMod->SetSUP_APPID($_POST['SUB_APPID']);
    $wxscanMod->SetRAW($_POST['IS_RAW']);
    if($wxscanMod->GetTRADETYPE() == '2' && $wxscanMod->IsOPENIDSet() == false)
    {
        $msg = '公众号支付必须上次微信openid';
    }else 
    {
        $wxscanMod->BodyAes();
        $wxscanMod->MakeSign();
        $result =$wxscanMod->send();
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
}

// $openid = $_GET['openid'];
// $openid = 'o3vx6v058L4d_iW-U8LDQaXdm9DM';

$MERORDERID = rand(10000000,99999999);
$rand = rand(10000000,99999999);//每次请求下预订单随机一个字符串


// $wxscanMod = new wxscan();
// $wxscanMod->SetCommandID(hexdec('0x0902'));
// $wxscanMod->SetSeqID('1');
// $wxscanMod->SetNodeType('3');
// $wxscanMod->SetNodeID('openplat');
// $wxscanMod->SetVersion('1.0.0');
// $wxscanMod->SetAGENTNO(payconfig::AGENTNO);//不传代理商就默认是商户交易
// $wxscanMod->SetMERNO(payconfig::MERNO);
// $wxscanMod->SetTERMNO(payconfig::TERMNO);
// $wxscanMod->SetTRADETYPE('2');
// $wxscanMod->SetIST0('1');
// $wxscanMod->SetAMT('1');
// $wxscanMod->SetCUR('CNY');
// $wxscanMod->SetGOODSNAME('商品');
// $wxscanMod->SetNOTIFY_URL('http://195.75.3.204:1680/wxsan.php');
// //$wxscanMod->SetTIME_END($_POST['TIME_END']);
// //$wxscanMod->SetIP($_POST['IP']);
// //$wxscanMod->SetJUMP_URL($_POST['JUMP_URL']);
// $wxscanMod->SetMERORDERID($MERORDERID);
// $wxscanMod->SetRANDSTR($rand);
// $wxscanMod->SetOPENID($openid);
// $wxscanMod->SetRAW('2');
// $wxscanMod->BodyAes();
// $wxscanMod->MakeSign();
// $result =$wxscanMod->send();
// header('Location: '.$result['URL']);



?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0" />
    <title>微信正扫/公众号-测试demo</title>
    <link rel="stylesheet" type="text/css" href="./css/common.css" />
   
</head>

<body>

<div class="ox">
    <!--支付状态-->
    <div class="state" style="padding:10px 1px 1px 1px;">
    	<span class="fail">QQ/微信正扫/公众号支付测试</span>
    </div>
    <hr/>
    <div style="padding-left:30px; color:red; font-size:18px;"><?php echo $msg;?><br/><?php echo $img;?></div>
    <form method="post" action="wxsan.php">
    <div class="state" style="margin-top:20px; padding:0px;">
    	<table width="60%" style=" border-collapse:   separate;   border-spacing:   10px;"  border="1">
            <tr>
                <td align="left" width="25%" style="padding-left:10px;">支付方式</td>
                <td  align="left"><select name='WAY'><option value="1">微信</option><option value="2">QQ</option></select></td>
             </tr>
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
            	<td align="left" width="25%" style="padding-left:10px;">交易类型</td>
                <td align="left"><select name='TRADETYPE'><option value="1">正扫</option><option value="2">公众号支付</option></select></td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;">清算周期</td>
                <td  align="left"><select name='IST0'><option value="1">T1隔日清算</option><option value="2">T0今天清算</option></select></td>
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
                <td  align="left"><input type="text" name="NOTIFY_URL" value="http://195.75.3.204:1680/wxsan.php"/></td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;">订单过期时间</td>
                <td  align="left"><input type="text" name="TIME_END" placeholder="格式：2017-03-07 10：05：00"/></td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;">IP地址</td>
                <td  align="left"><input type="text" name="IP"/></td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;">支付成功后前台调转地址</td>
                <td  align="left"><input type="text" name="JUMP_URL" value="http://195.75.3.204:1680/wxsan.php"/></td>
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
            	<td align="left" width="25%" style="padding-left:10px;">微信appid</td>
                <td  align="left"><input type="text" name="SUB_APPID" value=""/>交易类型是公众号支付的时候上传,默认用伯尚的</td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;">微信openid</td>
                <td  align="left"><input type="text" name="OPENID" value="<?php echo $openid;?>"/>交易类型是公众号支付的时候，必须上传</td>
             </tr>
             <tr>
                <td align="left" width="25%" style="padding-left:10px;">是否使用原生js支付</td>
                <td  align="left"><input type="text" name="IS_RAW" value="2" />
                交易类型是公众号支付的时候，必须上传</td>
             </tr>
             <tr>
            	<td></td>
                <td align="left" ><input type="submit" style="cursor:pointer;"  value=" 提 交 "/></td>
             </tr>
         </table>
    </div>
    </form>
</div>
</body>
</html>