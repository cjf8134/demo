<?php
class LeanWorkSDK{
    static $md5key="762549114209675";
    static $signType="MD5";
    static $key = 'bn250whr0tbkgga4b9ssdjy7ze59188n';
    static function buildMockUrl(){
        $para['pickupUrl']="http://localhost/pay/success";
        $para['receiveUrl']="http://localhost/pay/";
        $para['signType']="MD5";
        $para['orderNo']="180322000449TW001375000001140".mt_rand(100, 999);
        $para['orderAmount']="0.01";
        $para['orderCurrency']="CNY";
        $para['customerId']="1";
        $para['sign']=self::makePaySign($para);
        echo '<form action="pay.php" id="auto-form" method="post">';
        foreach ($para as $name => $value) {
            echo "<input type='hidden' name='$name' value='$value'>";
        }
        echo '</form>';
        echo '<script type="text/javascript">document.getElementById("auto-form").submit();</script>';
    }
    
    static function makePaySign($para){
        return MD5($para["pickupUrl"].$para["receiveUrl"].self::$signType.$para["orderNo"].$para["orderAmount"].$para["orderCurrency"].$para["customerId"].self::$md5key);
    }

    static function makeRecSign($para){
        return MD5(self::$signType.$para["orderNo"].$para["orderAmount"].$para["orderCurrency"].$para["transactionId"].$para["status"].self::$md5key);
    }

    /**
     * 将参数变为字符串
     * @param $array_query
     * @return string string 'm=content&c=index&a=lists&catid=6&area=0&author=0&h=0®ion=0&s=1&page=1' (length=73)
     */
    static function getUrlQuery($array_query)
    {
        $tmp=array();
        foreach($array_query as $k=>$param){
            $tmp[] = $k.'='.$param;
        }
        $params = implode('&',$tmp);
        return $params;
    }
    /** http请求
    *
    * @param        $url
    * @param array  $params
    * @param string $method
    * @return mixed
    */
    static function doRequest($url, $params = array(), $method = 'GET')
    {
        if (!function_exists('curl_init')) {
            exit('Need to open the curl extension');
        }
        if ($method == 'GET') {
            $url .= '?' . http_build_query($params);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_HEADER, 0); //展示响应头
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);//设置连接等待时间,0不等待
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }

        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }
    static function MakeSign($data){
        ksort($data);
        $string = self::ToUrlParams($data);
        $string = $string . "&key=".self::$key;
        $string = md5($string);
        $result = strtoupper($string);
        return $result;
    }
    //格式化url
    static function ToUrlParams($data)
    {
        $buff = "";
        foreach ($data as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }
        
        $buff = trim($buff, "&");
        return $buff;
    }


}