<?php


function createSign($data,$md5key) 
{
		$md5str = "";
		ksort($data);
		reset($data);
	foreach ($data as $key => $val) {
		if($val!==""){
			$md5str.= $key.$val ;
		}
		
	}
		return md5($md5str.$md5key);
}

/**
 * CURL请求
 * @param $url 请求url地址
 * @param $method 请求方法 get post
 * @param null $postfields post数据数组
 * @param array $headers 请求header信息
 * @param bool|false $debug  调试开启 默认false
 * @return mixed
 */
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


function getSignature($str, $key) {
	$signature = "";
	if (function_exists('hash_hmac')) {
		$signature = bin2hex(hash_hmac("sha1", $str, $key, true));

	} else {
		$blocksize = 64;
		$hashfunc = 'sha1';
		if (strlen($key) > $blocksize) {
			$key = pack('H*', $hashfunc($key));
		}
		$key = str_pad($key, $blocksize, chr(0x00));
		$ipad = str_repeat(chr(0x36), $blocksize);
		$opad = str_repeat(chr(0x5c), $blocksize);
		$hmac = pack(
			'H*', $hashfunc(
				($key ^ $opad) . pack(
					'H*', $hashfunc(
						($key ^ $ipad) . $str
					)
				)
			)
		);
		$signature = bin2hex($hmac);
	}
	return $signature;
}

function  getUrlStr($transMap){
	//排序
	ksort($transMap);

	$transStr="";
	$flag=1;
	foreach($transMap as $v=>$a)
	{
		if(sizeof($transMap)==$flag){
			$transStr= $transStr.$v."=".$a;
		}else{
			$transStr= $transStr.$v."=".$a."&";
		}
		$flag++;

	}

	return 	$transStr;
}


function  md5sign($data){
	ksort($data);
	reset($data);
	$md5str = "";
	foreach($data as $k=>$v){
		if($v != ""){
			$md5str .= $k . "=" . $v . "&";
		}
	}

	$md5str = rtrim($md5str,"&");
	return $md5str;

}

function get_millisecond()  
    {  
            list($usec, $sec) = explode(" ", microtime());  
            $msec=round($usec*1000);  
            return $msec;  
               
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
// 定义一个函数getIP() 客户端IP，
function get_ip(){
	if (getenv("HTTP_CLIENT_IP"))
		$ip = getenv("HTTP_CLIENT_IP");
	else if(getenv("HTTP_X_FORWARDED_FOR"))
		$ip = getenv("HTTP_X_FORWARDED_FOR");
	else if(getenv("REMOTE_ADDR"))
		$ip = getenv("REMOTE_ADDR");
	else $ip = "Unknow";

	if(preg_match('/^((?:(?:25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d)))\.){3}(?:25[0-5]|2[0-4]\d|((1\d{2})|([1 -9]?\d))))$/', $ip))
		return $ip;
	else
		return '';
}

/**
 * @param $xml
 * @return mixed
 * xml 转数组
 */
function xmltoarray($xml){
	libxml_disable_entity_loader(true);

	$xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);

	$val = json_decode(json_encode($xmlstring),true);

	return $val;
}

function arrayToXml($arr){
	$xml = "<xml>";
	foreach ($arr as $key=>$val){
		if(is_array($val)){
			$xml.="<".$key.">".arrayToXml($val)."</".$key.">";
		}else{
			$xml.="<".$key.">".$val."</".$key.">";
		}
	}
	$xml.="</xml>";
	return $xml;
}
function logResult($word='') {
	$fp = fopen("log.txt","a");
	flock($fp, LOCK_EX) ;
	fwrite($fp,"执行日期：".strftime("%Y%m%d%H%M%S",time())."\n".$word."\n");
	flock($fp, LOCK_UN);
	fclose($fp);
}

function ArrayToStr($data,$pay_url){
	$str = "";
	foreach($data as $k=>$v){
		$str.= $k ."=".$v."&";
	}
	$str = rtrim($str,"&");
	$request_url = $pay_url. "?" . $str;
	return $request_url;
}

?>