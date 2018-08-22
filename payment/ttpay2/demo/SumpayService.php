<?php
// $defaultCharset = 'GB2312';
include 'AesServer.php';
include 'httpclient.php';
function execute($url, $charset, $data, $privateKeyName, $password, $publicKeyName, $domain, $charset_change_fields, $encrypted_fields, $special_fields, $defaultCharset) {
	
	$data = charsetChange ( $charset_change_fields, $data, $charset, $defaultCharset );
	$aes = new CryptAES();
	$aesKey = $aes -> getAesKey ();
	$aes->set_key($aesKey);
	$aes->require_pkcs5();
	$data = encryptByAesKey ( $encrypted_fields, $aesKey, $data , $aes);
	$aesKey = encrpyt ( base64_encode($aesKey), $publicKeyName );
	$data ['aes_key'] = $aesKey;
	$data = specialChange ( $special_fields, $data );
	$signStr = sign ( getStr ( $data ), $privateKeyName, $password );
	$data ['sign'] = $signStr;
	$data ['sign_type'] = 'CERT';
	$optional_headers = "Referer: " . $domain . "\r\n";
	return do_post_request ( $url, $data, $optional_headers );
}
function charsetChange($charset_change_fields, $data, $merCharset, $defaultCharset) {
	foreach ( $charset_change_fields as $key ) {
		if (isset ( $data [$key] )) {
			$value = $data [$key];
			if ($value && "" != $value) {
				$data [$key] = iconv ( $merCharset, $defaultCharset, $value );
			}
		}
	}
	return $data;
}
function encryptByAesKey($encrypted_fields, $aesKey, $data, $aes) {
	foreach ( $encrypted_fields as $key ) {
		if (isset ( $data [$key] )) {
			$value = $data [$key];
			if ($value && "" != $value) {
				$data [$key] = $aes->encrypt($value); 
			}
		}
	}
	return $data;
}
function specialChange($special_fields, $data) {
	foreach ( $special_fields as $key ) {
		if (isset ( $data [$key] )) {
			$value = $data [$key];
			if ($value && "" != $value) {
				$data [$key] = base64_encode ( $value );
			}
		}
	}
	return $data;
}

?>