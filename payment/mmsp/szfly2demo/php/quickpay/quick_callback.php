<?php
//error_reporting(E_ERROR);
require_once '../lib/quickpay.class.php';
header("Content-type: text/html; charset=utf-8");
/********************
1、写入内容到文件,追加内容到文件
2、打开并读取文件内容
********************/
 $file  = __DIR__.'/log/log.txt';//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个
 $content = "[".date('Y-m-d H:i:s',time())."]callback";
 if($_REQUEST){
     $content .= '[request]'.json_encode($_REQUEST);
	 $data = $_REQUEST;
 }elseif ($input = file_get_contents("php://input")){
     $content .= '[php://input]'.json_encode($input);
	 $data = $input;
 }
 $content .="\n";
 /* if($f  = file_put_contents($file, $content,FILE_APPEND)){// 这个函数支持版本(PHP 5) 
    echo json_encode(array('name'=>'wangluozhifu','status'=>'1'),true);
 } */

$base = new base();
if(empty($data)){ return;}
$result = json_decode($data, true);
if($result['RetCode'] == 1)
{
	$mysign = $base->ckSign($result['Body']);

	if($mysign != $result['Sign']){
		exit('签名错误');
	}else{
		return $result['Body'];
	}

	return false;               
}elseif ($result == false && $base->GetCommandID() == hexdec('0x090B'))//输入文件流
{
	return array('STATUS'=>true,'txt'=>$data);
}
else
{
	return false;
}
?>