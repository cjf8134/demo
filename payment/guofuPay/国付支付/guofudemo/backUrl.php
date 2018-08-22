<?php

/**
 * 客户端请求本接口 同步回调
 * author: fengxing
 * Date: 2017/10/7
 */
error_reporting(E_ALL & ~E_NOTICE);
session_start();
include('./config.php');
$fxid = $_REQUEST['fxid']; //商户编号
$fxddh = $_REQUEST['fxddh']; //商户订单号
$fxorder = $_REQUEST['fxorder']; //平台订单号
$fxdesc = $_REQUEST['fxdesc']; //商品名称
$fxfee = $_REQUEST['fxfee']; //交易金额
$fxattch = $_REQUEST['fxattch']; //附加信息
$fxstatus = $_REQUEST['fxstatus']; //订单状态
$fxtime = $_REQUEST['fxtime']; //支付时间
$fxsign = $_REQUEST['fxsign']; //md5验证签名串

$mysign = md5($fxstatus . $fxid . $fxddh . $fxfee . $fxkey); //验证签名
//记录回调数据到文件，以便排错
if ($fxloaderror == 1)
    file_put_contents('./demo.txt', '同步：' . serialize($_REQUEST) . "\r\n", FILE_APPEND);

if ($fxsign == $mysign) {
    if ($fxstatus == '1') {//支付成功
        //支付成功 转入支付成功页面
        echo 'success';
    } else { //支付失败
        echo 'fail';
    }
    exit();
} else {
    /** 判断订单是否已经支付成功 如果不成功等待10秒刷新* */
    $ddh = $_SESSION['ddh']; //获取session订单号
    $ddhft = $_SESSION['ddhft']; //订单刷新次数

	//注意*******************************************
    //此处需要验证订单号是否支付成功 根据对接网站数据结构查询订单状态
    //$buffer=M('buyer')->where("ddh='".$ddh."'")->find();
	//注意*******************************************

    if ($buffer['status'] == 1) { //订单状态是否支付成功 $buffer['status']需要根据实际情况修改
        //跳转到支付成功后的页面
		echo 'success';
    } else {
        //支付失败等待刷新验证
        //完善流程 刷新3次跳出刷新
        if (!empty($ddhft) && $ddhft > 2) {
            $ddhft = empty($ddhft) ? 1 : $ddhft + 1;
            $_SESSION['ddhft'] = $ddhft;
            exit('支付失败');
        }

        echo '请等待支付结果返回,预计<span id="times">10</span>秒后跳转..';
        echo "<script>function ShowCountDown(){var time=document.getElementById('times').innerHTML;if(parseInt(time)<=1){location.href='" . $backurl . "';}else{time=parseInt(time)-1;document.getElementById('times').innerHTML=time; window.setTimeout(function(){ShowCountDown();}, 1000);} } window.setTimeout(function(){ShowCountDown();}, 1000); </script>";
    }

    exit();
}
?>