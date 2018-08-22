<?php
/* *
 * 功能：支付平台接口类
 * 版本：1.0
 * 日期：2015-03-26
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码。
 */
 	
class YbPfa {
	private $ybpKey;
	public $serverUrl;

	/**
	 * 签名初始化
	 * @param mbpKey	签名密钥
	 * @param url		请求的URL
	 */

	public function __construct($ybpKey, $url="") {
		$this->ybpKey = $ybpKey;
		$this->serverUrl = $url;
	}

	/**
	 * 创建表单
	 * @data		表单内容
	 * @gateway 支付网关地址
	 */
	function buildForm($data) {			
			$sHtml = "<form id='paysubmit' name='paysubmit' action='".$this->serverUrl."' method='post'>";
			while (list ($key, $val) = each ($data)) {
	            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
			}
			$sHtml.= "</form>";
			$sHtml.= "<script>document.forms['paysubmit'].submit();</script>";
			
			return $sHtml;
	}

	
	public function prepareSign($data) {
		//查单
		if($data['apiName'] == 'TRAN_DF_QUERY') {
			$result = sprintf(
				"apiName=%s&platformID=%s&merchNo=%s&orderNo=%s",
				$data['apiName'],$data['platformID'], $data['merchNo'], $data['orderNo']
			);
			return $result;
			
			
		//下单
		} else if ($data['apiName'] == 'TRAN_DF') {

			$result = sprintf(				"apiName=%s&platformID=%s&merchNo=%s&orderNo=%s&amt=%s&bankName=%s&bankCode=%s&account=%s&name=%s&province=%s&city=%s&branchName=%s",
			$data['apiName'],$data['platformID'],$data['merchNo'],$data['orderNo'],$data['amt'], $data['bankName'], $data['bankCode'], $data['account'],$data['name'],$data['province'],$data['city'],$data['branchName']);
			
			return $result;
			
		
		} 
		
		$array = array();
		
		foreach ($data as $key=>$value) {
			array_push($array, $key.'='.$value);
		}
		
		return implode($array, '&');
	}

	/**
	 * @name	生成签名
	 * @param	sourceData
	 * @return	签名数据
	 */
	public function sign($data) {
		$signature = MD5($data.$this->ybpKey);
		return $signature;
	}

	/*
	 * @name	准备带有签名的request字符串
	 * @desc	merge signature and request data
	 * @param	request字符串
	 * @param	签名数据
	 * @return	
	 */
	public function prepareRequest($string, $signature) {
		return $string.'&signMsg='.$signature;
	}

	/*
	 * @name	请求接口
	 * @desc	request api
	 * @param	curl,sock
	 */
	public function request($data, $method='curl') {
		# TODO:	当前只有curl方式，以后支持fsocket等方式
		$curl = curl_init();
		$curlData = array();
		$curlData[CURLOPT_POST] = true;
		$curlData[CURLOPT_URL] = $this->serverUrl;
		$curlData[CURLOPT_RETURNTRANSFER] = true;
		$curlData[CURLOPT_TIMEOUT] = 120;
		#CURLOPT_FOLLOWLOCATION
		$curlData[CURLOPT_POSTFIELDS] = $data;
		curl_setopt_array($curl, $curlData);
			
		curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, 0);
		$result = curl_exec($curl);
		
		if (!$result)
		{
			var_dump(curl_error($curl));
		}
		curl_close($curl);
		//echo $result;
		return $result;
	}

	/*
	 * @name	准备获取验签数据
	 * @desc	extract signature and string to verify from response result
	 */
	public function prepareVerify($result) {
		preg_match('{<respData>(.*?)</respData>}', $result, $match);
		$srcData = $match[1];
		preg_match('{<signMsg>(.*?)</signMsg>}', $result, $match);
		$signature = $match[1];
		//$signature = str_replace('%2B', '+', $signature);
		
		return array($srcData, $signature);
	}

	/*
	 * @name	验证签名
	 * @param	signData 签名数据
	 * @param	sourceData 原数据
	 * @return
	 */
	public function verify($data, $signature) {
		$mySign = $this->sign($data);
		if (strcasecmp($mySign, $signature) == 0) {
			return true;
		} else {
			return false;
		}
	}

	/*
	 * @name 平台查询请求交易
	 * @desc
	 */
	public function payTranQuery($data) {
		$str_to_sign = $this->prepareSign($data);
		$sign = $this->sign($str_to_sign);
		$to_request = $this->prepareRequest($str_to_sign, $sign);
		$result = $this->request($to_request);

		$to_verify = $this->prepareVerify($result);

		if ($this->verify($to_verify[0], $to_verify[1]) ) {
			return $result;
		} else{
			//echo "verify error";
			return false;
		}
	}

	/*
	 * @name	平台退款请求交易
	 * @desc
	 */
	public function payTranReturn($data) {
		$str_to_sign = $this->prepareSign($data);
		$sign = $this->sign($str_to_sign);
		$to_requset = $this->prepareRequest($str_to_sign, $sign);
		$result = $this->request($to_requset);
		$to_verify = $this->prepareVerify($result);
		if ($this->verify($to_verify[0], $to_verify[1]) ) {
			return $result;
		} else {
			return false;
		}
	}

	/*
	 * @name	组装请求的交易数据
	 * @desc
	 */
	public function getTradeMsg($data) {
		if($data['tradeSummary']){
			$data['tradeSummary'] = urlencode($data['tradeSummary']);
		}
		return $this->prepareSign($data);
	}
	/*
	 * @name	支付平台请求交易
	 * @desc
	 */
	public function payOrder($data) {
		$str_to_sign = $this->prepareSign($data);
		$sign = $this->sign($str_to_sign);
		$sign = urlencode($sign);
		$to_request = $this->prepareRequest($this->getTradeMsg($data), $sign);
		$url = $this->serverUrl . '?' . $to_request;
		if($data['bankCode']){
			$url = $url . '&bankCode='.$data['bankCode'];
		}
		$this->redirect($url);
	}	
}
?>
