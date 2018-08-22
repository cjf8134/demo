<?php 
require_once 'base.class.php';

class query extends base
{
    
    /**
     * 设置交易订单号
     * @param string $value
     **/
    public function SetORDERNO($value)
    {
        $this->Body['ORDERNO'] = $value;
    }
    
    /**
     * 获取交易订单号
     * @return 值
     **/
    public function GetORDERNO()
    {
        return $this->Body['ORDERNO'];
    }
    
    /**
     * 判断交易订单号
     * @return true 或 false
     **/
    public function IsORDERNOSet()
    {
        return array_key_exists('ORDERNO', $this->Body);
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

}

?>