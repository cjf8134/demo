<?php 
			require_once("pay_config.php");  //引用定义变量


            $apiurl = $apiurl['apiurl'];	//网关接口地址
            $partner = $partner['partner'];  //商户号
            $key = $Key['key'];		//MD5密钥，安全检验码
			
            $ordernumber =$_POST[txtordernumber]; //商户订单号
			
            $banktype =$_POST[txtbanktype]; //支付类型
			
            $attach = $_POST[txtattach];  //订单描述
			
			$paymoney =$_POST[txtpaymoney]; // 付款金额
			
            $callbackurl = $callbackurl['callbackurl'] ; //服务器异步通知页面路径
			
            $hrefbackurl = $hrefbackurl['hrefbackurl']; //页面跳转同步通知页面路径
			
            $signSource = sprintf("partner=%s&banktype=%s&paymoney=%s&ordernumber=%s&callbackurl=%s%s", $partner, $banktype, $paymoney, $ordernumber, $callbackurl, $key); //字符串连接处理
            $sign = md5($signSource);  //字符串加密处理
            $postUrl = $apiurl. "?banktype=".$banktype;
			$postUrl.="&partner=".$partner;
            $postUrl.="&paymoney=".$paymoney;
            $postUrl.="&ordernumber=".$ordernumber;
            $postUrl.="&callbackurl=".$callbackurl;
            $postUrl.="&hrefbackurl=".$hrefbackurl;
            $postUrl.="&attach=".$attach;
            $postUrl.="&sign=".$sign;
			header ("location:$postUrl");
?>