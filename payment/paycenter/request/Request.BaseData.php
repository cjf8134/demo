<?php

class RequestBaseData{
	public $values = array();
	public $pri_key;
	function __construct() {
		$this->values["partner"]   = M_ID;
		$this->values["sign_type"] = SysConfig::SIGN_TYPE;
		$this->values["version"]   = SysConfig::VERSION;
		$certs = array();
		openssl_pkcs12_read(trim(file_get_contents(SysConfig::PFX_PATH)), $certs, SysConfig::PRIVATEKEY_PASSWORD); //其中password为你的证书密码
		if(!$certs) return '';
		$this->pri_key = $certs['pkey'];
		$this->values["certId"] = CertSerialUtil::getSerial ($certs['cert'], $errMsg );
	}
	
	/**
	 * 设置签名，详见签名生成算法
	 * @param string $value
	 **/
	public function SetSign()
	{
		$sign = $this->MakeSign();
		$this->values['sign'] = $sign;
		return $sign;
	}
	
	/**
	 * 获取签名，详见签名生成算法的值
	 * @return 值
	 **/
	public function GetSign()
	{
		return $this->values['sign'];
	}
	
	/**
	 * 判断签名，详见签名生成算法是否存在
	 * @return true 或 false
	 **/
	public function IsSignSet()
	{
		return array_key_exists('sign', $this->values);
	}
	
	/**
	 * 格式化参数格式化成url参数
	 */
	public function ToUrlParams()
	{
		$buff = "";
		foreach ($this->values as $k => $v)
		{
			if($k != "sign" && $v != "" && !is_array($v)){
				$buff .= $k . "=" . $v . "&";
			}
		}
	
		$buff = trim($buff, "&");
		return $buff;
	}
	
	/**
	 * 生成签名
	 * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
	 */
	public function MakeSign()
	{

		//签名步骤一：按字典序排序参数
		ksort($this->values);
		$string = $this->ToUrlParams();
		//签名步骤二：在string后加入KEY
//		$string = $string . "&key=".APP_KEY;
		//签名步骤三：SHA256加密
		$string = $this->sign($string);
		return $string;
	}

	public function sign($data) {
		openssl_sign($data, $signature, $this->pri_key,"SHA256");
		return base64_encode($signature);
	}
	
	/**
	 * 获取设置的值
	 */
	public function GetValues()
	{
		return $this->values;
	}
	
}

?>