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
	$xml = "<root>";
	foreach ($arr as $key=>$val){
		if(is_array($val)){
			$xml.="<".$key.">".arrayToXml($val)."</".$key.">";
		}else{
			$xml.="<".$key.">".$val."</".$key.">";
		}
	}
	$xml.="</root>";
	return $xml;
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