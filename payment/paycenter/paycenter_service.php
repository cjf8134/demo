<?php
include_once 'config.php';
include_once 'common/Tool.php';
include_once 'common/config.php';
require_once 'common/Paycenter.Exception.php';
require_once 'request/order_query_request.php';
require_once 'request/refund_request.php';
require_once 'request/refund_query_request.php';
require_once 'common/Paycenter.Exception.php';
require_once 'common/CertSerialUtil.php';

class PayCenterService{
	
	/**
	 * 发起支付请求
	 * @param PayRequest $model 支付请求参数
	 */
	public function sendPayRequest(PayRequest $model){
		$httpUrl = PAY_URL."?";
		//2、签名
		$model->SetSign();
		$requestStr = ToRequestUrlParams($model->GetValues());

		//3、发送支付请求
		$requestUrl = $httpUrl.$requestStr."&sign=".urlencode($model->GetSign());

		redirect($requestUrl);
	}
	
	/**
	 * 支付请求同步接受响应
	 * @param unknown $getParams
	 * @param unknown $postParams
	 * @throws PaycenterException
	 */
	public function acceptResponse($getParams,$postParams){
		//1、接受请求参数
		$params = getRequstParamters($getParams,$postParams);
		//2、验证签名
		if(verifySign($params)){
			return $params;
		}else {
			throw new PaycenterException("签名验证失败");
		}
	}
	
	/**
	 * 支付请求异步接受响应
	 * @param unknown $getParams
	 * @param unknown $postParams
	 * @throws PaycenterException
	 */
	public function acceptNotifyResponse($getParams,$postParams){
		//异步请求返回需要用file_get_contents取值
		$str = file_get_contents("php://input");
		$params=array();
		//parse_str:将字符串解析成多个变量
		parse_str($str,$params);
		//2、验证签名
		if(verifySign($params)){

			return $params;
		}else {
			throw new PaycenterException("签名验证失败");
		}
	}
	
	
	/**
	 * 查询订单
	 * @param unknown $outTradeNo  商户订单业务流水号
	 * @return 响应结果 array
	 * @throws PaycenterException  
	 */
	public function queryOrder(OrderQueryRequest $model){
		//1、封装请求参数
		$model->setTransType("query");

		//2、进行签名
		$model->SetSign();

		//3、发送请求
		$responseStr = $this->postDataCurl(ToRequestUrlParams($model->GetValues())."&sign=".urlencode($model->GetSign()), SysConfig::ORDER_URL);
		

		$result = xmlToArray($responseStr);
		//4、解析xml
		if("00" == $result["resp_code"]){
			//5、签名验证
			if(verifySign($result)){
				Log::INFO("签名验证成功\r\n");
				return $result;
			}else{
				Log::INFO("签名验证失败\r\n");
				throw new PaycenterException("签名验证失败");
			}
			return null;
		}
		
	}
	
	/**
	 * 退款请求
	 * @param unknown $outTradeNo 商户订单流水号
	 * @param unknown $outRefundNo 商户退款订单流水号
	 * @param unknown $totalAmount 订单总金额
	 * @param unknown $refundAmount 退款金额
	 * @return 响应结果 array
	 * @throws PaycenterException
	 */
	function refundRequest(RefundRequest $model){
		//1、封装请求参数
		$model->setTransType("refund");
		
		//2、进行签名
		$model->SetSign();

		//3、发送请求
		$responseStr = $this->postDataCurl(ToRequestUrlParams($model->GetValues())."&sign=".urlencode($model->GetSign()), SysConfig::ORDER_URL);
		$result = xmlToArray($responseStr);
		//4、解析xml
		if("00" == $result["resp_code"]){
			//5、签名验证
			if(verifySign($result)){
				Log::INFO("签名验证成功\r\n");
				return $result;
			}else{
				Log::INFO("签名验证失败\r\n");
				throw new PaycenterException("签名验证失败");
			}
			return null;
		}
	}
	
	/**
	 * 退款单查询
	 * @param unknown $outTradeNo 商户订单业务流水号
	 * @param unknown $outRefundNo 商户退款订单流水号
	 * @param unknown $refundId 易票联退款订单流水号
	 * @return 响应结果 array
	 * @throws PaycenterException
	 */
	function refundQuery(RefundQueryRequest $model){
		//1、封装请求参数
		$model->setTransType("refundQuery");
		//2、进行签名
		$model->SetSign();

		//3、发送请求
		$responseStr = $this->postDataCurl(ToRequestUrlParams($model->GetValues())."&sign=".urlencode($model->GetSign()), SysConfig::ORDER_URL);
	

		$result = xmlToArray($responseStr);
		//4、解析xml
		if("00" == $result["resp_code"]){
			//5、签名验证
			if(verifySign($result)){
				Log::INFO("签名验证成功\r\n");
				return $result;
			}else{
				Log::INFO("签名验证失败\r\n");
				throw new PaycenterException("签名验证失败");
			}
			return null;
		}
	}
	
	/**
	 * curl 请求
	 * @param unknown $params
	 * @param unknown $url
	 * @param number $second
	 * @throws PaycenterException
	 */
	function postDataCurl($params, $url, $second = 30)
	{
		$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
	
		//如果有配置代理这里就设置代理
		if(SysConfig::CURL_PROXY_HOST != "0.0.0.0"
				&& SysConfig::CURL_PROXY_PORT != 0){
					curl_setopt($ch,CURLOPT_PROXY, SysConfig::CURL_PROXY_HOST);
					curl_setopt($ch,CURLOPT_PROXYPORT, SysConfig::CURL_PROXY_PORT);
		}
		//curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
		
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		
		//设置header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		//post提交方式
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_ENCODING, "");
		//运行curl
		$data = curl_exec($ch);
		$data = str_replace("GBK", "UTF-8", $data);
		$data = mb_convert_encoding($data, "UTF-8", "GBK");
		//返回结果
		if($data){
			curl_close($ch);
			return $data;
		} else {
			$error = curl_errno($ch);
			curl_close($ch);
			throw new PaycenterException("curl出错，错误码:$error");
		}
	}
}
?>