<?php 
/**
 * @copyright 快捷支付
 * @auth:wlj 2017年8月16日14:56:52
 * **/
require_once 'base.class.php';

class quickpay extends base
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

    public function SetTRADEMODE($value)
    {
        $this->Body['TRADE_MODE'] = $value;
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
    
    public function SetCARDNO($value)
    {
        $this->Body['CARDNO'] = $value;
    }
    public function GetCARDNO()
    {
        return $this->Body['CARDNO'];
    }
    
    public function SetCARDTYPE($value)
    {
        $this->Body['CARDTYPE'] = $value;
    }
    public function GetCARDTYPE()
    {
        return $this->Body['CARDTYPE'];
    }
    
    public function SetEXPDATE($value)
    {
        $this->Body['EXPDATE'] = $value;
    }
    public function GetEXPDATE()
    {
        return $this->Body['EXPDATE'];
    }
    
    public function SetCVN2($value)
    {
        $this->Body['CVN2'] = $value;
    }
    public function GetCVN2()
    {
        return $this->Body['CVN2'];
    }
    
    public function SetNAME($value)
    {
        $this->Body['NAME'] = $value;
    }
    public function GetNAME()
    {
        return $this->Body['NAME'];
    }
    
    public function SetID_NO($value)
    {
        $this->Body['ID_NO'] = $value;
    }
    public function GetID_NO()
    {
        return $this->Body['ID_NO'];
    }
    
    public function SetPHONENO($value)
    {
        $this->Body['PHONENO'] = $value;
    }
    public function GetPHONENO()
    {
        return $this->Body['PHONENO'];
    }
    
    public function SetRANDSTR($value)
    {
        $this->Body['RANDSTR'] = $value;
    }
    public function GetRANDSTR()
    {
        return $this->Body['RANDSTR'];
    }
    public function SetJUMP_URL($value)
    {
        $this->Body['JUMP_URL'] = $value;
    }
    public function SetNOTIFY_URL($value)
    {
        $this->Body['NOTIFY_URL'] = $value;
    }
    public function GetNOTIFY_URL()
    {
        return $this->Body['NOTIFY_URL'];
    }
    
    public function SetLIST_ID($value)
    {
        $this->Body['LIST_ID'] = $value;
    }
    public function GetLIST_ID()
    {
        return $this->Body['LIST_ID'];
    }
    
    public function SetMSG_CODE($value)
    {
        $this->Body['MSG_CODE'] = $value;
    }
    public function GetMSG_CODE()
    {
        return $this->Body['MSG_CODE'];
    }
    //开始时间
    public function SetSTART_DATE($value)
    {
        $this->Body['START_DATE'] = $value;
    }
    public function GetSTART_DATE()
    {
        return $this->Body['START_DATE'];
    }
    //结束时间
    public function SetEND_DATE($value)
    {
        $this->Body['END_DATE'] = $value;
    }
    public function GetEND_DATE()
    {
        return $this->Body['END_DATE'];
    }
    //每页
    public function SetPERPAGE($value)
    {
        $this->Body['PERPAGE'] = $value;
    }
    public function GetPERPAGE()
    {
        return $this->Body['PERPAGE'];
    }   
    
    //当前页
    public function SetPAGE($value)
    {
        $this->Body['PAGE'] = $value;
    }
    public function GetPAGE()
    {
        return $this->Body['PAGE'];
    }   
    //设置当用户ID
    public function SetUSER_ID($value)
    {
        $this->Body['USER_ID'] = $value;
    }
    public function GetUSER_ID()
    {
        return $this->Body['USER_ID'];
    }
    //设置当用户绑定ID
    public function SetBIND_ID($value)
    {
        $this->Body['BIND_ID'] = $value;
    }
    public function GetBIND_ID()
    {
        return $this->Body['BIND_ID'];
    }
}

?>