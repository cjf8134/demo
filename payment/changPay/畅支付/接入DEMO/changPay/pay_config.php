<?php


//商户号
$partner['partner'] = '37210';

// MD5密钥，安全检验码，由数字和字母组成的字符串，请登录商户后台查看
$Key['key']	= '5e6522049b5fbb8e2c708df54a3e2143';

//网关接口地址
$apiurl['apiurl'] = "http://api.ntlmh.com/PayBank.aspx";

// 服务器异步通知页面路径  需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
$callbackurl['callbackurl'] = "http://localhost/php_0315//callbackurl.php";

// 页面跳转同步通知页面路径 需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
$hrefbackurl['hrefbackurl'] = "http://demo.390pay.com/hrefbackurl.php";

//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

?>