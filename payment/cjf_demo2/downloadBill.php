<?php
include_once "common.php";

class downloadBill{
    public $mch_id = "";
    public $key = "589b8a0f2ea90952bbe076052b82b690";
    public $url_dev = "http://cs.meebill.cn:8080/WebGateway/ThirdQuery/downloadBill";  // 测试网关
    public $url = "http://pay.meebill.cn/WebGateway/ThirdQuery/downloadBill";  // 正式网关
    //构造函数
    public function __construct(){
        
    }

    // 下载订单
    public function downloadBill($date=""){
            $data['mch_id'] = $this->mch_id;   // 商户号
            $data['nonce_str'] = "text";      //  随机字符串
            $data['bill_date'] = $date;   // 商品描述
            $data['sign'] = common::md5sign($data);
            $res = common::httpRequest($this->url_dev,"post",$data);
           return $res;
    }



    // 处理订单返回的状态
    public function Handle_downloadBill(){
        $data = $this->downloadBill();
        var_dump($data);
    }

}