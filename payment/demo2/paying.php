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
       
        require_once 'fileCache.class.php';
        require_once 'lib.php';
        require_once 'config.php';

        $post=$_POST;
      
       
                echo "处理中,请别关闭页面...";

        
                $data = array(
                    'version' => "3.0",///
                    'method' =>'Yh.online.interface' ,
                    'partner' =>M_ID ,
                    'banktype'=>$post["banktype"],//验签类型
                    'paymoney'=>$post['orderAmount'],
                    'ordernumber'=>$post['orderNo'],
                    'callbackurl'=>$post['notify_url'],
                    'hrefbackurl'=>$post['pickupUrl'],

                    'goodsname' => "pay",///
                    'attach' =>$post['orderNo'] ,
                    'isshow' =>"1" ,
                  
                   );  
           
             $signSource = sprintf("version=%s&method=%s&partner=%s&banktype=%s&paymoney=%s&ordernumber=%s&callbackurl=%s%s", $data["version"],$data["method"],$data["partner"], $data["banktype"], $data["paymoney"], $data["ordernumber"], $data["callbackurl"], M_KEY);
              
                $data['sign'] = md5($signSource) ;

                $postUrl = PAY_URL. "?version=".$data["version"];
                $postUrl.="&method=".$data["method"];
                $postUrl.="&partner=".$data["partner"];
                $postUrl.="&banktype=".$data["banktype"];
                $postUrl.="&paymoney=".$data["paymoney"];
                $postUrl.="&ordernumber=".$data["ordernumber"];

                $postUrl.="&callbackurl=".$data["callbackurl"];
                $postUrl.="&hrefbackurl=".$data["hrefbackurl"];
                $postUrl.="&goodsname=".$data["goodsname"];
                $postUrl.="&attach=".$data["attach"];
                $postUrl.="&isshow=".$data["isshow"];

                $postUrl.="&sign=".$data['sign'];
              
                $log->W('表单提交地址：'. $postUrl);
                $log->W('表单提交');
                $log->W(var_export($data,true));

                header ("location:$postUrl");


    }else{
        echo "无效参数";
     }
    
  ?>
    
   
</body>
</html> 