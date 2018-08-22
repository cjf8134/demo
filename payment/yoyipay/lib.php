<?php

function createSign($data,$md5key) 
{
		$md5str = "";
		ksort($data);
	foreach ($data as $key => $val) {
		if($val!==""){
			$md5str.= $key.$val ;
		}
		
	}
		return md5($md5str.$md5key);
}

function get_millisecond()  
    {  
            list($usec, $sec) = explode(" ", microtime());  
            $msec=round($usec*1000);  
            return $msec;  
               
    }

function getMd5($data){
	return  strtoupper(md5($data));
}

function getHmacMd5($data,$key,$merchantId)
{
	$enkey= getMd5($key).$merchantId;
	$enkey= getMd5($enkey);
	return HmacMd5($data,$enkey);
}

function HmacMd5($data,$key)
{
	// RFC 2104 HMAC implementation for php.
	// Creates an md5 HMAC.
	// Eliminates the need to install mhash to compute a HMAC
	// written by shihh

	//需要配置环境支持iconv，否则中文参数不能正常处理
	$key = iconv("GB2312","UTF-8",$key);
	$data = iconv("GB2312","UTF-8",$data);

	$b = 64; // byte length for md5
	if (strlen($key) > $b) {
		$key = pack("H*",md5($key));
	}
	$key = str_pad($key, $b, chr(0x00));
	$ipad = str_pad('', $b, chr(0x36));
	$opad = str_pad('', $b, chr(0x5c));
	$k_ipad = $key ^ $ipad;
	$k_opad = $key ^ $opad;

	return md5($k_opad . pack("H*",md5($k_ipad . $data)));
}

function arrayToXml($arr){
	$xml = "";
	foreach ($arr as $key=>$val){
		if(is_array($val)){
			$xml.="<".$key.">".arrayToXml($val)."</".$key.">";
		}else{
			$xml.="<".$key.">".$val."</".$key.">";
		}
	}
	return $xml;
}

function certSign($data) {
	global $pfxPath, $pfxPwd;

	$certs = array();
	openssl_pkcs12_read(file_get_contents($pfxPath), $certs, $pfxPwd);
	//其中password为你的证书密码
	if(!$certs) return ;
	print_r($certs);
	$signature = '';
	openssl_sign($data, $signature, $certs['pkey']);
	return base64_encode($signature);
}


function httpRequest($url, $method, $postfields = null, $headers = array(), $debug = false) {
	$method = strtoupper($method);
	$ci = curl_init();
	/* Curl settings */
	curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
	curl_setopt($ci, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0");
	curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 60); /* 在发起连接前等待的时间，如果设置为0，则无限等待 */
	curl_setopt($ci, CURLOPT_TIMEOUT, 7); /* 设置cURL允许执行的最长秒数 */
	curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
	switch ($method) {
		case "POST":
			curl_setopt($ci, CURLOPT_POST, true);
			if (!empty($postfields)) {
				$tmpdatastr = is_array($postfields) ? http_build_query($postfields) : $postfields;
				//return $tmpdatastr;exit;
				curl_setopt($ci, CURLOPT_POSTFIELDS, $tmpdatastr);
			}
			break;
		default:
			curl_setopt($ci, CURLOPT_CUSTOMREQUEST, $method); /* //设置请求方式 */
			break;
	}
	$ssl = preg_match('/^https:\/\//i',$url) ? TRUE : FALSE;
	curl_setopt($ci, CURLOPT_URL, $url);
	if($ssl){
		curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
		curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE); // 不从证书中检查SSL加密算法是否存在
	}
	//curl_setopt($ci, CURLOPT_HEADER, true); /*启用时会将头文件的信息作为数据流输出*/
	curl_setopt($ci, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ci, CURLOPT_MAXREDIRS, 2);/*指定最多的HTTP重定向的数量，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的*/
	curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ci, CURLINFO_HEADER_OUT, true);
	/*curl_setopt($ci, CURLOPT_COOKIE, $Cookiestr); * *COOKIE带过去** */
	$response = curl_exec($ci);
	$requestinfo = curl_getinfo($ci);
	$http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
	if ($debug) {
		echo "=====post data======\r\n";
		var_dump($postfields);
		echo "=====info===== \r\n";
		print_r($requestinfo);
		echo "=====response=====\r\n";
		print_r($response);
	}
	curl_close($ci);
	return $response;
	//return array($http_code, $response,$requestinfo);
}
function httpClient($data, $url) 
{
		$postdata = http_build_query($data);
		try {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
			$res = curl_exec($ch);
			curl_close($ch);
			return $res;
		} catch (Exception $e) {
			$errorMsg = $e->getMessage();
			return false;
		}
}

function request_form($data=array(),$url='') {
	
	if (count($data) > 0) {
		$string = "<form style='display:none;' id='form1' name='form1' method='post' action='" . $url . "'>";
		foreach ($data as $key => $value) {
			if (!isset($value) || is_null($value) || empty($value)) {
				unset($data[$key]);
				continue;
			} else {
				$string .= "<input name='" . $key . "' type='text' value='" . $value . "' />";
			}
		}
		$string .= "</form>";
		$string .= "<script type='text/javascript'>function load_submit(){document.form1.submit()}load_submit();</script>";
		echo $string;
	}
}

function logResult($word='') {
	$fp = fopen("log.txt","a");
	flock($fp, LOCK_EX) ;
	fwrite($fp,"执行日期：".strftime("%Y%m%d%H%M%S",time())."\n".$word."\n");
	flock($fp, LOCK_UN);
	fclose($fp);
}

?>