<?php
date_default_timezone_set('PRC'); //设置中国时区
/**
 * 工具类
 * Class Tools
 */
class Tools
{
    /**
     *
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return 产生的随机字符串
     */
    public static function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 统一字符编码为UTF-8
     * @param $string
     * @return string
     */
    public static function unifyCode($string)
    {
        $encode = mb_detect_encoding($string, array("ASCII", "UTF-8", "GB2312", "GBK", "BIG5"));
        if ($encode != "UTF-8") {
            $string = iconv($encode, "UTF-8", $string);
        }
        return $string;
    }


    /**
     * 打印日志到文件
     * @param string $tips
     * @param string $data
     */
    public static function wrtLog($tips = 'DEBUG',$data = array())
    {
        $log_str = var_export($data, true);
        $msg = sprintf('%s[%s]  ' . $log_str . PHP_EOL, date("Y-m-d H:i:s", time()), $tips);
        $log_file = sprintf("./log/log_%s.txt", date('Y-m-d', time()));
        file_put_contents($log_file, $msg, FILE_APPEND);
    }

    /**
     * 请求网络接口
     * @param $url
     * @param string $method
     * @param array $postData
     * @return mixed|null|string
     */
    public static function http_post_json($url, $jsonStr)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: ' . strlen($jsonStr)
            )
        );
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        return $response;
    }

    /**
     * RSA 加密
     * $data array 加密的数组
     * $sign_type 加密类型:RSA 和RSA2
     * $privateKey RSA 密钥
     * $passphrase RSA 密钥密码
     * return sign 返回Base64后的签名
     */
    public static function en_rsa($data, $privateKey)
    {
        unset($data['Sign']);
        ksort($data);
        $string = json_encode($data,JSON_UNESCAPED_UNICODE);

        $private_id = openssl_pkey_get_private( $privateKey );

        $signature = '';
        openssl_sign($string, $signature, $private_id, OPENSSL_ALGO_SHA1 );
        openssl_free_key( $private_id );
        return base64_encode($signature);
    }

    /**
     *
     * RSA 验证签名
     * $arr 数组，接收到的数据，sign不参与签名
     * $sign 签名串
     * $publicKey RSA加密公钥
     * return bool 如果验证签名通过，true，否则返回false
     */
    public static function rsa_verify($arr, $sign, $publicKey)
    {
        if ($arr['Sign']) unset($arr['Sign']);
        ksort($arr);
        $paramStr = json_encode($arr,JSON_UNESCAPED_UNICODE);

        $res = openssl_get_publickey($publicKey);
        $result = (bool)openssl_verify($paramStr, base64_decode($sign), $res);
        openssl_free_key($res);
        if($result)
        {
            return true;
        }
        return false;
    }



    /**
     * RSA 私钥解密
     *
     */
    public static function rsa_decrypt($encrypted, $private_key)
    {
        $crypto = '';
        $rsaPrivateKey = openssl_pkey_get_private($private_key);
        foreach (str_split(base64_decode($encrypted), 128) as $chunk) {
            openssl_private_decrypt($chunk, $decryptData, $rsaPrivateKey);
            $crypto .= $decryptData;
        }
        return $crypto;
    }

    /**
     * RSA 公钥加密
     */
    public static function rsa_encrypt($data, $public_key)
    {
        $rsaPublicKey = openssl_pkey_get_public($public_key);
        $crypto = '';
        foreach (str_split($data, 117) as $chunk) {
            openssl_public_encrypt($chunk, $encryptData, $rsaPublicKey);
            $crypto .= $encryptData;
        }
        return base64_encode($crypto);
    }


    /**
     *
     *3des 加密
     * @param $body 需要加密的一维数组
     * @param $KEY 密钥
     * @return base64后的结果
     */
    public static function encrypt3DES($body, $key)
    {
        require_once '3des.class.php';

        ksort($body);
        $bodyStr = json_encode($body,JSON_UNESCAPED_UNICODE);
        $encrypt = new Encrypt($key);
        $result = $encrypt->encrypt3DES($bodyStr);
        if($result == false)
        {
            return false;
        }
        return base64_encode($result);
    }

    /**
     *
     * 3des 解密
     * @param $str 需要解密的base64字符串
     * @param $key 密钥
     * @return array $arr 解密后的数组
     */
    public static function decrypt3DES($str, $key)
    {
        require_once '3des.class.php';
        $encrypt = new Encrypt($key);
        $result = $encrypt->decrypt3DES(base64_decode($str));
        if($result == false)
        {
            return false;
        }
        return $result;
    }
}



?>
