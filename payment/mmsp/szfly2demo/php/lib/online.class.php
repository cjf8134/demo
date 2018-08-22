<?php 
/**
 * @copyright 网关支付
 * @auth:wlj 2017年8月16日14:56:52
 * **/
require_once 'base.class.php';

class online extends base
{   
    /**
     * 商户订单号
     * @param string $value
     **/    
    public function SetMERORDERID($value)
    {
        $this->Body['MERORDERID'] = $value;
    }
    
    public function GetMERORDERID()
    {
        return $this->Body['MERORDERID'];
    }
    /**
     * 金额
     * @param string $value
     **/
    public function SetAMT($value)
    {
        $this->Body['AMT'] = $value;
    }
    public function GetAMT()
    {
        return $this->Body['AMT'];
    }    

    /**
     * 商品名称
     * @param string $value
     **/
    public function SetGOODSNAME($value)
    {
        $this->Body['GOODSNAME'] = $value;
    }
    public function GetGOODSNAME()
    {
        return $this->Body['GOODSNAME'];
    }
    /**
     *   后端回调URL
     * @param string $value
     **/
    public function SetNOTIFY_URL($value)
    {
        $this->Body['NOTIFY_URL'] = $value;
    }
    public function GetNOTIFY_URL()
    {
        return $this->Body['NOTIFY_URL'];
    } 
    
    /**
     *    前端回调URL
     * @param string $value
     **/
    public function SetJUMP_URL($value)
    {
        $this->Body['JUMP_URL'] = $value;
    }
    
    
    public function GetJUMP_URL()
    {
        return $this->Body['JUMP_URL'];
    }
    /**
     *   支付通道编码
     * @param string $value
     **/
    public function SetPAY_CHANNEL($value)
    {
        $this->Body['PAY_CHANNEL'] = $value;
    }
    
    public function GetPAY_CHANNEL()
    {
        return $this->Body['PAY_CHANNEL'];
    }
    /**
     *   备注
     * @param string $value
     **/
    public function SetREMARK($value)
    {
        $this->Body['REMARK'] = $value;
    }
    
    public function GetREMARK()
    {
        return $this->Body['REMARK'];
    }   

}

?>