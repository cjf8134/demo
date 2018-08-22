<?php 
require_once 'base.class.php';

class random extends base
{
    
    /**
     * 设置随机数
     * @param string $value
     **/
    public function SetRANDOM($value)
    {
        $this->Body['RANDOM'] = $value;
    }
    
    /**
     * 获取随机数
     * @return 值
     **/
    public function GetRANDOM()
    {
        return $this->Body['RANDOM'];
    }
    
    /**
     * 判断随机数
     * @return true 或 false
     **/
    public function IsRANDOMSet()
    {
        return array_key_exists('RANDOM', $this->Body);
    }

}

?>