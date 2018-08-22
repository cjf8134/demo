<?php
require_once 'log.class.php';
class LeanWorkSDK{
    private $md5key;
    static $signType="MD5";
    public $log;
    // pickupUrl	付款客户成功后的页面
// receiveUrl 	服务器接受支 付结果的后台 地址 
// signType	签名类型 
// orderNo 	订单号
// orderAmount 	订单金额
// orderCurrency	货币类型
// customerId	客户交易者账号
// sign	签名
function __construct($md5key){
    $this->log=new Log();
    if($md5key==""){
        exit("md5key不能为空");
    }
    $this->md5key=$md5key;
}
 function mock(){
    $para['pickupUrl']="http://localhost/pay/success";
    $para['receiveUrl']="http://localhost/pay/";
    $para['signType']="MD5";
    $para['orderNo']="180322000449TW001375000001140".mt_rand(100, 999);
    $para['orderAmount']="10.01";
    $para['orderCurrency']="CNY";
    $para['customerId']="1";
    $para['sign']=$this->makePaySign($para);

    echo '<form action="pay.php" id="auto-form" method="post">';

    foreach ($para as $name => $value) {
        echo "<input type='hidden' name='$name' value='$value'>";
    }
    echo '</form>';
    echo '
    <script type="text/javascript">
    document.getElementById("auto-form").submit();
</script> 
    ';
}
    

//验证lw支付请求sign
function verifySign($para,$sign){
    $ret_sign=$this->makePaySign($para);
    if($ret_sign==$sign){
        return true;
    }else{
        return false;
    }
}
//支付请求签名
 function makePaySign($para){

return MD5($para["pickupUrl"].$para["receiveUrl"].self::$signType.$para["orderNo"].$para["orderAmount"].$para["orderCurrency"].$para["customerId"].$this->md5key);
}

 function makeNotifySign($para){
   return MD5(self::$signType.$para["orderNo"].$para["orderAmount"].$para["orderCurrency"].$para["transactionId"].$para["status"].$this->md5key);

}


 /**
         * @param string orderNo leanwork订单号32位
         * @param string orderAmount 必须为元，最多保留两位小数
         * @param string transactionId 支付商
         * @return bool 通知成功返回true
         * 
         */
        function notifyLw($orderNo,$orderAmount,$transactionId,$notify_url){
            $result=false;
           
            $para["signType"]=self::$signType;//签名类型
            $para["orderNo"]=$orderNo;//订单号
            $para["orderAmount"]= strval($orderAmount);//订单金额(元)
            $para["orderCurrency"]='CNY';//货币类型
            $para["transactionId"]=$transactionId;//第3方支付流水
            $para["status"]="success";//状态
            $para["sign"]=$this->makeNotifySign($para);//签名
            
                $count=0;
            do{
                $seconds=$count*2;
                sleep($seconds);
                $this->log->W("通知leanwork-请求:\n".var_export($para,true));
                $rs =$this->doRequest($notify_url, $para, $method = 'POST');
                $this->log->W("通知leanwork-结果:\n".var_export($rs,true));
                    if($rs=="success"){
                        //include "insert.php";
                        $result=true;
                        break;
                    }
                    $count++;
            }while($count<2);
            return result;
        }

 /** http请求
     *
     * @param        $url
     * @param array  $params
     * @param string $method
     *
     * @return mixed
     */
    static function doRequest($url, $params = [], $method = 'GET')
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


}