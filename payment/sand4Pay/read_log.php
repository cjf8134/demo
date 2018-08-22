<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<pre>
    <?php
    
    $now=isset($_GET['d'])?$_GET['d']:'';
    $dir=dirname(__FILE__)."/logs/";
	if($now){
		$path=$dir.$now;
	}else{
		$times=time();
		$path=$dir.strftime("%Y-%m-%d",$times);
	}			
    $file=$path.".log";
    echo file_get_contents($file);
    ?>
    </pre>
</body>
</html>
