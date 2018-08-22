<?php

$paykey = "F5Owd7m2ILuQF4TwvSXLvYFmYaHvJwcwc0zeZY8EFfvHqUti";
$reskey = "JZ9LVj35CPckkpouLqL6BxOL09MtOaD8pwSf6Kpt3FouRMJh";
$p = array(

                'mchId' => '20000000',
                'appId' => '918ea8a3abc545868d43d193bbbf051d',
                'passageId' => "1000",
                'mchOrderNo' => date('YmdHis'),
                'channelId' => 'gomepay_b2c',
                'currency' => 'cny',
                'amount' => 1000,
                'notifyUrl' => 'http://localhost/demonotify.php',
                'subject' => 'charge',
                'body' => 'charge',

        );
$str = "";
ksort($p);
foreach($p as $k => $v)
{
        $str .= $k .'='. $v .'&';
}

//$str = substr($str,0,strlen($str) - 1);

$str .= "key=".$paykey;
$p['sign'] = strtoupper(md5($str));

$url = "http://47.75.36.94:3020/api/pay/create_order";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, "params=".json_encode($p));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);

$res = json_decode($result,true);
if($res['retCode'] == 'SUCCESS')
{
    echo '订单号：'.$res['payOrderId'].'<br>';
    echo '支付地址：'.$res['payUrl'].'<br>';
}
else
{
    echo "请求失败";
}

?>