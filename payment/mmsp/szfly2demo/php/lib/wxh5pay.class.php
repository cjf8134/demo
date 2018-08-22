<?php
require_once 'base.class.php';

class wxh5pay extends base
{
    
    
    
    /**
     * 设置金额，单位：分
     * @param string $value
     **/
    public function SetAMT($value)
    {
        $this->Body['AMT'] = $value;
    }
    
    /**
     * 获取金额，单位：分
     * @return 值
     **/
    public function GetAMT()
    {
        return $this->Body['AMT'];
    }
    
    /**
     * 判断金额，单位：分
     * @return true 或 false
     **/
    public function IsAMTSet()
    {
        return array_key_exists('AMT', $this->Body);
    }
    
    /**
     * 设置默认人民币
     * @param string $value
     **/
    public function SetCUR($value)
    {
        $this->Body['CUR'] = $value;
    }
    
    /**
     * 获取默认人民币
     * @return 值
     **/
    public function GetCUR()
    {
        return $this->Body['CUR'];
    }
    
    /**
     * 判断默认人民币
     * @return true 或 false
     **/
    public function IsCURSet()
    {
        return array_key_exists('CUR', $this->Body);
    }
    
    /**
     * 设置商品名称
     * @param string $value
     **/
    public function SetGOODSNAME($value)
    {
        $this->Body['GOODSNAME'] = $value;
    }
    
    /**
     * 获取商品名称
     * @return 值
     **/
    public function GetGOODSNAME()
    {
        return $this->Body['GOODSNAME'];
    }
    
    /**
     * 判断商品名称
     * @return true 或 false
     **/
    public function IsGOODSNAMESet()
    {
        return array_key_exists('GOODSNAME', $this->Body);
    }
    
    /**
     * 设置支付结果通知地址
     * @param string $value
     **/
    public function SetNOTIFY_URL($value)
    {
        $this->Body['NOTIFY_URL'] = $value;
    }
    
    /**
     * 获取支付结果通知地址
     * @return 值
     **/
    public function GetNOTIFY_URL()
    {
        return $this->Body['NOTIFY_URL'];
    }
    
    /**
     * 判断支付结果通知地址
     * @return true 或 false
     **/
    public function IsNOTIFY_URLSet()
    {
        return array_key_exists('NOTIFY_URL', $this->Body);
    }
    
    
    
    
    /**
     * 设置前端通知地址
     * @param string $value
     **/
    public function SetJUMP_URL($value)
    {
        $this->Body['JUMP_URL'] = $value;
    }
    
    /**
     * 获取前端通知地址
     * @return 值
     **/
    public function GetJUMP_URL()
    {
        return $this->Body['JUMP_URL'];
    }
    
    /**
     * 判断前端通知地址
     * @return true 或 false
     **/
    public function IsJUMP_URLSet()
    {
        return array_key_exists('JUMP_URL', $this->Body);
    }
    
    /**
     * 设置交易过期时间
     * @param string $value
     **/
    public function SetTIME_END($value)
    {
        $this->Body['TIME_END'] = $value;
    }
    
    /**
     * 获取交易过期时间
     * @return 值
     **/
    public function GetTIME_END()
    {
        return $this->Body['TIME_END'];
    }
    
    /**
     * 判断交易过期时间
     * @return true 或 false
     **/
    public function IsTIME_ENDSet()
    {
        return array_key_exists('TIME_END', $this->Body);
    }
    
    /**
     * 设置交易IP地址
     * @param string $value
     **/
    public function SetIP($value)
    {
        $this->Body['IP'] = $value;
    }
    
    /**
     * 获取交易IP地址
     * @return 值
     **/
    public function GetIP()
    {
        return $this->Body['IP'];
    }
    
    /**
     * 判断交易IP地址
     * @return true 或 false
     **/
    public function IsIPSet()
    {
        return array_key_exists('IP', $this->Body);
    }
    
   
    
    /**
     * 设置商户订单号
     * @param string $value
     **/
    public function SetMERORDERID($value)
    {
        $this->Body['MERORDERID'] = $value;
    }
    
    /**
     * 获取商户订单号
     * @return 值
     **/
    public function GetMERORDERID()
    {
        return $this->Body['MERORDERID'];
    }
    
    /**
     * 判断商户订单号
     * @return true 或 false
     **/
    public function IsMERORDERIDSet()
    {
        return array_key_exists('MERORDERID', $this->Body);
    }
    
    /**
     * 设置随机字符串
     * @param string $value
     **/
    public function SetRANDSTR($value)
    {
        $this->Body['RANDSTR'] = $value;
    }
    
    /**
     * 获取随机字符串
     * @return 值
     **/
    public function GetRANDSTR()
    {
        return $this->Body['RANDSTR'];
    }
    
    /**
     * 判断随机字符串
     * @return true 或 false
     **/
    public function IsRANDSTRSet()
    {
        return array_key_exists('RANDSTR', $this->Body);
    }
    
	public function SetLIMIT_PAY($value)
    {
        $this->Body['LIMIT_PAY'] = $value;
    }
    
}

?>