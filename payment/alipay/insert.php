<?php
include_once "../../MMysql.class.php";

//插入数据库
$dbdata = array(
    'order_no'=> $para["orderNo"],
    'order_time'=>date("Y-m-d H:i:s"),
    'mer_name'=>'山东渶利达商务咨',
    'pay_name'=>"支付宝",
    'pay_url'=>getUrl(),
    'contact'=>'曹总',
    'amount'=>$para["orderAmount"]
    );
$mysql->insert('deposit',$dbdata);