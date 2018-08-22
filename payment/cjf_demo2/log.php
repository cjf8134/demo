<?php
//写日志的类,初始化时会在网站根目录创建个log文件夹，以时间区分
Class Log{
    private $dir;
    public $debug=true;
    function __construct(){
        $this->dir=dirname(__FILE__)."/logs/";
        if(!file_exists($this->dir)){
            mkdir($this->dir,0777);
        }
    }
    function  W($word)
    {
        if($this->debug){
            $now=time();


            $file=$this->dir.strftime("%Y-%m-%d",$now).".log";

            $fp = fopen($file,"a");
            flock($fp, LOCK_EX) ;
            fwrite($fp,"执行日期：".strftime("%Y-%m-%d-%H:%M:%S",$now)."\n".$word."\n\n");
            flock($fp, LOCK_UN);
            fclose($fp);
        }

    }
}


?>