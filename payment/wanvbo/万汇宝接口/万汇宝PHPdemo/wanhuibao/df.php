<?php
/**
 * 全球付代付demo
 */
date_default_timezone_set('Asia/Shanghai');
$para = [
    'mer_no' => '123456',//商家号
    'mer_remit_no' => 'NO'.date('YmdHis'),//商户订单号
    'apply_date' => date('Y-m-d H:i:s'),//申请时间
    'bank_code' => 'PABC',//银行code
    'province' => '广东省',//省份
    'city' => '深圳市',//城市
    'card_and_name' => '6230580000135712345' . '|' . '小明',//卡号姓名
    'amount' => sprintf("%.2f", 10),//金额，单位：元

];

$aes_str = $para['card_and_name'];
$key = '888888';//秘钥
//AES 加密 start
$blocksize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
$pad = $blocksize - (strlen($aes_str) % $blocksize);
$aes_str = $aes_str . str_repeat(chr($pad), $pad);
$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
mcrypt_generic_init($td, $key, @mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND));
$cyper_text = mcrypt_generic($td, $aes_str);
$rt = bin2hex($cyper_text);
mcrypt_generic_deinit($td);
mcrypt_module_close($td);
//AES 加密 end

$para['card_and_name'] = $rt;


ksort($para);
reset($para);
$prestr = '';
foreach ($para as $k => $val) {
    $prestr .= $k . "=" . $val . "&";
}
$prestr .= 'key=888888';//秘钥

$para['sign_type'] = 'MD5';
$para['sign'] = strtoupper(md5($prestr));


$df_url = 'http://remit.wanvbo.com/remit/doRemit';


$msg = http_build_query($para);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $df_url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS,$msg);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);

print_r($result);
echo "<pre>";