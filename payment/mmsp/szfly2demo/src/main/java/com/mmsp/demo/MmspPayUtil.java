package com.mmsp.demo;


import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.security.*;
import java.security.spec.PKCS8EncodedKeySpec;
import java.security.spec.X509EncodedKeySpec;
import java.util.Arrays;
import java.util.Base64;

import javax.crypto.Cipher;

import org.apache.commons.lang3.ArrayUtils;
import org.apache.log4j.Logger;  

import com.alibaba.fastjson.JSONObject;
import com.google.common.base.Charsets;
import com.google.common.hash.Hasher;
import com.google.common.hash.Hashing;


public class MmspPayUtil {
	
	private static Logger logger = Logger.getLogger(MmspPayUtil.class);
	
	
	public static String[] GenSign(JSONObject param,String key)
	{
		String[] signObj = {"",""};

		
		String signBody  = GenSignBody(param);
		String signStr = signBody.replace("/", "\\/") +"&key="+ key;
		
		logger.info("mmsp交易校验数据:"+signStr);
		//param.put("Body",body);
		@SuppressWarnings("deprecation")
		Hasher hasher = Hashing.md5().newHasher();
		hasher.putString(signStr,Charsets.UTF_8);
		String sign = hasher.hash().toString().toUpperCase();
		logger.info("mmsp交易sign:"+sign);
		
		signObj[0] = signBody;
		signObj[1] = sign;
		
		return signObj;
		
	}
	
	public static String GenSignBody(JSONObject param){
		String body = "{";
		Object[] keys = param.keySet().toArray();
		Arrays.sort(keys);
		for(Object key: keys ){
			Object obj = param.get(key);
			if ( obj instanceof Integer){
				body+= String.format("\"%s\":%s,", key,param.get(key));									
			}else{
				body+= String.format("\"%s\":\"%s\",", key,param.get(key));
			}
		}
		body = body.substring(0,body.length()-1)+"}";		
		return body;
	
	}
	
	 //将base64编码后的公钥字符串转成PublicKey实例  
    public static PublicKey getPublicKey(String publicKey) throws Exception{  
        byte[ ] keyBytes=Base64.getDecoder().decode(publicKey.getBytes());
    	
        X509EncodedKeySpec keySpec=new X509EncodedKeySpec(keyBytes);  
        KeyFactory keyFactory=KeyFactory.getInstance("RSA");  
        return keyFactory.generatePublic(keySpec);    
    }  
      
    //将base64编码后的私钥字符串转成PrivateKey实例  
    public static PrivateKey getPrivateKey(String privateKey) throws Exception{  
        byte[] keyBytes=Base64.getDecoder().decode(privateKey.getBytes());
    	
        PKCS8EncodedKeySpec keySpec=new PKCS8EncodedKeySpec(keyBytes);  
        KeyFactory keyFactory=KeyFactory.getInstance("RSA");  
        return keyFactory.generatePrivate(keySpec);  
    }  
      
    //公钥加密  
    public static byte[] encrypt(byte[] data, PublicKey publicKey) throws Exception{  
        Cipher cipher=Cipher.getInstance("RSA");//java默认"RSA"="RSA/ECB/PKCS1Padding"  
        cipher.init(Cipher.ENCRYPT_MODE, publicKey);  
        //return cipher.doFinal(content);  
        
     // 加密时超过117字节就报错。为此采用分段加密的办法来加密
        byte[] enBytes = null;  
        for (int i = 0; i < data.length; i += 64) {  
        	// 注意要使用2的倍数，否则会出现加密后的内容再解密时为乱码  
           	int max = i+64;
        	if ( max >= data.length){
        		max = data.length;
        	}
            byte[] doFinal = cipher.doFinal(Arrays.copyOfRange(data, i,max));    
            enBytes = ArrayUtils.addAll(enBytes, doFinal);    
        }
        return enBytes;
    }  
      
    //私钥解密  
    public static byte[] decrypt(byte[] data, PrivateKey privateKey) throws Exception{  
        Cipher cipher=Cipher.getInstance("RSA");  
        
        cipher.init(Cipher.DECRYPT_MODE, privateKey);  

     // 解密时超过128字节就报错。为此采用分段解密的办法来解密  
        byte[] deBytes = null;  
        for (int i = 0; i < data.length; i += 128) { 
        	int max = i+128;
        	if ( max >= data.length){
        		max = data.length;
        	}
        	byte[] doFinal = cipher.doFinal(ArrayUtils.subarray(data, i, max));
        	deBytes = ArrayUtils.addAll(deBytes, doFinal);    
        }
        return deBytes;
    }  
    
  //Unicode转中文  
    public static String DecodeUnicode(final String dataStr) {     
       int start = 0;     
       int end = 0;     
       final StringBuffer buffer = new StringBuffer();     
       while (start > -1) {     
           end = dataStr.indexOf("\\u", start + 2);     
           String charStr = "";     
           if (end == -1) {     
               charStr = dataStr.substring(start + 2, dataStr.length());     
           } else {     
               charStr = dataStr.substring(start + 2, end);     
           }     
           char letter = (char) Integer.parseInt(charStr, 16); // 16进制parse整形字符串。     
           buffer.append(new Character(letter).toString());     
           start = end;     
       }     
       return buffer.toString();     
    } 
    
    public static String txt2String(File file){
        StringBuilder result = new StringBuilder();
        try{
            BufferedReader br = new BufferedReader(new FileReader(file));//构造一个BufferedReader类来读取文件
            String s = null;
            while((s = br.readLine())!=null){//使用readLine方法，一次读一行
            	if (s.startsWith("--")) continue;
                //result.append(System.lineSeparator()+s);
            	result.append(s);
            }
            br.close();    
        }catch(Exception e){
            e.printStackTrace();
        }
        return result.toString();
    }

}
