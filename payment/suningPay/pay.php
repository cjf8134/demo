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
        require_once 'lib.php';
        require_once 'config.php';
        require_once 'RSA.php';
        $post=$_POST;
        $sign=LeanWorkSDK::makePaySign($post);
       
        if($sign==$post['sign']){
            $log->W("leanwork签名认证:成功");
            //缓存回调地址，以商户号作为文件名，
            //如果地址有变或者没有初始化则缓存
            $cache = new fileCache($cache_dir);
            $result = $cache->get(M_ID); //获取数据
            if(!$result || $result['receiveUrl'] != $post['receiveUrl']){
                $data = array(
                 'receiveUrl' => $post['receiveUrl'],
                );
                $cache->set(M_ID, $data);  //保存数据
            }
            
            $order_time = date ( 'YmdHis' );
            $order_no=$order_time.mt_rand(1000,9999);
            $cache->set($order_no, $post['orderNo']);  //保存订单数据

            $data = array(
                'salerMerchantNo'    => M_ID,
                'orderType'          => '01',
                'outOrderNo'         => $order_no,
                'merchantOrderNo'    => $order_no,
                'goodsName'          => base64_encode($goodsName),
                'goodsType'          => $goodsType,
                'body'               => base64_encode($goodsName),//商品描述
                'orderAmount'        => number_format($post['orderAmount'],0,".",""),   // 订单金额
                'currency'           =>'CNY',
                'orderTime'          => $order_time,
            );
            $log->W("签名参数:\n".var_export($data,true));
            /* 数字签名,按照字母排序 */
            $sigstr="inputCharset=UTF-8"."&merchantNo=".M_ID."&notifyUrl=".$notify_url."&orders="."[".json_encode($data)."]"."&publicKeyIndex=".APP_KEY."&returnUrl=".$post['pickupUrl']."&submitTime=".$order_time."&version=1.1";
            $log->W("签名参数组装的字符串:\n".$sigstr);
            $sign = strtoupper(md5($sigstr));
            ///////////////////////////////用私钥加密////////////////////////
            if(!file_exists($prifile) && !file_exists($pubfile)){
                die('密钥或者公钥的文件路径不正确');
            }

            $m = new RSA($pubfile, $prifile);
            $signature = $m->sign($sign);
            $log->W("签名生成:\n".$signature);
            /* 交易参数 */
            $parameter = array(
                'version'                =>  "1.1",//版本号
                'merchantNo'             =>  M_ID,  //交易发起方的商户号
                'publicKeyIndex'         =>  APP_KEY,//公钥索引
                'signature'              =>  $signature,//签名
                'signAlgorithm'          =>  'RSA',//签名算法
                'inputCharset'           =>  'UTF-8',//编码类型
                'notifyUrl'              =>  $notify_url,//服务器异步通 知URL
                'returnUrl'              =>  $post['pickupUrl'],//页面跳转同步 通知页面路径
                'submitTime'             =>  $order_time,//提交时间
                'orders'                 =>  "[".json_encode($data)."]"//订单数据集
            );
            $log->W('表单提交');
            $log->W("支付请求的参数:\n".var_export($parameter,true));
            ?>
            <form name="pay" id="register_form" action='<?php echo PAY_URL; ?>' method='post'>
                <?php foreach($parameter as $name=>$value) {
                    echo "<input type='hidden' name='$name' value='$value'>";
                };?>
            </form>
            <script>
                window.onload= function(){
                    document.getElementById('register_form').submit();
                    return false; //必须加上这个！！！
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