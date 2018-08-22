<?php

/*
 * 4.3网关查询订单接口
 */
    class orderQuery{
        public $mch_id = null;
        public $url_dev = "http://cs.meebill.cn:8080/WebGateway/ThirdQuery/orderQuery";  // 测试网关
        public $url = "http://pay.meebill.cn/WebGateway/ThirdQuery/orderQuery";  // 正式网关
        public $unifiedorder_url = false;
        //构造函数
        public function __construct($data=array()){
            $this->mch_id    = isset($data['mch_id']) ? $data['mch_id'] : "";
            $this->key       = isset($data['key']) ? $data['key'] : "";
            $this->unifiedorder_url   = isset($data['unifiedorder_url']) ? $data['unifiedorder_url'] :$this->unifiedorder_url;

        }


    }