<?php
error_reporting(E_ALL & ~E_NOTICE);
/**
 * ECSHOP 易付宝插件
 */
include_once("../RSA.php");

/**
 * 类
 */
class reviseOrderForm
{
	function __construct()
    {
        $this->reviseOrderForm();
    }
    /**
     * 构造函数
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function reviseOrderForm()
    {
    }

    

    /**
     * 生成查询代码
     * @param   array    $order       订单信息
     */
    function reviseOrder($order)
    {
    	//私钥
			$prifile='../rsa_private_key.pem';
    	//公钥
    	$pubfile="../rsa_public_key.pem";
    	
    	$merchantNo=$order['yfbpay_account'];//交易发起方的商户号
    	$publicKeyIndex=$order['yfbpay_Pindex'];//公钥索引
    	$signature="";//签名
    	$signAlgorithm="RSA";//签名算法
    	$inputCharset="UTF-8";//编码类型
    	$submitTime=date('YmdHis');//提交时间
      $outOrderNo=$order["outOrderNo"];//商品订单号
    	$orderTime=$order["orderTime"];//下单时间
    	$orderAmount=$order["orderAmount"];//修改后订单金额
      /* 数字签名,按照字母排序 */
      $sigstr="inputCharset=UTF-8"."&merchantNo=".$merchantNo."&orderAmount=".$orderAmount."&orderTime=".$orderTime."&outOrderNo=".$outOrderNo
      	."&publicKeyIndex=".$publicKeyIndex."&submitTime=".$submitTime;
      $sign = strtoupper(md5($sigstr));
      ///////////////////////////////用私钥加密//////////////////////// 
      if(!file_exists($prifile) && !file_exists($pubfile)){
        die('密钥或者公钥的文件路径不正确'); 
      }
          
      $m = new RSA($pubfile, $prifile);
	    $signature = $m->sign($sign);
      /* 交易参数 */
      $parameter = array(
         'merchantNo'             =>  $merchantNo,  //交易发起方的商户号
    	   'publicKeyIndex'         =>  $publicKeyIndex,//公钥索引
    	   'signature'              =>  $signature,//签名
    	   'signAlgorithm'          =>  $signAlgorithm,//签名算法                            
    	   'inputCharset'           =>  $inputCharset,//编码类型
    	   'outOrderNo'             =>  $outOrderNo,//商品订单号
    	   'orderTime'              =>  $orderTime, //订单创建时间
    	   'orderAmount'            =>  $orderAmount,//修改后订单金额
    	   'submitTime'             =>  $submitTime,//提交时间
      );

      $button  = '<br /><form style="text-align:center;" method="post" action="https://paytestpre.suning.com/epps-pag/apiGateway/merchantOrder/reviseMerchantOrder.do" style="margin:0px;padding:0px" >';
		  //$button  .= 'sign==' .$sign;
      foreach ($parameter AS $key=>$val)
      {
          $button  .= "<input type='hidden' name='$key' value='$val' />";
      }
      $button  .= '<input type="submit"  value="' .$GLOBALS['_LANG']['pay_button']. '"  style="display:none;"/></form><br />';
      $button = $button."<script>document.forms[0].submit();</script>";

      return $button;
    }

    /**
     * 响应操作
     */
    function respond()
    {
    	  //私钥
    	  $prifile="";
    	  //公钥
    	  $pubfile="";
    	
        /*取返回参数*/
        $pay_result     = $_GET['responseCode'];//响应码
        $signAlgorithm         = $_GET['signAlgorithm'];//签名方式
        $signature       = $_GET['signature'];
        $keyIndex      = $_GET['keyIndex'];
        $merchantOrderNos   = $_GET['merchantOrderNos'];
        //$order_sn   = $bill_date . str_pad(intval($sp_billno), 5, '0', STR_PAD_LEFT);
        //$log_id = preg_replace('/0*([0-9]*)/', '\1', $sp_billno); //取得支付的log_id
         $log_id = get_order_id_by_snyfb($merchantOrderNos);
        /* 如果pay_result大于0则表示支付失败 */
        if ($pay_result <>"0000")
        {
            return false;
        }else
        {
        	/* 检查数字签名是否正确 */
	        if(!file_exists($prifile) && !file_exists($pubfile)){
	          die('密钥或者公钥的文件路径不正确'); 
	        }
	       
	        $sigstr="keyIndex=".$keyIndex."&merchantOrderNos=".$merchantOrderNos."&responseCode=".$pay_result;
            $sign = strtoupper(md5($sigstr));
            $signature = str_replace(array('-','_'),array('+','/'),$signature);
            $m = new RSA($pubfile, $prifile);
            if(!$m->verify($sign,$signature)){
               return false;
            }
            /* 改变订单状态 */
            order_paid($log_id);
            return true;
        }
    }
}

?>