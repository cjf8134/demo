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
        require_once 'Util.php';
        $post=$_POST;
        $sign=LeanWorkSDK::makePaySign($post);
       
        if($sign==$post['sign']) {
            $log->W("leanwork签名认证:成功");
            //缓存回调地址，以商户号作为文件名，
            //如果地址有变或者没有初始化则缓存
            $cache = new fileCache($cache_dir);
            $result = $cache->get(M_ID); //获取数据
            if (!$result || $result['receiveUrl'] != $post['receiveUrl']) {
                $data = array(
                    'receiveUrl' => $post['receiveUrl'],
                );
                $cache->set(M_ID, $data);  //保存数据
            }


            $order_time = date('YmdHis');
            $order_no = $order_time . mt_rand(1000, 9999);
//            $cache->set($order_no, $post['orderNo']);  //保存数据
//            $data = array(
//                "Version" => '1.0', //商户订单号
//                "SignMethod" => 'MD5', //商户订单号
//                "TxCode" => "setupord", //商品名
//                "MerNo" => M_ID, //商户号
//                'TxSN' => $post['orderNo'], //商户订单号
//                "Amount" => number_format($post['orderAmount'], 2, ".", ""), //支付金额 单位元
//                "PdtName" => "test",
//                "Remark" => $post['orderNo'], //附加信息
//                "ReqTime" => date('YmdHis', time()), //支付类型 此处可选项以网站对接ylkj文档为准 微信公众号：wxgzh   微信H5网页：wxwap  微信扫码：wxsm   支付宝H5网页：zfbwap  支付宝扫码：zfbsm 等参考API
//                "ReturnUrl" => $post['pickupUrl'], //同步回调 不作为最终支付结果为准，请以异步回调为准
//                "NotifyUrl" => $notify_url, //异步回调 , 支付结果以异步为准
//            );

            $util = new Util();
            $util->writelog("==========收银台置单=============");
            //==设置请求参数
            $req["Version"] =$merconfig["Version"];
            $req["SignMethod"] =$merconfig["SignMethod"];
            //交易码
            $req["TxCode"] ="setupord";
            $req["MerNo"] =M_ID;
            //商户交易流水号(唯一)
            $req["TxSN"] =$order_no; //商户订单号
            //金额:单位:分
            $req["Amount"] =number_format($post['orderAmount'], 2, ".", "")*100; //支付金额 单位元
            //商品名称
            $req["PdtName"] ="text";
            //备注
            $req["Remark"] =$post['orderNo']; //商户订单号
            //同步通知URL
//            $req["ReturnUrl"] =$post['pickupUrl'];
            //异步通知URL
            $req["NotifyUrl"] =$notify_url; //异步回调 , 支付结果以异步为准
            //请求时间 格式:YmdHis
            $req["ReqTime"] =date('YmdHis',time());
            //订单有效时间，单位分钟，默认24小时,值可不传
            //$req["TimeoutExpress"] ="1440";
            $log->W("验证-参数:\n".var_export($req,true));
            //==设置请求签名
            $util->setSignature($req,$merconfig["Url_Param_Connect_Flag"]
                ,$removeKeys,APP_KEY);

            //==得到请求数据
            $post_data = $util->getWebForm($req, $base64Keys, $merconfig["Charset"]
                ,$merconfig["Url_Param_Connect_Flag"]);

            //==提交数据
            $respMsg = $util->postData(PAY_URL,$post_data);
            $util->writelog("返回数据:".$respMsg);

            //==解析返回数据为数组
            $respAr = $util->parseResponse($respMsg,$base64Keys
                ,$merconfig["Url_Param_Connect_Flag"], $merconfig["Charset"]);
            //==验签数据
            if ($util->verifySign($respAr, $merconfig["Url_Param_Connect_Flag"], $removeKeys
                , APP_KEY)){
                $log->W("验证-参数:\n".var_export($respAr,true));
                $util->writelog("验证签名成功:");
                if (strcmp($respAr['RspCod'],"00000") == 0
                    && strcmp($respAr['Status'],"1") == 0
                    && isset($respAr['Token'])){
                    $util->writelog("置单成功 获取token成功");
                    //收银台URL 拼接
                    $payUrl =  buildPayUrl($merconfig,$removeKeys,$base64Keys,$respAr['Token'],null,null);
                    if (empty($payUrl)){
                        $util->writelog("拼接收银台URL 失败");
                    }
                    else{
                        $util->writelog("支付链接：".$payUrl);
                        header("Location:".$payUrl);//需要把$util->writelog中print_r屏蔽
                    }
                } else {
                    //失败
                    echo "受理失败!!!";
                    $util->writelog("受理失败!!!");
                }
            }
            else{
                echo "验证签名失败!!!";
                $util->writelog("验证签名失败!!!");
            }

            $util->writelog("==========收银台置单  处理结束=============");

        }else{
            echo "签名错误";
        }

    }else{
        echo "无效参数";
     }

  function buildPayUrl($merconfig,$removeKeys,$base64Keys,$token,$productId,$directBankId){
      $util = new Util();
      if (empty($token)){
          $util->writelog("支付token为空");
          return null;
      }
      $build["Version"] =$merconfig["Version"];
      $build["SignMethod"] =$merconfig["SignMethod"];
      $build["MerNo"] =$merconfig["MerNo"];
      $build["Token"] =$token;
      //操作收银台的有效时间，到期后不可操作  格式:yyyyMMddHHmmss 不传：默认:请求支付链接10分钟后关闭
      //加5分钟
      $build["ExpireTime"] =date('YmdHis',time()+5*60);
      //用户ID  请填写系统平台真实用户ID,如果没有用随机数代替
      $build["UserId"] ="00001";
      //用户标识类型:USEID:用户 IDPHONE:用户手机号 ID_CARD:用户身份证号
      $build["UserIdType"] ="USEID";
      if (!empty($productId)){
          $build["ProductId"] =$productId;
          if (strcmp($productId,"0611")){
              if (empty($directBankId)){
                  $util->writelog("网银跳银行必须传直连银行编码");
                  return null;
              }
              else {
                  $build["DirectBankId"] =$directBankId;
              }
          }
      }

      //==设置请求签名
      $util->setSignature($build,$merconfig["Url_Param_Connect_Flag"]
          ,$removeKeys,$merconfig["Md5Key"]);
      //组合支付数据
      $get_data = $util->getWebForm($build, $base64Keys, $merconfig["Charset"]
          ,$merconfig["Url_Param_Connect_Flag"]);
      //生成支付URL
      $url = $merconfig["ReqUrl_Show"]."?".$get_data;

      $util->writelog("支付Url:".$url);
      return $url;
  }

  ?>
    
   
</body>
</html> 