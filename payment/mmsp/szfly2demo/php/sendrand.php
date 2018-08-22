<?php
require_once './lib/config.php';
error_reporting(E_ERROR);

$tradetype = false;
$user_agent = $_SERVER['HTTP_USER_AGENT'];
if(strpos($user_agent, 'MicroMessenger') !== false)
{
    $tradetype = '1';
}else if(strpos($user_agent, 'AlipayClient') !== false && strpos($user_agent, 'AliApp') !== false)
{
    $tradetype = '2';
}else
{
    echo '请用微信app或者支付宝app打开此页面';
    die;
}

if($_GET['token_id'])
{
    
    if($tradetype  == 1)
    {
        echo '微信openid：'.$_GET['token_id'];
        header('Location: http://www.baidu.com:20046/wxsan.php?openid='.$_GET['token_id']);
        return;
    }else
    {
        echo '支付宝user_id：'.$_GET['token_id'];
    }
    
}else
{
    $merurl = urlencode('http://www.baidu.com:20046/sendrand.php?a=11&b=222');//填写上商户的地址
    $merno = payconfig::MERNO;
    $url = payconfig::TOKEN_URL.'?merno='.$merno.'&merurl='.$merurl.'&tradetype='.$tradetype;
    header('Location: '.$url);
    exit();
}
?>
