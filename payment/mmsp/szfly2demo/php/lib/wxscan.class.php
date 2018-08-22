<?php
require_once 'base.class.php';

class wxscan extends base
{
    
    /**
     * 设置交易类型：1、正扫、2公众号支付
     * @param string $value
     **/
    public function SetTRADETYPE($value)
    {
        $this->Body['TRADETYPE'] = $value;
    }
    
    /**
     * 获取交易类型：1、正扫、2公众号支付
     * @return 值
     **/
    public function GetTRADETYPE()
    {
        return $this->Body['TRADETYPE'];
    }
    
    /**
     * 判断交易类型：1、正扫、2公众号支付
     * @return true 或 false
     **/
    public function IsTRADETYPESet()
    {
        return array_key_exists('TRADETYPE', $this->Body);
    }
    
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
     * 设置支付成功后前台跳转地址
     * @param string $value
     **/
    public function SetJUMP_URL($value)
    {
        $this->Body['JUMP_URL'] = $value;
    }
    
    /**
     * 获取支付成功后前台跳转地址
     * @return 值
     **/
    public function GetJUMP_URL()
    {
        return $this->Body['JUMP_URL'];
    }
    
    /**
     * 判断支付成功后前台跳转地址
     * @return true 或 false
     **/
    public function IsJUMP_URLSet()
    {
        return array_key_exists('JUMP_URL', $this->Body);
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
    
    /**
     * 设置微信用户openid
     * @param string $value
     **/
    public function SetOPENID($value)
    {
        $this->Body['OPENID'] = $value;
    }
    
    /**
     * 获取微信用户openid
     * @return 值
     **/
    public function GetOPENID()
    {
        return $this->Body['OPENID'];
    }
    
    /**
     * 判断微信用户openid
     * @return true 或 false
     **/
    public function IsOPENIDSet()
    {
        return array_key_exists('OPENID', $this->Body);
    }
    
    /**
     * 设置T0
     * @param string $value
     **/
    public function SetIST0($value)
    {
        $this->Body['IST0'] = $value;
    }
    
    /**
     * 获取T0
     * @return 值
     **/
    public function GetIST0()
    {
        return $this->Body['IST0'];
    }
    
    /**
     * 判断T0
     * @return true 或 false
     **/
    public function IsIST0Set()
    {
        return array_key_exists('IST0', $this->Body);
    }

    public function SetRAW($value)
    {
        $this->Body['IS_RAW'] = $value;
    }
	
	public function SetLIMIT_PAY($value)
    {
        $this->Body['LIMIT_PAY'] = $value;
    }
    
    public function SetSUP_APPID($value)
    {
        $this->Body['SUP_APPID'] = $value;
    }
    
}

?>