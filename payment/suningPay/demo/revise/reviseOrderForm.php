<?php
error_reporting(E_ALL & ~E_NOTICE);
/**
 * ECSHOP �׸������
 */
include_once("../RSA.php");

/**
 * ��
 */
class reviseOrderForm
{
	function __construct()
    {
        $this->reviseOrderForm();
    }
    /**
     * ���캯��
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
     * ���ɲ�ѯ����
     * @param   array    $order       ������Ϣ
     */
    function reviseOrder($order)
    {
    	//˽Կ
			$prifile='../rsa_private_key.pem';
    	//��Կ
    	$pubfile="../rsa_public_key.pem";
    	
    	$merchantNo=$order['yfbpay_account'];//���׷��𷽵��̻���
    	$publicKeyIndex=$order['yfbpay_Pindex'];//��Կ����
    	$signature="";//ǩ��
    	$signAlgorithm="RSA";//ǩ���㷨
    	$inputCharset="UTF-8";//��������
    	$submitTime=date('YmdHis');//�ύʱ��
      $outOrderNo=$order["outOrderNo"];//��Ʒ������
    	$orderTime=$order["orderTime"];//�µ�ʱ��
    	$orderAmount=$order["orderAmount"];//�޸ĺ󶩵����
      /* ����ǩ��,������ĸ���� */
      $sigstr="inputCharset=UTF-8"."&merchantNo=".$merchantNo."&orderAmount=".$orderAmount."&orderTime=".$orderTime."&outOrderNo=".$outOrderNo
      	."&publicKeyIndex=".$publicKeyIndex."&submitTime=".$submitTime;
      $sign = strtoupper(md5($sigstr));
      ///////////////////////////////��˽Կ����//////////////////////// 
      if(!file_exists($prifile) && !file_exists($pubfile)){
        die('��Կ���߹�Կ���ļ�·������ȷ'); 
      }
          
      $m = new RSA($pubfile, $prifile);
	    $signature = $m->sign($sign);
      /* ���ײ��� */
      $parameter = array(
         'merchantNo'             =>  $merchantNo,  //���׷��𷽵��̻���
    	   'publicKeyIndex'         =>  $publicKeyIndex,//��Կ����
    	   'signature'              =>  $signature,//ǩ��
    	   'signAlgorithm'          =>  $signAlgorithm,//ǩ���㷨                            
    	   'inputCharset'           =>  $inputCharset,//��������
    	   'outOrderNo'             =>  $outOrderNo,//��Ʒ������
    	   'orderTime'              =>  $orderTime, //��������ʱ��
    	   'orderAmount'            =>  $orderAmount,//�޸ĺ󶩵����
    	   'submitTime'             =>  $submitTime,//�ύʱ��
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
     * ��Ӧ����
     */
    function respond()
    {
    	  //˽Կ
    	  $prifile="";
    	  //��Կ
    	  $pubfile="";
    	
        /*ȡ���ز���*/
        $pay_result     = $_GET['responseCode'];//��Ӧ��
        $signAlgorithm         = $_GET['signAlgorithm'];//ǩ����ʽ
        $signature       = $_GET['signature'];
        $keyIndex      = $_GET['keyIndex'];
        $merchantOrderNos   = $_GET['merchantOrderNos'];
        //$order_sn   = $bill_date . str_pad(intval($sp_billno), 5, '0', STR_PAD_LEFT);
        //$log_id = preg_replace('/0*([0-9]*)/', '\1', $sp_billno); //ȡ��֧����log_id
         $log_id = get_order_id_by_snyfb($merchantOrderNos);
        /* ���pay_result����0���ʾ֧��ʧ�� */
        if ($pay_result <>"0000")
        {
            return false;
        }else
        {
        	/* �������ǩ���Ƿ���ȷ */
	        if(!file_exists($prifile) && !file_exists($pubfile)){
	          die('��Կ���߹�Կ���ļ�·������ȷ'); 
	        }
	       
	        $sigstr="keyIndex=".$keyIndex."&merchantOrderNos=".$merchantOrderNos."&responseCode=".$pay_result;
            $sign = strtoupper(md5($sigstr));
            $signature = str_replace(array('-','_'),array('+','/'),$signature);
            $m = new RSA($pubfile, $prifile);
            if(!$m->verify($sign,$signature)){
               return false;
            }
            /* �ı䶩��״̬ */
            order_paid($log_id);
            return true;
        }
    }
}

?>