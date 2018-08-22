<?php
require_once 'leanworkSDK.php';
$config=include("config.php");
$lw=new LeanWorkSDK($config['lw_key']);
$lw->mock();
