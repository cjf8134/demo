<?php

class gateway
{
	//秘钥
	protected $publickey = '66e36e230dace228579dbe0627b94ffe';
	//curl post
	public function curl_post($url,$data){ // 模拟提交数据函数
		$curl = curl_init(); // 启动一个CURL会话
		curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
		curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
		curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
		curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
		curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
		curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		$tmpInfo = curl_exec($curl); // 执行操作
		if (curl_errno($curl)) {
			echo 'Errno'.curl_error($curl);//捕抓异常
		}
		curl_close($curl); // 关闭CURL会话
		return $tmpInfo; // 返回数据，json格式
	}

	//get sign
	public function get_sign($arr) {
		$signmd5="";
		ksort($arr);
		foreach($arr as $x=>$x_value)
		{
			if(!$x_value==""||$x_value==0){
				if($signmd5==""){
					$signmd5 =$signmd5.$x .'='. $x_value;
				}else{
					$signmd5 = $signmd5.'&'.$x .'='. $x_value;
				}
			}
		}
		return md5($signmd5.$this->publickey);
	}
}