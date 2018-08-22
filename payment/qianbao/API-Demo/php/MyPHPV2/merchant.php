<?php
/**
1）merchant_private_key，商户私钥;merchant_public_key,商户公钥；商户需要按照《密钥对获取工具说明》操作并获取商户私钥，商户公钥。
2）demo提供的merchant_private_key、merchant_public_key是测试商户号588001002211的商户私钥和商户公钥，请商家自行获取并且替换；
3）使用商户私钥加密时需要调用到openssl_sign函数,需要在php_ini文件里打开php_openssl插件
4）php的商户私钥在格式上要求换行，如下所示；
*/
$merchant_private_key='-----BEGIN PRIVATE KEY-----
MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBALq0mkjfAi8bEpP6
MdvlwHPDXqajtKZBOV+SSyOuxxYMBEcLaiHZgCF+hUXD5Gl8aEISqkjEIJ8HxhCi
VEeDZTU303shg6kmtOuRu9crx+jAPmSdJbpLsgdVKOKTWhbMsCczIIdkw10aYcoH
yKw2QLvCUXB9KskV96CcHhQcnKvbAgMBAAECgYEAguEZil2yFT1gH5VyoBiFeWEK
F7yIZUcxpdpSi/f4HW9dDERnKMVkOZaMbCRvGLcaCr802X+K8pArevugIuVr6tdy
/2iSJ+9HDq6ZLD3QfG5WNdJilAZiLUh4lWrd0BAUH+T7bGAbjXRnGXFcd1hcOObX
20GCn3Hzf2dwmWFhPYkCQQDxKzKfOYIQVzhIfahpXXTWlWkKZkMINYw9UNSMduZz
uA94eCybrverNKB8NlL3zngOS8REIulDE2CdoHMFev7XAkEAxi/4mogovWzw4/i3
7Fre/3M1YKwjfSi65KJ6JR3Cp/kZ9/f1ncFDujBBfLGn4dHARHnVbamUOdSIr5pO
PwJunQJAZP2l8S9v28/qbdDRGW5dYw6mMgiowWNLGtIib7/KuWK2d8g7ReZ7KGKd
YeaNz9/SPopT4gSMkd4nc1qhUAY1eQJABftIq5FUeXMiSh8lnfKYLGmTwNkxMQPb
sC7fNOOTDnLMP9myBhLhMmtmbpcGFCC6htaOhILLwHsTrQkhN3GhWQJBAIcNQWgc
SZxbqij1e0mVI60rWbfcGSxycqVJCOhzsariU2JkJ0PhV1Dlqh+y994KOj/FcRTa
0UoQ+MuCOUJ7cjw=
-----END PRIVATE KEY-----';

//merchant_public_key,商户公钥，按照说明文档上传此密钥到商家后台，代码中不使用到此变量
	$merchant_public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC3/DQcfghijyJfwqM3+sokwsED
OnaOnFd7KvBKnEsttHPA4SR8Io/vGf0qSLirU1Gnl0+s/rVST+Yi0kqRZavR+18A
rFuQzK3S4zqA4MAI0VDXB5/cUO+9l4wY0CJGBdb5sWxu5jg1Uv/jbDs754Z4xPgh
N8cAyTjIvx8iX2oVoQIDAQAB
	-----END PUBLIC KEY-----';
	

/**
1)dinpay_public_key，钱包支付公钥，每个商家对应一个固定的钱包支付公钥（不是使用工具生成的密钥merchant_public_key，不要混淆），
即为钱包支付商家后台"公钥管理"->"快银支付公钥"里的绿色字符串内容,复制出来之后调成4行（换行位置任意，前面三行对齐），
并加上注释"-----BEGIN PUBLIC KEY-----"和"-----END PUBLIC KEY-----"
2)demo提供的dinpay_public_key是测试商户号1118004517的快银支付公钥，请自行复制对应商户号的快银支付公钥进行调整和替换。
3）使用快银支付公钥验证时需要调用openssl_verify函数进行验证,需要在php_ini文件里打开php_openssl插件
*/
$dinpay_public_key ='-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCTXRAk0ulemRBuM0PuA49imn/6hicl
7cVmCo++98V/1lX1kT0DY2FDD8Jz97vqhuOBo474+Ia7bEEMunI6z/AUXw1CF6KtGwGP
x/Q8IuG426EZjH3wCSOthQncW8hHBCkgzjqu/Yi/y1E8TVFB8bp1+28L/ZpTZc0ZGnQmp
04HSQIDAQAB
-----END PUBLIC KEY-----'; 	
	




?>