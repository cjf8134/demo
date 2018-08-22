<?php
header("content-type:text/html;charset=utf-8");
echo "<pre>";
include_once "functions.php";
$data = include "config.php";
require_once 'fileCache.class.php';


class Mibei{


    public $mch_id = null;
    public $url_dev = "http://cs.meebill.cn:8080/WebGateway/WebGateway/wgzf";  // 测试网关
    public $url = "http://pay.meebill.cn/WebGateway/WebGateway/wgzf";  // 正式网关
    public $unifiedorder_url = false;
    //构造函数
    public function __construct($data=array()){
        $this->mch_id    = isset($data['mch_id']) ? $data['mch_id'] : "";
        $this->key       = isset($data['key']) ? $data['key'] : "";
        $this->unifiedorder_url   = isset($data['unifiedorder_url']) ? $data['unifiedorder_url'] :$this->unifiedorder_url;

    }

    // 统一下单
    public function unifiedorder($trade_type = "trade.gateway.pay"){
        $data['mch_id'] = $this->mch_id;   // 商户号
        $data['nonce_str'] = "text";      //  随机字符串
        $data['body'] = "测试商品";   // 商品描述
        $data['out_trade_no'] = time() . mt_rand(0,1000);;   // 商户订单号
        $data['total_fee'] = "1";   // 总金额
        $data['trade_type'] = $trade_type;   // 交易类型  微信H5：WX 微信内WAP：WX_WAP微信扫码：WX_SCAN 支付宝WAP：ALI 支付宝扫码：ALI_SCAN
        $data['spbill_create_ip'] = $_SERVER['REMOTE_ADDR'];//终端IP;   // 客户端ip地址
        $data['notify_url'] = "http://".$_SERVER['HTTP_HOST']."notify_url.php";   // 通知地址
        $data['return_url'] = "http://".$_SERVER['HTTP_HOST']."return_url.php";   // 前端地址
        $data['bankType'] = 9008;   // 银行类型
        $data['accountType'] = "1";    // 账户类型，1-个人   2-企业
        $data['sign'] = common::md5sign($data);
        // $data['detail'] = "";     // 商品详情
        // $data['fee_type']   = "CNY";     // 默认人名币
        $xml = common::arrayToXml($data);
        $con = common::httpRequest($this->is_url(),"post",$xml);
        $res = common::xmltoarray($con);
        var_dump($res);
    }

    // 测试地址 还是 正式地址
    public function is_url(){
        return $url = $this->unifiedorder_url == false ? $this->url_dev : $this->url;
    }
}

$Mibei = new Mibei($data);
$Mibei ->unifiedorder();