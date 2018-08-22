<?php
  require_once 'log.class.php';
  $log=new Log();
 
    
       
        require_once 'fileCache.class.php';
        require_once 'lib.php';
        require_once 'config.php';

        $post=$_POST;
      if($post)
	  {
       
                //echo "处理中,请别关闭页面...";

        
                 $businessHead = array(
					'charset' =>'00',
					'version'=>'V1.1.0',
					'merchantNumber'=>CHANT,
					'requestTime'=>date("Ymdhms"),
					'signType'=>'RSA',
					'sign'=>'',
				);
				$businessContext = array(
					"orderNumber" => $post['orderNo'],
					"payType" => "QUICK_SAVINGS",
					"idType" => "IDENTITY_CARD",
					"idNo" => $post['idNo'],
					"userName" => $post['userName'],
					"mobile" => $post['mobile'],
					"cardNo" => $post['cardNo'],
					"cardType" =>"SAVINGS",
					"amount" => $post['orderAmount']*100,
					"currency" => "CNY",
					"orderCreateIp" => $_SERVER['REMOTE_ADDR'],
					"commodityDesc" => "666",
					"commodityName" => "888",
					"commodityRemark" => "888",
					"notifyUrl" => $post['notify_url'],
					"bankNumber" => "1001",
				);
				
				
				
				
				$log->W('表单提交');
				$log->W(var_export($businessHead,true));
				$log->W(var_export($businessContext,true));
				
				$merchant_private_key = PRIVATE_KEY;

				$ecpay_public_key = PAY_KEY;
				
				$server_url = 'http://www.babaodao.com';


				/** 对业务数据继续排序 **/
				ksort($businessContext);

				
				/**业务数据转化为JSON格式**/
				$json_businessContext = json_encode($businessContext, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

				

				
			   $mer_private_key = openssl_pkey_get_private($merchant_private_key);
				

				//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
				//---------------------------------------------------------------------------------------------
				openssl_sign($json_businessContext, $sign, $mer_private_key, OPENSSL_ALGO_MD5);//MD5方式 使用商户私钥进行签名

				$sign = base64_encode($sign);//最终的签名



				$businessHead['sign'] = $sign;//将签名加入businessHead中
				$arr_order['businessHead'] = $businessHead;
				$arr_order['businessContext'] = $businessContext;

				$json_order = json_encode($arr_order, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
				

				$ec_public_key = openssl_pkey_get_public($ecpay_public_key);
				
				//var_dump( $ec_public_key);
				
				
				//exit;
				$cryptos = rsa_encrypt($json_order, $ec_public_key);
				$context = array(
						'context' => $cryptos,
					);

				
				$json_context = json_encode($context);
				


				list($return_code, $json_return_content) = http_post_data($server_url."/api/pay/quickPayInit?context=".$cryptos, $json_context);
				$log->W('表单提交返回');
				$log->W(var_export($json_return_content,true));

				$json_return_content = json_decode($json_return_content,true);
				if($json_return_content['message']['content'] == '成功')
				{
					echo "成功";
				}
				else
				{
					echo $json_return_content['message']['content'];
				}
                //header ("Location:".$server_url."/api/pay/quickPayInit?context=".$cryptos);

	  }
	  else
	  {
		 echo "非法请求"; 
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
function http_post_data($url, $data_string) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json; charset=utf-8",
            "Content-Length: " . strlen($data_string))
        );
        ob_start();
        curl_exec($ch);
        $return_content = ob_get_contents();
        ob_end_clean();
        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return array($return_code, $return_content);
    }
  ?>