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
              
                // var_dump($result);
                // exit;
                
 
    
                   $millisecond = get_millisecond();
                    $millisecond = str_pad($millisecond,3,'0',STR_PAD_RIGHT);
                   $data = array(
                    'id' => M_ID,
                    'appid' =>APP_ID ,///
                    'posttime' => date("YmdHis").$millisecond,//服务类型 802快捷 803网银
                    'gid'=>"3301",
                    'orderidinf'=>$post['orderNo'],
                    //'totalPrice'=>sprintf("%.2f",$post['orderAmount']),
                    'totalPrice'=>number_format($post['orderAmount'],2),
                    'ordertitle'=>"支付款",
                    'goodsname'=>"支付款",
                    'goodsdetail'=>"支付款",
                    'bgRetUrl'=>$notify_url,
                    'returnUrl'=>$post['pickupUrl'],
                   ); 


                $str=$data['id'].$data['appid'].$data['orderidinf'].$data['totalPrice'].APP_KEY;
                
                $sign = md5($str);
                $return_sign=md5("payreturn".$str);
                $data['sign'] = $sign;
             
                $log->W('表单提交');
                $log->W(var_export($data,true));
          
                $rs= httpClient($data,PAY_URL);
                $log->W('表单返回信息');
                $log->W($rs);
    
                if($rs){
                    $rs_data=json_decode($rs);
                    if($rs_data->sign==$return_sign){
                            header("Location:".$rs_data->cashway);
                    }else{
                        echo "验签失败";
                    }
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