<?php
/* *
 *���ܣ�����֧����������֧�����ʶ�����ѯ�ӿڣ�Ŀǰֻ�ܲ�ѯ�����µ�ʱ��12Сʱ���ڵģ�
 *�汾��3.0
 *���ڣ�2017-06-30
 *˵����
 *���´���ֻ��Ϊ�˷����̻����Զ��ṩ���������룬�̻����Ը����Լ���վ����Ҫ�����ռ����ĵ���д,
 *����һ��Ҫʹ�øô��롣�ô������ѧϰ���о�����֧���ӿ�ʹ�ã���Ϊ�ṩһ���ο���
 **/
	
        date_default_timezone_set('UTC');
	include_once("./merchant.php");
	
	$code = "1685";    //�̻���
        $input_charset="UTF-8";	
	$sign_type ="RSA-S";
        
        $orderId ="";
        $result_format="JSON";
	$interfaceVersion ="2.0.1";
		
	$beginTime = "";//date("2018-01-01");	
	$endTime = "";//date("2018-05-05");

	$pageIndex= "1";
        $pageSize= "20"	;
        $timestamps= time()-8*60*60;//��׼UTC�������޸�
 
	$signStr= "";
	if($beginTime != ""){
	$signStr = $signStr."beginTime=".$beginTime."&";
	}
	$signStr = $signStr."code=".$code."&";	

        if($endTime != ""){
	$signStr = $signStr."endTime=".$endTime."&";
	}

	$signStr = $signStr."input_charset=".$input_charset."&";
        $signStr = $signStr."interfaceVersion=".$interfaceVersion ."&";
	
        if($orderId != ""){
	
	$signStr = $signStr."orderId=".$orderId."&";	
	
        }

	
      if($result_format != ""){
	
	$signStr = $signStr."result_format=".$result_format."&";	
	
        }

	//$signStr = $signStr."result_format=".$result_format."&";		
	
	$signStr = $signStr."sign_type=".$sign_type."&";	
        $signStr = $signStr."timestamps=".$timestamps;	

	$rs = file_put_contents('C:/log.txt', "\r\n".$signStr, FILE_APPEND);
	//echo $signStr;
	
/////////////////////////////   ��ȡsignֵ��RSA-S���ܣ�  /////////////////////////////////


	$merchant_private_key= openssl_get_privatekey($merchant_private_key);

	openssl_sign($signStr,$sign_info,$merchant_private_key,OPENSSL_ALGO_MD5);
	
	$sign = base64_encode($sign_info);

	//echo $sign;
	//$rs = file_put_contents('C:/log.txt', "\r\n".$sign, FILE_APPEND);

?>
<!-- ��post��ʽ�ύ���нӿڲ�������ѯ����https://query.fastbank.net/query -->
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<body onLoad="javascript:document.getElementById('queryForm').submit();">
		<form  id="queryForm" action="http://192.168.50.188/csepay/GetOrderList" method="post"  target="_self">
			<input type="hidden" name="sign"	value="<?php echo $sign?>" />
			<input type="hidden" name="orderId" value="<?php echo $orderId?>" />
			<input type="hidden" name="code"     value="<?php echo $code?>"/>
			<input type="hidden" name="beginTime"      value="<?php echo $beginTime?>"/>
			<input type="hidden" name="endTime"  value="<?php echo $endTime?>"/>		
			<input type="hidden" name="result_format"  value="<?php echo $result_format?>"/>
			<input type="hidden" name="interfaceVersion" value="<?php echo $interfaceVersion?>"/>
			<input type="hidden" name="pageIndex"    value="<?php echo $pageIndex?>">
	         	<input type="hidden" name="sign_type" value="<?php echo $sign_type?>"/>			
			<input type="hidden" name="pageSize"     value="<?php echo $pageSize?>"/>
			<input type="hidden" name="timestamps"    value="<?php echo $timestamps?>"/>
			<input Type="hidden" Name="input_charset"     value="<?php echo $input_charset?>"/>		
		</form>
	</body>
</html>