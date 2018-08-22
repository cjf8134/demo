<?php

class demoController extends PayOpenSdkPublicController {
    
    public function initialize()
    {
        parent::initialize();
    }
    
    
    public function indexAction() {

        
    }

    
    //上送随机数
    public function sendrandAction()
    {
        
    }
    
    
    //微信正扫
    public function wxsanAction()
    {
        
        if($this->request->isPost() && $this->request->isAjax())
        {
            
        }
        
    }
    
    //微信反扫
    public function wxrescanAction()
    {
        if($this->request->isPost() && $this->request->isAjax())
        {
        
        }
    }
    
    //微信公众号
    public function wxpayh5Action()
    {
        if($this->request->isPost() && $this->request->isAjax())
        {
        
        }
    }
    
    //微信查询
    public function wxqueryAction()
    {
        if($this->request->isPost() && $this->request->isAjax())
        {
        
        }
    }
    
   

}
