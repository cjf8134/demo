<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" /> 
    <title>快捷支付下单</title>
</head>
<body>
  <?php
  require_once 'log.class.php';
  $log=new Log();
    if($_POST){
        require_once 'leanworkSDK.php';
        require_once 'fileCache.class.php';
        require_once 'config.php';
        require_once 'lib.php';

        $post=$_POST;
        $sign=LeanWorkSDK::makePaySign($post);
        if($sign==$post['sign']){
            $log->W("leanwork签名认证:成功");
            echo "处理中,请别关闭页面...";
            //缓存回调地址，以商户号作为文件名，
            //如果地址有变或者没有初始化则缓存
            $cache = new fileCache($cache_dir);
            $result = $cache->get(M_ID); //获取数据
            if(!$result || $result['receiveUrl'] != $post['receiveUrl']){
                $data = array(
                'receiveUrl' => $post['receiveUrl']
                );
                $cache->set(M_ID, $data);  //保存数据
            }

            // var_dump($result);
            // exit;
            $keyValue = APP_KEY;//商家MD5密钥
            $interfaceName = 'anonymousPayOrder';
            $curType = 'CNY';
            $version='B2C1.0';
            $data = array(
                'orderNo'    => date("YmdHis").mt_rand(10000,99999),   // 订单号  最长30
                'orderAmt'   => number_format($post['orderAmount'],2,".",""),   // 订单金额
                'bankId'     =>"888C",
                'returnURL'  =>$post['pickupUrl'],
                'notifyURL'  =>$notify_url,
                'remark'     =>$post['orderNo'],   // 备注字段
                'cardType'   =>"X",    // 卡中
                'goodsName'  =>"baiduyixia",
                'goodsType'   =>0,    //0-实体商品,1-虚拟商品匿名快捷支付必输

            );
            $transactionData =  arrayToXml($data);
            $xmlData="<?xml version=\"1.0\" encoding=\"GBK\"?><B2CReq><merchantId>".M_ID."</merchantId><curType>".$curType."</curType><returnURL>".$post['pickupUrl']."</returnURL><notifyURL>".$notify_url."</notifyURL>".$transactionData."</B2CReq>";//支付通道编码
            // 获得证书签名(新商户都用此方法)
            $signMsg = certSign($xmlData);
            // tranData做base64编码
            $tranData =  base64_encode($xmlData);
            $log->W('表单提交');
            $log->W(var_export($data,true));
        ?>
            <form name="pay" id="register_form" action='<?php echo PAY_URL; ?>' method='POST' target="_blank">
                <input type='hidden' name='interfaceName'   value='<?php echo $interfaceName; ?>'>
                <input type='hidden' name='tranData'        value='<?php echo $tranData; ?>'>
                <input type='hidden' name='version'         value='<?php echo $version; ?>'>
                <input type='hidden' name='merSignMsg'      value='<?php echo $signMsg; ?>'>
                <input type='hidden' name='merchantId'      value='<?php echo M_ID; ?>'>
            </form>
            <script>
                window.onload= function(){
                    document.getElementById('register_form').submit();
                }
            </script>
            <?php

               


        }else{
            $log->W("leanwork签名认证—失败:\n".var_export($_POST,true));
            echo "非法访问";
         }

    }else{
        echo "无效参数";
     }
    
  ?>
    
   
</body>
</html> 