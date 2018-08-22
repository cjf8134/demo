<?php
/* *
 * 功能：甬易支付即时到账（直连银行）接口MD5签名方法页面
 * 版本：2.0
 * 日期：2017-04-20
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户应根据自己网站的需要，按照技术文档编写。
 */
$configFile = "./merchantInfo.ini";
$pfxPath = getini("pfxPath",$configFile);//你的.pfx私钥文件路径
$pfxPwd = getini("pfxPwd",$configFile);  //你的.pfx私钥文件密码
$cerPath = getini("cerPath",$configFile);//你的.cer公钥文件路径
/**
 * 证书验签：如非特殊商户，自2017年5月1日起，都用CERT证书方式验签！
 * 签名  生成签名串  基于sha1withRSA
 * @param string $data 签名前的字符串
 * @return string 签名串
 */
function certSign($data) {
    global $pfxPath, $pfxPwd;
    $certs = array();
    openssl_pkcs12_read(file_get_contents($pfxPath), $certs, $pfxPwd);
    //其中password为你的证书密码
    if(!$certs) return ;
    $signature = '';
    openssl_sign($data, $signature, $certs['pkey']);
    return base64_encode($signature);
}

/**
 * 验签  验证签名  基于sha1withRSA
 * @param $tranData 交易数据（base64密文）
 * @param $signature 签名串
 * @return 验签成功返回1，失败0，错误返回-1
 */
function verifyData($tranData, $signature) {
    global $cerPath;
    return verify($tranData, $signature, $cerPath);
}

/**
 * 验签  验证签名  基于sha1withRSA
 * @param $tranData 交易数据（base64密文）
 * @param $signature 签名串
 * @param $cerFilePath 公钥cer文件路径
 * @return 验签成功返回1，失败0，错误返回-1
 */
function verify($tranData, $signature, $cerFilePath) {
    $signature_str = base64_decode($signature);
    $sourceData = base64_decode($tranData);
    $public_key = file_get_contents($cerFilePath);
    
    $result = openssl_verify($sourceData, $signature_str, $public_key);
    // openssl_verify验签成功返回1，失败0，错误返回-1
    return $result;
}
//====================================================================================

/**
 * 说明：2017年5月前的原有商户、特殊商户，仍沿用MD5算法。
 * 注：先前对接成功的普通商户，2017年5月以后改造、扩展新接口的，也应升级成证书验签！
 */
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

//函数 parse_ini_file。
function getini($key,$inifile){
    $array = parse_ini_file($inifile);
    return $array[$key];
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
?>	