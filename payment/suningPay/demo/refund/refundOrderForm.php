<?php
error_reporting(E_ALL & ~E_NOTICE);
/**
 * ECSHOP �׸������
 */
include_once("../RSA.php");

/**
 * ��
 */
class refundOrderForm
{
	function __construct()
    {
        $this->refundOrderForm();
    }
    /**
     * ���캯��
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function refundOrderForm()
    {
    }

    

    /**
     * ���ɲ�ѯ����
     * @param   array    $order       ������Ϣ
     */
    function refundOrder($order)
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
    	$version="1.1";//�汾��
    	$submitTime=date('YmdHis');//�ύʱ��
    	$notifyUrl="http://api.test.suning.com/atinterface/receive.htm";//�������첽ͨ ֪URL
      $refundOrderNo=$order["refundOrderNo"];//�˿��
    	$origOutOrderNo=$order["origOutOrderNo"];//ԭ�̻�Ψһ������
    	$origMerchantOrderNo=$order["origOutOrderNo"];//ԭ�̻�չʾ������
    	$refundOrderTime=$order["refundOrderTime"];//�˿������ʱ��
    	$origOrderTime=$order["origOrderTime"];//ԭ��������ʱ��
    	$refundAmount = floatval($order['refundAmount']) * 100;//�˿���
    	$refundReason=$order["refundReason"];//�˿�����
      /* ����ǩ��,������ĸ���� */
      $sigstr="inputCharset=UTF-8"."&merchantNo=".$merchantNo."&notifyUrl=".$notifyUrl."&origMerchantOrderNo=".$origMerchantOrderNo
        ."&origOrderTime=".$origOrderTime."&origOutOrderNo=".$origOutOrderNo."&publicKeyIndex=".$publicKeyIndex."&refundAmount=".$refundAmount
        ."&refundOrderNo=".$refundOrderNo."&refundOrderTime=".$refundOrderTime."&refundReason=".$refundReason."&submitTime=".$submitTime."&version=".$version;
      $sign = strtoupper(md5($sigstr));
      ///////////////////////////////��˽Կ����//////////////////////// 
      if(!file_exists($prifile) && !file_exists($pubfile)){
        die('��Կ���߹�Կ���ļ�·������ȷ'); 
      }
          
      $m = new RSA($pubfile, $prifile);
	    $signature = $m->sign($sign);
      /* ���ײ��� */
      $parameter = array(
         'merchantNo'              =>  $merchantNo,  //���׷��𷽵��̻���
    	   'publicKeyIndex'          =>  $publicKeyIndex,//��Կ����
    	   'signature'               =>  $signature,//ǩ��
    	   'signAlgorithm'           =>  $signAlgorithm,//ǩ���㷨                            
    	   'inputCharset'            =>  $inputCharset,//��������
    	   'version'                 =>  $version,//�汾��
    	   'submitTime'              =>  $submitTime,//�ύʱ��
    	   'notifyUrl'               =>  $notifyUrl,//�������첽ͨ ֪URL
    	   'refundOrderNo'           =>  $refundOrderNo,//�˿��
    	   'origOutOrderNo'          =>  $origOutOrderNo,//ԭ�̻�Ψһ������
    	   'origMerchantOrderNo'     =>  $origMerchantOrderNo,//ԭ�̻�չʾ������
    	   'refundOrderTime'         =>  $refundOrderTime,//�˿������ʱ��
    	   'origOrderTime'           =>  $origOrderTime,//ԭ��������ʱ��
    	   'refundAmount'            =>  $refundAmount,//�˿���
    	   'refundReason'            =>  $refundReason//�˿�����
      );

      $button  = '<br /><form style="text-align:center;" method="post" action="https://paytestpre.suning.com/epps-pag/apiGateway/refundOrder/createRefundOrder.do" style="margin:0px;padding:0px" >';
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