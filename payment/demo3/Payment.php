<?php
//支付对接类
require_once 'fileCache.class.php';
require_once 'log.class.php';
require_once 'leanworkSDK.php';
require_once "lib.php";
class Payment{
    public $config=array();
    static $signType="MD5";
    public $log;
    function __construct(){
        $this->log=new Log();
        $this->config=include("config.php");
        if(!isset($this->config["m_id"])){
            exit("配置项需要m_id作为商户号");
        }
        if(!isset($this->config["lw_key"])){
            exit("配置项需要lw_key作为leanwork md5 key");
        }
        $this->config["cache_dir"]="cache";
        $this->config["notify_url"]=getUrl()."notify.php";
        $this->config["callback_url"]=getUrl()."callback.php";
    }



    

    //发起第三方支付请求
    function payRequest($post){
        $native = array(
            "pay_memberid" => $this->config["m_id"],
            "pay_orderid" => $post['orderNo'],
            "pay_amount" =>$post['orderAmount'],
            "pay_applydate" => date("Y-m-d H:i:s"),
            "pay_bankcode" => "907",//支付方式
            "pay_notifyurl" =>  $this->config["notify_url"],
            "pay_callbackurl" => $this->config["callback_url"],
           
        );

    
        ksort($native);
        $md5str = "";
        foreach ($native as $key => $val) {
            $md5str = $md5str . $key . "=" . $val . "&";
        }
        
        $sign = strtoupper(md5($md5str . "key=" . $this->config["m_key"]));
        $native["pay_md5sign"] = $sign;
        $native['pay_attach'] = "";
        $native['pay_productname'] ='支付通道';
        $native['bank_code']="CCB";
        //$native['bank_code']='ICBC';
        $this->log->W('表单提交');
        $this->log->W(var_export($native,true));

        $rs = request_form($native,$this->config["pay_url"]);
        echo $rs;

    }

    //处理支付成功异步通知
    function notify(){
        $this->log->W("支付通知验证-参数:\n".var_export($_REQUEST,true));
        $result=false;
        if($_REQUEST){
            $returnArray = array( // 返回字段
                "memberid" => $_REQUEST["memberid"], // 商户ID
                "orderid" =>  $_REQUEST["orderid"], // 订单号
                "amount" =>  $_REQUEST["amount"], // 交易金额
                "datetime" =>  $_REQUEST["datetime"], // 交易时间
                "transaction_id" =>  $_REQUEST["transaction_id"], // 支付流水号
                "returncode" => $_REQUEST["returncode"],
            );
           
            ksort($returnArray);
            reset($returnArray);
            $md5str = "";
            foreach ($returnArray as $key => $val) {
                $md5str = $md5str . $key . "=" . $val . "&";
            }
            $sign = strtoupper(md5($md5str . "key=" .  $this->config["m_key"]));
        
            if($sign == $_REQUEST["sign"]){
                if ($_REQUEST["returncode"] == "00") { // 签名验证通过
    
                    $orderNo=$_REQUEST["orderid"];
                    $orderAmount= $_REQUEST["amount"];
                    $transactionId=$_REQUEST["transaction_id"];
                     
    
                     $notify_url=getLwNotifyUrl();
                    $this->log->W('通知leanwork地址:'. $notify_url);
                     $lw=new LeanWorkSDK($this->config["lw_key"]);
                    $result=$lw->notify($orderNo,$orderAmount,$transactionId,$notify_url);
               
                }
                $verify=true;
            }else{
                $verify=false;
            }
            $this->log->W("支付通知验证-结果:\n".($verify?"ok":"fail"));
        }
        echo $result===true ? 'SUCCESS' : 'fail';	
    }

    //支付处理页面
    function pay(){
        if($_POST){
            $lw=new LeanWorkSDK($this->config["lw_key"]);

            if( $lw->verifySign($_POST,$_POST['sign'])){
                $this->log->W("leanwork签名认证:成功");
                echo "处理中,请别关闭页面...";
                $this->cacheLwNotifyUrl($_POST['receiveUrl']);
                $this->payRequest($_POST);

            }else{
                $this->log->W("leanwork签名认证—失败:\n".var_export($_POST,true));
                echo "非法访问";
             }
    
        }else{
            echo "无效参数";
         }
    }

        //从缓存获取lw异步通知地址
        function getLwNotifyUrl(){
            $cache = new fileCache($this->config["cache_dir"]);
            $config = $cache->get($this->config["m_id"]); //获取数据
            return $config["receiveUrl"];
        }
       
     

     

        //缓存lw异步通知地址
        function cacheLwNotifyUrl($receiveUrl){
            $cache = new fileCache($this->config["cache_dir"]);
            $result = $cache->get($this->config["m_id"]); //获取数据
            if(!$result || $result['receiveUrl'] != $receiveUrl){
                $data = array(
                'receiveUrl' => $receiveUrl
                );
                $cache->set($this->config["m_id"], $data);  //保存数据
            }
        }
      

    

}