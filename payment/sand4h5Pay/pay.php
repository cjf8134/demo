<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>快捷支付下单</title>
</head>
<body>
<pre>
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



          $data = array(

              'head' => array(
                  'version' => '1.0',
                  'method' => 'sandpay.trade.pay',
                  'productId' => '00000008',
                  'accessType' => '1',
                  'mid' => M_ID,
                  'channelType' => '07',
                  'reqTime' => date('YmdHis', time())
              ),
              'body' => array(
                  'orderCode' => $post['orderNo'],
                  'totalAmount' => makeOrderAmount($post['orderAmount']),
                  'subject' => "快捷h5支付",
                  'body' => "快捷h5支付",
                  'txnTimeOut' =>date("YmdHis",strtotime("+3 Months")),
                  'payMode'=>"sand_h5",
                  'payExtra' => '',  //json_encode(array('cardNo' => "622848******91177"))
                  'clientIp' => "127.0.0.1", //get_ip(),
                  'notifyUrl' =>$notify_url,
                  'frontUrl' => $return_url,
                  'extend' => '',
                  'clearCycle'=>'0'

              )

          );
          $log->W("参数:\n".var_export($data,true));

          $prikey = loadPk12Cert(PRI_KEY_PATH,CERT_PWD);
          $sign = sign($data, $prikey);
          $log->W("参数:\n".$sign);
          // step3: 拼接post数据
          $post = array(
              'charset' => 'utf-8',
              'signType' => '01',
              'data' => json_encode($data),
              'sign' => urlencode($sign)
          );

          $log->W("表单提交-参数:\n".var_export($post,true));
          // step4: post请求
          $result = http_post_json(API_HOST . '/order/pay', $post);
          $arr = parse_result($result);

          //step5: 公钥验签
          $pubkey = loadX509Cert(PUB_KEY_PATH);
          try {
              verify($arr['data'], $arr['sign'], $pubkey);
          } catch (\Exception $e) {
              echo $e->getMessage();
              exit;
          }

          // step6： 获取credential
          $data = json_decode($arr['data'], true);
          if ($data['head']['respCode'] == "000000") {
              $credential = $data['body']['credential'];



              ?>
              <script type="text/javascript" src="scripts/paymentjs.js"></script>
              <script type="text/javascript" src="scripts/jquery-1.7.2.min.js"></script>

              <script>
                  function wap_pay() {
                      var responseText = $("#credential").text();

                      paymentjs.createPayment(responseText, function(result, err) {

                      });
                  }
              </script>

              <div style="display: none" >
                  <p id="credential"><?php echo $credential; ?></p>
              </div>
              <script>
                  window.onload=function(){
                      wap_pay();
                  };
              </script>
              <?php
          }else{
              print_r($arr['data']);
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