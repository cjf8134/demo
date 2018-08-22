<?php
/*
 * PHP 同步通知 DEMO
 */
$merchant_private_key = '-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQCewgHoZqrtH502+8u6CBC513alcyLL5cxM1jq6synq4TFN4BJ9
R5Z4//b8UaqzQi7YdxaEXEfWGG2bb6Cy8mScZUcXAl24urv9sfkh7AoIvfEA28qC
hSJ2imllqQffGGXsRFl+k/4JB1k2VYIYh8MQf1DkQWsggYek+abExCDgGwIDAQAB
AoGACKSnVe/A/ofqF0Q+IzKtNnD0lK1gB5nLNaO0LtXyQkdgV80LNKbhGlVVLQeF
M502z7IsF6iugIlz7jJ1nUh1EbgsW4n0EZ9lulYNK3TzB2WEMhSTaDJszLvIWiN0
n5uhmCER+O3hkmrSqwTxKcUFRBmUCHCfSORnEuMJXRMhxQECQQD9EojMzg1sUJ0s
VFRqMZQ7SrYsPCTLzedIVkyOD4Ootx6oq1srHBaLXS2wL8QjPAQUJraTZeRmVSEh
dLobS0tTAkEAoJgp4clivBksBIf+t+jJ/vKpVsSNhVAHLjGrMyqmCW0ZLwuOLrrk
95oJP2zTYAE6a7qt63UN7CHrleGsxsPHGQJBAIQiKz8TzrphFM9ScIjJviV/CsLp
3CR1K27/cBU0UH/ErMNQRNerYLH/Qp2dMwFakp6a3/Tx3GD5zcSUF5+snnUCQGLS
P7N4wREOTE/df5ib3vDLUfjaqltGi6SZW8f4joNuZvjUG4IV75+NYfNtfASvvMtd
7HffZ9nOZbGtVSxafMECQAqzU1J/mJ97tg4PpahllcAcHdxExygiAnxPkDOOLDrZ
SZKXphiC+tLQnkRuEez8b9LZ2JcDnwyUUrqcjaMkih8=
-----END RSA PRIVATE KEY-----';
//自己生成的私钥

$merchant_public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCewgHoZqrtH502+8u6CBC513al
cyLL5cxM1jq6synq4TFN4BJ9R5Z4//b8UaqzQi7YdxaEXEfWGG2bb6Cy8mScZUcX
Al24urv9sfkh7AoIvfEA28qChSJ2imllqQffGGXsRFl+k/4JB1k2VYIYh8MQf1Dk
QWsggYek+abExCDgGwIDAQAB
-----END PUBLIC KEY-----';
//自己生成的公钥

$ecpay_public_key='-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCOAoslcPOFmqk/Okv5sT3z+Tsn
wjCXtev4OPTM9oLQpr7DwHNYlXIxGkI0rf0RWW6zKMXvrNCYXBjanUYvi0ukM0uj
LJiZ+qMutRzxkckqN1ZXSRsjPoCG7S46M1Ew52TKYYkPm/53gqe+gQzdIEDAg8cu
xIbSiuKGr2em/jnRfQIDAQAB
-----END PUBLIC KEY-----';
/*由PAY提供的公钥*/

    $notify = $_GET["context"];

    $mer_private_key = openssl_pkey_get_private($merchant_private_key);//取私钥资源号

    $ec_public_key = openssl_pkey_get_public($ecpay_public_key);//取PAY公钥资源号

    $data = rsa_decrypt($notify, $mer_private_key);//执行解密流程

    $context_arr = json_decode($data, true);//转为数组格式

    $sign = $context_arr['businessHead']['sign'];//取SIGN

    $businessContext = $context_arr['businessContext'];//取businessContext

    ksort($businessContext);//按ASCII码从小到大排序

    $json_businessContext = json_encode($businessContext, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    $isVerify = (boolean) openssl_verify($json_businessContext, base64_decode($sign), $ec_public_key, OPENSSL_ALGO_MD5);

    if ($isVerify) {
        /**
         * 验签成功，执行商户自己的逻辑,显示商户想要显示的内容或者转发到想要显示的地址
         */
        header("Location:https://www.baidu.com/");/* Redirect browser */
    }

    /**
     * RSA解密
     * @param $encrypted
     * @param $rsa_private_key
     * @return string
     */
    function rsa_decrypt($encrypted, $rsa_private_key){
        $crypto = '';
        $encrypted = base64_decode($encrypted);
        foreach (str_split($encrypted, 128) as $chunk) {
            openssl_private_decrypt($chunk, $decryptData, $rsa_private_key);
            $crypto .= $decryptData;
        }
        return $crypto;
    }