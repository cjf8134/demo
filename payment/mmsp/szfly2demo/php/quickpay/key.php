<?php

error_reporting(0);
require_once('lib/lib_tools_class.php');
require_once('lib/lib_config_class.php');
if($_POST){
//消息头
$req_arr = array();
$req_arr['CommandID'] = hexdec("0x0911");
$req_arr['SeqID'] = "1";
$req_arr['NodeType'] = "3";
$req_arr['NodeID'] = "openplat";
$req_arr['Version'] = "1.0.0";

$req_arr['AGENTNO'] = "00014403";
$req_arr['MERNO'] = Config::$MERNO;
$req_arr['TERMNO'] = Config::$TERMNO;
$req_arr['Extends'] = "";  //不参与签名

//body 体
$body = array(
    "RANDKEY" =>$_POST['RANDKEY'],
);
$req_arr['Body']  = Tools::rsa_encrypt(json_encode($body),Config::$PLATFORM_PUB_KEY);
$req_arr['Sign'] = Tools::en_rsa($req_arr,Config::$RSA_PRI);

$req_data = json_encode($req_arr);

$back_res = json_decode(Tools::http_post_json(Config::$APIURL, $req_data), true);
echo "<pre>";
echo PHP_EOL . "返回数据:" . PHP_EOL;
var_export($back_res);
if ($back_res['RetCode'] == 1) {
    $verify = Tools::rsa_verify($back_res, $back_res['Sign'], Config::$PLATFORM_PUB_KEY);
    if ($verify) {
        echo PHP_EOL . "验证签名成功" . PHP_EOL;
        $Body = json_decode(Tools::rsa_decrypt($back_res['Body'], Config::$RSA_PRI), true);
        echo PHP_EOL . "Body结果:" . PHP_EOL;
        var_export($Body);

        file_put_contents("randstr.txt",$_POST['RANDKEY']);
    } else {
        echo PHP_EOL . "验证签名失败" . PHP_EOL;
    }
} else {
    echo PHP_EOL;
    echo sprintf("错误码:%s,错误描述:%s", $back_res['RetCode'], $back_res['ErrorMsg']);
}

}
?>

<meta charset="utf-8">
<script src="./js/head.js"></script>
<form method="post" action="key.php" target="_blank">
    <table width="60%" border="0" align="center" cellpadding="5" cellspacing="5"
           style="border:solid 1px #1a88d5; margin-top:20px">
        <tr>
            <td align="left" bgcolor="#ABD8ED" height="25" colspan="2">支付接口示例：</td>
        </tr>


        <tr>
            <td align="left" width="19%">&nbsp;&nbsp;key值</td>
            <td width="81%" align="left">&nbsp;&nbsp;
                <input size="50" type="text" name="RANDKEY" value="0123456789" id="RANDSTR"/>
            </td>
        </tr>

        <tr>
            <td align="left" width="19%">&nbsp;&nbsp;</td>
            <td align="left">&nbsp;&nbsp;<input type="submit" value="上传随机数"/>&nbsp;&nbsp;<a href="index.php">返回</a></td>
        </tr>

    </table>
</form>
<script type="text/javascript">
    /**
     * 生成16位随机数
     * @returns {string}
     */
    function randomString() {
        len = 16;
        var $chars = 'abcdefhijkmnprstwxyz2345678';
        var maxPos = $chars.length;
        var pwd = '';
        for (i = 0; i < len; i++) {
            pwd += $chars.charAt(Math.floor(Math.random() * maxPos));
        }
        pwd = "qwertyuioplkjhgf"
        return pwd;
    }
    document.getElementById('RANDSTR').value = randomString();
</script>

</div>

</body>
</html>


