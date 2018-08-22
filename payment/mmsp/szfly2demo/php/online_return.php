<?php
header("Content-type: text/html; charset=utf-8");
/********************
1、写入内容到文件,追加内容到文件
2、打开并读取文件内容
********************/
 $file  = __DIR__.'/logs/log.txt';//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个
 $content = "[".date('Y-m-d H:i:s',time())."]return";
 if($_REQUEST){
     $content .= json_encode($_REQUEST);
 }elseif ($input = file_get_contents("php://input")){
     $content .= json_encode($input);
 }
 $content .="\n";
 if($f  = file_put_contents($file, $content,FILE_APPEND)){// 这个函数支持版本(PHP 5) 
    echo "success return";
 }
?>