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

                //参数
                $data['mchNo'] = M_ID;
                $data['orderID'] = $post['orderNo'];
                $data['money'] = $post['orderAmount'];
                $data['body'] = '支付款';
                $data['payType'] = 'wy';
                $data['notifyUrl'] = base64_encode($notify_url);
                $data['callbackurl'] = base64_encode($post['pickupUrl']);
                $data['sign'] = MakeSign($data);
             
                $log->W('表单提交');
                $log->W(var_export($data,true));
          
                $url = PAY_URL.'?requestBody='.json_encode($data,true);
                header("Location:".$url);

        }else{
            $log->W("leanwork签名认证—失败:\n".var_export($_POST,true));
            echo "非法访问";
         }

    }else{
        echo "无效参数";
    }
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
    //签名
    function MakeSign($data){
        //签名步骤一：按字典序排序参数
        ksort($data);
        $string = ToUrlParams($data);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".APP_KEY;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = $string;
        return $result;
    }
    
  ?>
    
   
</body>
</html> 