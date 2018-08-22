<?php
/**
 * Created by PhpStorm.
 * User: rocky
 * Date: 18/1/22
 * Time: 16:13
 */

//require 'PayParameters.php';
//include 'RSA.php';

/**
 * Class PayLib
 * 商家接入 SDK
 */
class PayLib {
    /**
     * AES/PKCS5_PADDING/ECB 128 位加密
     *
     * @param string $preEncryptString 原始 json 字符串
     * @param string $aesKey           base64_encode 编码过的 key
     *
     * @return string base64_encode 编码过的加密字符串
     */
    public static function AESEncrypt($preEncryptString, $aesKey) {
        $aesKey = base64_decode($aesKey);

        $size             = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $preEncryptString = self::pkcs5_pad($preEncryptString, $size);
        $td               = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv               = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $aesKey, $iv);
        $encryptData = mcrypt_generic($td, $preEncryptString);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);

        $encryptData = base64_encode($encryptData);

        return $encryptData;
    }

    /**
     * @param string $text      原始字符串
     * @param int    $blocksize 补码位
     *
     * @return string 经过补码的字符串
     */
    private static function pkcs5_pad($text, $blocksize) {
        $pad = $blocksize-(strlen($text)%$blocksize);

        return $text.str_repeat(chr($pad), $pad);
    }

    /**
     * AES/PKCS5_PADDING/ECB 128 位解密
     *
     * @param string $encrypted base64_encode 编码过的加密字符串
     * @param string $aesKey    base64_encode 编码过的秘钥
     * @param string $charset   字符集，未使用
     *
     * @return string 原始 json 字符串
     */
    public static function AESDecrypt($encrypted, $aesKey, $charset = 'UTF-8') {
        $aesKey    = base64_decode($aesKey);
        $encrypted = base64_decode($encrypted);

        $decrypted = mcrypt_decrypt(
            MCRYPT_RIJNDAEL_128,
            $aesKey,
            $encrypted,
            MCRYPT_MODE_ECB
        );

        $decrypted = self::pkcs5_unpad($decrypted);

        return $decrypted;
    }

    /**
     * @param string $decrypted 经过补码的字符串
     *
     * @return string 去除补码的字符串
     */
    private static function pkcs5_unpad($decrypted) {
        $len       = strlen($decrypted);
        $padding   = ord($decrypted[$len-1]);
        $decrypted = substr($decrypted, 0, -$padding);

        return $decrypted;
    }

    // /**
    //  * @param string $data
    //  * @param mixed  $publicPEMKey
    //  * @param int    $padding OPENSSL_PKCS1_PADDING|OPENSSL_NO_PADDING
    //  *
    //  * @return bool|string
    //  */
    // public static function rsaEncrypt($data, $publicPEMKey, $padding = OPENSSL_PKCS1_PADDING)
    // {
    // 	$decrypted = '';

    // 	//decode must be done before split for getting the binary String
    // 	$data = str_split(self::urlSafe_base64decode($data), self::DECRYPT_BLOCK_SIZE);

    // 	foreach ($data as $chunk) {
    // 		$partial = '';

    // 		//be sure to match padding
    // 		$decryptionOK = openssl_private_encrypt($chunk, $partial, $publicPEMKey, $padding);

    // 		if ($decryptionOK === FALSE) {
    // 			return FALSE;
    // 			//here also processed errors in decryption. If too big this will be false
    // 		}
    // 		$decrypted .= $partial;
    // 	}

    // 	return base64_encode($decrypted);
    // }

    // /**
    //  * @param string $string
    //  *
    //  * @return string
    //  */
    // public static function urlSafe_base64decode($string)
    // {
    // 	$data = str_replace(array(' ', '-', '_'), array('+', '+', '/'), $string);
    // 	$mod4 = strlen($data) % 4;
    // 	if ($mod4) {
    // 		$data .= substr('====', $mod4);
    // 	}

    // 	return base64_decode($data);
    // }

    // /**
    //  * 获取解密
    //  */
    // public static function decryptBizContext($encryptedBizContext, $rsa_key)
    // {
    // 	$rsa_key = base64_decode($rsa_key);

    // 	$rsa_key_resource = openssl_pkey_get_public($rsa_key);
    // 	$decrypted = self::rsaDecrypt($encryptedBizContext, $rsa_key_resource, OPENSSL_PKCS1_PADDING);
    // 	$decrypted = json_decode($decrypted, TRUE);

    // 	return $decrypted;
    // }

    // /**
    //  * @param string $data
    //  * @param mixed  $publicPEMKey
    //  * @param int    $padding OPENSSL_PKCS1_PADDING|OPENSSL_NO_PADDING
    //  *
    //  * @return bool|string
    //  */
    // public static function rsaDecrypt($data, $publicPEMKey, $padding = OPENSSL_PKCS1_PADDING)
    // {
    // 	$decrypted = '';

    // 	//decode must be done before split for getting the binary String
    // 	$data = str_split(self::urlSafe_base64decode($data), self::DECRYPT_BLOCK_SIZE);

    // 	foreach ($data as $chunk) {
    // 		$partial = '';

    // 		//be sure to match padding
    // 		$decryptionOK = openssl_public_decrypt($chunk, $partial, $publicPEMKey, $padding);

    // 		if ($decryptionOK === FALSE) {
    // 			return FALSE;
    // 			//here also processed errors in decryption. If too big this will be false
    // 		}
    // 		$decrypted .= $partial;
    // 	}

    // 	return $decrypted;
    // }

    /**
     * 签名  生成签名串  基于sha1withRSA
     *
     * @param string $data 签名前的字符串
     *
     * @param string $privateKey
     *
     * @return string 签名串
     */
    public static function rsaSHA1Sign($data, $privateKey) {
        $signature = '';
        openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA1);

        return base64_encode($signature);
    }

    /**
     * 验签  验证签名  基于sha1withRSA
     *
     * @param string $data      签名前的原字符串
     * @param string $signature 签名串
     * @param string $publicKey
     *
     * @return int
     */
    public static function rsaSHA1Verify($data, $signature, $publicKey) {
        $signature = base64_decode($signature);

        //		$publicKey = openssl_pkey_get_public($publicKey);
        //		$keyData = openssl_pkey_get_details($publicKey);

        $result = openssl_verify($data, $signature, $publicKey, OPENSSL_ALGO_SHA1);//openssl_verify 验签成功返回 1，失败 0，错误返回 -1

        return $result;
    }

    public static function postForm($url, $data, $headers = array(), $referer = NULL) {
        $headerArr = array();
        if (is_array($headers)) {
            foreach ($headers as $k => $v) {
                $headerArr[] = $k.': '.$v;
            }
        }
        $headerArr[] = 'Content-Type: application/x-www-form-urlencoded; charset=utf-8';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArr);
        if ($referer) {
            curl_setopt($ch, CURLOPT_REFERER, "http://{$referer}/");
        }
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

}