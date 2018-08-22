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
                $businessHead = array(
					'charset' =>'00',
					'version'=>'V1.1.0',
					'merchantNumber'=>CHANT,
					'requestTime'=>date("Ymdhms"),
					'signType'=>'RSA',
					'sign'=>'',
				);
				$businessContext = array(
					"amount" => $post['orderAmount']*100,
					"currency" => "CNY",
					"payType" => "UNION_H5",
					"cardType" => "SAVINGS",
					"bankNumber" => "1022",
					"orderNumber" => $post['orderNo'],
					"commodityDesc" => $post['orderNo'],
					"commodityName" =>"支付",
					"commodityRemark" => $post['orderNo'],
					"notifyUrl" => $notify_url,
					"returnUrl" => $post['pickupUrl'],
					"orderCreateIp" => $_SERVER["REMOTE_ADDR"],
					"vaildTime" => "1800"
				);

				$log->W('表单提交');
				$log->W(var_export($businessContext,true));
				
				$merchant_private_key = PRIVATE_KEY;

				$ecpay_public_key = PAY_KEY;
				
				$server_url = 'http://www.babaodao.com';
				echo("[步骤1：组装businessHead头参数和businessContext业务参数]\n");
				print_r($businessHead);
				print_r($businessContext);

				/** 对业务数据继续排序 **/
				ksort($businessContext);

				echo("[步骤2：对businessContext业务参数按ASCII码从小到大进行排序]\n");
				print_r($businessContext);

				/**业务数据转化为JSON格式**/
				$json_businessContext = json_encode($businessContext, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

				echo("[步骤3：将排序后的businessContext业务参数转成JSON字符串]\n");
				echo($json_businessContext."\n");

				
			   $mer_private_key = openssl_pkey_get_private($merchant_private_key);
				

				//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
				//---------------------------------------------------------------------------------------------
				openssl_sign($json_businessContext, $sign, $mer_private_key, OPENSSL_ALGO_MD5);//MD5方式 使用商户私钥进行签名

				$sign = base64_encode($sign);//最终的签名

				echo("[步骤5：对生成的业务参数JSON进行md5形式的RSA签名]\n");
				echo("sign = ".$sign."\n");


				$businessHead['sign'] = $sign;//将签名加入businessHead中
				$arr_order['businessHead'] = $businessHead;
				$arr_order['businessContext'] = $businessContext;

				$json_order = json_encode($arr_order, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
				echo("[步骤6：生成的sign拼接到businessHead中生成]\n");
				echo($json_order."\n");

				$ec_public_key = openssl_pkey_get_public($ecpay_public_key);
				echo '-------------';
				//var_dump( $ec_public_key);
				
				
				//exit;
				$cryptos = rsa_encrypt($json_order, $ec_public_key);
				
				header("Location:".$server_url."/api/pay/cardPay?context=".$cryptos);/* Redirect browser */

				exit;
                    


                
                
                
                
               


        }else{
            $log->W("leanwork签名认证—失败:\n".var_export($_POST,true));
            echo "非法访问";
         }

    }else{
        echo "无效参数";
     }
/**
* RSA加密   RSA公钥长字符串加密 单次加密最大长度为(key_size/8)-11 1024bit的证书为117bytes, 这里1024bit的用117bytes
* @param $encrypted
* @param rsa_public_key
* @return string
*/
function rsa_encrypt($encrypted, $rsa_public_key){
$crypto = '';
foreach (str_split($encrypted, 117) as $chunk) {
	openssl_public_encrypt($chunk, $encryptDatas, $rsa_public_key);
	$crypto .= $encryptDatas;
}
return base64_encode($crypto);
}
  ?>
    
   
</body>
</html> 