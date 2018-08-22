<?php
require_once 'config.php';
require_once '3des.class.php';
//基础类
class base
{
    
    public $values = array();
    public $Body = array();
    
    /**
     * 设置签名，详见签名生成算法
     * @param string $value
     **/
    public function SetSign($value)
    {
        $this->values['Sign'] = $value;
        return $value;
    }
    
    /**
     * 获取签名，详见签名生成算法的值
     * @return 值
     **/
    public function GetSign()
    {
        return $this->values['Sign'];
    }
    
    /**
     * 判断签名，详见签名生成算法是否存在
     * @return true 或 false
     **/
    public function IsSignSet()
    {
        return array_key_exists('Sign', $this->values);
    }
    
    
    /**
     * 设置接口id
     * @param string $value
     **/
    public function SetCommandID($value)
    {
        $this->values['CommandID'] = $value;
    }
    
    /**
     * 获取接口id
     * @return 值
     **/
    public function GetCommandID()
    {
        return $this->values['CommandID'];
    }
    
    /**
     * 判断接口id
     * @return true 或 false
     **/
    public function IsCommandIDSet()
    {
        return array_key_exists('CommandID', $this->values);
    }
    
    /**
     * 设置序列id
     * @param string $value
     **/
    public function SetSeqID($value)
    {
        $this->values['SeqID'] = $value;
    }
    
    /**
     * 获取序列id
     * @return 值
     **/
    public function GetSeqID()
    {
        return $this->values['SeqID'];
    }
    
    /**
     * 判断序列id是否存在
     * @return true 或 false
     **/
    public function IsSeqIDSet()
    {
        return array_key_exists('SeqID', $this->values);
    }
    
    /**
     * 设置请求类型
     * @param string $value
     **/
    public function SetNodeType($value)
    {
        $this->values['NodeType'] = $value;
    }
    
    /**
     * 获取请求类型
     * @return 值
     **/
    public function GetNodeType()
    {
        return $this->values['NodeType'];
    }
    
    /**
     * 判断请求类型是否存在
     * @return true 或 false
     **/
    public function IsNodeTypeSet()
    {
        return array_key_exists('NodeType', $this->values);
    }
    
    /**
     * 设置请求编号
     * @param string $value
     **/
    public function SetNodeID($value)
    {
        $this->values['NodeID'] = $value;
    }
    
    /**
     * 获取请求编号
     * @return 值
     **/
    public function GetNodeID()
    {
        return $this->values['NodeID'];
    }
    
    /**
     * 判断请求编号是否存在
     * @return true 或 false
     **/
    public function IsNodeIDSet()
    {
        return array_key_exists('NodeID', $this->values);
    }
    
    /**
     * 设置版本
     * @param string $value
     **/
    public function SetVersion($value)
    {
        $this->values['Version'] = $value;
    }
    
    /**
     * 获取版本
     * @return 值
     **/
    public function GetVersion()
    {
        return $this->values['Version'];
    }
    
    /**
     * 判断版本是否存在
     * @return true 或 false
     **/
    public function IsVersionSet()
    {
        return array_key_exists('Version', $this->values);
    }
    
    /**
     * 设置业务数据包
     * @param string $value
     **/
    public function SetBody($value)
    {
        $this->values['Body'] = $value;
    }
    
    /**
     * 获取业务数据包
     * @return 值
     **/
    public function GetBody()
    {
        return $this->values['Body'];
    }
    
    /**
     * 判断业务数据包是否存在
     * @return true 或 false
     **/
    public function IsBodySet()
    {
        return array_key_exists('Body', $this->values);
    }
    
    /**
     * 设置代理商编号
     * @param string $value
     **/
    public function SetAGENTNO($value)
    {
        $this->values['AGENTNO'] = $value;
    }
    
    /**
     * 获取代理商编号
     * @return 值
     **/
    public function GetAGENTNO()
    {
        return $this->values['AGENTNO'];
    }
    
    /**
     * 判断代理商编号是否存在
     * @return true 或 false
     **/
    public function IsAGENTNOSet()
    {
        return array_key_exists('AGENTNO', $this->values);
    }
    
    /**
     * 设置商户号
     * @param string $value
     **/
    public function SetMERNO($value)
    {
        $this->values['MERNO'] = $value;
    }
    
    /**
     * 获取商户号
     * @return 值
     **/
    public function GetMERNO()
    {
        return $this->values['MERNO'];
    }
    
    /**
     * 判断商户号是否存在
     * @return true 或 false
     **/
    public function IsMERNOSet()
    {
        return array_key_exists('MERNO', $this->values);
    }
    
    /**
     * 设置终端号
     * @param string $value
     **/
    public function SetTERMNO($value)
    {
        $this->values['TERMNO'] = $value;
    }
    
    /**
     * 获取终端号
     * @return 值
     **/
    public function GetTERMNO()
    {
        return $this->values['TERMNO'];
    }
    
    /**
     * 判断终端号是否存在
     * @return true 或 false
     **/
    public function IsTERMNOSet()
    {
        return array_key_exists('TERMNO', $this->values);
    }
    
    /**
     * 对整个报文生成签名
     * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
     */
    public function MakeSign()
    {
        $values = $this->Body;
        
        ksort($values);
        $string = json_encode($values, JSON_UNESCAPED_UNICODE);
        $string = $string . '&key=' . payconfig::KEY;
        $string = md5($string);
        $result = strtoupper($string);
        $this->SetSign($result);
        return $result;
    }


    /**
     * 对整个报文生成签名
     * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
     */
    public function _MakeSign()
    {
        $values = $this->Body;
        ksort($values);
        $string = json_encode($values, JSON_UNESCAPED_UNICODE);
        $string = $string . '&key=8ebae54be884479d2f79cca952311aad';
        $string = md5($string);
        $result = strtoupper($string);
        $this->SetSign($result);
        return $result;
    }
    
    /**
     * 对返回结果验证签名
     * 
     */
    public function ckSign($arr)
    {
        $values = $arr;
        ksort($values);
        $string = json_encode($values,JSON_UNESCAPED_UNICODE);
        $string = $string . '&key=' . payconfig::KEY;
        $string = md5($string);
        $result = strtoupper($string);
        return $result;
    }
    
    //此加密方式作废
    public function BodyAes()
    {
        $this->SetBody($this->Body);
        return true;
    }
    
    /**
     * 获取设置的值
     */
    public function GetValues()
    {
        return $this->values;
    }
    /**
     * 校验$value是否非空
     *  if not set ,return true;
     *    if is null , return true;
     **/
    protected function checkEmpty($value) {
        if (!isset($value))
            return true;
            if ($value === null)
                return true;
                if (trim($value) === "")
                    return true;
    
                    return false;
    }
	/**
     * 建立请求，以表单HTML形式构造（默认）
     * @param $para_temp 请求参数数组
     * @return 提交表单HTML文本
     */
	public function sendHtml($para_temp = '') {
	    $para_temp = empty($para_temp)? json_encode($this->GetValues()) :'';
	   
		$sHtml = "<form id='demosubmit' name='demosubmit' action='".payconfig::MS_URL."?charset=UTF-8' method='POST'>";
		/* while (list ($key, $val) = each ($para_temp)) {
			if (false === $this->checkEmpty($val)) {
				//$val = $this->characet($val, $this->postCharset);
				$val = str_replace("'","&apos;",$val);
				//$val = str_replace("\"","&quot;",$val);
				$sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
			}
        } */
		$sHtml.= "<input type='hidden' name='web_api' value='".$para_temp."'/>";
		//submit按钮控件请不要含有name属性
        $sHtml = $sHtml."<input type='submit' value='ok' style='display:none;''></form>";
		
//		$sHtml = $sHtml."<script>document.forms['demosubmit'].submit();</script>";
		
		return $sHtml;
	}
    /***
     * CURL发送请求
     */
    public function send($second = 60)
    {

        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        
        curl_setopt($ch,CURLOPT_URL, payconfig::MS_URL);
        // curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);       
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->GetValues()));
        //运行curl
        $data = curl_exec($ch);
        if(json_decode($data,true)){
            var_dump(json_encode(json_decode($data,true),320));
        }else{
            var_dump($data);
        }
	    
        //返回结果
        if($data){
            curl_close($ch);
            //如果是下载对账单，特殊处理
            
            $result = json_decode($data, true);
            if($result['RetCode'] == 1)
            {
                $mysign = $this->ckSign($result['Body']);

                if($mysign != $result['Sign']){
                    exit('签名错误');
                }else{
                    return $result['Body'];
                }

                return false;
                
                //验证签名
               /*$ckstatus = $this->ckSign($result);
               if($ckstatus)
               {
                  
                  if($result['CommandID'] == hexdec('0x8901'))
                  {
                      
                      $Body = $this->BodyDeRsa($result['Body']);
                  }else {
                    //解密Body数据
                    $Body = $this->BodyDeAes($result['Body']);
                     
                  }
                  if($Body)
                  {
                      return json_decode($Body,true);
                  }
                  return false;
               }
               return false;*/
            }elseif ($result == false && $this->GetCommandID() == hexdec('0x090B'))//输入文件流
            {
                return array('STATUS'=>true,'txt'=>$data);
            }
            else
            {
                return false;
            }
        } else {
            $error = curl_errno($ch);
            $er = curl_error($ch);
            curl_close($ch);
	    var_dump($er);
            return false;
        }
        
    }


    /***
     * CURL发送请求
     */
    public function Post($second = 60)
    {

        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        
        curl_setopt($ch,CURLOPT_URL, 'http://127.0.0.1:20044/open/mpay/api');
        // curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);       
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->GetValues()));
        //运行curl
        $data = curl_exec($ch);
    //var_dump($data);
        //返回结果
        if($data){
            curl_close($ch);
            //如果是下载对账单，特殊处理
            
            $result = json_decode($data, true);
            if($result['RetCode'] == 1)
            {
                $mysign = $this->ckSign($result['Body']);

                if($mysign != $result['Sign']){
                    exit('签名错误');
                }else{
                    return $result['Body'];
                }

                return false;
                
                //验证签名
               /*$ckstatus = $this->ckSign($result);
               if($ckstatus)
               {
                  
                  if($result['CommandID'] == hexdec('0x8901'))
                  {
                      
                      $Body = $this->BodyDeRsa($result['Body']);
                  }else {
                    //解密Body数据
                    $Body = $this->BodyDeAes($result['Body']);
                     
                  }
                  if($Body)
                  {
                      return json_decode($Body,true);
                  }
                  return false;
               }
               return false;*/
            }elseif ($result == false && $this->GetCommandID() == hexdec('0x090B'))//输入文件流
            {
                return array('STATUS'=>true,'txt'=>$data);
            }
            else
            {
                return false;
            }
        } else {
            $error = curl_errno($ch);
            $er = curl_error($ch);
            curl_close($ch);
        var_dump($er);
            return false;
        }
        
    }

    /***
     * CURL发送请求 文件类型发送
     * @param file_path 文件服务路径
     * @param second 超时时间
     */
    public function sendFile($file_path, $second = 60)
    {
    
		$fields = array();
		$fields['web_api'] = json_encode($this->GetValues());
		$fields['Attach']  = $file_path;
		
		$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		
		curl_setopt($ch,CURLOPT_URL, payconfig::MS_URL);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
		//设置header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);       
		//post提交方式
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_USERAGENT,'Opera/9.80 (Windows NT 6.2; Win64; x64) Presto/2.12.388 Version/12.15');
		//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
		curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);    // 5.6 给改成 true了, 弄回去
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		//运行curl
		$data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            //如果是下载对账单，特殊处理
    
            $result = json_decode($data, true);
            if($result['RetCode'] == 1)
            {
    
                //验证签名
                $ckstatus = $this->ckSign($result);
                if($ckstatus)
                {
    
                    if($result['CommandID'] == hexdec('0x8901'))
                    {
    
                        $Body = $this->BodyDeRsa($result['Body']);
                    }else {
                        //解密Body数据
                        $Body = $this->BodyDeAes($result['Body']);
                         
                    }
                    if($Body)
                    {
                        return json_decode($Body,true);
                    }
                    return false;
                }
                return false;
            }else{
                return $result;
            }
        } else {
            $error = curl_errno($ch);
            $er = curl_error($ch);
            curl_close($ch);
            return false;
        }
    
    }    
    /**
     * 设置附件
     */
    public function SetAttach($value)
    {
        $this->values['Attach'] = $value;
    }
    /**
     * 获取附件
     */
    public function GetAttach()
    {
        return $this->values['Attach'];
    }
    
}



?>