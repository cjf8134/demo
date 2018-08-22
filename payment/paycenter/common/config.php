<?php

class SysConfig{
//	//商户号
//	const PARTNER = '130';
//	//商户密钥
//	const KEY = '857e6g8y51b5k365f7v954s50u24h14w';
//	//支付请求网关访问地址
//	const PAY_URL = 'http://14.23.90.101/paycenter/v2.0/getoi.do';
//	//订单请求类网关访问地址
//	const ORDER_URL = 'https://14.23.90.101/paycenter/gateways.do';//'http://14.23.90.100/paycenter/gateways.do';
//	//本地字符编码
	const ENCODING = 'UTF-8';
	//版本号
	const VERSION = "4.0";
	//加密类型
	const SIGN_TYPE = "SHA256withRSA";
	//密钥地址
	const PFX_PATH = "./certs/yzt.pfx";
	//keystore密码
	const KEYSTORE_PASSWORD="yzt20160728";
	//私钥密码
	const PRIVATEKEY_PASSWORD="yzt20160728";
	//公钥地址
	const CER_PATH = "./certs/epaylinks_pfx.cer";
	
	
	const CURL_PROXY_HOST = "0.0.0.0";//"10.152.18.220";
	const CURL_PROXY_PORT = 0;//8080;
	
}

?>
