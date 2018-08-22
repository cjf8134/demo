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
        $config = require_once 'config.php';

        $post=$_POST;
        $sign=LeanWorkSDK::makePaySign($post);
        if($sign==$post['sign']){
            $log->W("leanwork签名认证:成功");
            echo "处理中,请别关闭页面...";

            //缓存回调地址，以商户号作为文件名，
            //如果地址有变或者没有初始化则缓存
            if(!$config || $config['receiveUrl'] != $post['receiveUrl']){
                $data = array(
                    'receiveUrl' => $post['receiveUrl']
                );
            }
          
            //公用参数
            $data['app_id'] = $config['app_id'];
            $data['method'] = 'alipay.trade.page.pay';
            $data['format'] = 'JSON';
            $data['charset'] = 'utf-8';
            $data['sign_type'] = 'RSA2';
            $data['timestamp'] = date('Y-m-d H:i:s',time());
            $data['version'] = '1.0';
            $data['notify_url'] = getUrl()."notify.php";;
            $data['return_url'] = $config['pickupUrl'];
            //业务参数
            $rqdata['out_trade_no'] = $post['orderNo'];
            $rqdata['product_code'] = 'FAST_INSTANT_TRADE_PAY';
            $rqdata['total_amount'] = $post['orderAmount'];
            $rqdata['subject'] = '支付款';
            $data['biz_content'] = json_encode($rqdata,true);
            //拼接数据
            $url_data = ToUrlParams($data);
            $url_data .= "&sign=".rsaSign($url_data);           
            $url_data = str_replace(' ','%20',$url_data);
            $log->W('支付宝跳转');
            $log->W(var_export($data,true));
            $url =  $config['pay_url']."?".$url_data;
            Header('Location: '.$url);
        }else{
            $log->W("leanwork签名认证—失败:\n".var_export($_POST,true));
            echo "非法访问";
         }
    }else{
        echo "无效参数";
    }

  function getUrl(){
      $str=substr($_SERVER["REQUEST_URI"],0,strrpos($_SERVER["REQUEST_URI"],"/")+1);
      $pageURL = 'http';
      if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]== "on")
      {
          $pageURL .= "s";
      }
      $pageURL .= "://";
      //$host=$_SERVER["SERVER_NAME"]?$_SERVER["SERVER_NAME"]:$_SERVER["HTTP_HOST"];
      $host=$_SERVER["HTTP_HOST"];
      if ($_SERVER["SERVER_PORT"] != "80")
      {

          $pageURL .=$host. ":" . $_SERVER["SERVER_PORT"];
      }
      else
      {
          $pageURL .= $host;
      }
      return $pageURL.$str;
  }

    //拼接参数
    function ToUrlParams( $query ){
        if ( !$query ) {
            return null;
        }
        ksort( $query );
        $params = array();
        foreach($query as $key => $value){
            $params[] = $key .'='. $value ;
        }
        $data = implode('&', $params);
        return $data;
    }
    //RSA2签名参数
    function rsaSign($data) {
        $private_key_value = APP_KEY;
        $private_key = "-----BEGIN RSA PRIVATE KEY-----\n".$private_key_value."\n-----END RSA PRIVATE KEY-----\n";
        $private_id = openssl_pkey_get_private( $private_key , '');
        openssl_sign($data, $sign, $private_id, OPENSSL_ALGO_SHA256);
        openssl_free_key( $private_id );
        return urlencode(  base64_encode($sign) );
    }
  ?>
</body>
</html> 