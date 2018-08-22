<?php

 /**
     *生成12位的字符串，数字不够12位的向左补零
    *@param  [$path]
    *@return [mixed]
    *@throws [\Exception]
    */
    function makeOrderAmount($d){
		return str_pad($d*100,12,"0",STR_PAD_LEFT);
	}
	
/**
 * 获取公钥
 * @param $path
 * @return mixed
 * @throws Exception
 */
function loadX509Cert($path)
{
    try {
        $file = file_get_contents($path);
        if (!$file) {
            throw new \Exception('loadx509Cert::file_get_contents ERROR');
        }

        $cert = chunk_split(base64_encode($file), 64, "\n");
        $cert = "-----BEGIN CERTIFICATE-----\n" . $cert . "-----END CERTIFICATE-----\n";

        $res = openssl_pkey_get_public($cert);
        $detail = openssl_pkey_get_details($res);
        openssl_free_key($res);

        if (!$detail) {
            throw new \Exception('loadX509Cert::openssl_pkey_get_details ERROR');
        }

        return $detail['key'];
    } catch (\Exception $e) {
        throw $e;
    }
}

/**
 * 获取私钥
 * @param $path
 * @param $pwd
 * @return mixed
 * @throws Exception
 */
function loadPk12Cert($path, $pwd)
{
    try {
        $file = file_get_contents($path);
        if (!$file) {
            throw new \Exception('loadPk12Cert::file
					_get_contents');
        }

        if (!openssl_pkcs12_read($file, $cert, $pwd)) {
            throw new \Exception('loadPk12Cert::openssl_pkcs12_read ERROR');
        }
        return $cert['pkey'];
    } catch (\Exception $e) {
        throw $e;
    }
}

/**
 * 私钥签名
 * @param $plainText
 * @param $path
 * @return string
 * @throws Exception
 */
function sign($plainText, $path)
{
    $plainText = json_encode($plainText);
    try {
        $resource = openssl_pkey_get_private($path);
        $result = openssl_sign($plainText, $sign, $resource);
        openssl_free_key($resource);

        if (!$result) {
            throw new \Exception('签名出错' . $plainText);
        }

        return base64_encode($sign);
    } catch (\Exception $e) {
        throw $e;
    }
}

/**
 * 公钥验签
 * @param $plainText
 * @param $sign
 * @param $path
 * @return int
 * @throws Exception
 */
function verify($plainText, $sign, $path)
{
    $resource = openssl_pkey_get_public($path);
    $result = openssl_verify($plainText, base64_decode($sign), $resource);
    openssl_free_key($resource);

    if (!$result) {
        throw new \Exception('签名验证未通过,plainText:' . $plainText . '。sign:' . $sign, '02002');
    }

    return $result;
}

/**
 * 发送请求
 * @param $url
 * @param $param
 * @return bool|mixed
 * @throws Exception
 */
function http_post_json($url, $param)
{
    if (empty($url) || empty($param)) {
        return false;
    }
    $param = http_build_query($param);
    try {

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //正式环境时解开注释
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

        if (!$data) {
            throw new \Exception('请求出错');
        }

        return $data;
    } catch (\Exception $e) {
        throw $e;
    }
}

function parse_result($result)
{
    $arr = array();
    $response = urldecode($result);
    $arrStr = explode('&', $response);
    foreach ($arrStr as $str) {
        $p = strpos($str, "=");
        $key = substr($str, 0, $p);
        $value = substr($str, $p + 1);
        $arr[$key] = $value;
    }

    return $arr;
}

// 定义一个函数getIP() 客户端IP，
function get_ip(){
    if (getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if(getenv("HTTP_X_FORWARDED_FOR"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if(getenv("REMOTE_ADDR"))
        $ip = getenv("REMOTE_ADDR");
    else $ip = "Unknow";

    if(preg_match('/^((?:(?:25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d)))\.){3}(?:25[0-5]|2[0-4]\d|((1\d{2})|([1 -9]?\d))))$/', $ip))
        return $ip;
    else
        return '';
}

?>