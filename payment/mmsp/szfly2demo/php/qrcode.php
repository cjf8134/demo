<?php 
	
	error_reporting(E_ERROR);
	require_once './phpqrcode/phpqrcode.php';
	$url = $_GET['url'];
	QRcode::png($url);

 ?>