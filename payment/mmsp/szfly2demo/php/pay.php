<?php 

function daifu_t()
{
    $ORDERNO = date('YmdHis');
    $AMT = 10;
    $BUSITYPE = '001';
    $ACCNAME = '刘德华';
    $ACCNO = '622612345678901234';
    $MERNO = '001440353999853';  
    $MEMO = '代付';
    $PAYTYPE = '1';
    $MOBILE = '13112345678';
    $BANKNAME = '中国银行';
    $IDCARD = '123456789012345678';
    $BANKSETTLENO = '123456789012';
    $BANKBRANCHNAME = '深圳分行';
        
    //测试商户私钥
    $private_key = '-----BEGIN PRIVATE KEY-----
MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBALVybJ9cqRfaLiWN
Zr5siuR3afRuflVG5pqcLqtqgknqJ+3HkS1qWga5ItMA2yiUL/q4vsaVgRevcUW3
L3l18sw+t71TtugRgTnl19pRGv19Fk9BoeEcVv25q11u4X4gZHfkZfk2XJkL9NYy
kIE51ce8Da3oZcd9z1hraLEOEla7AgMBAAECgYB+57nbOAa4PQwbjat3shjutCpy
IDnR0RYGuwfVMlhP9CrbHsKGXiT7IM+ffrDJz+NC26Xq5LP2aemyle3paLpYPFA8
6fS+oriOccj1MTPwSdYKsNCrEtXz4Vmkhmhf/fo5RCWNvv50KyJr/VresnolLbhu
OO2gpOgdz9ZM7MMeKQJBANy2gZDpzZGoxlb2EnRcf4vNmymLSRQLd1tluzSGGDMt
2ZlkjBRv9OjJYnPQDj+2/h6mGok5LJSMK6wBkeW6pw0CQQDSdNBcM28uqSgY4THF
F0NOiPecr31bB/s7m8h8J5Ep7UCXW/W6QosS/JZvUpMx68PNNuWl6i9dAHmAsCns
1YLnAkBQBlRACKWiVIFlcl8KlachN3E0xO3AONAT8XTI/H21wMAO3+fyWQ2BgdMS
jrM74suMrUkdy/8f9Rq4iPEvTFfZAkEAwrYk2EkWApuqZ2piO7EMKqr6PFL4rbIy
tLGqyYNqANpquh7wuAU82rIrFI/Xc4Znv4Oc8OY8L9VylKdoAqB/3QJAVbxcj2xx
YB3XKu7YjmaE6IxkbGjrxlpyG2zICin7zVg4G5sicHplT821wX0ZXCQcxdZobyx5
n/XTutLLOsu6DQ==
-----END PRIVATE KEY-----';
    //测试平台RSA公钥
    $public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDfCEEXAn1RpnSOOrWix3VLBoBf
rPpdxoVkosuW1f52Yv/1ENBlKnoefLJPDwbsR5F0OcDhiBojbhx5fU8Gv52csJB4
r7yjWvp70hsrXrh7UhulUdA0Rs8gOF8gWQIEsCIw8LRwdPAKENeqvdnSJeq5+qjP
P5knoWH32bB1C9vclwIDAQAB
-----END PUBLIC KEY-----';
    $pi_key =  openssl_pkey_get_private($private_key);// 可用返回资源id
    $pu_key = openssl_pkey_get_public($public_key);
    $daf_data=array(
        'CMDID'		=> '4097',
        'VERSION'	=> '1.0',
        'MERNO'		=> $MERNO,
        'ORDERNO'	=> $ORDERNO,
        'REQTIME'	=> $ORDERNO,
        'AMT'		=> $AMT,
        'BUSITYPE'	=> $BUSITYPE,
        'ACCNAME'	=> $ACCNAME,
        'ACCNO'		=> $ACCNO,
        'PAYTYPE'	=> $PAYTYPE,
        'ACCTYPE'	=> '0',
        'MOBILE'	=> $MOBILE,
        'BANKNAME'	=> $BANKNAME,
        'BANKSETTLENO'	=> $BANKSETTLENO,
        'BANKBRANCHNAME' => $BANKBRANCHNAME,
        'MEMO'		=> $MEMO,
        'IDCARD'	=> $IDCARD,
        'BANKPROV' 	=> '广东',
        'BANKCITY'	=> '深圳市'
    );
    $data= json_encode($daf_data);
    $encrypted = '';
    $decrypted = '';
    
    var_dump($pu_key);var_dump($public_key);

    $arr = str_split($data,117);
    $a = array();
    foreach ($arr as $p)
    {
       $str = null;
       openssl_public_encrypt($p,$str,$pu_key);
       $a[] = $str;
    }
    openssl_free_key($pu_key);
    $encrypted=base64_encode(implode('',$a));//这个上送的字段ENCRYPT的值
    echo 'ENCRYPT：'.$encrypted;
    echo '<br/>';
    //下面是私钥生成签名
    openssl_sign($data,$sign,$pi_key);
    openssl_free_key($pi_key);
    $sign=base64_encode($sign);//这个上送的字段SIGN的值
    echo '签名：'.$sign;
}
daifu_t();
?>