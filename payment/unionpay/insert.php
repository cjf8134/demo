<?php
include_once "../../MMysql.class.php";

//插入数据库
$dbdata = array(
    'order_no'=> $para["orderNo"],
    'order_time'=>date("Y-m-d H:i:s"),
    'mer_name'=>'友诺',
    'pay_name'=>"银联支付",
    'pay_url'=>getUrl(),
    'contact'=>'王伟',
    'amount'=>$para["orderAmount"]
    );
$mysql->insert('deposit',$dbdata);