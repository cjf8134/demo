<?php
require_once './lib/zfbscan.class.php';
error_reporting(E_ERROR);

$MERORDERID = rand(10000000,99999999);
$rand = rand(10000000,99999999);//每次请求下预订单随机一个字符串


if ($_POST) {

    $zfbscanMod = new zfbscan();
    //请求头
    $zfbscanMod->SetCommandID(hexdec('0x0904'));
    $zfbscanMod->SetSeqID('1');
    $zfbscanMod->SetNodeType('3');
    $zfbscanMod->SetNodeID('openplat');
    $zfbscanMod->SetVersion('1.0.0');
    $zfbscanMod->SetAGENTNO($_POST['AGENTNO'] ? $_POST['AGENTNO'] : payconfig::AGENTNO);
    $zfbscanMod->SetMERNO($_POST['MERNO'] ? $_POST['MERNO'] : payconfig::MERNO);
    $zfbscanMod->SetTERMNO($_POST['TERMNO'] ? $_POST['TERMNO'] : payconfig::TERMNO);
    //请求体
    $zfbscanMod->SetTRADETYPE($_POST['TRADETYPE']);
    $zfbscanMod->SetAMT($_POST['AMT']);
    $zfbscanMod->SetCUR($_POST['CUR']);
    $zfbscanMod->SetGOODSNAME($_POST['GOODSNAME']);
    $zfbscanMod->SetNOTIFY_URL($_POST['NOTIFY_URL']);
    $zfbscanMod->SetTIME_END($_POST['TIME_END']);
    $zfbscanMod->SetIP($_POST['IP']);
    $zfbscanMod->SetJUMP_URL($_POST['JUMP_URL']);
    $zfbscanMod->SetMERORDERID($_POST['MERORDERID']);
    $zfbscanMod->SetRANDSTR($_POST['RANDSTR']);
    $zfbscanMod->SetALIPAY_USER_ID($_POST['ALIPAY_USER_ID']);
    $zfbscanMod->SetALIPAY_ACCOUNT($_POST['ALIPAY_ACCOUNT']);
    $zfbscanMod->SetIST0($_POST['IST0']);
    $zfbscanMod->SetRAW($_POST['IS_RAW']);

    $zfbscanMod->BodyAes();
    $zfbscanMod->MakeSign();
    $return =  $zfbscanMod->send();
    $msg = '';
    //var_dump($return);
    if($return){
        if($return['STATUS'] == 1)
        {
            //STATUS表示上送成功，此处可以开始设置商户自己的密钥过期时间
            $msg = '返回报文：'.json_encode($return , JSON_UNESCAPED_UNICODE);
            $img = '支付连接(用工具转成二维码用手机扫码支付)：<br /><img style="width:200px;height:200px;" src="./qrcode.php?url='.urlencode($return['URL']).'" ';
        }else
        {
            $msg = '交易失败, 错误信息: '.$return['ErrorMsg'];
        }
    }else{
        $msg = '网络请求错误';
    }
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0" />
    <title>支付宝正扫/公众号-测试demo</title>
    <link rel="stylesheet" type="text/css" href="./css/common.css" />
   
</head>

<body>

<div class="ox">
    <!--支付状态-->
    <div class="state" style="padding:10px 1px 1px 1px;">
    	<span class="fail">支付宝正扫/公众号支付测试</span>
    </div>
    <hr/>
    <div style="padding-left:30px; color:red; font-size:18px;"><?php echo $msg;?><br/><?php echo $img;?></div>
    <div class="state" style="margin-top:20px; padding:0px;">
        <form action="zfbsan.php" enctype="application/x-www-form-urlencoded" method="post" accept-charset="utf-8">
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
                    <td align="left" width="25%" style="padding-left:10px;">交易类型</td>
                    <td align="left"><select name='TRADETYPE'><option value="1">正扫</option><option value="2">服务窗支付</option></select></td>
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
                    <td  align="left"><input type="text" name="NOTIFY_URL" value="http://195.75.3.204:1680/zfbsan.php" /></td>
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
                    <td  align="left"><input type="text" name="JUMP_URL" value="http://195.75.3.204:1680/zfbsan.php" /></td>
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
                    <td align="left" width="25%" style="padding-left:10px;">支付宝用户id</td>
                    <td  align="left"><input type="text" name="ALIPAY_USER_ID" value=""/>交易类型是支付宝服务窗支付的时候，必须上传</td>
                 </tr>
                 <tr>
                    <td align="left" width="25%" style="padding-left:10px;">支付宝买家账号</td>
                    <td  align="left"><input type="text" name="ALIPAY_ACCOUNT" value=""/>交易类型是支付宝服务窗支付的时候，若无id可上传账号</td>
                 </tr>
                 <tr>
                    <td align="left" width="25%" style="padding-left:10px;">是否使用原生js支付</td>
                    <td  align="left"><input type="text" name="IS_RAW" value="2" />
                    交易类型是支付宝服务窗支付的时候，必须上传</td>
                 </tr>
                 <tr>
                    <td></td>
                    <td align="left" ><input type="submit" style="cursor:pointer;"  value=" 提 交 "/></td>
                 </tr>
             </table>
        </form>
    </div>
</div>
</body>
</html>