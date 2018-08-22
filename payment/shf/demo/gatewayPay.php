<?php
/*
 *  PHP 网关支付 DEMO
 *  RSA密钥格式 PKCS1 1024bit字节证书
 *
 *  常见问题:
 *  1.签名校验错误
 *     a. 公私钥密钥对不匹配，商户未把商户公钥配置到平台中
 *     b. businessContext业务参数未按ASCII大小从小到大排序
 *     c. businessContext转出来的JSON字符串带多余空格
 *     d. php的json_encode转出来的JSON字符串中文会自动UNICODE编码，需要强制不使用UNICODE编码
 *  2.加密校验错误
 *     a. 公私钥密钥对不匹配，商户使用的是不是系统提供的公钥
 *     b. 加密方法错误
 *  3.接收回调,密文解出来是空字符串
 *     a. 使用的不是对应的私钥解密
 *  4.本地验签失败
 *     a.使用的不是平台公钥验签
 *     b.返回的验签businessContext业务参数规则同步第1点b.c.d
 *     c.sign需要经过base64_decode再进行验签
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
/*商户自己生成的私钥*/

$merchant_public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCewgHoZqrtH502+8u6CBC513al
cyLL5cxM1jq6synq4TFN4BJ9R5Z4//b8UaqzQi7YdxaEXEfWGG2bb6Cy8mScZUcX
Al24urv9sfkh7AoIvfEA28qChSJ2imllqQffGGXsRFl+k/4JB1k2VYIYh8MQf1Dk
QWsggYek+abExCDgGwIDAQAB
-----END PUBLIC KEY-----';
/*商户自己生成的公钥*/

$ecpay_public_key='-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCOAoslcPOFmqk/Okv5sT3z+Tsn
wjCXtev4OPTM9oLQpr7DwHNYlXIxGkI0rf0RWW6zKMXvrNCYXBjanUYvi0ukM0uj
LJiZ+qMutRzxkckqN1ZXSRsjPoCG7S46M1Ew52TKYYkPm/53gqe+gQzdIEDAg8cu
xIbSiuKGr2em/jnRfQIDAQAB
-----END PUBLIC KEY-----';
/*由PAY提供的公钥*/

$server_url = 'http://127.0.0.1:8080';

    $businessHead = array(
        'charset' =>'00',
        'version'=>'V1.1.0',
        'merchantNumber'=>'PAY013401013607',
        'requestTime'=>date("Ymdhms"),
        'signType'=>'RSA',
        'sign'=>'',
    );

    $businessContext = array(
        "amount" => "100",
        "currency" => "CNY",
        "payType" => "UNION_B2C_SAVINGS",
        "cardType" => "SAVINGS",
        "bankNumber" => "1004",
        "orderNumber" => date("Ymdhms").sprintf("%05d",rand(1, 99999)),
        "commodityDesc" => "商户描述：防寒大衣",
        "commodityName" =>"商品名称：大衣",
        "commodityRemark" => "备注",
        "notifyUrl" => "http://127.0.0.1:8095/ecpay-php-demo/notify.php",
        "returnUrl" => "http://127.0.0.1:8095/ecpay-php-demo/syncNotify.php",
        "orderCreateIp" => "22.22.2.2",
        "vaildTime" => "1800"
    );


    echo("[步骤1：组装businessHead头参数和businessContext业务参数]\n");
    print_r($businessHead);
    print_r($businessContext);

    /** 对业务数据继续排序 **/
    ksort($businessContext);

    echo("[步骤2：对businessContext业务参数按ASCII码从小到大进行排序]\n");
    print_r($businessContext);

    /**业务数据转化为JSON格式**/
    $json_businessContext = json_encode($businessContext, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    echo("[步骤3：将排序后的businessContext业务参数转成JSON字符串]\n");
    echo($json_businessContext."\n");

    $mer_private_key = openssl_pkey_get_private($merchant_private_key);//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
    //---------------------------------------------------------------------------------------------
    openssl_sign($json_businessContext, $sign, $mer_private_key, OPENSSL_ALGO_MD5);//MD5方式 使用商户私钥进行签名

    $sign = base64_encode($sign);//最终的签名

    echo("[步骤5：对生成的业务参数JSON进行md5形式的RSA签名]\n");
    echo("sign = ".$sign."\n");


    $businessHead['sign'] = $sign;//将签名加入businessHead中
    $arr_order['businessHead'] = $businessHead;
    $arr_order['businessContext'] = $businessContext;

    $json_order = json_encode($arr_order, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    echo("[步骤6：生成的sign拼接到businessHead中生成]\n");
    echo($json_order."\n");

    $ec_public_key = openssl_pkey_get_public($ecpay_public_key);
    $cryptos = rsa_encrypt($json_order, $ec_public_key);


    header("Location:".$server_url."/api/pay/cardPay?context=".$cryptos);/* Redirect browser */

    exit;

    /**
     * RSA加密   RSA公钥长字符串加密 单次加密最大长度为(key_size/8)-11 1024bit的证书为117bytes, 这里1024bit的用117bytes
     * @param $encrypted
     * @param rsa_public_key
     * @return string
     */
    function rsa_encrypt($encrypted, $rsa_public_key){
        $crypto = '';
        foreach (str_split($encrypted, 117) as $chunk) {
            openssl_public_encrypt($chunk, $encryptDatas, $rsa_public_key);
            $crypto .= $encryptDatas;
        }
        return base64_encode($crypto);
    }
