package com.csepay.demo.utils;

import java.io.UnsupportedEncodingException;
import java.lang.reflect.Method;
import java.security.KeyFactory;
import java.security.NoSuchAlgorithmException;
import java.security.PublicKey;
import java.security.Signature;
import java.security.interfaces.RSAPrivateKey;
import java.security.spec.EncodedKeySpec;
import java.security.spec.PKCS8EncodedKeySpec;
import java.security.spec.X509EncodedKeySpec;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;

import javax.servlet.http.HttpServletRequest;

public class Tools {

	/**
	 * 签名验证
	 * 
	 * @param content
	 * @param sign
	 * @param publicKey
	 * @param encode
	 * @return
	 */
	public static boolean doCheck(String content, String sign, String publicKey, String encode) {

		try {
			KeyFactory keyFactory = KeyFactory.getInstance("RSA");
			byte[] encodedKey = decodeBase64(publicKey);
			PublicKey pubKey = keyFactory.generatePublic(new X509EncodedKeySpec(encodedKey));
			java.security.Signature signature = java.security.Signature.getInstance("MD5withRSA");
			signature.initVerify(pubKey);
			signature.update(content.getBytes(encode));
			boolean bverify = signature.verify(decodeBase64(sign));
			return bverify;

		} catch (NoSuchAlgorithmException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return false;
	}

	/**
	 * 生成签名
	 * 
	 * @param datas
	 * @return
	 * @throws NoSuchAlgorithmException
	 */
	public static String getSign(String datas) {
		// 商户私钥 注意不能包含空格
		String private_key = "MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBALq0mkjfAi8bEpP6MdvlwHPDXqajtKZBOV+SSyOuxxYMBEcLaiHZgCF+hUXD5Gl8aEISqkjEIJ8HxhCiVEeDZTU303shg6kmtOuRu9crx+jAPmSdJbpLsgdVKOKTWhbMsCczIIdkw10aYcoHyKw2QLvCUXB9KskV96CcHhQcnKvbAgMBAAECgYEAguEZil2yFT1gH5VyoBiFeWEKF7yIZUcxpdpSi/f4HW9dDERnKMVkOZaMbCRvGLcaCr802X+K8pArevugIuVr6tdy/2iSJ+9HDq6ZLD3QfG5WNdJilAZiLUh4lWrd0BAUH+T7bGAbjXRnGXFcd1hcOObX20GCn3Hzf2dwmWFhPYkCQQDxKzKfOYIQVzhIfahpXXTWlWkKZkMINYw9UNSMduZzuA94eCybrverNKB8NlL3zngOS8REIulDE2CdoHMFev7XAkEAxi/4mogovWzw4/i37Fre/3M1YKwjfSi65KJ6JR3Cp / kZ9 / f1ncFDujBBfLGn4dHARHnVbamUOdSIr5pOPwJunQJAZP2l8S9v28/qbdDRGW5dYw6mMgiowWNLGtIib7/KuWK2d8g7ReZ7KGKdYeaNz9/SPopT4gSMkd4nc1qhUAY1eQJABftIq5FUeXMiSh8lnfKYLGmTwNkxMQPbsC7fNOOTDnLMP9myBhLhMmtmbpcGFCC6htaOhILLwHsTrQkhN3GhWQJBAIcNQWgcSZxbqij1e0mVI60rWbfcGSxycqVJCOhzsariU2JkJ0PhV1Dlqh+y994KOj/FcRTa0UoQ+MuCOUJ7cjw=";

		try {
			return sign(datas, private_key);
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
			return null;
		}
	}

	/**
	 * 
	 * @param plainData
	 * @param private_key
	 * @return
	 * @throws Exception
	 */
	public static String sign(final String plainData, String private_key) throws Exception {

		byte[] buff = decodeBase64(private_key);

		KeyFactory keyFactory = KeyFactory.getInstance("RSA");
		EncodedKeySpec privateKeySpec = new PKCS8EncodedKeySpec(buff);
		RSAPrivateKey privateKey = (RSAPrivateKey) keyFactory.generatePrivate(privateKeySpec);
		Signature dsa = Signature.getInstance("MD5withRSA");
		dsa.initSign(privateKey);
		dsa.update(plainData.getBytes("UTF-8"));
		return encodeBase64(dsa.sign());
	}

	/***
	 * encode by Base64
	 */
	public static String encodeBase64(byte[] input) throws Exception {
		Class clazz = Class.forName("com.sun.org.apache.xerces.internal.impl.dv.util.Base64");
		Method mainMethod = clazz.getMethod("encode", byte[].class);
		mainMethod.setAccessible(true);
		Object retObj = mainMethod.invoke(null, new Object[] { input });
		return (String) retObj;
	}

	/***
	 * decode by Base64
	 */
	public static byte[] decodeBase64(String input) throws Exception {
		Class clazz = Class.forName("com.sun.org.apache.xerces.internal.impl.dv.util.Base64");
		Method mainMethod = clazz.getMethod("decode", String.class);
		mainMethod.setAccessible(true);
		Object retObj = mainMethod.invoke(null, input);
		return (byte[]) retObj;
	}

	public static boolean isNullOrEmpty(String value) {
		if (value == null || value.trim().length() == 0)
			return true;
		return false;
	}

	public static String getTime() {
		Date date = new Date(System.currentTimeMillis());
		return getTime("yyyyMMddHHmmss", date);
	}

	public static String getTime(String format, Date date) {
		DateFormat df = new SimpleDateFormat(format);
		return df.format(date);
	}

	public static String getUTF8String(HttpServletRequest req, String name) {
		String value = null;
		try {
			value = new String(req.getParameter(name).getBytes("ISO-8859-1"), "UTF-8");
		} catch (UnsupportedEncodingException e) {
			e.printStackTrace();
		}
		return value;
	}

}
