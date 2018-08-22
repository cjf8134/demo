<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>快捷支付下单</title>
</head>
<body>
<?php
require_once 'log.class.php';
$log=new Log();

if($_POST){

    require_once 'fileCache.class.php';
    require_once 'lib.php';
    require_once 'config.php';
    $post=$_POST;
    $data = array(
        "CommandID"  => hexdec('0x0912'),
        "SeqID"      => "1",
        "NodeType"   => "3",
        "NodeID"     => "openapi",
        "Version"    => "1.0.0",
        "AGENTNO"    => AGENTNO,
        "MERNO"      => M_ID,
        "TERMNO"     => TERMNO,

    );
    $log->W('header头部数据:');
    $log->W(var_export($data,true));
    $data['body'] = array(
        "MERORDERID"  => $post['MERORDERID'],
        "AMT"         => $post['AMT'],
        "GOODSNAME"   => $post['GOODSNAME'],
        "NOTIFY_URL"  => $post['NOTIFY_URL'],
        "JUMP_URL"    => $post['JUMP_URL'],
        "PAY_CHANNEL" => $post['PAY_CHANNEL'],
        "REMARK"      => $post['REMARK'],
    );
    $log->W('body+header数据:');
    $log->W(var_export($data,true));
    $data['Sign'] =  MakeSign($data['body'],APP_KEY);
    $log->W('body数据获取签名:');
    $log->W($data['Sign']);

    $log->W('请求数据:');
    $log->W(var_export($data,true));
    $value['web_api'] = json_encode($data);
    ?>
    <form name="pay" id="register_form" action='<?php echo PAY_URL."?charset=UTF-8"; ?>' method='post'>
        <?php foreach($value as $key=>$val) {
            echo "<input type='hidden' name='$key' value='$val'>";
        };?>
    </form>
    <script>
        window.onload= function(){
            document.getElementById('register_form').submit();
            return false; //必须加上这个！！！
        }
    </script>
    <?php

}else{
    echo "无效参数";
}

?>


</body>
</html>