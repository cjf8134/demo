<?php

/**
 * 得到当前的毫秒数
 * @return number
 */
function getMillisecond() {
	list($s1, $s2) = explode(' ', microtime());
	return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
}


/**
 * 重定向浏览器到指定的 URL
 * www.jbxue.com
 * @param string $url 要重定向的 url
 * @param int $delay 等待多少秒以后跳转
 * @param bool $js 指示是否返回用于跳转的 JavaScript 代码
 * @param bool $jsWrapped 指示返回 JavaScript 代码时是否使用 <mce:script type="text/javascript"><!--
 标签进行包装
 * @param bool $return 指示是否返回生成的 JavaScript 代码
 */
function redirect($url, $delay = 0, $js = false, $jsWrapped = true, $return = false)
{
	$delay = (int)$delay;
	if (!$js) {
		if (headers_sent() || $delay > 0) {
			echo <<<EOT
<html>
<head>
<meta http-equiv="refresh" content="{$delay};URL={$url}" />
</head>
</html>
EOT;
    			exit;
   		} else {
    		header("Location: {$url}");
    		exit;
   		}
  	}
  
  	$out = '';
  	if ($jsWrapped) {
   		$out .= '<script language="JavaScript" type="text/javascript">';
  	}
  	$url = rawurlencode($url);
  	if ($delay > 0) {
   		$out .= "window.setTimeOut(function () { document.location='{$url}'; }, {$delay});";
  	} else {
   		$out .= "document.location='{$url}';";
  	}
  	if ($jsWrapped) {
   		$out .= '
 		// --></mce:script>';
  	}
  
  	if ($return) {
   		return $out;
  	}
  
  	echo $out;
  	exit;
 }
 
 /**
  * 循环获取get或post请求中的参数
  * @return unknown[]
  */
 function getRequstParamters($HTTP_GET_VARS,$HTTP_POST_VARS){
 	$params = array();
 	if(is_array($HTTP_GET_VARS) && $HTTP_GET_VARS){
 		foreach ($HTTP_GET_VARS as $key => $value){
 			if(is_array($HTTP_GET_VARS[$key])){
 				foreach ($HTTP_GET_VARS[$key] as $key2 => $value2){
 					$params[$key][$key2] = $value2;
 				}
 			}else{
 				$params[$key] = $value;
 			}
 		}
 		return $params;
 	}
 	if(is_array($HTTP_POST_VARS) && $HTTP_POST_VARS){
 		foreach ($HTTP_POST_VARS as $key => $value){
 			if(is_array($HTTP_POST_VARS[$key])){
 				foreach ($HTTP_POST_VARS[$key] as $key2 => $value2){
 					$params[$key][$key2] = $value2;
 				}
 			}else{
 				$params[$key] = $value;
 			}
 		}
 		return $params;
 	}
 	
 }
 
 /**
  * 对接口返回的数据进行签名验证
  * @param unknown $params
  * @return boolean
  */
 function verifySign($params){
 	$pu_key = openssl_get_publickey(file_get_contents(SysConfig::CER_PATH));
 	//1、组装urlStr
 	$sign = $params["sign"];

 	ksort($params);
 	$string = mb_convert_encoding(ToUrlParams($params),"GBK",SysConfig::ENCODING);

 	
 	//$pu_key = openssl_pkey_get_public($publicKeyString);//这个函数可用来判断公钥是否是可用的
 	
 	$result = (bool)openssl_verify($string, base64_decode($sign), $pu_key,"SHA256");
 	if($result){
 		return true;
 	}else{
 		return false;
 	}
//  	$string = $string . "&key=".SysConfig::KEY;
//  	$string = hash("sha256", $string);
//  	if($params["sign"] == $string){
//  		return true;
//  	}else{
//  		return false;
//  	}

 }
 
/**
 * 
 * 拼接签名字符串
 * @param array $urlObj
 * 
 * @return 返回已经拼接好的字符串
 */
function ToUrlParams($urlObj)
{
	$buff = "";
	foreach ($urlObj as $k => $v)
	{
		if($k != "sign" && $v != NULL){
			$buff .= $k . "=" . $v . "&";
		}
	}
	
	$buff = trim($buff, "&");
	return $buff;
}

/**
 * 将参数拼接成Url形式并进行url转码
 * @param unknown $urlObj
 * @return string
 */
function ToRequestUrlParams($urlObj){
	$buff = "";
	foreach ($urlObj as $k => $v)
	{
		if($k != "sign"){
			$buff .= $k . "=" . urlencode($v) . "&";
		}
	}
	
	$buff = trim($buff, "&");
	return $buff;
}

/**
 * 将xml转成array
 * @param unknown $str1
 */
function xmlToArray($str1){
	$dom = new DOMDocument();
	$dom->loadXML($str1);
	return getArray($dom->documentElement);
}

/**
 * 循环节点将xml转换成array
 * 注：只循环二级节点，根节点省略，二级以下取所有文本
 * @param unknown $node
 * @return boolean|string
 */
function getArray($node) {
	$array = false;
	if ($node->hasChildNodes()) {
		foreach ($node->childNodes as $childNode) {
			if ($childNode->childNodes->item(0) != null && $childNode->childNodes->item(0)->nodeType != XML_TEXT_NODE  ) {
				$array[$childNode->nodeName] = getXmlContent($childNode);
			}else{
				$array[$childNode->nodeName] = $childNode->nodeValue;
			}
		}
	}
	return $array;
}

/**
 * 将节点以原有xml形式展示
 * @param unknown $node
 * @return string
 */
function getXmlContent($node){
	$str = "";
	if ($node->hasChildNodes()) {
		foreach ($node->childNodes as $childNode) {
			if ($childNode->nodeType != XML_TEXT_NODE) {
				$str=$str."<".$childNode->nodeName.">";
				$str.=getXmlContent($childNode);
				$str=$str."</".$childNode->nodeName.">";
			}else{
				$str.=$childNode->nodeValue;
			}
		}
	}
	return $str;
}

?>
