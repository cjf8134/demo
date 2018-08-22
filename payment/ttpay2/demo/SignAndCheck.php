<?php

function sign($data, $privateKeyPath, $password){
	$certs = array();
	openssl_pkcs12_read(file_get_contents($privateKeyPath), $certs, $password);
	if(!$certs){
		return;
	}
	$signature = '';
	openssl_sign($data, $signature, $certs['pkey'], 'sha256');
	return base64_encode($signature);
}

function verify($data, $signature, $publicKeyName){
	$result = (bool)openssl_verify($data, base64_decode($signature), file_get_contents($publicKeyName), 'sha256');
	return $result;
}

function encrpyt($data, $publicKeyName){
	openssl_public_encrypt($data,$encrypted,file_get_contents($publicKeyName));//¹«Ô¿¼ÓÃÜ
	return base64_encode($encrypted);
}

function getStr($parameters){
	
	$parameters = array_filter($parameters,create_function('$v','return $v != \'\';'));
	$needSign = '';
	$first = true;
	ksort($parameters);
	foreach (array_keys($parameters) as $key){
		if($first){
			$first = false;
		}else{
			$needSign .= "&";
		}
		$needSign .= $key;
		$needSign .= "=";
		$needSign .= $parameters[$key];
	}
	return $needSign;
}

?>