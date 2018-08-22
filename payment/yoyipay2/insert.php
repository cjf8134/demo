<?php
include_once "../../MMysql.class.php";

//插入数据库
$dbdata = array(
    'order_no'=> $para["orderNo"],
    'order_time'=>date("Y-m-d H:i:s"),
    'mer_name'=>'北京天威占君建筑劳务有限公司',
    'pay_name'=>"久付",
    'pay_url'=>getUrl(),
    'contact'=>'颂慈',
    'amount'=>$para["orderAmount"]
    );
$mysql->insert('deposit',$dbdata);