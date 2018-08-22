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
              
                
                
 
                   $order_time = date ( 'YmdHis' );
                   $order_no=$order_time.mt_rand(1000,9999);
                   $parameters = array(
                    'app_id' => M_ID,
                    'terminal_type' => 'web',
                    'version' => '1.0',
                    'service' => 'fosun.sumpay.cashier.web.trade.order.apply',
                    'timestamp' => $order_time,
                    'mer_no' => M_ID,
                    'trade_code' => "T0002",
                    'user_id' => $post['customerId'],
                    'order_no' => $order_no,
                    'order_time' => $order_time,
                    'order_amount' => number_format($post['orderAmount'],2,".",""),
                    'need_notify' => "1",
                    'need_return' => "1",
                    'goods_name' => "electronic",
                    'goods_num' => "1",
                    'goods_type' => "2" ,
                    'notify_url' => $notify_url,
                    'return_url' => $post['pickupUrl'] ,
                    'remark'=>$post['orderNo'],
                    'currency'=>'CNY',
                   );


                    $domain="www.jin10mall.com";
                    $encrypted_fields = array (
                        "mobile_no",
                        "card_no",
                        "realname",
                        "cvv",
                        "valid_year",
                        "valid_month",
                        "id_no",
                        "auth_code" 
                );
                $charset_change_fields = array (
                        "terminal_info",
                        "remark",
                        "extension",
                        "realname",
                        "attach" 
                );
                $special_fields = array (
                        "terminal_info",
                        "remark",
                        "extension",
                        "notify_url",
                        "return_url",
                        "goods_name",
                        "attach",
                        "mer_logo_url" 
                );
                $defaultCharset = 'UTF-8';

                  
                $log->W('表单提交');
                $log->W(var_export($parameters,true));
          
                   
include 'SumpayService.php';
$url=PAY_URL;
$returnUrl = execute ( $url, 'GB2312', $parameters, "yixuntiankong.pfx", "sumpay", "yixun.cer", $domain, $charset_change_fields, $encrypted_fields, $special_fields, $defaultCharset );
$urlHead = substr ( $returnUrl, 0, 4 );
if (strcasecmp ( $urlHead, 'http' ) != 0) {
    echo iconv ( 'UTF-8', 'GB2312', $returnUrl );
} else {
    echo <<< HTML
<form hidden=true method=post action=$returnUrl>
<input hidden=true type=submit value=ok>
</form>
<script>
document.forms[0].submit();
</script>
HTML;
}
             
            
               


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